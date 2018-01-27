<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class pilar extends app
{
	public $id;
	public $centro_custos;
	public $nome;
	public $status;
	public $msg;
	public $array;

	private function checkExiste()
	{
		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT centro_custos FROM pilares WHERE centro_custos = '%s' AND id <> %d", $this->centro_custos, $this->id);	

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do centro de custos do pilar";
			return false;	
		}
		
		if (!empty($result->fetch_array(MYSQLI_ASSOC))) {
			$this->msg = "Centro de custos do pilar já está sendo utilizado";
			return false;			
		}
		return true;
	}

	private function check()
	{
		if (empty($this->centro_custos)) {
			$this->msg = "Insira o centro de custos do pilar.";
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

	public function montaSelect($selected=0)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT id,nome FROM pilares WHERE status = '%s' ORDER BY nome", $this::STATUS_SISTEMA_ATIVO);

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", $selected == $row['id'] ? "selected" : "",
			$row['id'], $row['nome']);
		}
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
		$query = sprintf(" INSERT INTO pilares (centro_custos, nome, status, usuario)
		VALUES ('%s','%s','%s',%d)", 
			$this->centro_custos, $this->nome, $this->status, $_SESSION['usuarioID']);	

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
		$query = sprintf(" UPDATE pilares SET nome = '%s', status ='%s', usuario = %d, data_alteracao = NOW() WHERE id = %d", 
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
							B.status = 'A'
						ORDER BY 
							A.data_apontamento, D.id, A.id");

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