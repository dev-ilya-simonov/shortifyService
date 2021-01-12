<?
session_start();
header('Content-Type: text/html; charset=utf-8');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('ROOT', $_SERVER['DOCUMENT_ROOT']); 
define('CLASSES_DIRECTORY',ROOT.'/classes');
define('VIEWS_DIR',ROOT.'/views');
define('PUBLIC_DIR',ROOT.'/public');
define('SHORT_URL_TEMPLATE',$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/s/#LINK#/');

//include_once(ROOT.'settings.php');

/* FUNCTIONS */
//include_once(ROOT.'functions/basicFunctions.php');
function d($arr) {    
    print_r('<pre>');
    print_r($arr);
    print_r('</pre>');
}

/* CLASSES */
include_once(ROOT.'/Autoloader.php');
Autoloader::register();
Settings::checkDBConnection();