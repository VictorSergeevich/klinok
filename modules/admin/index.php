<?php
use core\Core as Core;
include __DIR__ . '\indexTemplate.php';
class admin{
	function __construct(){
		switch (GET_PARAMETRS_URL) {
			case 'users':
				include __DIR__ . '/users.php';
				break;
			case 'elements':
				include __DIR__ . '/elements.php';
				break;	
			case 'test':
				include __DIR__ . '/test.php';
				break;						
			default:
				# code...
				break;
		}
	}
}
(new admin());
?>