<?php
require_once("include/common.inc.php");

$listOfBooks = getRecentBooks();

if (isset($_GET["sstr"]) && !empty($_GET["sstr"])) {
    $listOfBooks = getBooksBySubString($_GET["sstr"]);
} else {
    if (isset($_GET["genre"]) && !empty($_GET["genre"])) {
        $listOfBooks = getBooksByGenre($_GET["genre"]);
    }
}

$infoMessage = [];
if (isset($_SESSION["info_message"])) {
    $infoMessage = $_SESSION["info_message"];
    $_SESSION["info_message"] = [];
}

$genre = getBooksGenre();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];

$vars = array("books" => $listOfBooks,
    "genre" => $genre,
    "user" => $user,
    "info_message" => $infoMessage);

echo getView("index.twig", $vars);
