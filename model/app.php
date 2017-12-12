<?php
session_start();
require_once('database.php');
global $_SERVER;
/**
* Lucas Alencar
*/
class app
{
	public $getDB;
	public $PATH = '/var/www/html/unionit/apontamentohoras';
	public $dominio = 'http://dev.apontamentohoras/';
	
 	public function __construct(){
 		$this->getDB = new dba;
 	}
}

?>