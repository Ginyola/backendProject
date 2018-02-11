<?php
require_once("include/common.inc.php");

$listOfBooks = getRecentBooks(1);
$filter = 0;

if (isset($_GET["sstr"]) && !empty($_GET["sstr"])) {
    $listOfBooks = getBooksBySubString($_GET["sstr"]);
    $filter = 1;
} else {
    if (isset($_GET["genre"]) && !empty($_GET["genre"])) {
        $listOfBooks = getBooksByGenre($_GET["genre"]);
        $filter = 1;
    }
}

$infoMessage = [];
if (isset($_SESSION["info_message"])) {
    $infoMessage = $_SESSION["info_message"];
    $_SESSION["info_message"] = [];
}
if (empty($listOfBooks))
{
    $infoMessage = 3;
    $listOfBooks = getRecentBooks(1);
}

$pageNumbers = countPagesPagination();

$genre = getBooksGenre();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];

$vars = array("books" => $listOfBooks,
    "genre" => $genre,
    "user" => $user,
    "info_message" => $infoMessage,
    "pages" => $pageNumbers,
    "filter" => $filter);

echo getView("index.twig", $vars);
