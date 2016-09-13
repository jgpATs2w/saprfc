<?php

define('PROJECT_ROOT', realpath(__DIR__ . '/../') . '/');

///////////////////////

// Settings to make all errors more obvious during testing
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set('UTC');
define( 'PRINT_DIE' , false );

require PROJECT_ROOT.'Saprfc.php';
