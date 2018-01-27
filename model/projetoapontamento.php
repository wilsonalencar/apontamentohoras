<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class projetoapontamento extends app
{
	public $id;
	public $periodo_libera;
	public $libera;
	public $msg;
	public $array;

	private function checkExistencia()
	{
		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT id FROM liberaapontamento WHERE periodo_libera = '%s'", $this->periodo_libera);	
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do código do proposta";
			return false;	
		}
		$resultado = $result->fetch_array(MYSQLI_ASSOC);
		if (!empty($resultado)) {
			return $resultado['id'];
		}
		return '0';
	}

	public function loadPeriodo()
	{
		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT id,periodo_libera ,libera FROM liberaapontamento WHERE periodo_libera = '%s'", $this->periodo_libera);	
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do código do proposta";
			return false;	
		}
		$resultado = $result->fetch_array(MYSQLI_ASSOC);
		
		if (!empty($resultado)) {
			$this->id 				= $resultado['id'];
			$this->periodo_libera 	= $resultado['periodo_libera'];
			$this->libera 			= $resultado['libera'];
		}
	}

	private function check()
	{
		if (empty($this->periodo_libera)) {
			$this->msg = "Insira o período para liberação.";
			return false;
		}

		if (empty($this->libera)) {
			$this->msg = "Você precisa informar se vai ser liberado ou não.";
			return false;
		}

		return true;
	}

	public function save()
	{
		if (!$this->check()) {
		 	return false;
		}

		$this->id = $this->checkExistencia();
		
		if ($this->id > 0) {
			return $this->update();
		}

		return $this->insert();
	}

	public function insert()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf(" INSERT INTO liberaapontamento (periodo_libera, libera, usuario)
		VALUES ('%s','%s','%s')", 
			$this->periodo_libera, $this->libera, $_SESSION['email']);	

		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		$this->id = $conn->insert_id;
		$this->msg = "Registros inseridos com sucesso!";
		return true;
	}

	public function update()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf(" UPDATE liberaapontamento SET periodo_libera = '%s', libera ='%s', usuario = %d, data_alteracao = NOW() WHERE id = %d", 
			$this->periodo_libera, $this->libera, $_SESSION['email'], $this->id);	
	
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
		$query = sprintf("SELECT id, periodo_libera, libera FROM liberaapontamento WHERE id =  %d ", $id);
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento do proposta";	
			return false;	
		}
		$this->array = $result->fetch_array(MYSQLI_ASSOC);
		$this->msg = 'Registro carregado com sucesso';
		return true;
	}

}

?>