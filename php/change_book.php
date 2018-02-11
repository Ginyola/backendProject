<?php

require_once("../include/common.inc.php");
requireAuth();

//$genre = getBooksGenre();
$allgenres = getBooksGenre();
$user = isset($_SESSION['user']) ? $_SESSION['user'] : [];
$id = isset($_POST['id']) ? $_POST['id'] : [];
$book = getBooksById($id);

$book[0]['print_date']=stristr($book[0]['print_date'], ' ', true);
$vars = array(
    "book" => $book,
    //"genre" => $genre,
    "all_genres" => $allgenres,
    "user" => $user);

echo getView("change_book.twig", $vars);