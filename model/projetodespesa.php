<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class projetodespesa extends app
{

	public $id;
	public $id_projeto;
	public $Data_despesa;
	public $id_funcionario;
	public $Num_doc;
	public $Qtd_despesa;
	public $Vlr_unit;
	public $Vlr_total;
	public $Aprovado;
	public $msg;
	public $array;

	private function check()
	{
	
		if (empty($this->id_projeto)) {
			$this->msg = "Insira o projeto.";
			return false;
		}

		if (empty($this->Data_despesa)) {
			$this->msg = "Insira a data da despesa.";
			return false;
		}

		if (empty($this->id_funcionario)) {
			$this->msg = "Insira o funcionário .";
			return false;
		}

		if (empty($this->Qtd_despesa)) {
			$this->msg = "Insira a quantia da despesa.";
			return false;
		}

		if (empty($this->Vlr_unit)) {
			$this->msg = "Insira o valor unitário da despesa.";
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
		$query = sprintf(" INSERT INTO projetodespesas (id_projeto, id_funcionario, Data_despesa, id_tipodespesa, Num_doc, Qtd_despesa, Vlr_unit, Vlr_total, usuario)
		VALUES (%d, %d, '%s', %d, '%s', %d, %d, %d, '%s')", 
			$this->id_projeto, $this->id_funcionario, $this->Data_despesa, $this->id_tipodespesa, $this->Num_doc, $this->Qtd_despesa, $this->Vlr_unit, $this->Vlr_total, $_SESSION['email']);	

		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		$this->msg = "Registros inseridos com sucesso!";
		return true;
	}

	public function lista($id_projeto)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT 
						    A.id,
						    A.id_projeto,
						    A.id_funcionario,
						    A.Data_despesa,
						    A.id_tipodespesa,
						    A.Num_doc,
						    A.Qtd_despesa,
						    A.Vlr_unit,
						    A.Vlr_total,
						    A.Aprovado,
						    B.nome AS NomeFuncionario,
						    C.descricao AS NomeDespesa
						FROM
						    projetodespesas A
						        INNER JOIN
						    funcionarios B ON A.id_funcionario = B.id
						        INNER JOIN
						    tiposdespesas C ON A.id_tipodespesa = C.id
						WHERE
						    A.id_projeto = %d", $id_projeto);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento da previsão de faturamento.";	
			return false;	
		}
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$row['Qtd_despesa'] = number_format($row['Qtd_despesa'], 1, '', '');
			$row['Vlr_unit'] = number_format($row['Vlr_unit'], 2, ',', '.');
			$row['Vlr_total'] = number_format($row['Vlr_total'], 2, ',', '.');
			$row['Aprovado'] = $this->formatStatus($row['Aprovado']);
			$timestamp = strtotime($row['Data_despesa']);
			$row['Data_despesa'] = date("d-m-Y", $timestamp);
			$this->array[] = $row;
		}
	}

	private function formatStatus($status)
	{
		if ($status == 'S') {
			return "Aprovado";
		}
		return "Não Aprovado";
	}

	public function deleta($id)
	{
		if (!$id) {
			return false;
		}
		
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("DELETE FROM projetodespesas WHERE id = %d ", $id);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro na exclusão do recurso";	
			return false;	
		}

		$this->msg = 'Registro excluido com sucesso';
		return true;	
	}


}

?>