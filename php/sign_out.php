<?php

header("Location: http://localhost/index.php");

$cwd = getcwd();

chdir("../");
require_once("include/common.inc.php");

unset($_SESSION['user']);

chdir($cwd);
