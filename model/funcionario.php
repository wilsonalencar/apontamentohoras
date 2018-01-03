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
	public $status;
	public $msg;
	public $id_responsabilidade;

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

		if (empty($this->cpf)) {
			$this->msg = "Favor informar o CPF do funcionário.";
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
		$query = sprintf(" INSERT INTO funcionarios (nome, apelido, data_nascimento, id_tipocontratacao, id_perfilprofissional,id_responsabilidade, rg , cpf , endereco , complemento ,	cod_municipio, cep, telefone, email , usuario, status)
		VALUES ('%s','%s', '%s', %d, %d,%d, '%s', '%s', '%s', '%s', %d, '%s', '%s', '%s', '%s', '%s')", 
			$this->nome, $this->apelido, $this->data_nascimento, $this->id_tipocontratacao, $this->id_perfilprofissional, $this->id_responsabilidade, $this->rg, $this->cpf,$this->endereco,$this->complemento,$this->cod_municipio,$this->cep,$this->telefone,$this->email, $_SESSION['email'], $this->status);
		
		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		$this->msg = "Registro inserido com sucesso!";
		return true;
	}

	public function update()
	{
		if (!$this->check()) {
			return false;
		}

		$conn = $this->getDB->mysqli_connection;
		$query = sprintf(" UPDATE usuarios SET nome = '%s', email ='%s', id_perfilusuario = %d, id_responsabilidade = %d, senha = '%s', reset_senha = '%s' , usuario = '%s', data_alteracao = NOW(), status = '%s' WHERE usuarioID = %d", 
			$this->nome , $this->email, $this->id_perfilusuario, $this->id_responsabilidade, $this->senha, $this->reset_senha, $_SESSION['email'],$this->status, $this->usuarioID);	
		
		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}

		$this->msg = "Registro atualizado com sucesso!";
		return true;
	}

	public function get($id)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT nome, apelido, cpf, rg, data_nascimento, endereco, complemento, cod_municipio, cep, telefone, email, id_tipocontratacao, id_perfilprofissional, id_responsabilidade ,status FROM funcionarios WHERE id =  %d ", $this->id);

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento do funcionário";	
			return false;	
		}

		$this->array = $result->fetch_array(MYSQLI_ASSOC);
		$this->msg = 'Registro carregado com sucesso';
		return true;
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
			$this->msg = "Ocorreu um erro na exclusão do usuaŕio";	
			return false;	
		}

		$this->msg = 'Registro excluido com sucesso';
		return true;	
	}

}

?>