<?php

global $root, $current_user;
$root = $_SERVER['DOCUMENT_ROOT'] . "/regsys";
include_once $root . '/includes/all_includes.php';

session_start([
    'cookie_lifetime' => 86400,
]);


if (!isset($_SESSION['is_loggedin'])) {
    header('Location../index.php');
    exit;
}

if (isset($_POST['larp'])) $larp = $_POST['larp'];
elseif (isset($_GET['larp'])) $larp = $_GET['larp'];

// Now we check if the data from the larp select form was submitted, isset() will check if the data exists.
if ( !isset($larp) ) {
    // Could not get the data that should have been sent.
    exit('Du måste välja ett lajv!');
}

$_SESSION['larp'] = $larp;

$current_user = User::loadById($_SESSION['id']);
$current_larp = LARP::loadById($_SESSION['larp']);

if (AccessControl::hasAccessLarp($current_user, $current_larp) || AccessControl::hasAccessOther($current_user->Id, AccessControl::ADMIN)) header('Location: ../admin/index.php');
else header('Location: ../participant/index.php');