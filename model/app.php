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
 		$this->validLogin();
 		$this->getDB = new dba;
 	}
 	private function validLogin()
 	{
 		if (empty($_SESSION) && $_SERVER['SCRIPT_NAME'] != '/login.php') {
 			header('LOCATION:login.php');
 		}
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

	public function validaCNPJ($cnpj)
 	{
		$j=0;
		for($i=0; $i<(strlen($cnpj)); $i++)
			{
				if(is_numeric($cnpj[$i]))
					{
						$num[$j]=$cnpj[$i];
						$j++;
					}
			}
	
		if(count($num)!=14)
			{
				$isCnpjValid=false;
			}
	
		if ($num[0]==0 && $num[1]==0 && $num[2]==0 && $num[3]==0 && $num[4]==0 && $num[5]==0 && $num[6]==0 && $num[7]==0 && $num[8]==0 && $num[9]==0 && $num[10]==0 && $num[11]==0)
			{
				$isCnpjValid=false;
			}
	
		else
			{
				$j=5;
				for($i=0; $i<4; $i++)
					{
						$multiplica[$i]=$num[$i]*$j;
						$j--;
					}
				$soma = array_sum($multiplica);
				$j=9;
				for($i=4; $i<12; $i++)
					{
						$multiplica[$i]=$num[$i]*$j;
						$j--;
					}
				$soma = array_sum($multiplica);	
				$resto = $soma%11;			
				if($resto<2)
					{
						$dg=0;
					}
				else
					{
						$dg=11-$resto;
					}
				if($dg!=$num[12])
					{
						$isCnpjValid=false;
					} 
			}
	
		if(!isset($isCnpjValid))
			{
				$j=6;
				for($i=0; $i<5; $i++)
					{
						$multiplica[$i]=$num[$i]*$j;
						$j--;
					}
				$soma = array_sum($multiplica);
				$j=9;
				for($i=5; $i<13; $i++)
					{
						$multiplica[$i]=$num[$i]*$j;
						$j--;
					}
				$soma = array_sum($multiplica);	
				$resto = $soma%11;			
				if($resto<2)
					{
						$dg=0;
					}
				else
					{
						$dg=11-$resto;
					}
				if($dg!=$num[13])
					{
						$isCnpjValid=false;
					}
				else
					{
						$isCnpjValid=true;
					}
			}
	
		return $isCnpjValid;			
	}
}

?>