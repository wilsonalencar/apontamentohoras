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
	public $Vlr_taxa_venda;
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

		if (empty($this->mes_alocacao)) {
			$this->msg = "Insira o mês de locação do funcionário.";
			return false;
		}

		if (empty($this->Qtd_hrs_estimada)) {
			$this->msg = "Insira a quantia de horas estimada do recurso.";
			return false;
		}

		if ($this->Qtd_hrs_estimada <= 0) {
			$this->msg = "Insira a quantia de horas estimada do recurso corretamente.";
			return false;
		}

		if (empty($this->Vlr_taxa_compra)) {
			$this->msg = "Insira o Valor da taxa de compra do recurso.";
			return false;
		}

		if (empty($this->Vlr_taxa_venda)) {
			$this->msg = "Insira o Valor da taxa de venda do recurso.";
			return false;
		}

		if (!$this->checkExiste()) {
			return false;
		}

		return true;
	}

	private function checkExiste()
	{
		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT id FROM projetorecursos WHERE id_projeto = %d AND id_perfilprofissional = %d AND mes_alocacao= '%s'", $this->id_projeto, $this->id_perfilprofissional, $this->mes_alocacao);	
			
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação da disponibilidade do recurso.";
			return false;	
		}
		
		if (!empty($result->fetch_array(MYSQLI_ASSOC))) {
			$this->msg = "Desculpe, já existe uma estimativa criada para esse perfil, nesse mesmo mês/ano e projeto.";
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
		$query = sprintf(" INSERT INTO projetorecursos (id_projeto, id_perfilprofissional, Vlr_taxa_venda, mes_alocacao, Qtd_hrs_estimada, Vlr_taxa_compra, usuario)
		VALUES (%d ,%d, '%s', '%s', %d, '%s', '%s')", 
			$this->id_projeto, $this->id_perfilprofissional, $this->Vlr_taxa_venda, $this->mes_alocacao, $this->Qtd_hrs_estimada,$this->Vlr_taxa_compra, $_SESSION['email']);	
			
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
						    A.mes_alocacao,
						    A.id_perfilprofissional,
						    A.Qtd_hrs_estimada,
						    A.Vlr_taxa_compra,
						    A.Vlr_taxa_venda,
						    B.nome as nomePerfil
						FROM
						    projetorecursos A
						INNER JOIN
						    perfilprofissional B ON A.id_perfilprofissional = B.id
						WHERE
						    A.id_projeto = %d", $id_projeto);

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos perfis profissionais.";	
			return false;	
		}

		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$row['Vlr_taxa_compra'] = number_format($row['Vlr_taxa_compra'], 2, ',', '.');
			$row['Vlr_taxa_venda'] = number_format($row['Vlr_taxa_venda'], 2, ',', '.');
			$this->array[] = $row;
		}
	}

	public function getHorasReais($id_projeto, $id_perfilprofissional, $mes_alocacao){
		$data = explode("/", $mes_alocacao);
		
		$d1 = $data[1].'-'.$data[0].'-01';
		$d2 = $data[1].'-'.$data[0].'-31';
		$conn = $this->getDB->mysqli_connection;
		$query = "SELECT SUM(Qtd_hrs_real) as Qtd_hrs_real FROM projetohoras WHERE id_projeto = ".$id_projeto." AND id_perfilprofissional =".$id_perfilprofissional." AND data_apontamento BETWEEN "."'".$d1."'"." AND "."'".$d2."'"."";

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento da previsão de faturamento.";	
			return false;	
		}
		$hr_real = $result->fetch_array(MYSQLI_ASSOC)['Qtd_hrs_real'];
		if (empty($hr_real)) {
			$hr_real = 0;
		}

		return $hr_real;
	}

	public function montaSelect($selected=0)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT id,nome FROM projetoprevisaofat WHERE status = '%s' ORDER BY nome", $this::STATUS_SISTEMA_ATIVO);

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", $selected == $row['id'] ? "selected" : "",
			$row['id'], $row['nome']);
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