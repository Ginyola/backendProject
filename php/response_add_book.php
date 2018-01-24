<?php
chdir('../');
header("refresh: 3; url=http://localhost/index.php");
require_once("include/common.inc.php");
requireAuth();

define('UPLOAD_DIR', "content/images/");

$uploadedFiles = & $_FILES["cover"];
$userId = isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : [];

if (empty($userId))
{
    header("Location: http://localhost/php/sign_in.php");
    exit(0);
}

//ToDo: values;
$author = 0;
$genre_id = 0;
$add_info = "";
$print_date = "0000-02-06 00:00:00";

if (isset($_POST["title"])) {$title = $_POST["title"];}
if (isset($_POST["description"])) {$description = $_POST["description"];}
if (isset($_POST["genre"])) {$genre_id = $_POST["genre"];}
if (isset($_POST["author"])) {$author = $_POST["author"];}
if (isset($_POST["add_info"])) {$add_info = $_POST["add_info"];}
if (isset($_POST["print_date"])) {$print_date = $_POST["print_date"];}

$book = array("title" => $title, "author" => $author, "genre_id" => $genre_id, "add_info" => $add_info,
    "print_date" => $print_date, "description" => $description); //"image" => $path
$newId = dbAddBookToLibary($book, $userId);

if ($uploadedFiles["error"] === UPLOAD_ERR_OK) {
    
     dbUploadImage($uploadedFiles, $newId, "cover");
}
