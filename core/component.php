<?php
namespace core;
use core\core as Core;
class component extends Core {

	/**
	* метод работает с вызовом компонента и принимает различные параметры
	* @return ничего не возвращает
	* @param $name - имя компонента
	* @param $template - шаблон
	* @param $params - параметры
	*/
	public static function includsComponent($name,$template,$params = false){
		if($name){
			$GLOBALS["name"] = $name;
			if($template){
				$GLOBALS["template"] = $template;
			}
			if($params){
				$GLOBALS["arParams"] = $params;
			}
			include $_SERVER["DOCUMENT_ROOT"] . '/components/' . $name . '/component.php';
		}
		return $elements;
	}

	/**
	* метод подгружает шаблон компонента с полученными данными
	* @return ничего не возвращает
	* @param $arResult - результат выборки
	*/
	public function includeTemplate($arResult = false){
		$name = $GLOBALS["name"];
		$template = $GLOBALS["template"];
		include $_SERVER["DOCUMENT_ROOT"] . '/components/' . $name . '/templates/' . $template . '/template.php';
	}

	/**
	* метод принудительно вызывет 404 страницу с ошибкой
	* @return ничего не возвращает
	*/
	public function get404(){
		ob_clean(); // стирает/очищает буфер
		include $_SERVER["DOCUMENT_ROOT"].'/404.php';
	    exit;
	}

}
?>