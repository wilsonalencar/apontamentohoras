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
	public $msg;

	public function check(){
		if (empty($this->email)) {
			$this->msg = "Favor informar o email.";
			return false;
		}

		if (empty($this->senha)) {
			$this->msg = "Favor informar a senha.";
			return false;	
		}
	return true;
	}


	public function login(){
		if (!$this->check()) {
			return false;
		}
		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT usuarioID, nome, email FROM usuarios WHERE email = '%s' AND senha = '%s'", $this->email, $this->senha);	

		if (!$result = $conn->query($query)) {
			return false;	
		}

		if (!empty($row = $result->fetch_array(MYSQLI_ASSOC))){
			$_SESSION['usuarioID'] 	= $row[0];
 			$_SESSION['nome'] 	   	= $row[1];
 			$_SESSION['email'] 		= $row[3];
 			$_SESSION['logado'] 	= 1;	
 			return true;		
		}

		return false;
	}
}

?>