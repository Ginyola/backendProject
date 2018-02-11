<?php

header("Location: http://localhost/index.php");
require_once("../include/common.inc.php");
requireAuth();

$bookId = (isset($_POST["id"])) ? $_POST["id"] : [];
$userId = (isset($_SESSION["user"]["user_id"])) ? $_SESSION["user"]["user_id"] : [];
$role = getUserRole($userId);

if ($role == 'admin') {
    if (!empty($bookId) && !empty($userId)) {
        $_SESSION["info_message"] = deleteBook($bookId);
    }
} else {
    $_SESSION["info_message"] = 99;
}