<?php

class Role extends BaseModel{
    
    public $Id;
    public $Name;
    public $Profession;
    public $Description;
    public $DescriptionForGroup;
    public $DescriptionForOthers;
    public $PreviousLarps;
    public $ReasonForBeingInSlowRiver;
    public $Religion;
    public $DarkSecret;
    public $DarkSecretIntrigueIdeas;
    public $IntrigueSuggestions;
    public $NotAcceptableIntrigues;
    public $OtherInformation; 
    public $PersonId;
    public $GroupId;
    public $WealthId;
    public $PlaceOfResidenceId;
    public $Photo;
    public $Birthplace;
    public $CharactersWithRelations;
    public $CampaignId;
    public $ImageId;
    public $IsDead = 0;
    public $OrganizerNotes;
    

    public static $orderListBy = 'Name';
    
    
    public static function newFromArray($post){
        $role = static::newWithDefault();
        $role->setValuesByArray($post);
        return $role;
    }
    
    public function setValuesByArray($arr) {

        if (isset($arr['Id']))   $this->Id = $arr['Id'];
        if (isset($arr['Name'])) $this->Name = $arr['Name'];
        if (isset($arr['Profession'])) $this->Profession = $arr['Profession'];
        if (isset($arr['Description'])) $this->Description = $arr['Description'];
        if (isset($arr['DescriptionForGroup'])) $this->DescriptionForGroup = $arr['DescriptionForGroup'];
        if (isset($arr['DescriptionForOthers'])) $this->DescriptionForOthers = $arr['DescriptionForOthers'];
        if (isset($arr['PreviousLarps'])) $this->PreviousLarps = $arr['PreviousLarps'];
        if (isset($arr['ReasonForBeingInSlowRiver'])) $this->ReasonForBeingInSlowRiver = $arr['ReasonForBeingInSlowRiver'];
        if (isset($arr['Religion'])) $this->Religion = $arr['Religion'];
        if (isset($arr['DarkSecret'])) $this->DarkSecret = $arr['DarkSecret'];
        if (isset($arr['DarkSecretIntrigueIdeas'])) $this->DarkSecretIntrigueIdeas = $arr['DarkSecretIntrigueIdeas'];
        if (isset($arr['IntrigueSuggestions'])) $this->IntrigueSuggestions = $arr['IntrigueSuggestions'];
        if (isset($arr['NotAcceptableIntrigues'])) $this->NotAcceptableIntrigues = $arr['NotAcceptableIntrigues'];
        if (isset($arr['OtherInformation'])) $this->OtherInformation = $arr['OtherInformation'];
        if (isset($arr['PersonId'])) $this->PersonId = $arr['PersonId'];
        if (isset($arr['GroupId'])) $this->GroupId = $arr['GroupId'];
        if (isset($arr['WealthId'])) $this->WealthId = $arr['WealthId'];
        if (isset($arr['PlaceOfResidenceId'])) $this->PlaceOfResidenceId = $arr['PlaceOfResidenceId'];
        if (isset($arr['Birthplace'])) $this->Birthplace = $arr['Birthplace'];
        if (isset($arr['CharactersWithRelations'])) $this->CharactersWithRelations = $arr['CharactersWithRelations'];
        if (isset($arr['CampaignId'])) $this->CampaignId = $arr['CampaignId'];
        if (isset($arr['ImageId'])) $this->ImageId = $arr['ImageId'];
        if (isset($arr['IsDead'])) $this->IsDead = $arr['IsDead'];
        if (isset($arr['OrganizerNotes'])) $this->OrganizerNotes = $arr['OrganizerNotes'];
        
        if (isset($this->GroupId) && $this->GroupId=='null') $this->GroupId = null;
        if (isset($this->ImageId) && $this->ImageId=='null') $this->ImageId = null;
        
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
        $stmt = $this->connect()->prepare("UPDATE regsys_role SET Name=?, Profession=?, Description=?,
                                                              DescriptionForGroup=?, DescriptionForOthers=?,
                                                              PreviousLarps=?, ReasonForBeingInSlowRiver=?, Religion=?, DarkSecret=?,
                                                              DarkSecretIntrigueIdeas=?, IntrigueSuggestions=?, NotAcceptableIntrigues=?, OtherInformation=?,
                                                              PersonId=?, GroupId=?, WealthId=?, PlaceOfResidenceId=?, Birthplace=?, 
                                                              CharactersWithRelations=?, CampaignId=?, ImageId=?, IsDead=?, OrganizerNotes=? WHERE Id = ?;");
        
        if (!$stmt->execute(array($this->Name, $this->Profession, $this->Description, 
            $this->DescriptionForGroup, $this->DescriptionForOthers, $this->PreviousLarps, 
            $this->ReasonForBeingInSlowRiver, $this->Religion, $this->DarkSecret, $this->DarkSecretIntrigueIdeas,
            $this->IntrigueSuggestions, $this->NotAcceptableIntrigues, $this->OtherInformation, $this->PersonId, 
            $this->GroupId, $this->WealthId, $this->PlaceOfResidenceId,
            $this->Birthplace, $this->CharactersWithRelations, $this->CampaignId, $this->ImageId, $this->IsDead, $this->OrganizerNotes, $this->Id))) {
                $stmt = null;
                header("location: ../index.php?error=stmtfailed");
                exit();
            }
            $stmt = null;
    }
    
    # Create a new object in db
    public function create() { 
        $connection = $this->connect();
        $stmt = $connection->prepare("INSERT INTO regsys_role (Name, Profession, Description, 
                                                            DescriptionForGroup, DescriptionForOthers, PreviousLarps,
                                                            ReasonForBeingInSlowRiver, Religion, DarkSecret, DarkSecretIntrigueIdeas,
                                                            IntrigueSuggestions, NotAcceptableIntrigues, OtherInformation, PersonId,
                                                            GroupId, WealthId, PlaceOfResidenceId,
                                                            Birthplace, CharactersWithRelations, CampaignId, ImageId, IsDead, OrganizerNotes) VALUES (?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?,?,?, ?,?,?);");
        
        if (!$stmt->execute(array($this->Name, $this->Profession, $this->Description, $this->DescriptionForGroup, 
            $this->DescriptionForOthers,$this->PreviousLarps,
            $this->ReasonForBeingInSlowRiver, $this->Religion, $this->DarkSecret, $this->DarkSecretIntrigueIdeas,
            $this->IntrigueSuggestions, $this->NotAcceptableIntrigues, $this->OtherInformation, $this->PersonId,
            $this->GroupId, $this->WealthId, $this->PlaceOfResidenceId,
            $this->Birthplace, $this->CharactersWithRelations, $this->CampaignId, $this->ImageId, $this->IsDead, $this->OrganizerNotes))) {
                $this->connect()->rollBack();
                $stmt = null;
                header("location: ../participant/index.php?error=stmtfailed");
                exit();
            }
            
            $this->Id = $connection->lastInsertId();
            $stmt = null;
    }
    
    
    public function getGroup() {
        return Group::loadById($this->GroupId);
    }
    
    public function getPerson() {
        return Person::loadById($this->PersonId);
    }
    
    public function getCampaign() {
        return Campaign::loadById($this->CampaignId);
    }

    public function isRegistered(LARP $larp) {
        return LARP_Role::isRegistered($this->Id, $larp->Id);
        
    } 

    public function userMayEdit(LARP $larp) {
        return LARP_Role::userMayEdit($this->Id, $larp->Id);
        
    }
    
    public function getWealth() {
        if (is_null($this->WealthId)) return null;
        return Wealth::loadById($this->WealthId);
    }
    
    public function getPlaceOfResidence() {
        if (is_null($this->PlaceOfResidenceId)) return null;
        return PlaceOfResidence::loadById($this->PlaceOfResidenceId);
    }
    
    
    public function hasIntrigue(LARP $larp) {
        $larp_role = LARP_Role::loadByIds($this->Id, $larp->Id);
        if (isset($larp_role->Intrigue) && $larp_role->Intrigue != "") return true;
        return false;
        
    }
    
    public function getRegistration(LARP $larp) {
        return Registration::loadByIds($this->PersonId, $larp->Id);
    }
    
    public function isMain(LARP $larp) {
        $larp_role = LARP_Role::loadByIds($this->Id, $larp->Id);
        return $larp_role->IsMainRole;
    }
    
    public function hasImage() {
        if (isset($this->ImageId)) return true;
        return false;
    }
    
    
    public function getPreviousLarps() {
        return LARP::getPreviousLarps($this->Id);
    }
    
    
    public static function getRolesForPerson($personId) {
        if (is_null($personId)) return Array();
        $sql = "SELECT * FROM regsys_role WHERE PersonId = ? ORDER BY ".static::$orderListBy.";";
        return static::getSeveralObjectsqQuery($sql, array($personId));
    }
    
    public static function getAliveRolesForPerson($personId) {
        if (is_null($personId)) return Array();
        $sql = "SELECT * FROM regsys_role WHERE PersonId = ? AND IsDead=0 ORDER BY ".static::$orderListBy.";";
        return static::getSeveralObjectsqQuery($sql, array($personId));
    }
    
    # Hämta de karaktärer en person har anmält till ett lajv
    public static function getRegistredRolesForPerson(Person $person, LARP $larp) {
        if (is_null($person) || is_null($larp)) return Array();
        $sql = "SELECT * FROM regsys_role, regsys_larp_role WHERE ".
        "regsys_role.PersonId = ? AND ".
        "regsys_role.Id=regsys_larp_role.RoleId AND ".
        "regsys_larp_role.LarpId=? ORDER BY ".static::$orderListBy.";";
        return static::getSeveralObjectsqQuery($sql, array($person->Id, $larp->Id));
    }
   
    
    
    # Hämta huvudkaraktären för en person har anmält till ett lajv
    public static function getMainRoleForPerson(Person $person, LARP $larp) {
        if (is_null($person) || is_null($larp)) return Array();
        $sql = "SELECT * FROM regsys_role, regsys_larp_role WHERE ".
            "regsys_role.PersonId = ? AND ".
            "regsys_role.Id=regsys_larp_role.RoleId AND ".
            "regsys_larp_role.IsMainRole = 1 AND ".
            "regsys_larp_role.LarpId=?;";
        return static::getOneObjectQuery($sql, array($person->Id, $larp->Id));
    }
    
    
    # Hämta anmälda karaktärer i en grupp
    public static function getRegisteredRolesInGroup($group, $larp) {
        if (is_null($group) || is_null($larp)) return Array();
        $sql = "SELECT * FROM regsys_role, regsys_larp_role WHERE ".
        "regsys_role.GroupId = ? AND ".
        "regsys_role.Id=regsys_larp_role.RoleId AND ".
        "regsys_larp_role.LarpId=? ORDER BY ".static::$orderListBy.";";
        return static::getSeveralObjectsqQuery($sql, array($group->Id, $larp->Id));
    }
    
    public static function getAllRoles(LARP $larp) {
        if (is_null($larp)) return Array();
        $sql = "SELECT * FROM regsys_role WHERE Id IN ".
            "(SELECT RoleId FROM regsys_larp_role WHERE larpid=?) ".
            "ORDER BY GroupId, Name;";
        return static::getSeveralObjectsqQuery($sql, array($larp->Id));
    }
    
    public static function getAllMainRoles(LARP $larp) {
        if (is_null($larp)) return Array();
        $sql = "SELECT * FROM regsys_role WHERE Id IN ".
            "(SELECT RoleId FROM regsys_larp_role WHERE larpid=? AND IsMainRole=1) ".
            "ORDER BY GroupId, Name;";
        return static::getSeveralObjectsqQuery($sql, array($larp->Id));
    }
    
    public static function getAllUnregisteredRoles(LARP $larp) {
        if (is_null($larp)) return Array();
        $sql = "SELECT * FROM regsys_role WHERE Id NOT IN ".
            "(SELECT RoleId FROM regsys_larp_role WHERE larpid=?) AND ".
            "CampaignId = ? ORDER BY PersonId, Name;";
        return static::getSeveralObjectsqQuery($sql, array($larp->Id, $larp->CampaignId));
    }
    
    
    public static function getAllMainRolesInGroup(Group $group, LARP $larp) {
        if (is_null($group) or is_null($larp)) return Array();
        $sql = "SELECT * FROM regsys_role WHERE Id IN ".
            "(SELECT RoleId FROM regsys_larp_role WHERE ".
            "groupId =? AND larpid=? AND IsMainRole=1) ORDER BY Name;";
        return static::getSeveralObjectsqQuery($sql, array($group->Id, $larp->Id));
    }
    
    
    public static function getAllNonMainRolesInGroup(Group $group, LARP $larp) {
        if (is_null($group) or is_null($larp)) return Array();
        $sql = "SELECT * FROM regsys_role WHERE Id IN ".
            "(SELECT RoleId FROM regsys_larp_role WHERE ".
            "groupId =? AND larpid=? AND IsMainRole=0) ORDER BY Name;";
        return static::getSeveralObjectsqQuery($sql, array($group->Id, $larp->Id));
    }
    
    
    public static function getAllMainRolesWithoutGroup(LARP $larp) {
        if (is_null($larp)) return Array();
        $sql = "SELECT * FROM regsys_role WHERE Id IN ".
            "(SELECT RoleId FROM regsys_larp_role WHERE ".
            "groupId IS NULL AND larpid=? AND IsMainRole=1) ORDER BY Name;";
        return static::getSeveralObjectsqQuery($sql, array($larp->Id));
    }
 
    
    public static function getAllNonMainRolesWithoutGroup(LARP $larp) {
        if (is_null($larp)) return Array();
        $sql = "SELECT * FROM regsys_role WHERE Id IN ".
            "(SELECT RoleId FROM regsys_larp_role WHERE ".
            "groupId IS NULL AND larpid=? AND IsMainRole=0) ORDER BY Name;";
        return static::getSeveralObjectsqQuery($sql, array($larp->Id));
    }
    
    
    public static function getAllNotMainRoles(LARP $larp) {
        if (is_null($larp)) return Array();
        $sql = "SELECT * FROM regsys_role WHERE Id IN ".
            "(SELECT RoleId FROM regsys_larp_role WHERE ".
        "larpId =? AND IsMainRole=0) ORDER BY GroupId;";
        return static::getSeveralObjectsqQuery($sql, array($larp->Id));
    }
    
    public function groupIsRegistered(Larp $larp) {
        if (!isset($this->GroupId)) return true;
        return $this->GetGroup()->isRegistered($larp);
    }
    
    public function isNeverRegistered() {
        $sql = "SELECT COUNT(*) AS Num FROM regsys_larp_role WHERE RoleId=?;";
        
        $stmt = static::connectStatic()->prepare($sql);
        
        if (!$stmt->execute(array($this->Id))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        
        if ($stmt->rowCount() == 0) {
            $stmt = null;
            return true;
            
        }
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $stmt = null;
        
        
        if ($res[0]['Num'] == 0) return true;
        return false;
        
    }
    
    public function is_trading(LARP $larp) {
        $campaign = $larp->getCampaign();
        if (!$campaign->is_dmh()) return false;
        $person = $this->getPerson();
        if (empty($person)) return false;
        if ($person->isMysLajvare()) return false;
        if ($this->WealthId > 2) return true;
        $intrigtyper = commaStringFromArrayObject($this->getIntrigueTypes());
        return (str_contains($intrigtyper, 'Handel'));
        # Hantering för de som har gamla lagfarter
    }
    
    public function lastLarp() {
        return LARP::lastLarp($this);
    }
    
    # Hämta intrigtyperna
    public function getIntrigueTypes(){
        return IntrigueType::getIntrigeTypesForRole($this->Id);
    }
    
    
    
    
    public function getSelectedIntrigueTypeIds() {
        $stmt = $this->connect()->prepare("SELECT IntrigueTypeId FROM  regsys_intriguetype_role WHERE RoleId = ? ORDER BY IntrigueTypeId;");
        
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
    
    public function saveAllIntrigueTypes($idArr) {
        if (!isset($idArr)) {
            return;
        }
        foreach($idArr as $Id) {
            $stmt = $this->connect()->prepare("INSERT INTO regsys_intriguetype_role (IntrigueTypeId, RoleId) VALUES (?,?);");
            if (!$stmt->execute(array($Id, $this->Id))) {
                $stmt = null;
                header("location: ../participant/index.php?error=stmtfailed");
                exit();
            }
        }
        $stmt = null;
    }
    
    public function deleteAllIntrigueTypes() {
        $stmt = $this->connect()->prepare("DELETE FROM regsys_intriguetype_role WHERE RoleId = ?;");
        if (!$stmt->execute(array($this->Id))) {
            $stmt = null;
            header("location: ../participant/index.php?error=stmtfailed");
            exit();
        }
        $stmt = null;
    }
    
    
}