<?php

global $root;
$root = $_SERVER['DOCUMENT_ROOT'] . "/regsys";
require $root . '/includes/init.php';

//If the user isnt admin it may not use this page
if (!isset($_SESSION['admin'])) {
    header('Location: ../../participant/index.php');
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (isset($_POST['Intrigue'])) {
        $roleId = $_POST['Id'];
        $larp_role = LARP_Role::loadByIds($roleId, $current_larp->Id);
        $larp_role->Intrigue = $_POST['Intrigue'];
        $larp_role->update();
    }

    if (isset($_POST['OrganizerNotes'])) {
        $roleId = $_POST['Id'];
        $role = Role::loadById($roleId);
        $role->OrganizerNotes = $_POST['OrganizerNotes'];
        $role->update();
    }
    
       
    if (isset($_POST['Referer']) && $_POST['Referer']!="") {
        header('Location: ' . $_POST['Referer']);
        exit;
    }
           
}
header('Location: ../index.php');