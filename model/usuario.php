<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class usuario
{
	public $id;
	public $nome;
	public $email;
	public $data_nascimento;
	public $data_registro;
	public $senha; 

	public function login($email,$senha){
		if (empty($email) or empty($senha)) {
		 	echo "Por favor, insira o email E senha";
		 	return false;
		}	
		$query = sprintf("SELECT * FROM usuarios WHERE email = '%s' AND senha = '%s'", $email, $senha);
		return false;
		$queryResult = $mysqli_connection->query($query);
		if (!$queryResult) {
			echo "Login inválido";
		 	return false;
		}	
	}
}

?>