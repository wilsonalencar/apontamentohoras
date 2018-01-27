<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class apontamento extends app
{
	public $id;
	public $id_projeto;
	public $id_funcionario;
	public $id_perfilprofissional;
	public $Data_apontamento;
	public $Qtd_hrs_real;
	public $observacao;
	public $Aprovado;
	public $id_cliente;
	public $id_proposta;
	public $cliente;
	public $data_busca_ini;
	public $data_busca_fim;
	public $Cliente_reembolsa;
	public $proposta;
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

		if (empty($this->id_projeto)) {
			$this->msg = "Favor informar o projeto.";
			return false;	
		}

		if (empty($this->id_funcionario)) {
			$this->msg = "Favor informar o funcionário.";
			return false;	
		}

		if (empty($this->Data_apontamento)) {
			$this->msg = "Favor informar a data do apontamento.";
			return false;	
		}

		if (empty($this->Qtd_hrs_real)) {
			$this->msg = "Favor informar a quantidade de horas real.";
			return false;	
		}		
		return true;
	}

	public function carregaPendencia($id_projeto)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = "	SELECT 
					    A.id_cliente,
					    A.id_proposta,
					    B.codigo as PropostaNome,
					    C.nome as ClienteNome,
						A.Cliente_reembolsa
					FROM
					    projetos A
					INNER JOIN 
						propostas B on A.id_proposta = B.id
					INNER JOIN 
						clientes C on A.id_cliente = C.id 
					WHERE
					    A.id = ".$id_projeto."";

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento do usuário";	
			return false;	
		}
		$this->array = $result->fetch_array(MYSQLI_ASSOC);
		$this->id_cliente = $this->array['id_cliente'];
		$this->id_proposta = $this->array['id_proposta'];
		$this->cliente = $this->array['ClienteNome'];
		$this->proposta = $this->array['PropostaNome'];
		$this->Cliente_reembolsa = $this->array['Cliente_reembolsa'];


		if ($this->id_perfilprofissional <= 0) {
			$query = "SELECT 
					    id_perfilprofissional
					FROM
					    funcionarios
					WHERE
					    id = ".$this->id_funcionario."";
			if (!$result = $conn->query($query)) {
				$this->msg = "Ocorreu um erro no carregamento do usuário";	
				return false;	
			}
			$this->array = $result->fetch_array(MYSQLI_ASSOC);
			$this->id_perfilprofissional = $this->array['id_perfilprofissional'];
		}
	}


	public function save()
	{
		if ($this->id_projeto > 0) {
			$this->carregaPendencia($this->id_projeto);
		}

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
		$query = sprintf(" INSERT INTO projetohoras (id_projeto, id_funcionario, id_perfilprofissional, Data_apontamento, Qtd_hrs_real, observacao, Aprovado, usuario)
		VALUES (%d, %d, %d, '%s', %d, '%s', '%s', '%s')", 
			$this->id_projeto, $this->id_funcionario,$this->id_perfilprofissional, $this->Data_apontamento, $this->Qtd_hrs_real, $this->observacao, $this->Aprovado, $_SESSION['email']);
		
		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		$this->msg = "Apontamento Criado com sucesso!";
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
	
	public function Aprova($id, $status)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf(" UPDATE projetohoras SET Aprovado= '%s', data_alteracao = NOW(), data_aprovacao = NOW(), login_aprovador = '%s' WHERE id = %d", 
			$status, $_SESSION['email'] ,$id);	
	
		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}

		$this->msg = "Apontamentos atualizados com sucesso!";
		return true;
	}

	public function lista()
	{
		$conn = $this->getDB->mysqli_connection;
		if ($this->id_projeto > 0 or $this->id_funcionario > 0) {
			$query = "SELECT id, Data_apontamento, Qtd_hrs_real, observacao, Aprovado, id_funcionario, id_projeto FROM projetohoras where 1 ";
			if ($this->id_projeto > 0) {
				$query .= " AND id_projeto = ".$this->id_projeto;
			}
			
			if ($this->id_funcionario > 0) {
				$query .= " AND id_funcionario = ".$this->id_funcionario;
			}

			if (!$result = $conn->query($query)) {
				$this->msg = "Ocorreu um erro no carregamento dos projetos";	
				return false;	
			}

			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
	    		$timestamp = strtotime($row['Data_apontamento']);
				$row['Aprovado'] = $this->formatStatus($row['Aprovado']);
				$row['Data_apontamento'] = date("d/m/Y", $timestamp);
	    		$this->array[] = $row;
			}
		}
	}
	private function formatStatus($status)
	{
		if ($status == 'S') {
			return "Aprovado";
		} elseif ($status == 'R') {
			return "Rejeitado";
		} 
		return "Não Aprovado";
	}

	public function lista_aprovacao()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = "SELECT
					A.id,
					A.id_projeto,
				    C.codigo as id_proposta,
				    A.Data_apontamento,
				    D.nome as nomeCliente,
				    F.nome as funcionarioNome,
				    A.Qtd_hrs_real as Qtd_hrs,
				    A.observacao as atividade,
				    A.Aprovado as status
				FROM 
					projetohoras A 
				INNER JOIN 
					projetos B on A.id_projeto = B.id
				INNER JOIN 
					propostas C on B.id_proposta = C.id
				INNER JOIN
					clientes D on B.id_cliente = D.id
				INNER JOIN 
					funcionarios F on A.id_funcionario = F.id
				WHERE 
					A.Aprovado = 'N'
					";

		if ($_SESSION['id_perfilusuario'] != '1') {
			$query .= " AND F.email = "."'".$_SESSION['email']."'";
		}
		
		if ($this->id_projeto > 0) {
			$query .= " AND A.id_projeto = ".$this->id_projeto;
		}
			
		if ($this->id_funcionario > 0) {
			$query .= " AND A.id_funcionario = ".$this->id_funcionario;
		}

		if (!empty($this->data_busca_ini) AND !empty($this->data_busca_fim) ) {
			$query .= " AND A.Data_despesa BETWEEN "."'".$this->data_busca_ini."'"." AND "."'".$this->data_busca_fim."'";
		}
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos projetos";	
			return false;	
		}

		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$timestamp = strtotime($row['Data_apontamento']);
    		$row['Data_apontamento'] = date("d/m/Y", $timestamp);
    		$this->array[] = $row;
		}
	}


	public function lista_consulta()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT 
							    A.id, B.codigo, C.nome, D.descricao
							FROM
							    projetos A
							        INNER JOIN
							    propostas B ON A.id_proposta = B.id
									INNER JOIN 
								clientes C ON A.id_cliente = C.id
									INNER JOIN 
								projetostatus D ON A.id_status = D.id");

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
		$query = sprintf("DELETE FROM projetohoras WHERE id = %d ", $id);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro na exclusão do apontamento";	
			return false;	
		}

		$this->msg = 'Registro excluido com sucesso';
		return true;	
	}
}

?>