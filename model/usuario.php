<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class usuario extends app
{
	public $id;
	public $nome;
	public $email;
	public $data_nascimento;
	public $data_registro;
	public $senha; 
	public $app;

	public function login($email,$senha){
		$conn = $app->getDB->mysqli_connection;		
		$query = sprintf("SELECT usuarioID, nome, email FROM usuarios WHERE email = '%s' AND senha = '%s'", $email, $senha);	

		if (!$result = $conn->query($query)) {
			return false;	
		}

		if (!empty($row = mysqli_fetch_row($result))){
			$_SESSION['usuarioID'] 	= $row[0];
 			$_SESSION['nome'] 	   	= $row[1];
 			$_SESSION['email'] 		= $row[3];
 			$_SESSION['logado'] 	= 1;			
		}

		if (!empty($_SESSION['logado'])) {
			return true;
		}
	}
}

?>