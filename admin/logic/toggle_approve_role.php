<?php
include_once '../header.php';

if (!isset( $_POST['roleId']) && !isset( $_POST['groupId'])) {
    header('Location: ../index.php');
    exit;
}

if (isset($_POST['roleId'])) {
    $role = Role::loadById($_POST['roleId']);

    if ($role->isApproved()) $role->unapprove($current_larp, true);
    else $role->approve($current_larp, $current_user);
    $location = "../view_role.php?id=$role->Id";
} elseif (isset($_POST['groupId'])) {
    $group = Group::loadById($_POST['groupId']);
    
    if ($group->isApproved()) $group->unapprove($current_larp, true);
    else $group->approve($current_larp, $current_user);
    $location = "../view_group.php?id=$group->Id";
}


if (isset($_SERVER['HTTP_REFERER'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}

echo $location;
header('Location: '.$location);
