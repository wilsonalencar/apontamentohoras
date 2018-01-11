<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class projeto extends app
{
	public $id;
	public $id_cliente;
	public $id_proposta;
	public $id_pilar;
	public $data_inicio;
	public $data_fim;
	public $status;
	public $msg;


	private function check(){
		
		if (empty($this->id_cliente)) {
			$this->msg = "Favor informar o cliente.";
			return false;
		}
			
		if (empty($this->id_proposta)) {
			$this->msg = "Favor informar a proposta.";
			return false;
		}

		if (empty($this->id_pilar)) {
			$this->msg = "Favor informar o pilar.";
			return false;	
		}

		if (empty($this->data_inicio)) {
			$this->msg = "Favor informar a data de início do projeto.";
			return false;	
		}

		if (empty($this->data_inicio)) {
			$this->msg = "Favor informar a data final do projeto.";
			return false;	
		}

		if (empty($this->status)) {
			$this->msg = "Favor informar o status.";
			return false;	
		}
		
		return true;
	}

	public function save()
	{
		if (!$this->check()) {
		 	return false;
		}

		if ($this->id > 0) {
			return $this->update();
		}
		return $this->insert();
	}

	public function insert()
	{	
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf(" INSERT INTO projetos (nome, email, id_perfilprojeto, id_responsabilidade, senha, reset_senha, projeto, status)
		VALUES ('%s','%s', %d, %d, '%s', '%s', '%s', '%s')", 
			$this->nome, $this->email,$this->id_perfilprojeto, $this->id_responsabilidade,md5(funcionalidadeConst::SENHA_PADRAO), funcionalidadeConst::RESET_TRUE, $_SESSION['email'], $this->status);

		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		$this->msg = "Registro inserido com sucesso!";
		return true;
	}

	public function update()
	{
		if ($this->reset_senha == funcionalidadeConst::RESET_TRUE) {
			$this->senha = md5(funcionalidadeConst::SENHA_PADRAO);
		}

		$conn = $this->getDB->mysqli_connection;
		$query = sprintf(" UPDATE projetos SET nome = '%s', email ='%s', id_perfilprojeto = %d, id_responsabilidade = %d, senha = '%s', reset_senha = '%s' , projeto = '%s', data_alteracao = NOW(), status = '%s' WHERE projetoID = %d", 
			$this->nome , $this->email, $this->id_perfilprojeto, $this->id_responsabilidade, $this->senha, $this->reset_senha, $_SESSION['email'],$this->status, $this->projetoID);	


	
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
		$query = sprintf("SELECT projetoID, nome, email, id_perfilprojeto, id_responsabilidade, senha, reset_senha, status FROM projetos WHERE projetoID =  %d ", $this->projetoID);

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento do usuário";	
			return false;	
		}

		$this->array = $result->fetch_array(MYSQLI_ASSOC);
		$this->msg = 'Registro carregado com sucesso';
		return true;
	}

	public function lista()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT A.projetoID, A.nome, A.email, B.nome as id_perfilprojeto FROM projetos A INNER JOIN perfilprojeto B ON A.id_perfilprojeto = B.id");
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos projetos";	
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
		$query = sprintf("DELETE FROM projetos WHERE projetoID = %d ", $id);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro na exclusão do usuaŕio";	
			return false;	
		}

		$this->msg = 'Registro excluido com sucesso';
		return true;	
	}


}

?>