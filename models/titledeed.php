<?php

class Titledeed extends BaseModel{
    
    public $Id;
    public $Name;
    public $Location;
    public $Tradeable = 1;
    public $IsTradingPost = 0;
    public $CampaignId;
    
    
    public static $orderListBy = 'Name';
    
    
    public static function newFromArray($post){
        $role = static::newWithDefault();
        $role->setValuesByArray($post);
        return $role;
    }
    
    public function setValuesByArray($arr) {
        
        if (isset($arr['Id']))   $this->Id = $arr['Id'];
        if (isset($arr['Name'])) $this->Name = $arr['Name'];
        if (isset($arr['Location'])) $this->Location = $arr['Location'];
        if (isset($arr['Tradeable'])) $this->Tradeable = $arr['Tradeable'];
        if (isset($arr['IsTradingPost'])) $this->IsTradingPost = $arr['IsTradingPost'];
        if (isset($arr['CampaignId'])) $this->CampaignId = $arr['CampaignId'];
        
    }
    
    # För komplicerade defaultvärden som inte kan sättas i class-defenitionen
    public static function newWithDefault() {
        global $current_larp;
        
        $newOne = new self();
        $newOne->CampaignId = $current_larp->CampaignId;
        return $newOne;
    }
    
    
    # Update an existing object in db
    public function update() {
        $stmt = $this->connect()->prepare("UPDATE regsys_titledeed SET Name=?, Location=?, Tradeable=?, IsTradingPost=?,
                                                              CampaignId=? WHERE Id = ?;");
        
        if (!$stmt->execute(array($this->Name, $this->Location, $this->Tradeable, $this->IsTradingPost, $this->CampaignId, $this->Id))) {
                $stmt = null;
                header("location: ../index.php?error=stmtfailed");
                exit();
            }
            $stmt = null;
    }
    
    # Create a new object in db
    public function create() {
        $connection = $this->connect();
        $stmt = $connection->prepare("INSERT INTO regsys_titledeed (Name, Location, Tradeable, IsTradingPost, CampaignId) VALUES (?,?,?,?,?);");
        
        if (!$stmt->execute(array($this->Name, $this->Location, $this->Tradeable, $this->IsTradingPost, $this->CampaignId))) {
                $this->connect()->rollBack();
                $stmt = null;
                header("location: ../participant/index.php?error=stmtfailed");
                exit();
            }
            
            $this->Id = $connection->lastInsertId();
            $stmt = null;
    }
    
    public static function allByCampaign(LARP $larp) {
        if (is_null($larp)) return Array();
        $sql = "SELECT * FROM regsys_titledeed WHERE CampaignId = ? ORDER BY ".static::$orderListBy.";";
        return static::getSeveralObjectsqQuery($sql, array($larp->Id));
    }
    
    
    public function owners() {
        return Role::getTitledeedOwners($this);
    }
 
    
    public function deleteOwner($roleId) {
        $stmt = $this->connect()->prepare("DELETE FROM regsys_titledeed_role WHERE RoleId = ? AND TitledeedId = ?;");
        if (!$stmt->execute(array($roleId, $this->Id))) {
            $stmt = null;
            header("location: ../participant/index.php?error=stmtfailed");
            exit();
        }
        $stmt = null;
    }
    
    public function addRoleOwners($rolesIds) {
        foreach ($rolesIds as $roleId) {
            $stmt = $this->connect()->prepare("INSERT INTO ".
                "regsys_titledeed_role (RoleId, TitledeedId) VALUES (?,?);");
            if (!$stmt->execute(array($roleId, $this->Id))) {
                $stmt = null;
                header("location: ../participant/index.php?error=stmtfailed");
                exit();
            }
            
            $stmt = null;
        }
        
        
    }
    
    
    public function Produces() {
        return Resource::TitleDeedProcuces($this);
    }
    
    public function Requires() {
        return Resource::TitleDeedRequires($this);
    }
    
    public function deleteAllProduces() {   
        $stmt = $this->connect()->prepare("DELETE FROM regsys_resource_titledeed_normally_produces WHERE TitleDeedId = ?;");
        if (!$stmt->execute(array($this->Id))) {
            $stmt = null;
            header("location: ../participant/index.php?error=stmtfailed");
            exit();
        }
        $stmt = null;
    }
        
     
    public function deleteAllRequires() {
        $stmt = $this->connect()->prepare("DELETE FROM regsys_resource_titledeed_normally_requires WHERE TitleDeedId = ?;");
        if (!$stmt->execute(array($this->Id))) {
            $stmt = null;
            header("location: ../participant/index.php?error=stmtfailed");
            exit();
        }
        $stmt = null;
    }
    
    public function setProduces($resourceIds) {
        foreach($resourceIds as $resourceId) {
            $stmt = $this->connect()->prepare("INSERT INTO ".
                "regsys_resource_titledeed_normally_produces (ResourceId, TitleDeedId) VALUES (?,?);");
            if (!$stmt->execute(array($resourceId, $this->Id))) {
                $stmt = null;
                header("location: ../participant/index.php?error=stmtfailed");
                exit();
            }
        }
        $stmt = null;
    }
    
    public function setRequires($resourceIds) {
        foreach($resourceIds as $resourceId) {
            $stmt = $this->connect()->prepare("INSERT INTO ".
                "regsys_resource_titledeed_normally_requires (ResourceId, TitleDeedId) VALUES (?,?);");
            if (!$stmt->execute(array($resourceId, $this->Id))) {
                $stmt = null;
                header("location: ../participant/index.php?error=stmtfailed");
                exit();
            }
        }
        $stmt = null;
    }
    
    
    public function getSelectedProducesResourcesIds() {
        $stmt = $this->connect()->prepare("SELECT ResourceId FROM  regsys_resource_titledeed_normally_produces WHERE TitleDeedId = ? ORDER BY ResourceId;");
        
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
            $resultArray[] = $row['ResourceId'];
        }
        $stmt = null;
        
        return $resultArray;
    }

    public function getSelectedRequiresResourcesIds() {
        $stmt = $this->connect()->prepare("SELECT ResourceId FROM  regsys_resource_titledeed_normally_requires WHERE TitleDeedId = ? ORDER BY ResourceId;");
        
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
            $resultArray[] = $row['ResourceId'];
        }
        $stmt = null;
        
        return $resultArray;
    }
    
    
    
}