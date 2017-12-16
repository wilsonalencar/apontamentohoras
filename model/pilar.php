<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class pilar extends app
{
	public $id;
	public $codigo;
	public $nome;
	public $status;
	public $msg;
	public $array;

	private function checkExiste()
	{
		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT codigo FROM pilares WHERE codigo = %d AND id <> %d", $this->codigo, $this->id);	

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do código do pilar";
			return false;	
		}
		
		if (!empty($result->fetch_array(MYSQLI_ASSOC))) {
			$this->msg = "Codigo do pilar já está sendo utilizado";
			return false;			
		}
		return true;
	}

	private function check()
	{
		if (empty($this->codigo)) {
			$this->msg = "Insira o código do pilar.";
			return false;
		}

		if (empty($this->nome)) {
			$this->msg = "Insira o nome do pilar.";
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
		if ($this->id > 0) {
			return $this->update();
		}

		return $this->insert();
	}

	public function insert()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf(" INSERT INTO pilares (codigo, nome, status, usuario)
		VALUES ('%s','%s','%s',%d)", 
			$this->codigo, $this->nome, $this->status, $_SESSION['usuarioID']);	

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
		$query = sprintf(" UPDATE pilares SET nome = '%s', status ='%s', usuario = %d WHERE id = %d", 
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
		$query = sprintf("SELECT id, codigo, nome, status, usuario FROM pilares WHERE id =  %d ", $id);
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento do pilar";	
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
		$query = sprintf("DELETE FROM pilares WHERE id = %d ", $id);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro na exclusão do pilar";	
			return false;	
		}

		$this->msg = 'Registro excluido com sucesso';
		return true;	
	}


}

?>