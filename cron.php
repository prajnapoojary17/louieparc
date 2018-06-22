<?php
/*
|---------------------------------------------------------------
| CASTING argc AND argv INTO LOCAL VARIABLES
|---------------------------------------------------------------
|
*/
/*$argc = $_SERVER['argc'];
$argv = $_SERVER['argv'];

if ($argc > 1 && isset($argv[1])) {
$_SERVER['PATH_INFO']   = $argv[1];
$_SERVER['REQUEST_URI'] = $argv[1];
} else {
$_SERVER['PATH_INFO']   = '/crons/index';
$_SERVER['REQUEST_URI'] = '/crons/index';
}*/


/* override normal limitations */
set_time_limit(0);
ini_set('memory_limit', '256M');

/* deny direct call from web browser */
//if (isset($_SERVER['REMOTE_ADDR'])) die('Permission denied.');

/* constants */
define('CMD', 1);

/* manually set the URI path based on command line arguments... */
unset($argv[0]); /* except the first one */
$_SERVER['QUERY_STRING'] =  $_SERVER['PATH_INFO'] = $_SERVER['REQUEST_URI'] = '/' . implode('/', $argv) . '/';
 
/*
|---------------------------------------------------------------
| PHP SCRIPT EXECUTION TIME ('0' means Unlimited)
|---------------------------------------------------------------
|
*/

 
require_once('index.php');
 
/* End of file test.php */