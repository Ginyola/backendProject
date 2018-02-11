<?php

require_once("../include/common.inc.php");

$page = (isset($_POST["page"])) ? intval($_POST["page"]) : 1;
$genre = (($_POST["genre"]) != "") ? intval($_POST["genre"]): "";
$sstr = (($_POST["sstr"]) != "") ? intval($_POST["sstr"]): "";



$listOfBooks = getRecentBooks($page);

$vars = array(
    "books" => $listOfBooks,
);


echo getView("recent_books.twig", $vars);

