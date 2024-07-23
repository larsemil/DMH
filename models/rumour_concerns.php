<?php

class Rumour_concerns extends BaseModel{
    
    public $Id;
    public $RumourId;
    public $RoleId;
    public $GroupId;
    
    public static $orderListBy = 'Id';
    
    public static function newFromArray($post){
        $obj = static::newWithDefault();
        $obj->setValuesByArray($post);
        return $obj;
    }
    
    public function setValuesByArray($arr) {
        if (isset($arr['Id'])) $this->Id = $arr['Id'];
        if (isset($arr['RumourId'])) $this->RumourId = $arr['RumourId'];
        if (isset($arr['RoleId'])) $this->RoleId = $arr['RoleId'];
        if (isset($arr['GroupId'])) $this->GroupId = $arr['GroupId'];
    }
    
    # För komplicerade defaultvärden som inte kan sättas i class-defenitionen
    public static function newWithDefault() {
        return new self();
    }
    
    # Create a new object in db
    public function create() {
        $connection = $this->connect();
        $stmt = $connection->prepare("INSERT INTO regsys_rumour_concerns (RumourId, RoleId, GroupId) VALUES (?,?,?)");
        
        if (!$stmt->execute(array($this->RumourId, $this->RoleId, $this->GroupId))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        $this->Id = $connection->lastInsertId();
        $stmt = null;
    }
    
    
    public function getName() {
        if (!empty($this->RoleId)) {
            $role = Role::loadById($this->RoleId);
            return $role->Name;
        } elseif (!empty($this->GroupId)) {
            $group = Group::loadById($this->GroupId);
            return $group->Name;
        }
        return "";
    }
    
    public function getViewLink() {
        if (!empty($this->RoleId)) {
            $role = Role::loadById($this->RoleId);
            return $role->getViewLink();
        } elseif (!empty($this->GroupId)) {
            $group = Group::loadById($this->GroupId);
            return "<a href='view_group.php?id=$group->Id'>$group->Name</a>";
        }
        return "";
    }
    
    public static function getAllForRumour(Rumour $rumour) {
        if (is_null($rumour)) return Array();
        $sql = "SELECT * FROM regsys_rumour_concerns WHERE RumourId = ? ORDER BY ".static::$orderListBy.";";
        return static::getSeveralObjectsqQuery($sql, array($rumour->Id));
        
    }
    
    public function getGroup() {
        if (empty($this->GroupId)) return null;
        return Group::loadById($this->GroupId);
    }
 
    public function getRole() {
        if (empty($this->RoleId)) return null;
        return Role::loadById($this->RoleId);
    }
    
    
}
