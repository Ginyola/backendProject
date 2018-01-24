<?php

require_once("../include/common.inc.php");
requireAuth();

$id = (isset($_POST["userId"])) ? intval($_POST["userId"]) : [];

$userInfo = getUserInfo($id);
$vars = array(
    "user" => $userInfo
);

if (!empty($id)) {
    echo getView("book_user_info.twig", $vars);
}