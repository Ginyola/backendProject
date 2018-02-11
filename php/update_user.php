<?php

require_once("../include/common.inc.php");
requireAuth();

define('UPLOAD_DIR', "../content/users/avatars/");

$userId = $_SESSION["user"]["user_id"];
$uploadedFiles = & $_FILES["avatar"];

$userName = "";
$address = 0;
$number = "";

    if (isset($_POST["name"])) {$userName = $_POST["name"];}
    if (isset($_POST["address"])) {$address = $_POST["address"];}
    if (isset($_POST["number"])) {$number = $_POST["number"];}

    $user = array("name" => $userName, "address" => $address, "phone_number" => $number);
    
    dbUpdateUser($userId, $user);

    if ($uploadedFiles["error"] === UPLOAD_ERR_OK) {

        dbUploadImage($uploadedFiles, $userId, "update_avatar");
    }
    
    header("Location: http://localhost/php/profile.php");