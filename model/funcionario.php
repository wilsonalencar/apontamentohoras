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
	public $complemento;
	public $cod_municipio;
	public $cep;
	public $telefone;
	public $email;
	public $valor_taxa;
	public $status;
	public $msg;
	public $id_responsabilidade;
	public $insertID;
	public $fileCV = false;


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

	public function montaSelect($selected=0)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT id,nome FROM funcionarios WHERE status = '%s'", $this::STATUS_SISTEMA_ATIVO);

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo utf8_encode(sprintf("<option %s value='%d'>%s</option>\n", $selected == $row['id'] ? "selected" : "",
			$row['id'], $row['nome']));
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

		if (!empty($this->email) && !$this->validaEmail($this->email)) {
			$this->msg = "Favor informar um email válido.";
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

		$query = sprintf(" INSERT INTO funcionarios (nome, apelido, data_nascimento, id_tipocontratacao, id_perfilprofissional,id_responsabilidade, rg , cpf , endereco, valor_taxa , complemento ,	cod_municipio, cep, telefone, email , usuario, status)
		VALUES ('%s','%s', '%s', %d, %d, %d, '%s', '%s', '%s', '%s', %d, '%s', '%s', '%s', '%s', '%s', '%s')", 
			$this->nome, $this->apelido, $this->data_nascimento, $this->id_tipocontratacao, $this->id_perfilprofissional, $this->id_responsabilidade, $this->rg, $this->cpf,$this->endereco, $this->valor_taxa,$this->complemento,$this->cod_municipio,$this->cep,$this->telefone,$this->email, $_SESSION['email'], $this->status);
		
		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
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

		$conn->commit();

		$this->msg = "Registro inserido com sucesso!";
		return true;
	}

	public function update()
	{
		$conn = $this->getDB->mysqli_connection;
		$this->valor_taxa = str_replace(',','.',str_replace('.','',$this->valor_taxa));

		$conn->autocommit(FALSE);

		$query = sprintf(" UPDATE funcionarios SET nome = '%s', apelido = '%s', data_nascimento = '%s', id_tipocontratacao = %d, id_perfilprofissional = %d ,id_responsabilidade = %d , rg = '%s' , cpf = '%s' , endereco = '%s', valor_taxa = %d , complemento = '%s' ,	cod_municipio = %d , cep = '%s', telefone = '%s', email = '%s', usuario = '%s', status = '%s', data_alteracao = NOW() WHERE id = %d", 
			$this->nome , $this->apelido, $this->data_nascimento, $this->id_tipocontratacao, $this->id_perfilprofissional, $this->id_responsabilidade, $this->rg, $this->cpf, $this->endereco, $this->valor_taxa, $this->complemento, $this->cod_municipio, $this->cep, $this->telefone, $this->email, $_SESSION['email'], $this->status, $this->id);	
		
		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
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
		
		$conn->commit();
		$this->msg = "Registro atualizado com sucesso!";
		return true;
	}

	public function get($id)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT id, nome, apelido, cpf, rg, data_nascimento, endereco, complemento, cod_municipio, cep, telefone, email, id_tipocontratacao, id_perfilprofissional, id_responsabilidade, valor_taxa ,status FROM funcionarios WHERE id =  %d ", $this->id);

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
			$row['data_nascimento'] = date("d-m-Y", $timestamp);
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
		
		if (!$result = $conn->query($query)) {
			$this->msg = "O funcionário tem um vinculo externo, exclusão não permitida.";	
			return false;	
		}

		$this->msg = 'Registro excluido com sucesso';
		return true;	
	}

}

?>