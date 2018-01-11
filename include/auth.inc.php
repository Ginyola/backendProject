<?php

function getSessionUser() {
    $userInfo = [];

    if (isset($_SESSION['user']['user_id'])) {
        $userInfo['user_id'] = $_SESSION['user']['user_id'];
    }
    
    return $userInfo;
}

function requireAuth()
{
    $userInfo = getSessionUser();
    if(empty($userInfo)){
        header("Location: http://localhost/php/sign_in.php");
        exit(0);
    }
}

function saveSessionUser($userInfo)
{
    $_SESSION['user'] = $userInfo;
}