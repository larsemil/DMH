<?php

class Group extends BaseModel{
    
    public $Id;
    public $Name;
    public $ApproximateNumberOfMembers;
    public $NeedFireplace = false;
    public $Friends;
    public $Enemies;
    public $Description;
    public $IntrigueIdeas;
    public $OtherInformation;
    public $WealthId;
    public $PlaceOfResidenceId;
    public $PersonId; # Gruppledaren
    
//     public static $tableName = 'group';
    public static $orderListBy = 'Name';
    
    public static function newFromArray($post){
        $group = static::newWithDefault();
        if (isset($post['Id'])) $group->Id = $post['Id'];
        if (isset($post['Name'])) $group->Name = $post['Name'];
        if (isset($post['ApproximateNumberOfMembers'])) $group->ApproximateNumberOfMembers = $post['ApproximateNumberOfMembers'];
        if (isset($post['NeedFireplace'])) $group->NeedFireplace = $post['NeedFireplace'];
        if (isset($post['Friends'])) $group->Friends = $post['Friends'];
        if (isset($post['Enemies'])) $group->Enemies = $post['Enemies'];
        if (isset($post['Description'])) $group->Description = $post['Description'];
        if (isset($post['IntrigueIdeas'])) $group->IntrigueIdeas = $post['IntrigueIdeas'];
        if (isset($post['OtherInformation'])) $group->OtherInformation = $post['OtherInformation'];
        if (isset($post['WealthId'])) $group->WealthId = $post['WealthId'];
        if (isset($post['PlaceOfResidenceId'])) $group->PlaceOfResidenceId = $post['PlaceOfResidenceId'];
        if (isset($post['PersonId'])) $group->PersonId = $post['PersonId'];
        
        return $group;
    }
     
    
    # För komplicerade defaultvärden som inte kan sättas i class-defenitionen
    public static function newWithDefault() {
        return new self();
    }
    
    
    # Update an existing group in db
    public function update() {
        
        $stmt = $this->connect()->prepare("UPDATE `group` SET Name=?, ApproximateNumberOfMembers=?, NeedFireplace=?, Friends=?, Enemies=?,
                                                                  Description=?, IntrigueIdeas=?, OtherInformation=?,
                                                                  WealthId=?, PlaceOfResidenceId=?, PersonId=? WHERE Id = ?");
        
        if (!$stmt->execute(array($this->Name, $this->ApproximateNumberOfMembers, $this->NeedFireplace, $this->Friends, $this->Enemies,
            $this->Description, $this->IntrigueIdeas, $this->OtherInformation, $this->WealthId, $this->PlaceOfResidenceId, $this->PersonId, $this->Id))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        
        $stmt = null;
    }
    
    
    
    # Create a new group in db
    public function create() {
        $connection = $this->connect();
        $stmt = $connection->prepare("INSERT INTO `group` (Name, ApproximateNumberOfMembers, NeedFireplace, 
                         Friends, Description, Enemies, IntrigueIdeas, OtherInformation, WealthId, PlaceOfResidenceId, PersonId) 
                         VALUES (?,?,?,?,?, ?,?,?,?,?,?);");
        
        if (!$stmt->execute(array($this->Name, $this->ApproximateNumberOfMembers, $this->NeedFireplace, 
            $this->Friends, $this->Description, $this->Enemies, $this->IntrigueIdeas, $this->OtherInformation, $this->WealthId, 
            $this->PlaceOfResidenceId, $this->PersonId))) {
            $this->connect()->rollBack();
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }

        $this->Id = $connection->lastInsertId();
        $stmt = null;
    }
    
    public function getWealth() {
        if (is_null($this->WealthId)) return null;
        return Wealth::loadById($this->WealthId);
    }
    
    public function getPlaceOfResidence() {
        if (is_null($this->PlaceOfResidenceId)) return null;
        return PlaceOfResidence::loadById($this->PlaceOfResidenceId);
    }
    
     public function getPerson() {
         return Person::loadById($this->PersonId);
     }
    
     public function getSelectedIntrigueTypeIds() {
         if (is_null($this->Id)) return array();
         
         $stmt = $this->connect()->prepare("SELECT IntrigueTypeId FROM IntrigueType_Group where GroupId = ? ORDER BY IntrigueTypeId;");
         
         if (!$stmt->execute(array($this->Id))) {
             $stmt = null;
             header("location: ../index.php?error=stmtfailed");
             exit();
         }
         
         if ($stmt->rowCount() == 0) {
             $stmt = null;
             return array();
         }
         
         $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
         $resultArray = array();
         foreach ($rows as $row) {
             $resultArray[] = $row['IntrigueTypeId'];
         }
         $stmt = null;
         
         return $resultArray;
     }
     
     
    
}