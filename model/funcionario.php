<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class funcionario extends app
{
	public $id;
	public $nome;
	public $apelido;
	public $data_nascimento;
	public $id_tipocontratacao;
	public $id_perfilprofissional;
	public $rg;
	public $cpf;
	public $endereco;
	public $data_busca_ini;
	public $data_busca_fim;
	public $complemento;
	public $cod_municipio;
	public $cep;
	public $telefone;
	public $email;
	public $emailParticular;
	public $valor_taxa;
	public $status;
	public $msg;
	public $razao_social;
	public $id_responsabilidade;
	public $insertID;
	public $fileCV = false;
	public $fileFOTO = false;
	const PJ = 3;


	private function checkRG()
	{
		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT rg FROM funcionarios WHERE rg = '%s' AND id <> %d", $this->rg, $this->id);	
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do RG do funcionario.";
			return false;	
		}
		
		if (!empty($result->fetch_array(MYSQLI_ASSOC))) {
			$this->msg = "RG do funcionário já está sendo utilizado";
			return false;			
		}
		return true;
	}


	public function montaSelectGerente($selected=0)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT A.id, A.nome FROM funcionarios A INNER JOIN responsabilidades B on A.id_responsabilidade = B.id WHERE B.nome = 'APROVADOR' AND A.status = '%s' order by B.nome ASC", $this::STATUS_SISTEMA_ATIVO);

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%s</option>\n", $selected == $row['id'] ? "selected" : "",
			$row['id'], $row['nome']);
		}
	}

	public function montaSelect($selected=0, $id_projeto=0, $id_perfilprofissional=0, $option=false, $uniqueSelected=false)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = "SELECT 
					A.id, A.nome, A.valor_taxa
				FROM 
					funcionarios A ";

		if ($id_projeto > 0) {
			$query .= " LEFT JOIN 
			liberarprojeto B on A.id = B.id_funcionario ";
		}
				
		$query .= " WHERE 1 = 1 ";

				$query .= sprintf(" AND A.status = '%s' ", $this::STATUS_SISTEMA_ATIVO);

				if ($id_projeto > 0) {
					$query .= sprintf(" AND B.id_projeto = %d", $id_projeto);
				}

				if ($id_perfilprofissional > 0) {
					$query .= sprintf(" AND A.id_perfilprofissional = %d", $id_perfilprofissional);
				}
				 
		$query .= " GROUP BY A.id ORDER BY A.nome";
		
		if($result = $conn->query($query))
		{
			if ($option) {
				echo "<option value=''>Selecione</option>";
			}

			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				
				if ($uniqueSelected && $selected != $row['id']) {
					continue;
				}

				echo sprintf("<option %s value='%d' valor_taxa = %s>%s</option>\n", $selected == $row['id'] ? "selected" : "",
				$row['id'], number_format($row['valor_taxa'], 2, ',', '.'), $row['nome']);
			}
		}
	}

	private function checkCPF()
	{
		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT cpf FROM funcionarios WHERE cpf = '%s' AND id <> %d", $this->cpf, $this->id);	
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do CPF do funcionário";
			return false;	
		}
		
		if (!empty($result->fetch_array(MYSQLI_ASSOC))) {
			$this->msg = "CPF do funcionário já está sendo utilizado";
			return false;			
		}
		return true;
	}

	private function checkApelido()
	{
		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT apelido FROM funcionarios WHERE apelido = '%s' AND id <> %d", $this->apelido, $this->id);	
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do apelido do funcionário";
			return false;	
		}
		
		if (!empty($result->fetch_array(MYSQLI_ASSOC))) {
			$this->msg = "Apelido do funcionário já está sendo utilizado";
			return false;			
		}
		return true;
	}
	private function check(){
		
		if (empty($this->nome)) {
			$this->msg = "Favor informar o Nome do funcionário.";
			return false;
		}

		if (empty($this->data_nascimento)) {
			$this->msg = "Favor informar a data de nascimento do funcionário.";
			return false;
		}
		
		if (empty($this->apelido)) {
			$this->msg = "Favor inserir o apelido do funcionário.";
			return false;
		}

		if (!$this->checkApelido()) {
			return false;
		}

		if (empty($this->id_tipocontratacao)) {
			$this->msg = "Favor informar o tipo de contratação do funcionário.";
			return false;	
		}

		if (empty($this->id_perfilprofissional)) {
			$this->msg = "Favor informar o perfil profissional do funcionário.";
			return false;	
		}

		if (empty($this->rg)) {
			$this->msg = "Favor informar o RG do funcionário.";
			return false;	
		}

		if (!$this->checkRG()) {
			return false;
		}

		if (empty($this->cpf)) {
			$this->msg = "Favor informar o CPF do funcionário.";
			return false;	
		}

		if (empty($this->email)) {
			$this->msg = "Favor informar um email.";
			return false;
		}

		if (!$this->validaEmail($this->email)) {
			return false;
		}

		if (!$this->checkExiste()) {
			return false;
		}

		if (!empty($this->emailParticular) && !$this->validaEmail($this->emailParticular)) {
			return false;
		}

		if (!empty($this->emailParticular) && !$this->checkMail()) {
			$this->msg = 'Email Particular informado já está sendo utilizado';
			return false;
		}

		if (!$this->checkCPF()) {
			return false;
		}

		if (!$this->validaCPF($this->cpf)) {
			$this->msg = "CPF é inválido, favor verificar.";
			return false;
		}

		if (empty($this->endereco)) {
			$this->msg = "Favor informar o endereço do funcionário.";
			return false;	
		}

		if (empty($this->cod_municipio)) {
			$this->msg = "Favor informar o município do funcionário.";
			return false;	
		}

		if (empty($this->cep)) {
			$this->msg = "Favor informar o CEP do funcionário.";
			return false;	
		}

		if (empty($this->valor_taxa)) {
			$this->msg = "Favor informar a Taxa do funcionário.";
			return false;	
		}
		
		return true;
	}


	private function checkExiste()
	{
		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT id FROM funcionarios WHERE email = '%s' AND id <> %d", $this->email, $this->id);	
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do email do funcionario";
			return false;	
		}
		
		if (!empty($result->fetch_array(MYSQLI_ASSOC))) {
			$this->msg = "Email do funcionário já está sendo utilizado";
			return false;			
		}
		return true;
	}



	private function checkMail()
	{
		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT id FROM funcionarios WHERE emailParticular = '%s' AND id <> %d", $this->emailParticular, $this->id);	
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do email do funcionario";
			return false;	
		}
		
		if (!empty($result->fetch_array(MYSQLI_ASSOC))) {
			$this->msg = "Email pessoal do funcionário já está sendo utilizado";
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
		$this->valor_taxa = str_replace(',','.',str_replace('.','',$this->valor_taxa));  

		$conn->autocommit(FALSE);

		$query = sprintf(" INSERT INTO funcionarios (nome, apelido, data_nascimento, id_tipocontratacao, id_perfilprofissional,id_responsabilidade, rg , cpf , endereco, valor_taxa , complemento ,	cod_municipio, cep, telefone, email , emailParticular, usuario, status)
		VALUES ('%s','%s', '%s', %d, %d, %d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', %s ,'%s', '%s')", 
			$this->nome, $this->apelido, $this->data_nascimento, $this->id_tipocontratacao, $this->id_perfilprofissional, $this->id_responsabilidade, $this->rg, $this->cpf,$this->endereco, $this->valor_taxa,$this->complemento,$this->cod_municipio,$this->cep,$this->telefone,$this->email, $this->quote($this->emailParticular, true, true), $_SESSION['email'], $this->status);
		
		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}

		if (!empty($this->razao_social) && $this->id_tipocontratacao == $this::PJ) {
			$id = $conn->insert_id;
			$query = $query = sprintf("INSERT INTO empresafunpj(id_funcionario, Razao_social) VALUES (%d,'%s')", $id, $this->razao_social);

			if (!$conn->query($query)) {
				$this->msg = "Ocorreu um erro, contate o administrador do sistema (Razão Social) !";
				return false;	
			}
		}

		if (!empty($this->fileCV)) {
			
			$an = new anexo;
			$an->file = $this->fileCV;
			$an->path = 'curriculo_funcionario';
			$an->name = $conn->insert_id;
			$an->typeFile = $an::FILE_CV;

			if (!$an->insert()) {
				$this->msg = 'Ocorreu um erro ao atualizar funcionario '. $an->msg;
				return false;
			}
		}

		if (!empty($this->fileFOTO)) {		
			$an = new fotos;
			$an->file = $this->fileFOTO;
			$an->path = 'foto_funcionario';
			$an->name = $conn->insert_id;

			if (!$an->insert()) {
				$this->msg = 'Ocorreu um erro ao atualizar funcionario '. $an->msg;
				return false;
			}
		}

		$conn->commit();

		$this->msg = "Registro inserido com sucesso!";
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
							A.tipo_horas as tipo_horas,
						    A.observacao as atividade,
						    A.Aprovado as status,
						    A.Data_apontamento as data_apont,
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
						");
		
		if ($this->id > 0) {
			$query .= " AND A.id_funcionario = ".$this->id;
		}

		if (!empty($this->data_busca_ini) AND !empty($this->data_busca_fim) ) {
			$query .= " AND A.Data_apontamento BETWEEN "."'".$this->data_busca_ini."'"." AND "."'".$this->data_busca_fim."'";
		}
		if ($_SESSION['id_perfilusuario'] == funcionalidadeConst::PERFIL_GERENTEPROJETOS && $this->id != $_SESSION['id_funcionario']) {
			$query .= sprintf(" AND C.id_gerente = %d ", $_SESSION['id_funcionario']);
		}

		if ($_SESSION['id_perfilusuario'] == funcionalidadeConst::PERFIL_GERENTEPROJETOS && $this->id == $_SESSION['id_funcionario']) {
			$query .= " AND (C.id_gerente = '".$_SESSION['id_funcionario']."' OR A.id_funcionario = "."'".$_SESSION['id_funcionario']."')";
		}

		if ($_SESSION['id_perfilusuario'] == funcionalidadeConst::PERFIL_RECURSO) {
			$query .= " AND B.Email = '".$_SESSION['email']."'";
		}

		if ($_SESSION['id_perfilusuario'] == funcionalidadeConst::PERFIL_GERENTEPROJETOSADM && $this->id != $_SESSION['id_funcionario']) {
			$query .= sprintf(" AND C.id_gerente = %d ", $_SESSION['id_funcionario']);
		}

		if ($_SESSION['id_perfilusuario'] == funcionalidadeConst::PERFIL_GERENTEPROJETOSADM && $this->id == $_SESSION['id_funcionario']) {
			$query .= " AND (C.id_gerente = '".$_SESSION['id_funcionario']."' OR A.id_funcionario = "."'".$_SESSION['id_funcionario']."')";
		}
		
		$query .= " ORDER BY A.data_apontamento, B.id, A.id";
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		$this->array['valorTotalGeral'] = 0;
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$timestamp = strtotime($row['data_apont']);
			$row['data_apont'] = date("d/m/Y", $timestamp);
			$row['status'] = $this->formatStatusL($row['status']);
			if (empty($this->array['dados'][$row['id_funcionario']])) {
				$this->array['dados'][$row['id_funcionario']]['valorTotal'] = 0;	
			}
			$this->array['dados'][$row['id_funcionario']][] = $row;
			$this->array['dados'][$row['id_funcionario']]['valorTotal'] = $row['qtd_hrs'] + $this->array['dados'][$row['id_funcionario']]['valorTotal'] ;	
			$this->array['valorTotalGeral'] = $row['qtd_hrs'] + $this->array['valorTotalGeral'];
		}
	}

	private function checkExistencia($id)
	{
		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT * FROM empresafunpj WHERE id_funcionario = %d", $id);	
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do email do funcionario";
			return false;	
		}
		if (!empty($result->fetch_array(MYSQLI_ASSOC))) {
			$this->msg = "Email do funcionário já está sendo utilizado";
			return false;			
		}
		
		return true;

	}
	public function update()
	{
		$conn = $this->getDB->mysqli_connection;
		$this->valor_taxa = str_replace(',','.',str_replace('.','',$this->valor_taxa));

		$conn->autocommit(FALSE);

		$query = sprintf(" UPDATE funcionarios SET nome = '%s', apelido = '%s', data_nascimento = '%s', id_tipocontratacao = %d, id_perfilprofissional = %d ,id_responsabilidade = %d , rg = '%s' , cpf = '%s' , endereco = '%s', valor_taxa = '%s' , complemento = '%s', cod_municipio = %d , cep = '%s', telefone = '%s', email = '%s', usuario = '%s', status = '%s', emailParticular = %s, data_alteracao = NOW() WHERE id = %d", 
			$this->nome , $this->apelido, $this->data_nascimento, $this->id_tipocontratacao, $this->id_perfilprofissional, $this->id_responsabilidade, $this->rg, $this->cpf, $this->endereco, $this->valor_taxa, $this->complemento, $this->cod_municipio, $this->cep, $this->telefone, $this->email, $_SESSION['email'], $this->status, $this->quote($this->emailParticular, true, true) ,$this->id);	
		
		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}

		if ($this->id_tipocontratacao != $this::PJ) {
			$id = $this->id;	
			if (!$this->checkExistencia($id)) {
				$query = "DELETE FROM empresafunpj WHERE id_funcionario = ".$id."";	
				if (!$conn->query($query)) {
					$this->msg = "Ocorreu um erro, contate o administrador do sistema (Razão Social) !";
					return false;	
				}
			}
		}

		if (!empty($this->razao_social) && $this->id_tipocontratacao == $this::PJ) {
			$id = $this->id;
			if ($this->checkExistencia($id)) {
				$query = $query = sprintf("INSERT INTO empresafunpj(id_funcionario, Razao_social) VALUES (%d,'%s')", $id, $this->razao_social);	
			} else {
				$query = "UPDATE empresafunpj SET Razao_social = '".$this->razao_social."' WHERE id_funcionario = ".$id."";
			}
			if (!$conn->query($query)) {
				$this->msg = "Ocorreu um erro, contate o administrador do sistema (Razão Social) !";
				return false;	
			}

		}

		if (!empty($this->fileCV)) {

			$an = new anexo;
			$an->file = $this->fileCV;
			$an->path = 'curriculo_funcionario';
			$an->name = $this->id;

			if (!$an->insert()) {
				$this->msg = 'Ocorreu um erro ao atualizar funcionario '. $an->msg;
				return false;
			}
		}

		if (!empty($this->fileFOTO)) {

			$an = new fotos;
			$an->file = $this->fileFOTO;
			$an->path = 'foto_funcionario';
			$an->name = $this->id;

			if (!$an->insert()) {
				$this->msg = 'Ocorreu um erro ao atualizar funcionario '. $an->msg;
				return false;
			}
		}

		$conn->commit();
		$this->msg = "Registro atualizado com sucesso!";
		return true;
	}

	public function get($id)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT A.id, A.nome, A.apelido, A.cpf, A.rg, A.data_nascimento, A.endereco, A.complemento, A.cod_municipio, A.cep, A.telefone, A.email, A.id_tipocontratacao , A.id_perfilprofissional, A.id_responsabilidade, A.valor_taxa ,A.status, A.emailParticular, B.Razao_social FROM funcionarios A LEFT JOIN empresafunpj B ON A.id = B.id_funcionario WHERE A.id =  %d ", $this->id);

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento do funcionário";	
			return false;	
		}

		$this->array = $result->fetch_array(MYSQLI_ASSOC);
		$this->array['valor_taxa'] = number_format($this->array['valor_taxa'], 2, ',', '.');
		$this->msg = 'Registro carregado com sucesso';
		return true;
	}


	public function findFuncionario()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT id, nome, email FROM funcionarios WHERE email =  '%s' ", $_SESSION['email']);

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento do funcionário";	
			return false;	
		}

		$this->array = $result->fetch_array(MYSQLI_ASSOC);
		return $this->array;
	}


	private function formatStatus($status)
	{
		if ($status == $this::STATUS_SISTEMA_ATIVO) {
			return "Ativo";
		}
		return "Inativo";
	}

	public function lista()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT A.id, A.apelido, B.nome as id_perfilprofissional, A.data_nascimento, A.status FROM funcionarios A INNER JOIN perfilprofissional B ON A.id_perfilprofissional = B.id");

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos funcionários";	
			return false;	
		}
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$timestamp = strtotime($row['data_nascimento']);
			$row['data_nascimento'] = date("d/m/Y", $timestamp);
			$row['status'] = $this->formatStatus($row['status']);
			$this->array[] = $row;
		}
	}
	public function deleta($id)
	{
		if (!$id) {
			return false;
		}
		
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("DELETE FROM funcionarios WHERE id = %d ", $id);

		$query2 = sprintf("DELETE FROM empresafunpj WHERE id_funcionario = %d ", $id);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "O funcionário tem um vinculo externo, exclusão não permitida.";	
			return false;	
		}

		if (!$result = $conn->query($query2)) {
			$this->msg = "Ocorreu um erro na exclusão da razão social do funcionário.";	
			return false;	
		}

		$this->msg = 'Registro excluido com sucesso';
		return true;	
	}

	public function verify_acesso_banco_horas()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = 'SELECT * FROM acessobancohoras WHERE funcionario_id = '.$_SESSION['id_funcionario'];
		$execute = $conn->query($query);

		if($_SESSION['id_perfilusuario'] != 1)
		{
			if(mysqli_num_rows($execute) < 1)
			{
				session_destroy();
				header("LOCATION:index.php");
			}
		}
	}

}

?>