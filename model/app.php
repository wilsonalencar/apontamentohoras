<?php
require_once('database.php');
global $_SERVER;
/**
* Lucas Alencar
*/
class app
{
	public $_SESSION;
	public $getDB;
	public $PATH = '/var/www/html/unionit/apontamentohoras/view/assets/';
 	public function __construct(){
 		$this->getDB = new dba;
 	}

 	public function DoSession($id,$nome,$email){
 		if (!isset($this->_SESSION)) {
 			session_start();
 			$this->_SESSION['usuarioID'] 	= $id;
 			$this->_SESSION['nome'] 	   	= $nome;
 			$this->_SESSION['email'] 		= $email;

 		return $this->_SESSION;
 		}
 	}	    
}

?>