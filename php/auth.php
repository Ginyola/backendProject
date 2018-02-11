<?php

chdir('../');
require_once("include/common.inc.php");

$login = isset($_POST['login']) ? ($_POST['login']) : "";
$pass = isset($_POST['pass']) ? ($_POST['pass']) : "";

if (!empty($login) && !empty($pass)) {
    $userInfo = findUserByLogin($login, $pass);
    if (!empty($userInfo)) {
        saveSessionUser($userInfo);
        header('Location: http://localhost/php/profile.php');
        exit(0);
    } else {
        header('Location: http://localhost/php/sign_in.php');
        exit(0);
    }
}


