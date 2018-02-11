<?php

require_once("../include/common.inc.php");

$infoMessage = [];
if (isset($_SESSION["info_message"])) {
    $infoMessage = $_SESSION["info_message"];
    $_SESSION["info_message"] = [];
}

$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];

$vars = array(
    "user" => $user,
    "info_message" => $infoMessage);

echo getView("change_profile.twig", $vars);