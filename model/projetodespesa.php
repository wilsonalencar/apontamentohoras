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
	public $data_busca_ini;
	public $arrayIDS;
	public $data_busca_fim;
	public $Aprovado;
	public $msg;
	public $array;

	private function check()
	{
		if (empty($this->id_projeto)) {
			$this->msg = "Selecione o projeto.";
			return false;
		}

		if (empty($this->Data_despesa)) {
			$this->msg = "Insira a data da despesa.";
			return false;
		}

		if (empty($this->id_funcionario)) {
			$this->msg = "Selecione o funcionário.";
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

		if ($this->Qtd_despesa < 0) {
			$this->msg = "Favor informar a quantidade da despesa corretamente.";
			return false;	
		}

		if ($this->Vlr_unit < 0) {
			$this->msg = "Favor informar o valor da despesa corretamente.";
			return false;	
		}

		if (!$this->checkData($this->Data_despesa)) {
			return false;
		}
		return true;
	}

	public function checkData($data_despesa)
	{
	 	$data_despesa = strtotime($data_despesa);
		$data_despesa = date("m/Y", $data_despesa);
	 	$data = date('m/Y');
		if ($data_despesa != $data) {
			$conn = $this->getDB->mysqli_connection;		
			$query = sprintf("SELECT libera, periodo_libera FROM liberaapontamento WHERE periodo_libera = '%s'", $data_despesa);

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
		if (!$this->check()) {
		 	return false;
		}

		return $this->insert();
	}

	public function MontaArray($array){
		$val = '';

		foreach ($array as $key => $value) {
			if ($value != funcionalidadeConst::PENDENTE) {
				$val .= "'";
				$val .= $key."',";
			}
		}
		$val = substr($val, 0, -1);
		$conn = $this->getDB->mysqli_connection;
		$query = "SELECT 
					A.id,
				    A.id_funcionario,
				    A.id_projeto,
				    A.Aprovado,
				    A.Data_despesa AS data,
				    A.Vlr_total,
				    I.descricao AS tipodespesa,
				    C.codigo AS codProposta,
				    D.email AS email,
				    D.nome AS nomeFuncionario,
				    E.nome AS nomeCliente
				FROM
				    projetodespesas A
				        INNER JOIN
				    projetos B ON A.id_projeto = B.id
				        INNER JOIN
				    propostas C ON B.id_proposta = C.id
				        INNER JOIN
				    funcionarios D ON A.id_funcionario = D.id
				        INNER JOIN
				    clientes E ON B.id_cliente = E.id
				        INNER JOIN
				    tiposdespesas I ON A.id_tipodespesa = I.id
				WHERE A.id in (".$val.") group by A.id order by A.id ;";

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no envio de emails";	
			return false;	
		}

		while ($row = $result->fetch_array(MYSQLI_ASSOC)){
			$row['Vlr_total'] = number_format($row['Vlr_total'], 2, ',', '.');
			$row['Aprovado'] = $this->formatStatus($row['Aprovado']);
			$timestamp = strtotime($row['data']);
			$row['data'] = date("d/m/Y", $timestamp);
			$this->array['dados'][$row['email']][$row['id']] = $row;
		}

		return $this->array;
	}

	public function insert()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf(" INSERT INTO projetodespesas (id_projeto, id_funcionario, Data_despesa, id_tipodespesa, Num_doc, Qtd_despesa, Vlr_unit, Vlr_total, usuario)
		VALUES (%d, %d, '%s', %d, '%s', %d, '%s', '%s', '%s')", 
			$this->id_projeto, $this->id_funcionario, $this->Data_despesa, $this->id_tipodespesa, $this->Num_doc, $this->Qtd_despesa, $this->Vlr_unit, $this->Vlr_total, $_SESSION['email']);	

		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		$inmail = $this->carregaHoras($conn->insert_id);
		$this->mailPendente($inmail['email'], $inmail['emailAprovador'], $inmail['nomeFuncionario'], $inmail['id_projeto'], $inmail['nomeCliente'], $inmail['codProposta']);

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
			$row['Qtd_despesa'] = number_format($row['Qtd_despesa'], 0, '', '');
			$row['Vlr_unit'] = number_format($row['Vlr_unit'], 2, ',', '.');
			$row['Vlr_total'] = number_format($row['Vlr_total'], 2, ',', '.');
			$row['Aprovado'] = $this->formatStatus($row['Aprovado']);
			$timestamp = strtotime($row['Data_despesa']);
			$row['Data_despesa'] = date("d/m/Y", $timestamp);
			$this->array[] = $row;
		}
	}

	public function relatorioFunc(){
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT 
						    A.id AS id,
						    A.Vlr_Unit AS Vlr_Unit,
						    A.Qtd_despesa AS quantidade,
						    A.Vlr_Total,
						    A.Num_doc as documento,
						    A.Aprovado AS status,
						    A.Data_despesa AS data_despesa,
						    B.nome AS nomefuncionario,
						    B.id AS id_funcionario,
						    C.id AS id_projeto,
						    D.nome AS nomepilar,
						    F.codigo AS projeto1,
						    E.nome AS projeto2,
						    G.descricao AS tipodespesa,
						    C.Cliente_reembolsa as Cliente_reembolsa
						FROM
						    projetodespesas A
						        INNER JOIN
						    funcionarios B ON A.id_funcionario = B.id
						        INNER JOIN
						    projetos C ON A.id_projeto = C.id
						        INNER JOIN
						    pilares D ON C.id_pilar = D.id
						        INNER JOIN
						    clientes E ON C.id_cliente = E.id
						        INNER JOIN
						    propostas F ON C.id_proposta = F.id
								INNER JOIN 
							tiposdespesas G ON A.id_tipodespesa = G.id
						WHERE
						    B.status = 'A'");
		
		if ($this->id_funcionario > 0) {
			$query .= " AND A.id_funcionario = ".$this->id_funcionario;
		}

		if ($this->id_projeto > 0) {
			$query .= " AND A.id_projeto = ".$this->id_projeto;
		}

		if ($this->id_projeto == 0 && $this->id_funcionario == 0) {
			$query .= " AND A.id_projeto = 0"; 
		}

		if (!empty($this->data_busca_ini) AND !empty($this->data_busca_fim) ) {
			$query .= " AND A.Data_despesa BETWEEN "."'".$this->data_busca_ini."'"." AND "."'".$this->data_busca_fim."'";
		}
		
		$query .= " ORDER BY A.data_despesa, A.id_projeto, A.id";

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		$this->array['valorTotalGeral'] = 0;
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$timestamp = strtotime($row['data_despesa']);
			$row['data_despesa'] = date("d/m/Y", $timestamp);
			$row['status'] = $this->formatStatusL($row['status']);
			$row['quantidade'] = number_format($row['quantidade'], 0, '', '');
			if (empty($this->array['dados'][$row['id_funcionario']])) {
				$this->array['dados'][$row['id_funcionario']]['valorTotal'] = 0;	
			}
			$this->array['dados'][$row['id_funcionario']]['projeto'] = $row['projeto2'].' - '.$row['projeto1'];
			$this->array['dados'][$row['id_funcionario']][] = $row;
			$this->array['dados'][$row['id_funcionario']]['valorTotal'] = $row['Vlr_Total'] + $this->array['dados'][$row['id_funcionario']]['valorTotal'] ;	
			$this->array['valorTotalGeral'] = $row['Vlr_Total'] + $this->array['valorTotalGeral'];
			$this->array['Cliente_reembolsa'] = $row['Cliente_reembolsa'];
		}
		$this->array['valorTotalGeral'] = number_format($this->array['valorTotalGeral'], 2, ',', '.');
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

	public function lista_aprovacao()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = "SELECT
					A.id,
					A.id_projeto,
				    D.nome as nomeCliente,
                    C.codigo as id_proposta,
                    F.nome as funcionarioNome,
                    A.Data_despesa,
                    A.Num_doc,
                    A.Qtd_despesa,
                    A.Vlr_unit,
                    A.Vlr_total,
				    A.Aprovado as status,
				    H.descricao
				FROM 
					projetodespesas A 
				INNER JOIN 
					projetos B on A.id_projeto = B.id
				INNER JOIN 
					propostas C on B.id_proposta = C.id
				INNER JOIN
					clientes D on B.id_cliente = D.id
				INNER JOIN 
					funcionarios F on A.id_funcionario = F.id
				INNER JOIN
					funcionarios G on B.id_gerente = G.id
				INNER JOIN 
					tiposdespesas H on A.id_tipodespesa = H.id
				WHERE 
					A.Aprovado = 'N'
					";
		
		if ($_SESSION['id_perfilusuario'] != funcionalidadeConst::ADMIN) {
			$query .= sprintf(" AND G.Email = '%s' ", $_SESSION['email']);
		}

		if ($_SESSION['id_perfilusuario'] != funcionalidadeConst::ADMIN) {
			$query .= sprintf(" AND F.Email <> '%s' ", $_SESSION['email']);
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

		$query .= " ORDER BY F.nome, A.Data_despesa asc";

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos projetos";	
			return false;	
		}

		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$row['Qtd_despesa'] = number_format($row['Qtd_despesa'], 0, '', '');
			$row['Vlr_unit'] = number_format($row['Vlr_unit'], 2, ',', '.');
			$row['Vlr_total'] = number_format($row['Vlr_total'], 2, ',', '.');
			$timestamp = strtotime($row['Data_despesa']);
    		$row['Data_despesa'] = date("d/m/Y", $timestamp);
    		$this->array[] = $row;
		}
	}

	public function Aprova($id, $status, $motivo = false)
	{
		if ($status != funcionalidadeConst::PENDENTE) {
			if ($status == funcionalidadeConst::REJEITADO) {
				if (empty($motivo)) {
					$this->msg = "É necessário informar o motivo para recusar esta(s) despesa(s)!";
					return false;
				}
			}

			$conn = $this->getDB->mysqli_connection;
			$query = sprintf(" UPDATE projetodespesas SET Aprovado= '%s', data_alteracao = NOW(), data_aprovacao = NOW(), login_aprovador = '%s', motivo = %s WHERE id = %d", 
				$status, $_SESSION['email'], $this->quote($motivo, true, true) ,$id);	

			if (!$conn->query($query)) {
				$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
				return false;	
			}
		}
		
		$this->msg = "Despesas atualizadas com sucesso!";
		return true;
	}

	public function lista_Apont($periodo = false, $id_funcionario)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = "SELECT 
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
						    C.descricao AS NomeDespesa,
							CONCAT(D.id, ' - ', E.nome, ' - ', F.codigo) AS nome_projeto
						FROM
						    projetodespesas A
						        INNER JOIN
						    funcionarios B ON A.id_funcionario = B.id
						        INNER JOIN
						    tiposdespesas C ON A.id_tipodespesa = C.id
							    left JOIN 
							projetos D on A.id_projeto = D.id 
								left JOIN 
							clientes E ON D.id_cliente = E.id 
								left JOIN 
							propostas F ON D.id_proposta = F.id
						WHERE A.id_funcionario = ".$id_funcionario."";

		if (!empty($periodo)) {
			$query .= " AND DATE_FORMAT(A.data_despesa, '%m/%Y') = '".$periodo."' ";
		}

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento da previsão de faturamento.";	
			return false;	
		}
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$row['Qtd_despesa'] = number_format($row['Qtd_despesa'], 0, '', '');
			$row['Vlr_unit'] = number_format($row['Vlr_unit'], 2, ',', '.');
			$row['Vlr_total'] = number_format($row['Vlr_total'], 2, ',', '.');
			$row['Aprovado'] = $this->formatStatus($row['Aprovado']);
			$timestamp = strtotime($row['Data_despesa']);
			$row['Data_despesa'] = date("d/m/Y", $timestamp);
			$this->array[] = $row;
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


	public function carregaHoras($id)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = "SELECT 
				A.id_funcionario,
				A.id_projeto,
				B.id_gerente,
				A.Data_despesa as data,
				A.Vlr_total,
				I.descricao as tipodespesa,
				C.codigo as codProposta,
				D.email as email,
				D.nome as nomeFuncionario,
				E.nome as nomeCliente,
			    F.email as emailAprovador
			FROM 
				projetodespesas A 
			INNER JOIN 
				projetos B on A.id_projeto = B.id 
			INNER JOIN 
				propostas C on B.id_proposta = C.id
			INNER JOIN 
				funcionarios D on A.id_funcionario = D.id
			INNER JOIN 
				clientes E on B.id_cliente = E.id
			INNER JOIN 
				tiposdespesas I on A.id_tipodespesa = I.id 
			INNER JOIN 
				funcionarios F on B.id_gerente = F.id
			WHERE A.id = ".$id.";";
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no envio de emails";	
			return false;	
		}

		$row = $result->fetch_array(MYSQLI_ASSOC);
		if ($row['id_funcionario'] == $row['id_gerente']) {
			
			$query = "SELECT 
				A.id_funcionario,
				A.id_projeto,
				A.Data_despesa as data,
				A.Vlr_total,
				I.descricao as tipodespesa,
				C.codigo as codProposta,
				D.email as email,
				D.nome as nomeFuncionario,
				E.nome as nomeCliente,
			    F.email as emailAprovador,
			    GROUP_CONCAT(G.email separator ',') AS emailAprovador
			FROM 
				projetodespesas A 
			INNER JOIN 
				projetos B on A.id_projeto = B.id 
			INNER JOIN 
				propostas C on B.id_proposta = C.id
			INNER JOIN 
				funcionarios D on A.id_funcionario = D.id
			INNER JOIN 
				clientes E on B.id_cliente = E.id
			INNER JOIN 
				tiposdespesas I on A.id_tipodespesa = I.id 
			INNER JOIN 
				funcionarios F on B.id_gerente = F.id
			LEFT JOIN
				usuarios G ON G.id_perfilusuario = ".funcionalidadeConst::ADMIN."
			WHERE A.id = ".$id.";";		
			if (!$result = $conn->query($query)) {
				$this->msg = "Ocorreu um erro no envio de emails";	
				return false;	
			}	
			$row = $result->fetch_array(MYSQLI_ASSOC);
		}

		$timestamp = strtotime($row['data']);
    	$row['data'] = date("d/m/Y", $timestamp);
		return $row;
	}

	public function mailAprovacao($array)
	{
		foreach ($array as $dados => $valores) {
			foreach ($valores as $email => $despesas) {
			$this->mail->addAddress($email);
			$assunto = utf8_decode("Suas despesas receberam Interações");
			$mensagem = "<h3>Suas despesas, receberam interações, conforme abaixo :</h3>
							<table border='2'>
								<tr>
									<td align='center'>
										<b> Cliente </b>
									</td>
									<td align='center'>
										<b> Projeto </b>
									</td>
									<td align='center'>
										<b> Data </b>
									</td>
									<td align='center'>
										<b> Aprovado </b>
									</td>
									<td align='center'>
										<b> Tipo da despesa </b>
									</td>
									<td align='center'> 
										<b> Valor Total R$ </b>
									</td>
								</tr>";
			//Corpo do Email
			foreach ($despesas as $key => $value) {
				$mensagem .= "<tr align='center'>
									<td width='20%'>".$value['nomeCliente']."</td>
									<td width='15%'>".$value['id_projeto'] ."--". $value['codProposta']."</td>
									<td width='20%'>".$value['data']."</td>
									<td width='10%'>".$value['Aprovado']."</td>
									<td width='20%'>".$value['tipodespesa']."</td>
									<td width='10%'>R$ ".$value['Vlr_total']."</td>
								</tr>";
			}
			$mensagem .="</table>";
			$this->mail->IsHTML(true);
			$this->mail->Subject  = $assunto;
			$this->mail->Body = $mensagem;		
			$this->mail->Send();
			$this->mail->ClearAllRecipients();
			$this->mail->ClearAttachments();								
			}
		}
	}

	public function mailPendente($email, $nomeFuncionario, $id_projeto, $nomeCliente, $codProposta)
	{	
		$email_enviar = $email;

		if (!empty($emailAprovador)) {
			if (strstr($emailAprovador, ",")) {
				$arr = preg_split('/[^\w@\.]+/', $emailAprovador);
				foreach ($arr as $key => $value) {
					$this->mail->addAddress($value);
				}
			} else {
				$this->mail->addAddress($emailAprovador);
			}
		}
		$assunto = utf8_decode("Aprovação do Reembolso das Despesas - Projeto ".$id_projeto." - ".$nomeCliente." - ".$codProposta);
		$mensagem = "<h3>Existem despesas do profissional : ".$nomeFuncionario." <br /> No projeto ".$id_projeto." - ".$nomeCliente." - ".$codProposta.", <br />Pendentes para a aprovação.</h3>";

		$this->mail->IsHTML(true);
		$this->mail->Subject  = $assunto; // Assunto da mensagem
		$this->mail->Body = $mensagem;		
		$this->mail->Send();
		$this->mail->ClearAllRecipients();
		$this->mail->ClearAttachments();
	}

}

?>