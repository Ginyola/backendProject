<?php

chdir('../');
require_once("include/common.inc.php");

$book = [];
$bookId = (!isset($_POST["book_id"])) ? ($_POST["book_id"]) : [];
if (!isset($_POST["set_rating"])) {
    $book = getBookRating($id);
} else {
    requireAuth();
}

echo $book;
