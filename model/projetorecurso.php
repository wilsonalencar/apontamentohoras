<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class projetorecurso extends app
{

	public $id;
	public $id_projeto;
	public $id_perfilprofissional;
	public $id_funcionario;
	public $mes_alocacao;
	public $Qtd_hrs_estimada;
	public $Vlr_taxa_compra;
	public $msg;
	public $array;

	private function check()
	{
	
		if (empty($this->id_projeto)) {
			$this->msg = "Insira o projeto.";
			return false;
		}

		if (empty($this->id_perfilprofissional)) {
			$this->msg = "Insira o perfil profissional.";
			return false;
		}

		if (empty($this->id_funcionario)) {
			$this->msg = "Insira o funcionário .";
			return false;
		}

		if (empty($this->mes_alocacao)) {
			$this->msg = "Insira o mês de locação do funcionário.";
			return false;
		}

		if (empty($this->Qtd_hrs_estimada)) {
			$this->msg = "Insira o mês de locação do funcionário.";
			return false;
		}

		if (empty($this->Vlr_taxa_compra)) {
			$this->msg = "Insira o mês de locação do funcionário.";
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
		$query = sprintf(" INSERT INTO projetorecursos (id_projeto, id_perfilprofissional, id_funcionario, mes_alocacao, Qtd_hrs_estimada, Vlr_taxa_compra, usuario)
		VALUES (%d ,%d, %d, '%s', %d, %d, '%s')", 
			$this->id_projeto, $this->id_perfilprofissional, $this->id_funcionario, $this->mes_alocacao, $this->Qtd_hrs_estimada,$this->Vlr_taxa_compra, $_SESSION['email']);	
		
		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		$this->msg = "Registros inseridos com sucesso!";
		return true;
	}

	// #FALTA
	// public function update()
	// {
	// 	$conn = $this->getDB->mysqli_connection;
	// 	$query = sprintf(" UPDATE projetoprevisaofat SET nome = '%s', status ='%s', usuario = %d, data_alteracao = NOW() WHERE id = %d", 
	// 		$this->nome, $this->status, $_SESSION['usuarioID'], $this->id);	
	
	// 	if (!$conn->query($query)) {
	// 		$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
	// 		return false;	
	// 	}

	// 	$this->msg = "Registros atualizados com sucesso!";
	// 	return true;
	// }

	// #FALTA
	// public function get($id)
	// {
	// 	if (!$id) {
	// 		return false;
	// 	}
	// 	$conn = $this->getDB->mysqli_connection;
	// 	$query = sprintf("SELECT id, codigo, nome, status, usuario FROM projetoprevisaofat WHERE id =  %d ", $id);
	// 	if (!$result = $conn->query($query)) {
	// 		$this->msg = "Ocorreu um erro no carregamento do proposta";	
	// 		return false;	
	// 	}
	// 	$this->array = $result->fetch_array(MYSQLI_ASSOC);
	// 	$this->msg = 'Registro carregado com sucesso';
	// 	return true;
	// }

	public function lista($id_projeto)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT 
						    A.id,
						    A.id_projeto,
						    A.id_funcionario,
						    A.mes_alocacao,
						    A.id_perfilprofissional,
						    A.Qtd_hrs_estimada,
						    A.Vlr_taxa_compra,
						    B.nome as nomePerfil,
						    C.nome as nomeFuncionario
						FROM
						    projetorecursos A
						INNER JOIN
						    perfilprofissional B ON A.id_perfilprofissional = B.id
				        INNER JOIN
						    funcionarios C ON A.id_funcionario = C.id
						WHERE
						    A.id_projeto = %d", $id_projeto);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento da previsão de faturamento.";	
			return false;	
		}
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$this->array[] = $row;
		}
	}


	public function montaSelect($selected=0)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT id,nome FROM projetoprevisaofat WHERE status = '%s' ORDER BY nome", $this::STATUS_SISTEMA_ATIVO);

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo utf8_encode(sprintf("<option %s value='%d'>%s</option>\n", $selected == $row['id'] ? "selected" : "",
			$row['id'], $row['nome']));
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
		$query = sprintf("DELETE FROM projetorecursos WHERE id = %d ", $id);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro na exclusão do recurso";	
			return false;	
		}

		$this->msg = 'Registro excluido com sucesso';
		return true;	
	}


}

?>