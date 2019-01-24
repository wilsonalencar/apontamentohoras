<?php
require_once('app.php');

class ProjetoBancoDeHora extends app
{
	public $funcionario_id;
	public $msg;

	//SALVA O FUNCIONÁRIO
	public function save()
	{
		if(!$this->count())
		{
			$this->msg = 'Funcionario já cadastrado!';
			return false;
		}

		$conn = $this->getDB->mysqli_connection;
		$query = 'INSERT INTO acessobancohoras (funcionario_id) VALUES ('.$this->funcionario_id.')';

		if($conn->query($query))
		{
			$this->msg = 'Funcionario cadastrado com sucesso!';
			return true;
		}

		$this->msg = 'Erro interno!';
		return false;
	}

	//REMOVER FUNCIONÁRIO
	public function remove()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = 'DELETE FROM acessobancohoras WHERE funcionario_id = '.$this->funcionario_id;

		if($conn->query($query))
		{
			$this->msg = 'Funcionario excluído com sucesso!';
			return true;
		}

		$this->msg = 'Erro interno!';
		return false;
	}

	//VERIFICA SE JÁ EXISTE O FUNCIONÁRIO CADASTRADO
	public function count()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = 'SELECT * FROM acessobancohoras WHERE funcionario_id = '.$this->funcionario_id;
		$execute = $conn->query($query);
		$count = mysqli_num_rows($execute);

		if($count > 0)
			return false;

		return true;
	}

	//MOSTRA TODOS OS FUNCIONÁRIOS
	public function funcionarios()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = "SELECT * FROM funcionarios";
		$execute = $conn->query($query);
		$array = [];

		while($row = $execute->fetch_array(MYSQLI_ASSOC))
		{
			$array[] = $row;
		}

		return $array;
	}

	//MOSTRA A TABELA COM OS FUNCIONÁRIOS CADASTRADOS
	public function acesso_funcionarios()
	{
		$conn = $this->getDB->mysqli_connection;

		$query = 'SELECT acessobancohoras.funcionario_id, funcionarios.nome FROM acessobancohoras
				  LEFT JOIN funcionarios ON funcionarios.id = acessobancohoras.funcionario_id';

		$execute = $conn->query($query);
		$array = [];

		while($row = $execute->fetch_array(MYSQLI_ASSOC))
		{
			$array[] = $row;
		}

		return $array;
	}
}