<?php
/**
*
* Тут стартует CMS WM ~ 
*/
require_once ($_SERVER["DOCUMENT_ROOT"] . '/settings.php');

use app\app as App;//,app\Application as Application,app\Models as Models,core\Module as Module,core\Core as Core;
//use app\Application as Application;
//use app\Models as Models;
use core\Module as Module;
use core\core as Core;
use core\component as component;

// Путь к шаблону
define('PAGE_TEMPLATE', '../templates/site/');
// Параметры урла
if($_SERVER["REQUEST_URI"]){
	$GET_P_URL = explode("?", $_SERVER["REQUEST_URI"]);
	define('GET_PARAMETRS_URL',$GET_P_URL[1]);
}

// если в урле два слеша и более
if(preg_match("(\/\/{1,})", $_SERVER['REQUEST_URI'])){
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ".preg_replace("(\/\/{1,})", "/", $_SERVER['REQUEST_URI']));
	exit(); 
}

define('SCRIPT_URL',$_SERVER["SCRIPT_URL"]);

$router = new Core();
$router = new router();
?>