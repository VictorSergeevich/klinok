<?php
class router{
	function __construct(){
		//echo"РОУТИНГ";
		//echo"<PRE>"; print_r($_SERVER["REDIRECT_URL"]); echo"</PRE>";
		$template = "site";
		switch ($_SERVER["REDIRECT_URL"]) {
		case "":
   			$index = '/indexTemplate.php';
   		break;
		case "/help":
   			$index = '/' . $_SERVER["REDIRECT_URL"] . '.php';
    	break;
		case "/admin/":
			$template = "admin";
   			$index = '/modules/admin/index.php';
    	break;
		case "/admin/filter/":
			$template = "admin";
   			$index = '/modules/admin/filter.php';
    	break;
		case "/admin/tables/":
			$template = "admin";
   			$index = '/modules/admin/tables.php';
    	break;
		case (strripos($_SERVER["REDIRECT_URL"],"recipe-") !== false && preg_match("/^\/recipe-[0-9\d]*\/$/i", $_SERVER["REDIRECT_URL"])):
   				$index = '/recipes/detail.php';
    	break;
		case (strripos($_SERVER["REDIRECT_URL"],"sovet-") !== false && preg_match("/^\/sovet-[0-9\d]*\/$/i", $_SERVER["REDIRECT_URL"])):
   				$index = '/sovety/detail.php';
    	break;
		case (strripos($_SERVER["REDIRECT_URL"],"ovosh-") !== false && preg_match("/^\/ovosh-[0-9\d]*\/$/i", $_SERVER["REDIRECT_URL"])):
   				$index = '/produkty/ovoshchi/detail.php';
    	break;
		case "/recepty-supov/":
   			$index = '/recipes/category/sup.php';
    	break;
		case "/goryachie-blyuda/":
   			$index = '/recipes/category/goryachie.php';
    	break;
		case "/deserty/":
   			$index = '/recipes/category/deserty.php';
    	break;
		case "/recepty-salatov/":
   			$index = '/recipes/category/salaty.php';
    	break;
		case "/redkie-blyuda/":
   			$index = '/recipes/category/goryachie.php';
    	break;
		case "/ovoshchi/":
   			$index = '/produkty/ovoshchi/index.php';
    	break;
		case "/search/":
   				$index = '/recipes/search.php';
    	break;
		case "/skachat-retsepty-besplatno/":
   				$index = '/recipes/download.php';
    	break;
		case "/razmestit-retsept/":
   				$index = '/recipes/razmestit.php';
    	break;
		case (preg_match("/^\/([a-z]{3})\/$/i", $_SERVER["REDIRECT_URL"]) == 1):
   				$index = '/recipes/city.php';
    	break;
		case "/rating.php":
			$template = "none";
   			$index = '/templates/site/ajax/rating.php';
    	break;
		case "/ratingsovet.php":
			$template = "none";
   			$index = '/templates/site/ajax/ratingsovet.php';
    	break;
		}

		if(empty($index)){
				include __DIR__ . '/404.php';
    			exit;
		}

		ob_start('buffer'); // включение буферизации вывода
		include __DIR__ . '/templates/' . $template . '/header.php';
		include __DIR__ . $index;
		include __DIR__ . '/templates/' . $template . '/footer.php';
		ob_end_flush();


	}
}

/*
* Отложенная фукнция для подмены буфера
*/
function buffer($buffer){
	$result = (str_replace("{SEO}", $GLOBALS["SEO_BUFFER"], $buffer));
	return $result;
}

?>