<?php
chdir('../');
header("refresh: 5; url=http://localhost/index.php");
require_once("include/common.inc.php");

define('UPLOAD_DIR', "content/users/avatars/");

$uploadedFiles = & $_FILES["avatar"];

$email = "";
$userName = "";
$password = "";
$birthdate = "2000-02-06 00:00:00";
$address = 0;
$number = "";


if (isset($_POST["email"])) {
    $email = strtolower($_POST["email"]);
}

if (!checkUserExist($email)) {
    if (isset($_POST["password"])) {$password = password_hash($_POST["password"] . $email, PASSWORD_DEFAULT);}
    if (isset($_POST["name"])) {$userName = $_POST["name"];}
    if (isset($_POST["birthdate"])) {$birthdate = $_POST["birthdate"];}
    if (isset($_POST["address"])) {$address = $_POST["address"];}
    if (isset($_POST["number"])) {$number = $_POST["number"];}

    $user = array("email" => $email, "name" => $userName, "password" => $password, "birtdate" => $birthdate,
        "address" => $address, "phone_number" => $number);
    $newId = dbAddNewUser($user);

    if ($uploadedFiles["error"] === UPLOAD_ERR_OK) {

        dbUploadImage($uploadedFiles, $newId, "avatar"); //TODO: check function result
    }
} else {
    echo "Error\n";
}