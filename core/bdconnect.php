<?php
namespace core;
use PDO as PDO;
/**
*
* подключение к базе данных
* @param 
*/

class bdconnect{

	function __construct(){ 
		// функция работает при объявлении класса
	}

	public static function connect($sql){
		if(empty($GLOBALS["settings"]["BD"]["dbhost"])){
			echo "<span style=\"color:red;font-family:arial\">Отсутствует указание хоста в настройках сайта</span> <br/>";
			$error = 1;
		}
		if(empty($GLOBALS["settings"]["BD"]["dbname"])){
			echo "<span style=\"color:red;font-family:arial\">Отсутствует название базы данных в настройках сайта</span> <br/>";
			$error = 1;
		}
		if(empty($GLOBALS["settings"]["BD"]["login"])){
			echo "<span style=\"color:red;font-family:arial\">Отсутствует логин пользователя базы данных в настройках сайта</span> <br/>";
			$error = 1;
		}
		if(!empty($error)){
			echo "<span style=\"color:red;font-family:arial\">Критическая ошибка! Невозможно подключиться к базе данных.</span> <br/>";
			die();
		}else{
		try {
    		$pdo = new PDO('mysql:host='.$GLOBALS["settings"]["BD"]["dbhost"].';dbname='.$GLOBALS["settings"]["BD"]["dbname"], $GLOBALS["settings"]["BD"]["login"], $GLOBALS["settings"]["BD"]["password"]);
    		if($sql){    		
	    		$stmt = $pdo->query($sql);
	    		if($stmt){
    				$return = array();
					while ($row = $stmt->fetch())
					{
    			 		$return[] = $row;
					}
					return $return;
				}else{
    				return false;
				}
    		}else{
    			return false;
    		}
    		$dbh = null;
		} catch (PDOException $e) {
    		print "Error!: " . $e->getMessage() . "<br/>";
			echo "<span style=\"color:red;font-family:arial\">Критическая ошибка! Невозможно подключиться к базе данных.</span> <br/>";
    		die();
		}
		}
	}

	public static function fetch($filter,$select,$table,$page = false,$order = false){
		$sql = "SELECT " . $select . " from " . $table;
		if(!empty($filter)){
			$sql .= " where " . $filter;
		}		
		if(!empty($order)){
			$sql .= " " . $order;
		}
		if(!empty($page)){
			$sql .= " limit ".$page;
		}
		//print_r($sql);
		
		return self::connect($sql);
	}

	
	/**
	* метод обновляет записи в таблице БД
	* @param $table - название таблицы
	* @param $params - параметры необходимые для обновления VOTES_CNT=10,VOTE_SUM=50
	* @param $where - условие ID=1
	* @return возращает таблицу в соответствии с параметрами
	*/
	public static function update($table,$params,$where = false){
		$sql = "UPDATE ".$table." SET ".$params." WHERE ".$where;
		return self::connect($sql);
	}
}
?>