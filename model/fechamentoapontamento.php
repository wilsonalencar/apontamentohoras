<?php

require_once('app.php');

class fechamentoapontamento extends app
{
	public $id_funcionario;
	public $periodo;
	public $periodo_busca;
	public $data;
	public $saldo_atual;
	public $create_request;
	public $msg;
	public $array;
	public $arrayFolga;
	public $arrayHoras;
	public $frontTimes;
	public $arrayPassado;
	public $Data_apontamento;

	public function save()
	{
		$conn = $this->getDB->mysqli_connection;

		if (!$this->checkHoras()) {
			return false;
		}
		
		if ($this->create_request < 1) {
			if (!$this->checkPeriodo()) {
				$this->create_request = 1;
				return false;
			}
		}

		$this->CalcHoras();

		if (!$this->DeleteSaldoAtual()) {
			$this->msg = "Ocorreu um erro ao apagar o período atual, contate o administrador do sistema!";
			return false;
		}

		if (!empty($this->arrayHoras)) {
			foreach ($this->arrayHoras as $key => $value) {
				
				$query = sprintf("INSERT INTO saldobancohoras (id_funcionario, periodo, saldo_atual)
				VALUES (%d,'%s','%s')", $key, $this->periodo, $value);	

				if (!$conn->query($query)) {
					$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
					return false;	
				}
			}
		}
	
		$this->msg = "Registros inseridos com sucesso!";
		return true;
	}

	public function getFrontTimes()
	{
		$this->frontTimes['saldo_inicial'] = '0';
		$this->frontTimes['horas_banco'] = '0';
		$this->frontTimes['folgas'] = '0';
		$this->frontTimes['saldo_final'] = '0';

		if (!empty($this->id_funcionario) && !empty($this->periodo_busca)) {
			$this->CalcSaldoInicial();
			$this->CalcHorasBanco();
			$this->CalcFolgaFuncionario();
			$this->CalcSaldoAtualFuncionario();
		}
	}

	public function CalcHorasBanco()
	{
		$conn = $this->getDB->mysqli_connection;

       	$query = "SELECT SUM(A.Qtd_hrs_real) as horas FROM projetohoras A INNER JOIN projetos B ON A.id_projeto = B.id WHERE A.tipo_horas = 'B' AND B.controle_folga = 'N' AND DATE_FORMAT(A.Data_apontamento, '%m/%Y') = '".$this->periodo_busca."' AND A.id_funcionario= ".$this->id_funcionario;

       	if (!$result = $conn->query($query)) {
			$this->msg = " Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}

		$checkn = $result->fetch_array(MYSQLI_ASSOC);
		
		if (!empty($checkn)) {
			$this->frontTimes['horas_banco'] += $checkn['horas'];
		}
	}

	public function CalcSaldoInicial()
	{
		$conn = $this->getDB->mysqli_connection;

		$var = '01/'.$this->periodo_busca;
		$date = str_replace('/', '-', $var);
		$data = date('Y-m-d', strtotime($date));
		$timestamp = strtotime('-1 month', strtotime($data));
		$periodo = date("m/Y",$timestamp);
		$query = "SELECT A.saldo_atual FROM saldobancohoras A WHERE A.periodo ='".$periodo."' AND A.id_funcionario= ".$this->id_funcionario;

		if (!$result = $conn->query($query)) {
			$this->msg = " Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}

		$checkn = $result->fetch_array(MYSQLI_ASSOC);

		if (!empty($checkn)) {
			$this->frontTimes['saldo_inicial'] = $checkn['saldo_atual'];
		}
	}

	private function DeleteSaldoAtual()
	{
		$conn = $this->getDB->mysqli_connection;

		$query = "DELETE FROM saldobancohoras WHERE periodo ='".$this->periodo."'";

		if (!$result = $conn->query($query)) {
			$this->msg = " Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}

		return true;
	}

	public function checkHoras()
	{
		$conn = $this->getDB->mysqli_connection;

       	$query = "SELECT A.* FROM projetohoras A INNER JOIN projetos B ON A.id_projeto = B.id WHERE A.tipo_horas = 'B' AND B.controle_folga = 'N' AND DATE_FORMAT(A.Data_apontamento, '%m/%Y') = '".$this->periodo."'";

       	if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}

       	$checkn = $result->fetch_array(MYSQLI_ASSOC);
		if (empty($checkn)) {
			$this->msg = "Não há horas disponíveis para cálculo!";
			return false;
		}

		return true;
	}

	public function checkPeriodo()
	{
		$conn = $this->getDB->mysqli_connection;

		$query = "SELECT periodo FROM saldobancohoras WHERE periodo ='".$this->periodo."'";

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}

		$checkn = $result->fetch_array(MYSQLI_ASSOC);
		if (!empty($checkn)) {
			$this->msg = 'Fechamento Apontamento já realizado para o Período, deseja executar novamente? Se sim, clique novamente no botão calcular';
			return false;
		}

		return true;
	}

	public function calcHoras()
	{
		$conn = $this->getDB->mysqli_connection;

       	$sql = "SELECT A.* FROM projetohoras A INNER JOIN projetos B ON A.id_projeto = B.id WHERE A.tipo_horas = 'B' AND B.controle_folga = 'N' AND DATE_FORMAT(A.Data_apontamento, '%m/%Y') = '".$this->periodo."'";

       	if (!$result = $conn->query($sql)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		while ($array = $result->fetch_array(MYSQLI_ASSOC)) {
			$dados[] = $array;	
		}

		if (!empty($dados)) {
			foreach ($dados as $id => $registro) {
				$arrayHorasReturn[$registro['id_funcionario']] += $registro['Qtd_hrs_real']; 
			}

			$this->arrayHoras = $arrayHorasReturn;
		}

		$this->CalcFolga();
	}

	public function CalcFolgaFuncionario()
	{
		$conn = $this->getDB->mysqli_connection;

       	$sql = "SELECT A.* FROM projetohoras A INNER JOIN projetos B ON A.id_projeto = B.id WHERE B.controle_folga = 'S' AND DATE_FORMAT(A.Data_apontamento, '%m/%Y') = '".$this->periodo_busca."' AND A.id_funcionario= ".$this->id_funcionario;

       	if (!$result = $conn->query($sql)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		while ($array = $result->fetch_array(MYSQLI_ASSOC)) {
			$this->frontTimes['folgas'] += $array['Qtd_hrs_real'];
		}
	}

	public function CalcFolga()
	{
		$conn = $this->getDB->mysqli_connection;

       	$sql = "SELECT A.* FROM projetohoras A INNER JOIN projetos B ON A.id_projeto = B.id WHERE B.controle_folga = 'S' AND DATE_FORMAT(A.Data_apontamento, '%m/%Y') = '".$this->periodo."'";

       	if (!$result = $conn->query($sql)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		while ($array = $result->fetch_array(MYSQLI_ASSOC)) {
			$dados[] = $array;	
		}

		if (!empty($dados)) {
			foreach ($dados as $id => $registro) {
				$arrayFolgaReturn[$registro['id_funcionario']] += $registro['Qtd_hrs_real']; 
			}

			$this->arrayFolga = $arrayFolgaReturn;
		}

		$this->CalcSaldoAtual();
	}

	public function CalcSaldoAtual()
	{
		$conn = $this->getDB->mysqli_connection;

		$var = '01/'.$this->periodo;
		$date = str_replace('/', '-', $var);
		$data = date('Y-m-d', strtotime($date));
		$periodo_anterior = date('m/Y', strtotime('-1 months', strtotime(date($data))));
		
		$query = "SELECT * FROM saldobancohoras WHERE periodo ='".$periodo_anterior."'";

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		
		while ($array = $result->fetch_array(MYSQLI_ASSOC)) {
			$dados[] = $array;	
		}	

		if (!empty($dados)) {
			foreach ($dados as $x => $k) {
				$this->arrayPassado[$k['id_funcionario']] = $k['saldo_atual'];
			}

			foreach ($this->arrayHoras as $id_funcionario => $horas) {
				$this->arrayHoras[$id_funcionario] += $this->arrayPassado[$id_funcionario];
				$this->arrayHoras[$id_funcionario] -= $this->arrayFolga[$id_funcionario];
			}
		}
	}


	public function CalcSaldoAtualFuncionario()
	{
		$this->frontTimes['saldo_final'] = $this->frontTimes['saldo_inicial'] + $this->frontTimes['horas_banco'] - $this->frontTimes['folgas'];
	}

	public function relatorioFunc()
	{
		$conn = $this->getDB->mysqli_connection;

		$query = "SELECT 
					B.nome as nomefuncionario,
					A.id_funcionario,
					A.periodo as data,
					A.saldo_atual as qtd_hrs
				FROM 
					saldobancohoras A
				INNER JOIN 
					funcionarios B on A.id_funcionario = B.id
				WHERE 
					right(A.periodo, 4) =".$this->data.' order by B.nome asc';		
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;
		}

		while ($array = $result->fetch_array(MYSQLI_ASSOC)) {
			$dados[] = $array;	
		}	

		if (!empty($dados)) {
			foreach ($dados as $x => $k) {
				if (empty($this->array['totais'][substr($k['data'], 0,2)])) {
					$this->array['totais'][substr($k['data'], 0,2)] = 0;
				}
				$this->array[$k['id_funcionario']]['nomefuncionario'] = $k['nomefuncionario'];
				$this->array[$k['id_funcionario']]['horas'][substr($k['data'], 0,2)] = $k['qtd_hrs'];
				$this->array['totais'][substr($k['data'], 0,2)] += $k['qtd_hrs'];
			}
		}
	}	
}

?>