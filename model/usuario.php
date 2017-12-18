<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class usuario extends app
{
	public $usuarioID;
	public $nome;
	public $email;
	public $data_nascimento;
	public $data_registro;
	public $senha;
	public $msg;

	private function check(){
		
		if (empty($this->email)) {
			$this->msg = "Favor informar o email do usuário.";
			return false;
		}
		
		if (empty($this->data_nascimento)) {
			$this->msg = "Favor informar a data de nascimento.";
			return false;
		}
		
		if (empty($this->senha)) {
			$this->msg = "Favor inserir a senha do usuário.";
			return false;
		}

		if (empty($this->nome)) {
			$this->msg = "Favor informar o nome do usuário.";
			return false;	
		}
		
		return true;
	}


	private function checkLogin(){
		
		if (empty($this->email)) {
			$this->msg = "Favor informar o email do usuário.";
			return false;
		}
		
		if (empty($this->senha)) {
			$this->msg = "Favor inserir a senha do usuário.";
			return false;
		}

		return true;
	}



	public function login(){
		if (!$this->checkLogin()) {
			return false;
		}

		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT usuarioID, nome, email FROM usuarios WHERE email = '%s' AND senha = '%s'", $this->email, $this->senha);	

		if (!$result = $conn->query($query)) {
			return false;	
		}

		if (!empty($row = $result->fetch_array(MYSQLI_ASSOC))){
			$_SESSION['usuarioID'] 	= $row['usuarioID'];
 			$_SESSION['nome'] 	   	= $row['nome'];
 			$_SESSION['email'] 		= $row['email'];
 			$_SESSION['logado'] 	= 1;	
 			return true;		
		}
		$this->msg = 'Login inválido';
		return false;
	}

	public function save()
	{
		if (!$this->check()) {
		 	return false;
		}

		if ($this->usuarioID > 0) {
			return $this->update();
		}

		return $this->insert();
	}

	public function insert()
	{
		if (!$this->check()) {
			return false;
		}
		
		$this->data_nascimento = str_replace("/", "-", $this->data_nascimento);
    	$this->data_nascimento = date('Y-m-d', strtotime($this->data_nascimento));

		$conn = $this->getDB->mysqli_connection;
		$query = sprintf(" INSERT INTO usuarios (nome, email, data_nascimento, senha)
		VALUES ('%s','%s','%s','%s')", 
			$this->nome, $this->email, $this->data_nascimento, $this->senha);	

		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		$this->msg = "Registro inserido com sucesso!";
		return true;
	}

	public function update()
	{
		if (!$this->check()) {
			return false;
		}

		$this->data_nascimento = str_replace("/", "-", $this->data_nascimento);
    	$this->data_nascimento = date('Y-m-d', strtotime($this->data_nascimento));

		$conn = $this->getDB->mysqli_connection;
		$query = sprintf(" UPDATE usuarios SET nome = '%s', email ='%s', data_nascimento = '%s', senha = '%s' WHERE usuarioID = %d", 
			$this->nome, $this->email, $this->data_nascimento, $this->senha ,$this->usuarioID);	
	
		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}

		$this->msg = "Registro atualizado com sucesso!";
		return true;
	}

	public function get($id)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT usuarioID,nome,email,data_nascimento,senha FROM usuarios WHERE usuarioID =  %d ", 1);
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento do usuário";	
			return false;	
		}

		$this->array = $result->fetch_array(MYSQLI_ASSOC);
		$this->msg = 'Registro carregado com sucesso';
		return true;
	}

	public function deleta($id)
	{
		if (!$id) {
			return false;
		}
		
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("DELETE FROM usuarios WHERE usuarioID = %d ", $id);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro na exclusão do usuaŕio";	
			return false;	
		}

		$this->msg = 'Registro excluido com sucesso';
		return true;	
	}

}

?>