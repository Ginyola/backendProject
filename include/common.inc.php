<?php

$currentWorkDir = getcwd();
chdir(dirname(__FILE__));

define('ROOT_DIR', dirname(dirname(__FILE__) . "../"));
define('TEMPLATE_DIR', ROOT_DIR . '/template');
define('CONTENT_DIR', ROOT_DIR . '/content');

require_once("../vendor/autoload.php");
require_once("config.inc.php");
require_once("database.inc.php");
require_once("template.inc.php");
require_once("book.inc.php");
require_once("user.inc.php");
require_once("network.inc.php");
require_once("auth.inc.php");

session_start();
dbInitialConnect();

chdir($currentWorkDir);