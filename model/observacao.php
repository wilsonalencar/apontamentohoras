<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class observacao extends app
{
	public $id;
	public $nome;
	public $status;
	public $msg;
	public $observacao;
	public $id_projeto;
	public $array;

	private function check()
	{
		if (empty($this->observacao)) {
			$this->msg = 'Favor informar qual a observação';
			return false;
		}
		return true;
	}

	public function getObservacoes($id_projeto)
	{
		$conn = $this->getDB->mysqli_connection;
		
		$query = 'SELECT B.nome, A.observacao, DATE_FORMAT(A.Data_observacao, "%d/%m/%Y") as dataObs from projetoobservacao A INNER JOIN usuarios B on A.Id_usuario = B.usuarioID where A.id_projeto ='.$id_projeto;
		
		$tabela = '<table><tr><td><b>Usuário</b></td><td><b>Observacao</b></td><td><b>Data Observação</b></td></tr>';
		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			{
				$tabela .= "<tr><td>".$row['nome']."</td><td>".$row['observacao']."</td><td>".$row['dataObs']."</td></tr>";
			}
		}	
		$tabela .= '</table>';
		return $tabela;
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

		$data = date('Y-m-d H:i:s');

		$query = sprintf(" INSERT INTO projetoobservacao (id_projeto, Data_observacao, observacao, Id_usuario)
		VALUES (%d,'%s','%s',%d)", 
			$this->id_projeto, $data, $this->observacao, $_SESSION['usuarioID']);	

		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		$this->msg = "Observação inserida com sucesso!";
		return true;
	}

	public function get($id)
	{
		if (!$id) {
			return false;
		}
		
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT id, centro_custos, nome, status, usuario FROM pilares WHERE id =  %d ", $id);
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento do pilar";	
			return false;	
		}
		$this->array = $result->fetch_array(MYSQLI_ASSOC);
		$this->msg = 'Registro carregado com sucesso';
		return true;
	}
	private function formatStatusL($status)
	{
		if ($status == 'S') {
			return "APROVADO";
		} elseif ($status == 'R') {
			return "REJEITADO";
		} 
		return "PENDENTE";
	}

	public function relatorioFunc(){
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT 
							A.id as id,
							A.Qtd_hrs_real as qtd_hrs,
						    A.observacao as atividade,
						    A.Aprovado as status,
						    A.Data_apontamento as data_apont,
						    C.id_pilar,
						    B.nome as nomefuncionario,
						    B.id as id_funcionario,
						    D.nome as nomepilar,
						    F.codigo as projeto1,
						    E.nome as projeto2
						FROM 
							projetohoras A
						INNER JOIN 
							funcionarios B on A.id_funcionario = B.id
						INNER JOIN 
							projetos C on A.id_projeto = C.id
						INNER JOIN 
							pilares D on C.id_pilar = D.id
						INNER JOIN 
							clientes E on C.id_cliente = E.id
						INNER JOIN 
							propostas F on C.id_proposta = F.id
						WHERE 
							B.status = 'A' ");

		if ($this->id > 0) {
			$query .= " AND D.id = ".$this->id;
		}

		if (!empty($this->data_busca_ini) AND !empty($this->data_busca_fim) ) {
			$query .= " AND A.Data_apontamento BETWEEN "."'".$this->data_busca_ini."'"." AND "."'".$this->data_busca_fim."'";
		}

		$query .= " ORDER BY A.data_apontamento, D.id, A.id";
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		$this->array['valorTotalGeral'] = 0;
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$timestamp = strtotime($row['data_apont']);
			$row['data_apont'] = date("d/m/Y", $timestamp);
			$row['status'] = $this->formatStatusL($row['status']);
			if (empty($this->array['dados'][$row['id_pilar']])) {
				$this->array['dados'][$row['id_pilar']]['valorTotal'] = 0;	
			}
			$this->array['dados'][$row['id_pilar']][] = $row;
			$this->array['dados'][$row['id_pilar']]['valorTotal'] = $row['qtd_hrs'] + $this->array['dados'][$row['id_pilar']]['valorTotal'] ;	
			$this->array['valorTotalGeral'] = $row['qtd_hrs'] + $this->array['valorTotalGeral'];
		}
	}

	public function lista()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT id, centro_custos, nome, status, usuario FROM pilares");
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos pilares";	
			return false;	
		}
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$row['status'] = $this->formatStatus($row['status']);
			$this->array[] = $row;
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
		$query = sprintf("DELETE FROM pilares WHERE id = %d ", $id);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "O pilar tem um vinculo externo, exclusão não permitida.";	
			return false;	
		}

		$this->msg = 'Registro excluido com sucesso';
		return true;	
	}


}

?>