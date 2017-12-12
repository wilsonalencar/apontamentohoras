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
		$app = new app;
		$conn = $app->getDB->mysqli_connection;		
		$query = sprintf("SELECT usuarioID, nome, email FROM usuarios WHERE email = '%s' AND senha = '%s'", $email, $senha);	

		if (!$result = $conn->query($query)) {
			return false;	
		}

		if (!empty($row = mysqli_fetch_row($result))){
			$app->DoSession($row[0],$row[1],$row[2]);
		}

		if (!empty($app->_SESSION['usuarioID'])) {
			return true;
		}
	}
}

?>