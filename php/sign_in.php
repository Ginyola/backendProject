<?php

require_once("../include/common.inc.php");

$genre = getBooksGenre();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : []; //ToDo: пользователь ведь уже залогинен?

$infoMessage = [];
if (isset($_SESSION["info_message"])) {
    $infoMessage = $_SESSION["info_message"];
    $_SESSION["info_message"] = [];
}

$vars = array("genre" => $genre,
    "info_message" => $infoMessage,
    "user" => $user);

echo getView("sign_in.twig", $vars);