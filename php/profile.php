<?php

require_once("../include/common.inc.php");

requireAuth();

$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];
$userBooks = !empty($user) ? getUserBooks($user['user_id']) : [];

$role = getUserRole($user['user_id']);

$infoMessage = [];
if (isset($_SESSION["info_message"])) {
    $infoMessage = $_SESSION["info_message"];
    $_SESSION["info_message"] = [];
}

$vars = array("user" => $user,
    "user_books" => $userBooks,
    "role" => $role,
    "info_message" => $infoMessage,);


echo ($role == "admin" ) ? (getView("admin.twig", $vars)) : (getView("profile.twig", $vars));

