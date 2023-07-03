<?php

class Titledeed extends BaseModel{
    
    public $Id;
    public $Name;
    public $Location;
    public $Tradeable = 1;
    public $IsTradingPost = 0;
    public $CampaignId;
    public $Money = 0;
    public $MoneyForUpgrade = 0;
    public $OrganizerNotes;
    public $PublicNotes;
    public $SpecialUpgradeRequirements;
    
    
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
        if (isset($arr['Money'])) $this->Money = $arr['Money'];
        if (isset($arr['MoneyForUpgrade'])) $this->MoneyForUpgrade = $arr['MoneyForUpgrade'];
        if (isset($arr['OrganizerNotes'])) $this->OrganizerNotes = $arr['OrganizerNotes'];
        if (isset($arr['PublicNotes'])) $this->PublicNotes = $arr['PublicNotes'];
        if (isset($arr['SpecialUpgradeRequirements'])) $this->SpecialUpgradeRequirements = $arr['SpecialUpgradeRequirements'];
        
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
                  CampaignId=?, Money=?, MoneyForUpgrade=?, OrganizerNotes=?, PublicNotes=?, SpecialUpgradeRequirements=? WHERE Id = ?;");
        
        if (!$stmt->execute(array($this->Name, $this->Location, $this->Tradeable, $this->IsTradingPost, 
            $this->CampaignId, $this->Money, $this->MoneyForUpgrade, $this->OrganizerNotes, $this->PublicNotes, 
            $this->SpecialUpgradeRequirements, $this->Id))) {
                $stmt = null;
                header("location: ../index.php?error=stmtfailed");
                exit();
            }
            $stmt = null;
    }
    
    # Create a new object in db
    public function create() {
        $connection = $this->connect();
        $stmt = $connection->prepare("INSERT INTO regsys_titledeed (Name, Location, Tradeable, IsTradingPost, 
            CampaignId, Money, MoneyForUpgrade, OrganizerNotes, PublicNotes, SpecialUpgradeRequirements) VALUES (?,?,?,?,?,?, ?,?,?,?);");
        
        if (!$stmt->execute(array($this->Name, $this->Location, $this->Tradeable, $this->IsTradingPost, 
            $this->CampaignId, $this->Money, $this->MoneyForUpgrade, $this->OrganizerNotes, $this->PublicNotes,
            $this->SpecialUpgradeRequirements))) {
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
    
    
    public function getRoleOwners() {
        return Role::getTitledeedOwners($this);
    }
 
    public function getGroupOwners() {
        return Group::getTitledeedOwners($this);
    }
    
    
    public function deleteRoleOwner($roleId) {
        $stmt = $this->connect()->prepare("DELETE FROM regsys_titledeed_role WHERE RoleId = ? AND TitledeedId = ?;");
        if (!$stmt->execute(array($roleId, $this->Id))) {
            $stmt = null;
            header("location: ../participant/index.php?error=stmtfailed");
            exit();
        }
        $stmt = null;
    }
 
    public function deleteGroupOwner($groupId) {
        $stmt = $this->connect()->prepare("DELETE FROM regsys_titledeed_group WHERE GroupId = ? AND TitledeedId = ?;");
        if (!$stmt->execute(array($groupId, $this->Id))) {
            $stmt = null;
            header("location: ../participant/index.php?error=stmtfailed");
            exit();
        }
        $stmt = null;
    }
    
    public function addRoleOwners($roleIds) {
        //Ta reda på vilka som inte redan är kopplade till lagfarten
        $exisitingRoleIds = array();
        $role_owners = $this->getRoleOwners();
        foreach ($role_owners as $role_owner) {
            $exisitingRoleIds[] = $role_owner->Id;
        }
        
        $newRoleIds = array_diff($roleIds,$exisitingRoleIds);
        foreach ($newRoleIds as $roleId) {
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
    
    public function addGroupOwners($groupIds) {
        //Ta reda på vilka som inte redan är kopplade till lagfarten
        $exisitingGroupIds = array();
        $group_owners = $this->getGroupOwners();
        foreach ($group_owners as $group_owner) {
            $exisitingGroupIds[] = $group_owner->Id;
        }
        
        $newGroupIds = array_diff($groupIds,$exisitingGroupIds);
        foreach ($newGroupIds as $groupId) {
            $stmt = $this->connect()->prepare("INSERT INTO ".
                "regsys_titledeed_group (GroupId, TitledeedId) VALUES (?,?);");
            if (!$stmt->execute(array($groupId, $this->Id))) {
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
    
    function calculateResult(LARP $larp) {
        $resource_titledeeds = Resource_Titledeed::allForTitledeed($this);
        $res = 0;
        foreach ($resource_titledeeds as $resource_titledeed) {
            $resource = $resource_titledeed->getResource();
            $res = $res + $resource->Price * $resource_titledeed->Quantity;
        }
        return $res;
    }
    
}