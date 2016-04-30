<?php
/** 
 * Author: Gayan C. Karunarathna < agchamara93 [at] gmail.com >
 */
 
define('DB_HOST', 'localhost');
define('DB_NAME', 'changemypic');
define('DB_USER', 'root');
define('DB_PASSWD', '123');

class Db {
	private $con;
	
	function __construct() {
		$this->con = new mysqli(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);
		
		if ($this->con->connect_error) {
			die("Connection error". $this->con->connect_error);
		}
	} 
	
	function get_connection() {
		return $this->con;
	}
}
?>
