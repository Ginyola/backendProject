<?php
$cwd = getcwd();

chdir("../");
require_once("include/common.inc.php");
requireAuth();

$genreLimit = 7;
$genre = getBooksGenre($genreLimit);
$allgenres = getBooksGenre(100);
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];

$vars = array(
    "genre" => $genre,
    "all_genres" => $allgenres,
    "user" => $user);

echo getView("add_book.twig", $vars);

chdir($cwd);
