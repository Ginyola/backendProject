<?php

require_once("../include/common.inc.php");

$id = [];
$book = [];
$bookOwners = [];
$user = [];
$role = '';
$comments = [];

$infoMessage = [];
if (isset($_SESSION["info_message"])) {
    $infoMessage = $_SESSION["info_message"];
    $_SESSION["info_message"] = [];
}

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $book = getBooksById($id);
    $book[0]['print_date'] = stristr($book[0]['print_date'], ' ', true);

    $comments = getComments($id);
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $role = getUserRole($user['user_id']);
    $bookOwners = getBookOwners($id, 1);
    $user['book_offer'] = bookInPosession($user['user_id'], $id);
}


$genre = getBooksGenre();
$countComments = count($comments);

$vars = array(
    "book" => $book,
    "owner" => $bookOwners,
    "info_message" => $infoMessage,
    "genre" => $genre,
    "user" => $user,
    "role" => $role,
    "comments" => $comments,
    "count_comments" => $countComments
);

echo getView("book.twig", $vars);
