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
	public $Entrada_1;
	public $Saida_1;
	public $Entrada_2;
	public $Saida_2;
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
		if (empty($this->Entrada_1)) {
			$this->msg = "Favor informar a hora de entrada 1.";
			return false;	
		}
		if (empty($this->Saida_1)) {
			$this->msg = "Favor informar a hora de saída 1.";
			return false;	
		}
		if (strtotime($this->Entrada_1) > strtotime($this->Saida_1)) {
			$this->msg = "O horário de saída 1 é menor que o de Entrada 1.";
			return false;
		}
		if (!empty($this->Entrada_2) && empty($this->Saida_2)) {
			$this->msg = "Favor informar a saída 2.";
			return false;
		}
		if (empty($this->Entrada_2) && !empty($this->Saida_2)) {
			$this->msg = "Favor informar a Entrada 2.";
			return false;
		}
		if (!$this->checkHorarios($this->Entrada_1, $this->Saida_1, $this->Entrada_2, $this->Saida_2)) {
			return false;	
		}

		if (!$this->checkData($this->Data_apontamento)) {
			return false;
		}
		return true;
	}
	private function checkHorarios($entrada1, $saida1, $entrada2 = 0, $saida2 = 0)
	{
		if (!empty($entrada2) && !empty($saida2)) {
			if (strtotime($entrada2) > strtotime($saida2)) {
				$this->msg = "O horário de saida 2 é menor que o de Entrada 2.";
				return false;
			}

			if (strtotime($entrada1) > strtotime($saida2) || strtotime($saida1) > strtotime($entrada2)){
				$this->msg = "O horário informado está incorreto, favor verificar.";
				return false;
			}
		}
		$horarios = array();
		$conn = $this->getDB->mysqli_connection;
		$query = "SELECT 
					    id, Data_apontamento, Entrada_1, Saida_1, Entrada_2, Saida_2
					FROM
					    projetohoras
					WHERE
					    data_apontamento = '".$this->Data_apontamento."' AND id_funcionario = ".$this->id_funcionario." AND id_projeto = ".$this->id_projeto."";

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro na verificação de duplicidade de lançamento de horas.";	
			return false;	
		}

		while ($horarios[] = $result->fetch_array(MYSQLI_ASSOC)) {
		}

		if (!empty($horarios)) {
			foreach ($horarios as $key => $val) {
				if (is_array($val)) {
					if ((strtotime($entrada1) >= strtotime($val['Entrada_1']) && strtotime($entrada1) <= strtotime($val['Saida_1'])) || (strtotime($entrada1) <= strtotime($val['Entrada_1']) && strtotime($saida1) >= strtotime($val['Saida_1'])) || (strtotime($entrada1) >= strtotime($val['Entrada_2']) && strtotime($entrada1) <= strtotime($val['Saida_2'])) || (strtotime($entrada1) <= strtotime($val['Entrada_2']) && strtotime($saida2) >= strtotime($val['Saida_2'])) || (strtotime($saida1) <= strtotime($val['Entrada_1']) && strtotime($saida1) >= strtotime($val['Saida_1'])) || (strtotime($saida1) <= strtotime($val['Entrada_2']) && strtotime($saida1) >= strtotime($val['Saida_2']))) {
						$this->msg = "Período já foi lançado, favor verificar.";
						return false; 
					}

					if (!empty($entrada2) && !empty($saida2) && ((strtotime($entrada2) >= strtotime($val['Entrada_1']) && strtotime($entrada2) <= strtotime($val['Saida_1'])) || (strtotime($entrada2) <= strtotime($val['Entrada_1']) && strtotime($saida2) >= strtotime($val['Saida_1'])) || (strtotime($entrada2) >= strtotime($val['Entrada_2']) && strtotime($entrada2) <= strtotime($val['Saida_2'])) || (strtotime($entrada2) <= strtotime($val['Entrada_2']) && strtotime($saida2) >= strtotime($val['Saida_2'])) || (strtotime($saida2) <= strtotime($val['Entrada_1']) && strtotime($saida2) >= strtotime($val['Saida_1'])) || (strtotime($saida2) <= strtotime($val['Entrada_2']) && strtotime($saida2) >= strtotime($val['Saida_2'])))) {
						$this->msg = "Período já foi lançado, favor verificar.";
						return false; 
					}
				}
			}
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

		return $this->insert();
	}

	public function relatorioFunc()
	{

		$conn = $this->getDB->mysqli_connection;

		$query = "SELECT B.nome, A.id_funcionario, A.data_apontamento, A.Qtd_hrs_real, A.Entrada_1, A.Saida_1, A.Entrada_2, A.Saida_2, C.Razao_social FROM projetohoras A INNER JOIN funcionarios B ON A.id_funcionario = B.id LEFT JOIN empresafunpj C ON A.id_funcionario = C.id_funcionario WHERE 1 ";

		if ($this->id_funcionario > 0) {
			$query .= " AND A.id_funcionario = ".$this->id_funcionario;
		}
		
		if (!empty($this->data_busca_ini) AND !empty($this->data_busca_fim) ) {
			$query .= " AND A.Data_apontamento BETWEEN "."'".$this->data_busca_ini."'"." AND "."'".$this->data_busca_fim."'";
		}

		$query .= " ORDER BY A.data_apontamento ASC";

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}

		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$timestamp = strtotime($row['data_apontamento']);
			$row['data_apontamento'] = date("d/m/Y", $timestamp);
			if (empty($this->array['dados'][$row['id_funcionario']])) {
				$this->array['dados'][$row['id_funcionario']]['Qtd_hrs_real'] = 0;	
			}
			$this->array['dados'][$row['id_funcionario']][] = $row;
			$this->array['dados'][$row['id_funcionario']]['Qtd_hrs_real'] = $row['Qtd_hrs_real'] + $this->array['dados'][$row['id_funcionario']]['Qtd_hrs_real'] ;	
		}
	}

	public function insert()
	{	
		$conn = $this->getDB->mysqli_connection;
		
		$var = explode(':', $this->Qtd_hrs_real);
		$this->Qtd_hrs_real = '';
		foreach ($var as $value) {
			$this->Qtd_hrs_real .= '.'.$value;
		}
		$this->Qtd_hrs_real = substr($this->Qtd_hrs_real, 1);
		
		$horaReal = explode('.', $this->Qtd_hrs_real);
		if ($horaReal[1] > 0) {
			$horaReal[1] = $horaReal[1]/60;
		}
		$horareal2 = explode('.', $horaReal[1]);
		$this->Qtd_hrs_real = $horaReal[0].'.'.substr($horareal2[1], 0,1);
		
		$query = sprintf("INSERT INTO projetohoras (id_projeto, id_funcionario, id_perfilprofissional, Data_apontamento, Qtd_hrs_real, observacao, Aprovado, usuario, Entrada_1, Saida_1, Entrada_2, Saida_2)
		VALUES (%d, %d, %d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', %s, %s)", 
			$this->id_projeto, $this->id_funcionario,$this->id_perfilprofissional, $this->Data_apontamento, $this->Qtd_hrs_real, $this->observacao, $this->Aprovado, $_SESSION['email'], $this->Entrada_1, $this->Saida_1, $this->quote($this->Entrada_2, true, true),$this->quote($this->Saida_2, true, true));
		
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
		$conn  = $this->getDB->mysqli_connection;
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
		}
		$this->msg = "Apontamentos atualizados com sucesso!";
		return true;
	}

	public function lista()
	{
		$conn = $this->getDB->mysqli_connection;
		if ($this->id_projeto > 0 or $this->id_funcionario > 0) {
			$query = "SELECT id,Entrada_1, Entrada_2, Saida_1, Saida_2, Data_apontamento, Qtd_hrs_real, observacao, Aprovado, id_funcionario, id_projeto FROM projetohoras where 1";
			if ($this->id_projeto > 0) {
				$query .= " AND id_projeto = ".$this->id_projeto;
			}
			
			if ($this->id_funcionario > 0) {
				$query .= " AND id_funcionario = ".$this->id_funcionario;
			}

			$query .= " order by Data_apontamento desc; ";
			
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
				    A.Qtd_hrs_real,
				    A.observacao as atividade,
				    A.Data_apontamento AS data,
				    C.codigo AS codProposta,
				    D.email AS email,
				    D.nome AS nomeFuncionario,
				    E.nome AS nomeCliente
				FROM
				    projetohoras A
				        INNER JOIN
				    projetos B ON A.id_projeto = B.id
				        INNER JOIN
				    propostas C ON B.id_proposta = C.id
				        INNER JOIN
				    funcionarios D ON A.id_funcionario = D.id
				        INNER JOIN
				    clientes E ON B.id_cliente = E.id
				WHERE A.id in (".$val.") order by A.id ;";
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no envio de emails";	
			return false;	
		}

		while ($row = $result->fetch_array(MYSQLI_ASSOC)){
			$timestamp = strtotime($row['data']);
			$row['Aprovado'] = $this->formatStatus($row['Aprovado']);
			$row['data'] = date("d/m/Y", $timestamp);
			$this->array['dados'][$row['email']][$row['id']] = $row;
		}
		return $this->array;
	}

	public function carregaHoras($id)
	{	
		$conn = $this->getDB->mysqli_connection;
		$query = "SELECT 
				    A.id_funcionario,
				    A.id_projeto,
				    B.id_gerente,
				    A.Data_apontamento AS data,
				    A.Qtd_hrs_real AS horas,
				    A.observacao AS atividade,
				    C.codigo AS codProposta,
				    D.email AS email,
				    D.nome AS nomeFuncionario,
				    E.nome AS nomeCliente,
				    F.email AS emailAprovador
				FROM
				    projetohoras A
				        INNER JOIN
				    projetos B ON A.id_projeto = B.id
				        INNER JOIN
				    propostas C ON B.id_proposta = C.id
				        INNER JOIN
				    funcionarios D ON A.id_funcionario = D.id
				        INNER JOIN
				    clientes E ON B.id_cliente = E.id
						INNER JOIN
				    funcionarios F ON B.id_gerente = F.id
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
				    B.id_gerente,
				    A.Data_apontamento AS data,
				    A.Qtd_hrs_real AS horas,
				    A.observacao AS atividade,
				    C.codigo AS codProposta,
				    D.email AS email,
				    D.nome AS nomeFuncionario,
				    E.nome AS nomeCliente,
				    GROUP_CONCAT(G.email separator ',') AS emailAprovador
				FROM
				    projetohoras A
				        INNER JOIN
				    projetos B ON A.id_projeto = B.id
				        INNER JOIN
				    propostas C ON B.id_proposta = C.id
				        INNER JOIN
				    funcionarios D ON A.id_funcionario = D.id
				        INNER JOIN
				    clientes E ON B.id_cliente = E.id
						INNER JOIN
				    funcionarios F ON B.id_gerente = F.id
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
				INNER JOIN
					funcionarios G on B.id_gerente = G.id
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

	public function mailAprovacao($array)
	{
		foreach ($array as $dados => $valores) {
			foreach ($valores as $email => $apontamentos) {
			$this->mail->addAddress($email);
			$assunto = utf8_decode("Seus apontamentos receberam Interações");
			$mensagem = "<h3>Seus apontamentos receberam interações, conforme abaixo :</h3>
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
										<b> Atividade </b>
									</td>
									<td align='center'> 
										<b> Horas </b>
									</td>
								</tr>";
			//Corpo do Email
			foreach ($apontamentos as $key => $value) {
				$mensagem .= "<tr align='center'>
									<td width='20%'>".$value['nomeCliente']."</td>
									<td width='15%'>".$value['id_projeto'] ."--". $value['codProposta']."</td>
									<td width='20%'>".$value['data']."</td>
									<td width='10%'>".$value['Aprovado']."</td>
									<td width='20%'>".$value['atividade']."</td>
									<td width='10%'>".$value['Qtd_hrs_real']."</td>
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


	public function mailPendente($email, $emailAprovador, $nomeFuncionario, $id_projeto, $nomeCliente, $codProposta)
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

		$assunto = utf8_decode("Aprovação das Horas - Projeto ".$id_projeto." - ".$nomeCliente." - ".$codProposta);
		$mensagem = "<h3>Existem horas do(a) profissional(a) : ".$nomeFuncionario." <br /> No projeto ".$id_projeto." - ".$nomeCliente." - ".$codProposta." <br /> Pendentes para a aprovação.</h3>";

		$this->mail->IsHTML(true);
		$this->mail->Subject  = $assunto; // Assunto da mensagem
		$this->mail->Body = $mensagem;		
		$this->mail->Send();
		$this->mail->ClearAllRecipients();
		$this->mail->ClearAttachments();
	}
}

?>