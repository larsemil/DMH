<?php

global $root, $current_user;
$root = $_SERVER['DOCUMENT_ROOT'];
require $root . '/includes/init.php';

echo '$_POST :<br>';
print_r($_POST);

echo "<br />";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $operation = $_POST['operation'];

    if ($operation == 'insert') {
        $group = Group::newFromArray($_POST);
        $group->create();
        if (strpos($_POST['action'], "anmälan") == false) {
            header('Location: ../index.php');
        }
        else {
            echo "Till anmälan";
            header('Location: ../group_registration_form.php?new_group='.$group->Id);
        }
        exit;
    } elseif ($operation == 'delete') {
        Group::delete($_POST['Id']);
    } elseif ($operation == 'update') {
        
        $group = Group::newFromArray($_POST);
        $group->update();
        if (strpos($_POST['action'], "anmälan") == false) {
            header('Location: ../index.php');
        }
        else {
            echo "Till anmälan";
            header('Location: ../group_registration_form.php?new_group='.$group->Id);
        }
        exit;
    } else {
        echo $operation;
    }
}
//header('Location: ../index.php');
