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
	public $PilarNome;
	public $ClienteNome;
	public $Cliente_reembolsa;
	public $status;
	public $msg;
	public $array;


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
		$query = sprintf(" INSERT INTO projetos (id_cliente, id_proposta, id_pilar, data_inicio, data_fim, id_status, Cliente_reembolsa, usuario)
		VALUES (%d, %d, %d, '%s', '%s', %d, '%s', '%s')", 
			$this->id_cliente, $this->id_proposta,$this->id_pilar, $this->data_inicio, $this->data_fim, $this->status, $this->Cliente_reembolsa, $_SESSION['email']);

		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		$this->id = $conn->insert_id;
		$this->msg = "Projeto Criado com sucesso!";
		return true;
	}

	public function update()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf(" UPDATE projetos SET id_cliente= %d, id_proposta= %d, id_pilar= %d, data_inicio= '%s', data_fim= '%s', id_status= %d, Cliente_reembolsa= '%s', usuario= '%s', data_alteracao = NOW() WHERE id = %d", 
			$this->id_cliente , $this->id_proposta, $this->id_pilar, $this->data_inicio, $this->data_fim, $this->status, $this->Cliente_reembolsa, $_SESSION['email'], $this->id);	
	
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
		$query = sprintf("SELECT 
						    A.id,
						    A.id_cliente,
						    A.id_proposta,
						    A.id_pilar,
						    A.Data_inicio,
						    A.Data_fim,
						    A.id_status,
						    A.Cliente_reembolsa,
						    B.nome AS ClienteNome,
						    C.nome AS PropostaNome,
						    D.nome AS PilarNome
						FROM
						    projetos A
						        INNER JOIN
						    clientes B ON A.id_cliente = B.id
						        INNER JOIN
						    propostas C ON A.id_proposta = C.id
						    	INNER JOIN 
						    pilares D ON A.id_pilar = D.id
						WHERE
						    A.id = %d ", $id);

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento do usuário";	
			return false;	
		}
		$this->array = $result->fetch_array(MYSQLI_ASSOC);
		return true;
	}

	public function lista()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT A.id, A.nome, A.email, B.nome as id_perfilprojeto FROM projetos A INNER JOIN perfilprojeto B ON A.id_perfilprojeto = B.id");
		
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
		$query = sprintf("DELETE FROM projetos WHERE id = %d ", $id);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro na exclusão do usuaŕio";	
			return false;	
		}

		$this->msg = 'Registro excluido com sucesso';
		return true;	
	}
}

?>