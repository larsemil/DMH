<?php

global $root, $current_user;
$root = $_SERVER['DOCUMENT_ROOT'] . "/regsys";
require $root . '/includes/init.php';

//If the user isnt admin it may not use this page
if (!isset($_SESSION['admin'])) {
    header('Location: ../../participant/index.php');
    exit;
}




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $registrationId = $_POST['RegistrationId'];
    $registration = Registration::loadById($registrationId);
    if (isset($registration)) {

        $registration->Approved = date("Y-m-d");
        
        $registration->update();
        send_approval_mail($registration);
        header('Location: ../persons_to_approve.php');
        exit;
    }
    
}
header('Location: ../index.php');
exit;



function send_approval_mail(Registration $registration) {
    $person = $registration->getPerson();
    $mail = $person->Email;
    
    $larp = $registration->getLARP();
    $roles = $person->getRolesAtLarp($larp);
    
    $campaign = $larp->getCampaign();
    
    $text  = "Dina karaktärer är nu godkända för att vara med i lajvet $larp->Name<br>\n";
    $text .= "<br>\n";
    $text .= "De karaktärer du har anmält är:<br>\n";
    $text .= "<br>\n";
    foreach ($roles as $role) {
        $text .= '* '.$role->Name;
        if ($role->isMain($larp)) {
            $text .= " - Din huvudkaraktär";
        }
        $text .= "<br>\n";
    }
    
    BerghemMailer::send($mail, $person->Name, $text, "Godkänd anmälan till ".$larp->Name);
}