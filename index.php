<?php
/**
 * Файл index.php расположен в корне CMS, является единственной точкой инициализирующей работу системы.
 *
 * В этом файле:
 *  - настраивается вывод ошибок;
 *  - устанавлюиваются константы для работы движка;
 *
 * @author Виктор Малетин <klinok92@inbox.ru>
 * @version 1.1
 * @copyright Copyright (c) 2017 
 * @todo сама CMS система будет иметь в ближайшее время обширную админ часть
 * @package files
 * @subpackage Files
 */

/**
* автозагрузчик классов - заменяет - require($_SERVER["DOCUMENT_ROOT"] . "/app/App.php");
* @param $class_name - собирает все классы с подключения use
*/
spl_autoload_register(function ($class_name) {
	if(strripos($class_name, "PDO") === false){
    	include '' . str_replace('\\','/',$class_name) . '.php';
	}
});

/**
 * Подключает движок и запускает CMS.
 */
require_once ( __DIR__ . '/core/wm-start.php');