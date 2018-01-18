<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class projetoprevisaofat extends app
{

	public $id;
	public $id_cliente;
	public $id_projeto;
	public $id_proposta;
	public $id_pilar;
	public $Num_parcela;
	public $Vlr_parcela_cimp;
	public $Vlr_parcela_simp;
	public $mes_previsao_fat;
	public $msg;
	public $array;

	private function check()
	{
	
		if (empty($this->id_projeto)) {
			$this->msg = "Insira a proposta.";
			return false;
		}

		if (empty($this->Num_parcela)) {
			$this->msg = "Insira o número da parcela.";
			return false;
		}

		if (empty($this->Vlr_parcela_cimp)) {
			$this->msg = "Insira o Valor com impostos do projeto.";
			return false;
		}

		if (empty($this->mes_previsao_fat)) {
			$this->msg = "Insira o mês de previsão da fatura.";
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
		$query = sprintf(" INSERT INTO projetoprevisaofat (id_projeto, Num_parcela, mes_previsao_fat, Vlr_parcela_cimp, Vlr_parcela_simp, usuario)
		VALUES (%d,%d,'%s','%s', '%s', '%s')", 
			$this->id_projeto, $this->Num_parcela, $this->mes_previsao_fat, $this->Vlr_parcela_cimp, $this->Vlr_parcela_simp, $_SESSION['email']);	
		
		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		$this->msg = "Registros inseridos com sucesso!";
		return true;
	}

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
		$query = sprintf("SELECT id, Num_parcela, mes_previsao_fat, Vlr_parcela_cimp, Vlr_parcela_simp FROM projetoprevisaofat where id_projeto = %d", $id_projeto );
		
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
		$query = sprintf("DELETE FROM projetoprevisaofat WHERE id = %d ", $id);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro na exclusão da previsão de faturamento";	
			return false;	
		}

		$this->msg = 'Registro excluido com sucesso';
		return true;	
	}


}

?>