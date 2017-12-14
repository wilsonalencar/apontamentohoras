<?php
session_start();
require_once('database.php');

/**
* Lucas Alencar
*/
class app
{
	const  dominio = 'http://dev.apontamentohoras/';
	const  path    = '/var/www/html/unionit/apontamentohoras/';
	public $getDB;

 	public function __construct(){
 		$this->getDB = new dba;
 	}

 	public function getRequest($variable, $default_value = '') 
 	{
	   //Correção para todo o SCID, CORREÇÃO DE FALHA DE SEGURANÇA - XSS E SQL INJECTION
	   if($variable == "scid" && isset($_REQUEST[$variable]))
	       return intval($_REQUEST[$variable]);
	   
	   if (isset($_POST[$variable]))
	       return $_POST[$variable];

	   if (isset($_GET[$variable]))
	       return $_GET[$variable];

	   if (isset($_REQUEST[$variable]))
	       return $_REQUEST[$variable];

	   return $default_value;
	}
}

?>