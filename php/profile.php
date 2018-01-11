<?php

$cwd = getcwd();

chdir("../");
require_once("include/common.inc.php");

requireAuth();

$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];
$userBooks = !empty($user) ? getUserBooks($user['user_id']) : [];

$vars = array("user" => $user,
    "user_books" => $userBooks);
$role = getUserRole($user['user_id']);

echo ($role == "admin" ) ? (getView("admin.twig", $vars)) : (getView("profile.twig", $vars)); 

chdir($cwd);

