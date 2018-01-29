<?php

$cwd = getcwd();

require_once("../include/common.inc.php");
requireAuth();

$allgenres = getBooksGenre();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];

$vars = array(
   // "genre" => $genre,
    "all_genres" => $allgenres,
    "user" => $user);

echo getView("add_book.twig", $vars);

chdir($cwd);
