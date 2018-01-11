<?php

$cwd = getcwd();

chdir("../");
require_once("include/common.inc.php");

if(isset($_GET["id"]))
{
    $id = intval($_GET["id"]);
}

$book = getBooksById($id);
$genreLimit = 7;
$genre = getBooksGenre($genreLimit);
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];

$vars = array(
    "book" => $book,
    "genre" => $genre,
    "user" => $user
);

echo getView("book.twig", $vars);

chdir($cwd);
