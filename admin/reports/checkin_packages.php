<?php
# Läs mer på http://www.fpdf.org/

global $root, $current_user, $current_larp;
$root = $_SERVER['DOCUMENT_ROOT'] . "/regsys";

require_once $root . '/pdf/report_pdf.php';

include_once '../header.php';

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    header('Location: ../../admin/index.php');
    exit;
}

$name = 'Paketering';

// $pdf = new Report_PDF('L'); # Argument som är gilltiga är 'P' och 'L'
$pdf = new Report_PDF('P'); # Argument som är gilltiga är 'P' och 'L'

$pdf->SetTitle(encode_utf_to_iso($name));
$pdf->SetAuthor(encode_utf_to_iso($current_user->Name));
$pdf->SetCreator('Omnes Mundi');
$pdf->AddFont('Helvetica','');
$pdf->SetSubject(encode_utf_to_iso($name));


function cmp($a, $b)
{
    if ($a->Name == $b->Name) {
        return 0;
    }
    return ($a->Name < $b->Name) ? -1 : 1;
}

$roles = Role::getAllMainRoles($current_larp, false);
usort($roles, "cmp");
$currency = $current_larp->getCampaign()->Currency;
$rows = array();
$rows[] = array("Namn", "Ska ha                                                                                                                        ");
foreach ($roles as $role) {
    $larp_role = LARP_Role::loadByIds($role->Id, $current_larp->Id);
    $checkin_letters = $role->getAllCheckinLetters($current_larp);
    $checkin_telegrams = $role->getAllCheckinTelegrams($current_larp);
    $checkin_props = $role->getAllCheckinProps($current_larp);
    
    $package = "";
    
    //Pengar
    $start_money = (isset($larp_role->StartingMoney)) ? $larp_role->StartingMoney : '0';
    $package .= "$start_money $currency\n";
    
    
    //Verksamheter
    $titlededsArr = array();
    $titledeeds = Titledeed::getAllForRole($role);
    foreach ($titledeeds as $titledeed) {
        if ($titledeed->IsFirstOwnerRole($role)) {
           $titlededsArr[] = "  $titledeed->Name";
        }
    }
    if (!empty($titlededsArr)) $package .= "Verksamheter:\n".implode("\n", $titlededsArr)."\n";
    
    
    
    $docuumentsArr = array();
    //Intrighandouts
    $intrigues = Intrigue::getAllIntriguesForRole($role->Id, $current_larp->Id);
    foreach ($intrigues as $intrigue) {
        $intrgueActor = IntrigueActor::getRoleActorForIntrigue($intrigue, $role);
        $intrigue_Pdfs = $intrgueActor->getAllPdfsThatAreKnown();
        foreach($intrigue_Pdfs as $intrigue_Pdf) {
            $docuumentsArr[] = "  $intrigue_Pdf->Filename";
        }
    }
    
    
    //Brev
    foreach($checkin_letters as $checkin_letter) {
        $letter = $checkin_letter->getIntrigueLetter()->getLetter();   
        $docuumentsArr[] = "  Brev från: $letter->Signature till: $letter->Recipient";
    }
    
    //Telegram
    foreach($checkin_telegrams as $checkin_telegram) {
        $telegram = $checkin_telegram->getIntrigueTelegram()->getTelegram();
        $docuumentsArr[] = "  Telegram från: $telegram->Sender till: $telegram->Reciever";
    }
    if (!empty($docuumentsArr)) $package .= "Dokument:\n".implode("\n", $docuumentsArr)."\n";

    //Props
    $props_txt_Arr = array();
    foreach($checkin_props as $checkin_props) $props_txt_Arr[] = $checkin_props->getIntrigueProp()->getProp()->Name;
    if (!empty($props_txt_Arr)) $package .= "Rekvisita: ". implode(", ", $props_txt_Arr);

    
    $rows[] = array($role->Name, $package);
}
$pdf->new_report($current_larp, "Karaktärer ska ha vid lajvstart", $rows);



$groups = Group::getAllRegistered($current_larp);
$rows = array();
$rows[] = array("Namn", "Ska ha                                                                                                                        ");
foreach ($groups as $group) {
    $larp_group = LARP_Group::loadByIds($group->Id, $current_larp->Id);
    $checkin_letters = $group->getAllCheckinLetters($current_larp);
    $checkin_telegrams = $group->getAllCheckinTelegrams($current_larp);
    $checkin_props = $group->getAllCheckinProps($current_larp);
    
    $package = "";
    
    //Pengar
    $start_money = (isset($larp_group->StartingMoney)) ? $larp_group->StartingMoney : '0';
    $package .= "$start_money $currency\n";
    
    
    //Verksamheter
    $titlededsArr = array();
    $titledeeds = Titledeed::getAllForGroup($group);
    foreach ($titledeeds as $titledeed) {
        if ($titledeed->IsFirstOwnerGroup($group)) {
            $titlededsArr[] = "  $titledeed->Name";
        }
    }
    if (!empty($titlededsArr)) $package .= "Verksamheter:\n".implode("\n", $titlededsArr)."\n";
    
    
    
    $docuumentsArr = array();
    //Intrighandouts
    $intrigues = Intrigue::getAllIntriguesForGroup($group->Id, $current_larp->Id);
    foreach ($intrigues as $intrigue) {
        $intrgueActor = IntrigueActor::getGroupActorForIntrigue($intrigue, $group);
        $intrigue_Pdfs = $intrgueActor->getAllPdfsThatAreKnown();
        foreach($intrigue_Pdfs as $intrigue_Pdf) {
            $docuumentsArr[] = "  $intrigue_Pdf->Filename";
        }
    }
    
    
    //Brev
    foreach($checkin_letters as $checkin_letter) {
        $letter = $checkin_letter->getIntrigueLetter()->getLetter();
        $docuumentsArr[] = "  Brev från: $letter->Signature till: $letter->Recipient";
    }
    
    //Telegram
    foreach($checkin_telegrams as $checkin_telegram) {
        $telegram = $checkin_telegram->getIntrigueTelegram()->getTelegram();
        $docuumentsArr[] = "  Telegram från: $telegram->Sender till: $telegram->Reciever";
    }
    if (!empty($docuumentsArr)) $package .= "Dokument:\n".implode("\n", $docuumentsArr)."\n";
    
    //Props
    $props_txt_Arr = array();
    foreach($checkin_props as $checkin_props) $props_txt_Arr[] = $checkin_props->getIntrigueProp()->getProp()->Name;
    if (!empty($props_txt_Arr)) $package .= "Rekvisita: ". implode(", ", $props_txt_Arr);
    
    
    $rows[] = array($group->Name, $package);
}
$pdf->new_report($current_larp, "Grupper ska ha vid lajvstart", $rows);


$pdf->Output();
