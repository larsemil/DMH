<?php


class Registration extends BaseModel{

    
    public $Id;
    public $LARPId;
    public $PersonId;
    public $ApprovedCharacters; //Date
    public $RegisteredAt;
    public $PaymentReference;
    public $AmountToPay = 0;
    public $AmountPayed = 0;
    public $Payed; //Datum
    public $IsMember; 
    public $MembershipCheckedAt;
    public $NotComing = 0;
    public $ToBeRefunded = 0;
    public $RefundDate; 
    public $IsOfficial = 0;
    public $NPCDesire;
    public $HousingRequestId;
    public $GuardianId;
    public $NotComingReason;
    
    public static $orderListBy = 'RegisteredAt';
    
    
    public static function newFromArray($post){
        $registration = static::newWithDefault();
        $registration->setValuesByArray($post);
        return $registration;
    }
    
    public function setValuesByArray($arr) {
        if (isset($arr['Id']))   $this->Id = $arr['Id'];
        if (isset($arr['LARPId'])) $this->LARPId = $arr['LARPId'];
        if (isset($arr['PersonId'])) $this->PersonId = $arr['PersonId'];
        if (isset($arr['ApprovedCharacters'])) $this->ApprovedCharacters = $arr['ApprovedCharacters'];
        if (isset($arr['RegisteredAt'])) $this->RegisteredAt = $arr['RegisteredAt'];
        if (isset($arr['PaymentReference'])) $this->PaymentReference = $arr['PaymentReference'];
        if (isset($arr['AmountToPay'])) $this->AmountToPay = $arr['AmountToPay'];
        if (isset($arr['AmountPayed'])) $this->AmountPayed = $arr['AmountPayed'];
        if (isset($arr['Payed'])) $this->Payed = $arr['Payed'];
        if (isset($arr['IsMember'])) $this->IsMember = $arr['IsMember'];
        if (isset($arr['MembershipCheckedAt'])) $this->MembershipCheckedAt = $arr['MembershipCheckedAt'];
        if (isset($arr['NotComing'])) $this->NotComing = $arr['NotComing'];
        if (isset($arr['ToBeRefunded'])) $this->ToBeRefunded = $arr['ToBeRefunded'];
        if (isset($arr['RefundDate'])) $this->RefundDate = $arr['RefundDate'];
        if (isset($arr['IsOfficial'])) $this->IsOfficial = $arr['IsOfficial'];
        if (isset($arr['NPCDesire'])) $this->NPCDesire = $arr['NPCDesire'];
        if (isset($arr['HousingRequestId'])) $this->HousingRequestId = $arr['HousingRequestId'];
        if (isset($arr['GuardianId'])) $this->GuardianId = $arr['GuardianId'];
        if (isset($arr['NotComingReason'])) $this->NotComingReason = $arr['NotComingReason'];
        
    }
    
    # För komplicerade defaultvärden som inte kan sättas i class-defenitionen
    public static function newWithDefault() {
        return new self();
    }

