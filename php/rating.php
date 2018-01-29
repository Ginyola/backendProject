<?php

chdir('../');
require_once("include/common.inc.php");

$book = [];
$rating = '';
$bookId = (isset($_POST["book_id"])) ? ($_POST["book_id"]) : [];
if (isset($_POST["set_rating"])) {
    requireAuth();
    updateBookRating($_SESSION["user"]["user_id"], $bookId, $_POST["set_rating"]);
}

$book = getBookRating($bookId);
$rating = $book[0]["rate"];

echo $rating;
