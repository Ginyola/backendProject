<?php

$cwd = getcwd();

chdir("../");
require_once("include/common.inc.php");

$id = [];
$book = [];
$bookOwners = [];
$user = [];
$role = '';

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $book = getBooksById($id);
    $book[0]['print_date']=stristr($book[0]['print_date'], ' ', true);
}

if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $role = getUserRole($user['user_id']);
    $bookOwners = getBookOwners($id);
    $user['book_offer'] = bookInPosession($user['user_id'], $id);
}

$genre = getBooksGenre();


$vars = array(
    "book" => $book,
    "owner" => $bookOwners,
    "genre" => $genre,
    "user" => $user,
    "role" => $role
);

echo getView("book.twig", $vars);

chdir($cwd);