    public static function allBySelectedLARP(LARP $larp) {
        if (is_null($larp)) return Array();
        $sql = "SELECT * FROM regsys_registration WHERE LARPid = ? ORDER BY ".static::$orderListBy.";";
        return static::getSeveralObjectsqQuery($sql, array($larp->Id));
    }
    
    
    public static function countAllNonOfficials(LARP $larp) {
        if (is_null($larp)) return Array();
        $sql = "SELECT COUNT(*) AS Num FROM regsys_registration WHERE LARPid = ? AND IsOfficial=0;";
        $stmt = static::connectStatic()->prepare($sql);
        
        if (!$stmt->execute(array($larp->Id))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        
        if ($stmt->rowCount() == 0) {
            $stmt = null;
            return array();
        }
        
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;
        return $rows[0]['Num'];
    }
    
    # Update an existing registration in db
    public function update() {
        $stmt = $this->connect()->prepare("UPDATE regsys_registration SET LARPId=?, PersonId=?, ApprovedCharacters=?, 
                RegisteredAt=?, PaymentReference=?, AmountToPay=?, AmountPayed=?,
                Payed=?, IsMember=?, MembershipCheckedAt=?, NotComing=?, ToBeRefunded=?,
                RefundDate=?, IsOfficial=?, NPCDesire=?, HousingRequestId=?, GuardianId=?, NotComingReason=? WHERE Id = ?");
        
        if (!$stmt->execute(array($this->LARPId, $this->PersonId, $this->ApprovedCharacters, 
            $this->RegisteredAt, $this->PaymentReference, $this->AmountToPay, $this->AmountPayed, 
            $this->Payed, $this->IsMember, $this->MembershipCheckedAt, $this->NotComing, $this->ToBeRefunded, 
            $this->RefundDate, $this->IsOfficial, $this->NPCDesire, $this->HousingRequestId, $this->GuardianId, $this->NotComingReason, $this->Id))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        
        $stmt = null;
    }
    	
    
    
    # Create a new registration in db
    public function create() {
        $connection = $this->connect();
        $stmt = $connection->prepare("INSERT INTO regsys_registration (LARPId, PersonId, ApprovedCharacters, RegisteredAt, 
            PaymentReference, AmountToPay, AmountPayed, Payed, IsMember,
            MembershipCheckedAt, NotComing, ToBeRefunded, RefundDate, IsOfficial, 
            NPCDesire, HousingRequestId, GuardianId, NotComingReason) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        
        if (!$stmt->execute(array($this->LARPId, $this->PersonId, $this->ApprovedCharacters, $this->RegisteredAt, $this->PaymentReference, $this->AmountToPay,
            $this->AmountPayed, $this->Payed, $this->IsMember, $this->MembershipCheckedAt, $this->NotComing, $this->ToBeRefunded,
            $this->RefundDate, $this->IsOfficial, $this->NPCDesire, $this->HousingRequestId, $this->GuardianId, $this->NotComingReason))) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        $this->Id = $connection->lastInsertId();
        $stmt = null;
    }
    
    public function isApprovedCharacters() {
        if (isset($this->ApprovedCharacters)) {
            return true;
        }
        return false;
    }
    
    public function hasPayed() {
        if ($this->AmountToPay <= $this->AmountPayed) {
            return true;
        }
        return false;
        
    }
    
    public function isMember() {
        //Vi har fått svar på att man har betalat medlemsavgift för året. Behöver inte kolla fler gånger.
        if ($this->IsMember == 1) return true;
        
        //Kolla inte oftare än en gång per kvart
        if (isset($this->MembershipCheckedAt) && (time()-strtotime($this->MembershipCheckedAt) < 15*60)) return false;
        
        $larp = LARP::loadById($this->LARPId);
        $year = substr($larp->StartDate, 0, 4);
        
        $val = check_membership($this->SocialSecurityNumber, $year);
        
        
        if ($val == 1) {
            $this->IsMember=1;
        }
        else {
            $this->IsMember = 0;
        }
        $now = new Datetime();
        $this->MembershipCheckedAt = date_format($now,"Y-m-d H:i:s");
        $this->update();
        
        if ($this->IsMember == 1) return true;
        return false;
        
    }
 
    public static function loadByIds($personId, $larpId)
    {
        # Gör en SQL där man söker baserat på ID och returnerar ett object mha newFromArray
        $sql = "SELECT * FROM regsys_registration WHERE PersonId = ? AND LARPId = ?";
        return static::getOneObjectQuery($sql, array($personId, $larpId));
    }
    
    public function getPerson() {
        return Person::loadById($this->PersonId);
    }
    
    public function getGuardian() {
        return Person::loadById($this->GuardianId);
    }
    
    public function getLARP() {
        return LARP::loadById($this->LARPId);
    }

    public function getOfficialTypes() {
        if (is_null($this->Id)) return array();
        
        $stmt = $this->connect()->prepare("SELECT * FROM ".
            "regsys_officialtype_person where RegistrationId = ? ORDER BY OfficialTypeId;");
        
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
            $resultArray[] = OfficialType::loadById($row['OfficialTypeId']);
        }
        $stmt = null;
        return $resultArray;
    }
    
    # Spara den här relationen
    public function saveAllOfficialTypes($post) {
        if (!isset($post['OfficialTypeId'])) {
            return;
        }
        foreach($post['OfficialTypeId'] as $Id) {
            $stmt = $this->connect()->prepare("INSERT INTO ".
                "regsys_officialtype_person (OfficialTypeId, RegistrationId) VALUES (?,?);");
            if (!$stmt->execute(array($Id, $this->Id))) {
                $stmt = null;
                header("location: ../participant/index.php?error=stmtfailed");
                exit();
            }
        }
        $stmt = null;
    }
    
    
    public function deleteAllOfficialTypes() {
        $stmt = $this->connect()->prepare("DELETE FROM ".
            "regsys_officialtype_person WHERE RegistrationId = ?;");
        if (!$stmt->execute(array($this->Id))) {
            $stmt = null;
            header("location: ../participant/index.php?error=stmtfailed");
            exit();
        }
        $stmt = null;
    }
    
    public function getSelectedOfficialTypeIds() {
        if (is_null($this->Id)) return array();
        
        $stmt = $this->connect()->prepare("SELECT OfficialTypeId FROM ".
            "regsys_officialtype_person where RegistrationId = ? ORDER BY OfficialTypeId;");
        
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
            $resultArray[] = $row['OfficialTypeId'];
        }
        $stmt = null;
        
        return $resultArray;
    }
    
    public static function totalIncomeToBe(LARP $larp) {
        $registrationArr = static::allBySelectedLARP($larp);
        $income = 0;
        foreach($registrationArr as $registration) {
            $income = $income + $registration ->AmountToPay;
            if (isset($registration->ToBeRefunded)) {
                $income = $income - $registration->ToBeRefunded;
            }
        }
        return $income;
    }
    
    public static function totalIncomeToday(LARP $larp) {
        $registrationArr = static::allBySelectedLARP($larp);
        $income = 0;
        foreach($registrationArr as $registration) {
            $income = $income + $registration ->AmountPayed;
            if (isset($registration->ToBeRefunded) && isset($registration->RefundDate)) {
                $income = $income - $registration->ToBeRefunded;
            }
        }
        return $income;
        
    }
}