<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class cliente extends app
{
	public $id;
	public $codigo;
	public $nome;
	public $cnpj;
	public $endereco;
	public $complemento;
	public $cod_municipio;
	public $cep;
	public $telefone;
	public $email;
	public $contato;
	public $status;
	public $array;
	public $msg;

	private function checkCodigo()
	{
		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT codigo FROM clientes WHERE codigo = %d AND id <> %d", $this->codigo, $this->id);	
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do código do cliente";
			return false;	
		}
		
		if (!empty($result->fetch_array(MYSQLI_ASSOC))) {
			$this->msg = "Codigo do cliente já está sendo utilizado";
			return false;			
		}
		return true;
	}

	private function checkCNPJ()
	{
		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT cnpj FROM clientes WHERE cnpj = '%s' AND id <> %d", $this->cnpj, $this->id);	
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do cnpj do cliente.";
			return false;	
		}
		
		if (!empty($result->fetch_array(MYSQLI_ASSOC))) {
			$this->msg = "CNPJ já está sendo utilizado por outro cliente.";
			return false;			
		}
		return true;
	}

	private function check()
	{
		if (empty($this->codigo)) {
			$this->msg = 'Informar codigo.';
			return false;
		}

		if (empty($this->nome)) {
			$this->msg = 'Informar o Nome.';
			return false;
		}
		if (empty($this->cnpj)) {
			$this->msg = 'Informar o CNPJ.';
			return false;
		}
		if (empty($this->endereco)) {
			$this->msg = 'Informar o endereço.';
			return false;
		}
		if (empty($this->cod_municipio)) {
			$this->msg = 'Informar a cidade.';
			return false;
		}
		if (empty($this->cep)) {
			$this->msg = 'Informar o CEP';
			return false;
		}

		if (!empty($this->email) && !$this->validaEmail($this->email)) {
			$this->msg = "Favor informar um email válido.";
			return false;
		}

		if (!$this->validaCNPJ($this->cnpj)) {
			$this->msg = 'Favor inserir o CNPJ corretamente.';
			return false;
		}

		if (!$this->checkCNPJ()) {
			return false;
		}

		if (!$this->checkCodigo()) {
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

	public function montaSelect($selected=0)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT id,nome FROM clientes WHERE status = '%s' ORDER BY nome", $this::STATUS_SISTEMA_ATIVO);

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo utf8_encode(sprintf("<option %s value='%d'>%s</option>\n", $selected == $row['id'] ? "selected" : "",
			$row['id'], $row['nome']));
		}
	}

	public function insert()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf(" INSERT INTO clientes (codigo, nome, cnpj, endereco, complemento, cod_municipio, cep, telefone, email, contato, status, usuario)
		VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',%d)", 
			$this->codigo, $this->nome, $this->cnpj, $this->endereco, $this->complemento, $this->cod_municipio, $this->cep, $this->telefone, $this->email, $this->contato, $this->status, $_SESSION['usuarioID']);	

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
		$query = sprintf(" UPDATE clientes SET nome = '%s', cnpj = '%s', endereco = '%s', complemento = '%s', cod_municipio = '%s', cep = '%s', telefone = '%s', email= '%s', contato= '%s', status ='%s', usuario = %d, data_alteracao = NOW() WHERE id = %d", 
			$this->nome, $this->cnpj, $this->endereco, $this->complemento, $this->cod_municipio, $this->cep, $this->telefone, $this->email, $this->contato, $this->status, $_SESSION['usuarioID'], $this->id);	
	
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
		$query = sprintf("SELECT id, codigo, nome, cnpj, endereco, complemento, cod_municipio, cep, telefone, email, contato, status, usuario FROM clientes WHERE id =  %d ", $id);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento do cliente";	
			return false;	
		}
		$this->array = $result->fetch_array(MYSQLI_ASSOC);
		$this->msg = 'Registro carregado com sucesso';
		return true;
	}

	public function lista()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT 
			A.id, 
			A.codigo, 
			A.nome, 
			A.cnpj, 
			B.nome as cidade, 
			B.uf, 
			A.email, 
			A.status FROM clientes A
			INNER JOIN municipios B ON A.cod_municipio = B.codigo");
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento do cliente";	
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
		$query = sprintf("DELETE FROM clientes WHERE id = %d ", $id);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro na exclusão do cliente";	
			return false;	
		}
		$this->msg = 'Registro excluido com sucesso';
		return true;	
	}


}

?>