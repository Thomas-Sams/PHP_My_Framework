<?php

define('WEBROOT',str_replace('public/index.php','',$_SERVER['SCRIPT_NAME']));
define('ROOT',str_replace('public/index.php','',$_SERVER['SCRIPT_FILENAME']));

require_once(ROOT . "lib/jupiter/Core.php");
jupiter\Core::run();