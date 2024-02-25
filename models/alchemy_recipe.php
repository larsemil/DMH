<?php

class Alchemy_Recipe extends BaseModel{
    
    public $Id;
    public $Name;
    public $AlchemistType;
    public $Preparation;
    public $Effect;
    public $SideEffect;
    public $IsApproved = 0;
    public $OrganizerNotes;
    public $Level;
    public $CampaignId;
    
    
    public static $orderListBy = 'Name';
    
    
    public static function newFromArray($post){
        $object = static::newWithDefault();
        $object->setValuesByArray($post);
        return $object;
    }
    
    public function setValuesByArray($arr) {
        if (isset($arr['Id'])) $this->Id = $arr['Id'];
        if (isset($arr['Name'])) $this->Name = $arr['Name'];
        if (isset($arr['AlchemistType'])) $this->AlchemistType = $arr['AlchemistType'];
        if (isset($arr['Preparation'])) $this->Preparation = $arr['Preparation'];
        if (isset($arr['Effect'])) $this->Effect = $arr['Effect'];
        if (isset($arr['SideEffect'])) $this->SideEffect = $arr['SideEffect'];
        if (isset($arr['IsApproved'])) $this->IsApproved = $arr['IsApproved'];
        if (isset($arr['OrganizerNotes'])) $this->OrganizerNotes = $arr['OrganizerNotes'];
        if (isset($arr['Level'])) $this->Level = $arr['Level'];
        if (isset($arr['CampaignId'])) $this->CampaignId = $arr['CampaignId'];
    }
    
    
    # För komplicerade defaultvärden som inte kan sättas i class-defenitionen
    public static function newWithDefault() {
        global $current_larp;
        $object = new self();
        $object->CampaignId = $current_larp->CampaignId;
        return $object;
    }
    
    # Update an existing object in db
    public function update() {
        $stmt = $this->connect()->prepare("UPDATE regsys_alchemy_recipe SET Name=?, AlchemistType=?, Preparation=?, Effect=?, SideEffect=?, 
                IsApproved, Level=?, OrganizerNotes=? WHERE Id = ?");
        
        if (!$stmt->execute(array($this->Name, $this->AlchemistType, $this->Preparation, $this->Effect, $this->SideEffect, 
            $this->IsApproved, $this->Level, $this->OrganizerNotes, $this->Id))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        
        $stmt = null;
    }
    
    
    # Create a new object in db
    public function create() {
        $connection = $this->connect();
        $stmt = $connection->prepare("INSERT INTO regsys_alchemy_recipe (Name, AlchemistType, Preparation, Effect, SideEffect, 
            IsApproved, Level, OrganizerNotes, CampaignId) VALUES (?,?,?,?,?, ?,?,?,?);");
        
        if (!$stmt->execute(array($this->Name, $this->AlchemistType, $this->Preparation, $this->Effect, $this->SideEffect,
            $this->IsApproved, $this->Level, $this->OrganizerNotes, $this->CampaignId))) {
                $this->connect()->rollBack();
                $stmt = null;
                header("location: ../participant/index.php?error=stmtfailed");
                exit();
            }
            $stmt = null;
    }
    
    public function getAllAlchemists() {
        return Alchemy_Alchemist::getAlchemistsThatKnowsRecipe($this);
    }
    
    
    public static function getRecipesForAlchemist(Alchemy_Alchemist $alchemist) {
        $sql = "SELECT * FROM regsys_alchemy_recipe WHERE Id IN (".
            "SELECT AlchemyRecipelId FROM regsys_alchemy_alchemist_recipe WHERE AlchemyAlchemistId=?) ORDER BY ".static::$orderListBy.";";
        return static::getSeveralObjectsqQuery($sql, array($alchemist->Id));
    }
 
    public static function allByCampaign(LARP $larp) {
        if (is_null($larp)) return Array();
        $sql = "SELECT * FROM regsys_alchemy_recipe WHERE CampaignId = ? ORDER BY ".static::$orderListBy.";";
        return static::getSeveralObjectsqQuery($sql, array($larp->CampaignId));
    }
    
    
    public function addToAlchemists($alchemistIds, LARP $larp) {
        //Ta reda på vilka som inte redan är kopplade till receptet
        $exisitingIds = array();
        $recipe_alchemists = $this->getAllAlchemists();
        foreach ($recipe_alchemists as $recipe_alchemist) {
            $exisitingIds[] = $recipe_alchemist->Id;
        }
        
        $newAlchemistIds = array_diff($alchemistIds,$exisitingIds);
        //Koppla recept till alkemist
        foreach ($newAlchemistIds as $alchemistId) {
            $this->addToAlchemist($alchemistId, $larp);
        }
    }
    
    private function addToAlchemist($alchemistId, LARP $larp) {
        
        $stmt = $this->connect()->prepare("INSERT INTO ".
            "regsys_alchemy_alchemist_recipe (AlchemyAlchemistId, AlchemyRecipelId, GrantedLarpId) VALUES (?,?,?);");
        if (!$stmt->execute(array($alchemistId, $this->Id, $larp->Id))) {
            $stmt = null;
            header("location: ../participant/index.php?error=stmtfailed");
            exit();
        }
        
        $stmt = null;
    }
    
    
    
}