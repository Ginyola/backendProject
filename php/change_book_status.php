<?php

require_once("../include/common.inc.php");

requireAuth();

$userId = isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : [];
$bookId = isset($_POST['id']) ? $_POST['id'] : [];
$offer = isset($_POST['offer']) ? $_POST['offer'] : [];
changeBookStatus($userId, $bookId, $offer);