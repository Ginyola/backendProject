<?php
require_once("include/common.inc.php");

$listOfBooks = getRecentBooks();

if (isset($_POST["sstr"]) && !empty($_POST["sstr"])) {
    $listOfBooks = getBooksBySubString($_POST["sstr"]);
}

if (isset($_GET["genre"]) && !empty($_GET["genre"])) {
    $listOfBooks = getBooksByGenre($_GET["genre"]);
}

$genreLimit = 7;
$genre = getBooksGenre($genreLimit);
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];


$vars = array("books" => $listOfBooks,
    "genre" => $genre,
    "user" => $user);

echo getView("index.twig", $vars);
