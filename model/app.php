<?php
session_start();
require_once('database.php');

/**
* Lucas Alencar
*/
class app
{
	const  dominio = 'http://dev.apontamentohoras/';
	const  path    = '/var/www/html/apontamentohoras/';
	public $getDB;

 	public function __construct(){
 		$this->getDB = new dba;
 	}
}

?>