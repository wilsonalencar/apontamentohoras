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
	public $id_perfilusuario;
	public $id_responsabilidade;
	public $reset_senha;
	public $status;
	public $senha;
	public $msg;

	const STATUS_ATIVO = 'A';
	const STATUS_INATIVO = 'I';

	private function check(){
		
		if (empty($this->email)) {
			$this->msg = "Favor informar o email do usuário.";
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

		if (empty($this->id_perfilusuario)) {
			$this->msg = "Favor informar o perfil do usuário.";
			return false;	
		}

		if (empty($this->id_responsabilidade)) {
			$this->msg = "Favor informar a responsabilidade do usuário.";
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
		$query = sprintf("SELECT usuarioID, nome, email, id_perfilusuario FROM usuarios WHERE email = '%s' AND senha = '%s' AND status = '%s'", 
			$this->email, $this->senha, $this::STATUS_ATIVO);	

		if (!$result = $conn->query($query)) {
			return false;	
		}

		if (!empty($row = $result->fetch_array(MYSQLI_ASSOC))){
			$_SESSION['usuarioID'] 			= $row['usuarioID'];
 			$_SESSION['nome'] 	   			= $row['nome'];
 			$_SESSION['email'] 				= $row['email'];
 			$_SESSION['id_perfilusuario'] 	= $row['id_perfilusuario'];
 			$_SESSION['logado'] 			= 1;	
 			
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
		
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf(" INSERT INTO usuarios (nome, email, id_perfilusuario, id_responsabilidade, senha, reset_senha, usuario, status)
		VALUES ('%s','%s', %d, %d, '%s', '%s', '%s', '%s')", 
			$this->nome, $this->email,$this->id_perfilusuario, $this->id_responsabilidade, $this->senha, $this->reset_senha, $_SESSION['email'], $this->status);

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

		$conn = $this->getDB->mysqli_connection;
		$query = sprintf(" UPDATE usuarios SET nome = '%s', email ='%s', id_perfilusuario = %d, id_responsabilidade = %d, senha = '%s', reset_senha = '%s' , usuario = '%s', data_alteracao = NOW(), status = '%s' WHERE usuarioID = %d", 
			$this->nome , $this->email, $this->id_perfilusuario, $this->id_responsabilidade, $this->senha, $this->reset_senha, $_SESSION['email'],$this->status, $this->usuarioID);	
	
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
		$query = sprintf("SELECT nome, email, id_perfilusuario, id_responsabilidade, senha, reset_senha FROM usuarios WHERE usuarioID =  %d ", $this->usuarioID);

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento do usuário";	
			return false;	
		}

		$this->array = $result->fetch_array(MYSQLI_ASSOC);
		$this->msg = 'Registro carregado com sucesso';
		return true;
	}

	public function montaSelect($selected=0)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = "SELECT id,nome FROM perfilusuario ORDER BY nome";

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo utf8_encode(sprintf("<option %s value='%d'>%s</option>\n", $selected == $row['id'] ? "selected" : "",
			$row['id'], $row['nome']));
		}
	}

	public function lista()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT A.usuarioID, A.nome, A.email, B.nome as id_perfilusuario FROM usuarios A INNER JOIN perfilusuario B ON A.id_perfilusuario = B.id");
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos usuarios";	
			return false;	
		}
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    		$this->array[] = $row;
		}
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