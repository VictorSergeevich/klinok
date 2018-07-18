<?php
namespace core;
use core\bdconnect as BD;
class core{
	function __construct(){
		$BD = new BD();
	}

	/**
	* метод работает с таблицей пользователей
	* @return возращает список всех пользователей array
	*/
	public static function getUsers(){
		$users = bdconnect::fetch(false,"*","users");
		return $users;
	}

	/**
	* метод работает с таблицей элементов
	* @return возращает список всех пользователей array
	*/
	public static function getElements(){
		$elements = bdconnect::fetch(false,"*","elements");
		return $elements;
	}

	/**
	* метод работает с таблицей элементов
	* @param $params - параметры необходимые для обновления VOTES_CNT=10,VOTE_SUM=50
	* @param $id - ID элемента
	* @return возращает список всех пользователей array
	*/
	public static function elementUpdate($params,$id){
		if(empty($id) or empty($params)){
			return false;
		}
		$update = bdconnect::update("elements",$params,"ID=".$id);
		return $update;
	}

	/**
	* метод работает с таблицей советов
	* @param $params - параметры необходимые для обновления VOTES_CNT=10,VOTE_SUM=50
	* @param $id - ID элемента
	* @return возращает список всех пользователей array
	*/
	public static function sovetUpdate($params,$id){
		if(empty($id) or empty($params)){
			return false;
		}
		$update = bdconnect::update("sovet",$params,"ID=".$id);
		return $update;
	}

	/**
	* метод работает с любой таблицей
	* @param $filter - фильтр запроса к базе
	* @param $select - необходимые поля через запятую в верхнем регистре ID,NAME
	* @param $table - имя таблицы
	* @return возращает таблицу в соответствии с параметрами
	*/
	public static function getItems($filter,$select,$table,$pagination = false,$order = false){
		if(empty($filter)){
			$filter = false;
		}
		if(is_array($filter)){
			if($filter["AND"]){
				$fil = "";
				foreach ($filter["AND"] as $item) {
					$fil .= $item." AND ";
				}
				$filter = substr($fil,0,-5);
			}
			elseif($filter["OR"]){
				$fil = "";
				foreach ($filter["OR"] as $item) {
					$fil .= $item." OR ";
				}
				$filter = substr($fil,0,-4);
			}
		}
		if(empty($select)){
			$select = "*";
		}
		if(empty($table)){
			return false;
		}
		if($pagination){
			if($pagination["COUNT"]){
				$num_next = $pagination["NUM"] * $pagination["COUNT"];
				if($pagination["NUM"] > 1){
					$num_prev = $num_next - $pagination["COUNT"];
					$num_next = $pagination["COUNT"];
					$page = $num_prev.",".$num_next;
				}else{
					$num_prev = $num_next - $pagination["COUNT"];
					$page = $num_prev.",".$num_next;
				}
			}
			if($pagination["LIMIT"]){
				$page = $pagination["LIMIT"];
			}
		}

		$elements = bdconnect::fetch($filter,$select,$table,$page,$order);
		return $elements;
	}


	/**
	* метод получает список таблиц
	* @return возращает список таблиц array
	*/
	public static function getTables(){
		$tables = bdconnect::connect("SHOW TABLE STATUS"); 
		return $tables;
	}

	/**
	* метод для создания таблицы
	* @return возращает список всех пользователей array
	* @param $name Имя таблицы
	* @param $pole_name название полей
	* @param $pole_tip типы полей
	* @param $pole_dlina длина полей
	*/
	public static function createTable($name,$pole_name,$pole_tip = false,$pole_dlina = false){
		$result = "create table";
		return $result;
	}

	/**
	 * @param string $aInitialImageFilePath - строка, представляющая путь к обрезаемому изображению
	 * @param string $aNewImageFilePath - строка, представляющая путь куда нахо сохранить выходное обрезанное изображение
	 * @param int $aNewImageWidth - ширина выходного обрезанного изображения
	 * @param int $aNewImageHeight - высота выходного обрезанного изображения
	 */
	function resizeImage($aInitialImageFilePath, $aNewImageFilePath=false, $aNewImageWidth, $aNewImageHeight) {
	    if (($aNewImageWidth < 0) || ($aNewImageHeight < 0)) {
	        return false;
	    }

	    $files_path = str_replace("imgs/", "imgs/resize/".$aNewImageWidth."_".$aNewImageHeight, $aInitialImageFilePath);
	    $aInitialImageFilePath = $_SERVER['DOCUMENT_ROOT'].$aInitialImageFilePath;
	    $aNewImageFilePath = $_SERVER['DOCUMENT_ROOT'].$files_path;
	    // Массив с поддерживаемыми типами изображений
	    $lAllowedExtensions = array(1 => "gif", 2 => "jpeg", 3 => "png"); 
	    
	    // Получаем размеры и тип изображения в виде числа
	    list($lInitialImageWidth, $lInitialImageHeight, $lImageExtensionId) = getimagesize($aInitialImageFilePath); 
	    
	    if (!array_key_exists($lImageExtensionId, $lAllowedExtensions)) {
	        return false;
	    }
	    $lImageExtension = $lAllowedExtensions[$lImageExtensionId];
	    
	    // Получаем название функции, соответствующую типу, для создания изображения
	    $func = 'imagecreatefrom' . $lImageExtension; 
	    // Создаём дескриптор исходного изображения
	    $lInitialImageDescriptor = $func($aInitialImageFilePath);

	    // Определяем отображаемую область
	    $lCroppedImageWidth = 0;
	    $lCroppedImageHeight = 0;
	    $lInitialImageCroppingX = 0;
	    $lInitialImageCroppingY = 0;
	    if ($aNewImageWidth / $aNewImageHeight > $lInitialImageWidth / $lInitialImageHeight) {
	        $lCroppedImageWidth = floor($lInitialImageWidth);
	        $lCroppedImageHeight = floor($lInitialImageWidth * $aNewImageHeight / $aNewImageWidth);
	        $lInitialImageCroppingY = floor(($lInitialImageHeight - $lCroppedImageHeight) / 2);
	    } else {
	        $lCroppedImageWidth = floor($lInitialImageHeight * $aNewImageWidth / $aNewImageHeight);
	        $lCroppedImageHeight = floor($lInitialImageHeight);
	        $lInitialImageCroppingX = floor(($lInitialImageWidth - $lCroppedImageWidth) / 2);
	    }
	    
	    // Создаём дескриптор для выходного изображения
	    $lNewImageDescriptor = imagecreatetruecolor($aNewImageWidth, $aNewImageHeight);
	    imagecopyresampled($lNewImageDescriptor, $lInitialImageDescriptor, 0, 0, $lInitialImageCroppingX, $lInitialImageCroppingY, $aNewImageWidth, $aNewImageHeight, $lCroppedImageWidth, $lCroppedImageHeight);
	    $func = 'image' . $lImageExtension;
	    
	    // сохраняем полученное изображение в указанный файл
	   $func($lNewImageDescriptor, $aNewImageFilePath);
	   // возрващаем новый путь к изображению
	   return($files_path);
	}
}

//echo"<PRE>"; print_r(Core::getUsers()); echo"</PRE>";
?>