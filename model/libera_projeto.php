<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class liberaprojetos extends app
{
	public $id;
	public $id_funcionario;
	public $id_projeto;
	public $status;
	public $msg;
	public $array;

	private function checkExiste()
	{
		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT id FROM liberarprojeto WHERE id_funcionario = %d AND id_projeto = %d", $this->id_funcionario, $this->id_projeto);

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a disponibilidade para o funcionário";
			return false;	
		}
			
		if (!empty($result->fetch_array(MYSQLI_ASSOC))) {
			$this->msg = "Funcionário já mencionado no projeto selecionado";
			return false;			
		}
		return true;
	}

	private function check()
	{
		if (empty($this->id_funcionario)) {
			$this->msg = "Escolha o funcionário.";
			return false;
		}

		if (empty($this->id_projeto)) {
			$this->msg = "Escolha o projeto desejado.";
			return false;
		}

		if (!$this->checkExiste()) {
			return false;
		}

		return true;
	}

	public function save()
	{
		if (!$this->check()) {
		 	return false;
		}

		return $this->insert();
	}

	public function insert()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf(" INSERT INTO liberarprojeto (id_projeto, id_funcionario, usuario)
		VALUES (%d,%d,'%s')", 
			$this->id_projeto, $this->id_funcionario, $_SESSION['email']);	
		
		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}

		$this->msg = "Registros inseridos com sucesso!";
		return true;
	}

	public function update()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf(" UPDATE propostas SET nome = '%s', status ='%s', usuario = %d, data_alteracao = NOW() WHERE id = %d", 
			$this->nome, $this->status, $_SESSION['usuarioID'], $this->id);	
	
		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}

		$this->msg = "Registros atualizados com sucesso!";
		return true;
	}

	public function get($id)
	{
		if (!$id) {
			return false;
		}
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT id, codigo, nome, status, usuario FROM propostas WHERE id =  %d ", $id);
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento do proposta";	
			return false;	
		}
		$this->array = $result->fetch_array(MYSQLI_ASSOC);
		$this->msg = 'Registro carregado com sucesso';
		return true;
	}

	public function list($projeto_id)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT A.id, B.nome FROM liberarprojeto A INNER JOIN funcionarios B ON A.id_funcionario = B.id WHERE A.id_projeto = ".$projeto_id."");
			
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos propostas";	
			return false;	
		}
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$this->array[] = $row;
		}

	return $this->array;
	}

	public function montaSelect($selected=0)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT id,codigo FROM propostas WHERE status = '%s' ORDER BY nome", $this::STATUS_SISTEMA_ATIVO);

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", $selected == $row['id'] ? "selected" : "",
			$row['id'], $row['codigo']);
		}
	}

	private function formatStatus($status)
	{
		if ($status == $this::STATUS_SISTEMA_ATIVO) {
			return "Ativo";
		}
		return "Inativo";
	}

	public function deleta($id)
	{
		if (!$id) {
			return false;
		}
		
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("DELETE FROM liberarprojeto WHERE id = %d ", $id);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "O vínculo está mencionado em algum nível do sistema, favor veríficar.";	
			return false;	
		}

		$this->msg = 'Registro excluido com sucesso';
		return true;	
	}


}

?>