<?php

require_once("../include/common.inc.php");
requireAuth();

$userId = (isset($_SESSION["user"]["user_id"]))? $_SESSION["user"]["user_id"]:[];
$bookId = (isset($_POST["book_id"])) ? $_POST["book_id"] : [];
$comment = (isset($_POST["comment_text"])) ? $_POST["comment_text"] : [];

addComment($userId, $bookId, $comment);

