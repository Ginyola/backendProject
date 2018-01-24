<?php

require_once("include/common.inc.php");

$password = 'testtest@test.ru';
$hash = '$2y$10$7mxUkjjajF3x9mQPfeFREuvmWODiz9KV07BCfF533CX2EsGgk69E2';

$test = password_verify($password, $hash);
var_dump($test);

