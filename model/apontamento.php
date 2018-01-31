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
		
		if ($this->Qtd_hrs_real < 0) {
			$this->msg = "Favor informar a quantidade de horas corretamente.";
			return false;	
		}

		if (!$this->checkData($this->Data_apontamento)) {
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


	public function checkData($data_apontamento)
	{
	 	$data_apontamento = strtotime($data_apontamento);
		$data_apontamento = date("m/Y", $data_apontamento);
	 	$data = date('m/Y');
	
		if ($data_apontamento != $data) {
			$conn = $this->getDB->mysqli_connection;		
			$query = sprintf("SELECT libera, periodo_libera FROM liberaapontamento WHERE periodo_libera = '%s'", $data_apontamento);

			if (!$result = $conn->query($query)) {
				$this->msg = "Ocorreu um erro durante a verificação do código do proposta";
				return false;	
			}
			$data_ver = $result->fetch_array(MYSQLI_ASSOC);
			if (!empty($data_ver['periodo_libera']) && $data_ver['libera'] == 'S') {
				return true;
			} 

			$this->msg = "Desculpe, o período não existe ou está liberado para lançamento de despesa, contate a controller.";
			return false;
		}
		return true;
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

		$inmail = $this->carregaHoras($conn->insert_id);
		$this->mailPendente($inmail['email'], $inmail['emailAprovador'], $inmail['nomeFuncionario'] , $inmail['id_projeto'], $inmail['nomeCliente'], $inmail['codProposta']);
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
		if ($status != funcionalidadeConst::PENDENTE) {
			$conn = $this->getDB->mysqli_connection;
			$query = sprintf(" UPDATE projetohoras SET Aprovado= '%s', data_alteracao = NOW(), data_aprovacao = NOW(), login_aprovador = '%s' WHERE id = %d", 
				$status, $_SESSION['email'] ,$id);	
		
			if (!$conn->query($query)) {
				$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
				return false;	
			}

			$inmail = $this->carregaHoras($id);
			if ($status == funcionalidadeConst::APROVADO) {
				$this->mailAprovar($inmail['email'], 'luciafcastro.lfc@gmail.com', $inmail['id_projeto'], $inmail['nomeCliente'], $inmail['codProposta'], $inmail['data'], $inmail['horas'], $inmail['atividade']);
			}

			if ($status == funcionalidadeConst::REJEITADO) {
				$this->mailReprovar($inmail['email'], 'luciafcastro.lfc@gmail.com', $inmail['id_projeto'], $inmail['nomeCliente'], $inmail['codProposta'], $inmail['data'], $inmail['horas'], $inmail['atividade']);
			}
			$this->msg = "Apontamentos atualizados com sucesso!";
			return true;
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
	public function carregaHoras($id)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = "SELECT 
				A.id_funcionario,
				A.id_projeto,
				A.Data_apontamento as data,
				A.Qtd_hrs_real as horas,
				A.observacao as atividade,
				C.codigo as codProposta,
				D.email as email,
				D.nome as nomeFuncionario,
				E.nome as nomeCliente,
			    (
					SELECT 
						G.email 
					FROM 
						projetorecursos F 
					INNER JOIN 
						funcionarios G on F.id_funcionario = G.id 
					INNER JOIN
						responsabilidades H on G.id_responsabilidade = H.id
					WHERE 
						F.id_projeto = A.id_projeto 
					AND H.nome = 'APROVADOR'
				) as emailAprovador
			FROM 
				projetohoras A 
			INNER JOIN 
				projetos B on A.id_projeto = B.id 
			INNER JOIN 
				propostas C on B.id_proposta = C.id
			INNER JOIN 
				funcionarios D on A.id_funcionario = D.id
			INNER JOIN 
				clientes E on B.id_cliente = E.id
			WHERE A.id = ".$id.";";

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no envio de emails";	
			return false;	
		}
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$timestamp = strtotime($row['data']);
    	$row['data'] = date("d/m/Y", $timestamp);
		return $row;
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

		if ($_SESSION['id_perfilusuario'] != funcionalidadeConst::ADMIN) {
			$query .= sprintf(" AND A.id_projeto IN(Select SPR.id_projeto FROM projetorecursos SPR where SPR.id_funcionario = (select id FROM funcionarios where Email = '%s')) ", $_SESSION['email']);
		}
		
		if ($this->id_projeto > 0) {
			$query .= " AND A.id_projeto = ".$this->id_projeto;
		}
			
		if ($this->id_funcionario > 0) {
			$query .= " AND A.id_funcionario = ".$this->id_funcionario;
		}

		if (!empty($this->data_busca_ini) AND !empty($this->data_busca_fim) ) {
			$query .= " AND A.Data_apontamento BETWEEN "."'".$this->data_busca_ini."'"." AND "."'".$this->data_busca_fim."'";
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

	public function mailAprovar($email, $emailAprovador, $id_projeto, $nomeCliente, $codProposta, $data, $horas, $atividade)
	{
		$email_enviar = $email.",".$emailAprovador;
		$assunto = "Horas aprovadas - Projeto ".$id_projeto." - ".$nomeCliente." - ".$codProposta;

		$cabecalho = 'MIME-Version: 1.0' . "\r\n";
		$cabecalho .= 'Content-type: text/html; charset=iso-8859-1;' . "\r\n";
		$cabecalho .= "Return-Path: $email_enviar \r\n";
		$cabecalho .= "From: $email_enviar \r\n";
		$cabecalho .= "Reply-To: $email_enviar \r\n";

		$mensagem = "<h3>Foram aprovadas as horas do projeto ".$id_projeto." - ".$nomeCliente." - ".$codProposta.",conforme abaixo:</h3>";
		$mensagem .= "<table border='0'><tr><td><b>Data </b></td><td><b>Horas </b></td><td><b>  Atividade </b></td></tr>";
		$mensagem .= "<tr align='center'><td>".$data."</td><td>".$horas."</td><td>".$atividade."</td></tr>";
		$mensagem .= "</table>";
		//mail($email_enviar, $assunto, $mensagem, $cabecalho);
	}

	public function mailReprovar($email, $emailAprovador, $id_projeto, $nomeCliente, $codProposta, $data, $horas, $atividade)
	{
		$email_enviar = $email.",".$emailAprovador;
		$assunto = "Horas Rejeitadas - Projeto ".$id_projeto." - ".$nomeCliente." - ".$codProposta;

		$cabecalho = 'MIME-Version: 1.0' . "\r\n";
		$cabecalho .= 'Content-type: text/html; charset=iso-8859-1;' . "\r\n";
		$cabecalho .= "Return-Path: $email_enviar \r\n";
		$cabecalho .= "From: $email_enviar \r\n";
		$cabecalho .= "Reply-To: $email_enviar \r\n";

		$mensagem = "<h3>Foram rejeitadas as horas do projeto ".$id_projeto." - ".$nomeCliente." - ".$codProposta.",conforme abaixo:</h3>";
		$mensagem .= "<table border='0'><tr><td><b>Data </b></td><td><b>Horas </b></td><td><b>  Atividade </b></td></tr>";
		$mensagem .= "<tr align='center'><td>".$data."</td><td>".$horas."</td><td>".$atividade."</td></tr>";
		$mensagem .= "</table>";
		//mail($email_enviar, $assunto, $mensagem, $cabecalho);
	}


	public function mailPendente($email, $emailAprovador, $nomeFuncionario, $id_projeto, $nomeCliente, $codProposta)
	{	
		$email_enviar = $email;

		if (!empty($emailAprovador)) {
			$email_enviar = ",".$emailAprovador;
		}

		$assunto = "Aprovação das Horas – Projeto ".$id_projeto." - ".$nomeCliente." - ".$codProposta;

		$cabecalho = 'MIME-Version: 1.0' . "\r\n";
		$cabecalho .= 'Content-type: text/html; charset=iso-8859-1;' . "\r\n";
		$cabecalho .= "Return-Path: $email_enviar \r\n";
		$cabecalho .= "From: $email_enviar \r\n";
		$cabecalho .= "Reply-To: $email_enviar \r\n";

		$mensagem = "<h3>Existem horas do profissional : ".$nomeFuncionario." no projeto ".$id_projeto." - ".$nomeCliente." - ".$codProposta.", pendentes para a aprovação.</h3>";
		//mail($email_enviar, $assunto, $mensagem, $cabecalho);
	}
}

?>