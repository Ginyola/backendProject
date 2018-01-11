<?php

$cwd = getcwd();

chdir("../");
require_once("include/common.inc.php");

$genreLimit = 7;
$genre = getBooksGenre($genreLimit);
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];

$vars = array(
    "genre" => $genre,
    "user" => $user);

echo getView("registration.twig", $vars);

chdir($cwd);