<?php

require_once("../include/common.inc.php");
requireAuth();

$bookId = (isset($_POST["id"])) ? $_POST["id"] : [];
$userId = (isset($_SESSION["user"]["user_id"]))? $_SESSION["user"]["user_id"]:[];

if(!empty($bookId) && !empty($userId))
{
    untieUserWithBook($bookId, $userId);
}


