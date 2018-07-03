<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class projeto extends app
{
	public $id;
	public $id_cliente;
	public $id_proposta;
	public $id_gerente;
	public $id_pilar;
	public $data_inicio;
	public $data_fim;
	public $PilarNome;
	public $ClienteNome;
	public $data_busca_ini;
	public $data_busca_fim;
	public $Cliente_reembolsa;
	public $status;
	public $msg;
	public $array;
	public $array_Fin;
	public $array_Fin_precificacao;
	public $fileAnexo;
	public $statusID;
	public $farol;

	private function check(){
		
		if (empty($this->id_cliente)) {
			$this->msg = "Favor informar o cliente.";
			return false;
		}
			
		if (empty($this->id_proposta)) {
			$this->msg = "Favor informar a proposta.";
			return false;
		}

		if (empty($this->id_pilar)) {
			$this->msg = "Favor informar o pilar.";
			return false;	
		}

		if (empty($this->status)) {
			$this->msg = "Favor informar o status.";
			return false;	
		}

		if (!$this->id_gerente > 0) {
			$this->msg = "Favor informar o gerente do projeto.";
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

		$query = sprintf(" INSERT INTO projetos (id_cliente, id_proposta, id_pilar, data_inicio, data_fim, id_status, Cliente_reembolsa, id_gerente, usuario)
		VALUES (%d, %d, %d, %s, %s, %d, '%s', %d, '%s')", 
			$this->id_cliente, $this->id_proposta,$this->id_pilar, $this->quote($this->data_inicio, true, true), $this->quote($this->data_fim, true, true), $this->status, $this->Cliente_reembolsa, $this->id_gerente ,$_SESSION['email']);
		
		if (!$conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		$this->id = $conn->insert_id;
		$this->msg = "Projeto Criado com sucesso!";
		return true;
	}

	public function update()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf(" UPDATE projetos SET id_cliente= %d, id_proposta= %d, id_pilar= %d, data_inicio= %s, data_fim= %s, id_status= %d, Cliente_reembolsa= '%s', usuario= '%s', id_gerente = %d, data_alteracao = NOW() WHERE id = %d", 
			$this->id_cliente , $this->id_proposta, $this->id_pilar, $this->quote($this->data_inicio, true, true), $this->quote($this->data_fim, true, true), $this->status, $this->Cliente_reembolsa, $_SESSION['email'], $this->id_gerente ,$this->id);	
	
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
		$query = sprintf("SELECT 
						    A.id,
						    A.id_cliente,
						    A.id_proposta,
						    A.id_pilar,
						    A.id_gerente,
						    A.Data_inicio,
						    A.Data_fim,
						    A.id_status,
						    A.Cliente_reembolsa,
						    B.nome AS ClienteNome,
						    C.codigo AS PropostaNome,
						    D.nome AS PilarNome
						FROM
						    projetos A
						        INNER JOIN
						    clientes B ON A.id_cliente = B.id
						        INNER JOIN
						    propostas C ON A.id_proposta = C.id
						    	INNER JOIN 
						    pilares D ON A.id_pilar = D.id
						WHERE
						    A.id = %d ", $id);

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento do usuário";	
			return false;	
		}
		$this->array = $result->fetch_array(MYSQLI_ASSOC);
		return true;
	}

	public function calcPrecificacao($id_projeto)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = "SELECT SUM(Vlr_parcela_cimp) as receita_bruta, SUM(Vlr_parcela_simp) as receita_liquida FROM projetoprevisaofat where id_projeto = ".$id_projeto.";";

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos projetos";	
			return false;	
		}

		$result = $result->fetch_array(MYSQLI_ASSOC);
		$this->array_Fin_precificacao['receita_liquida'] = $result['receita_liquida'];
		$this->array_Fin_precificacao['receita_bruta'] = $result['receita_bruta'];

		$query = "SELECT A.id, A.Qtd_hrs_estimada, A.mes_alocacao, A.Vlr_taxa_compra FROM projetorecursos A WHERE A.id_projeto = ".$id_projeto.";";

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos projetos";	
			return false;	
		}

		while ($array = $result->fetch_array(MYSQLI_ASSOC)) {
			$dados[] = $array;	
		}

		$this->array_Fin_precificacao['custos_direto'] = 0;
		if (!empty($dados)) {
			foreach ($dados as $key => $value) {
				$soma = $value['Vlr_taxa_compra'] * $value['Qtd_hrs_estimada'];
				$dados[$key]['total'] = $soma;
				$this->array_Fin_precificacao['custos_direto'] += $soma;
			}
		}

		$this->array_Fin_precificacao['CM1'] = 0;
		if (!empty($this->array_Fin_precificacao['receita_liquida']) && !empty($this->array_Fin_precificacao['custos_direto'])) {
			$this->array_Fin_precificacao['CM1'] = $this->array_Fin_precificacao['receita_liquida'] - $this->array_Fin_precificacao['custos_direto'];
		}
		$this->array_Fin_precificacao['CM1%'] = 0;
		if ($this->array_Fin_precificacao['CM1'] > 0 && !empty($this->array_Fin_precificacao['receita_liquida'])) {
			$this->array_Fin_precificacao['CM1%'] = (($this->array_Fin_precificacao['CM1'] * 100)/$this->array_Fin_precificacao['receita_liquida']); 
		}

		//formatando valores
		$this->array_Fin_precificacao['receita_liquida'] = number_format($this->array_Fin_precificacao['receita_liquida'], 2, ',', '.'); 
		$this->array_Fin_precificacao['receita_bruta'] = number_format($this->array_Fin_precificacao['receita_bruta'], 2, ',', '.'); 
		$this->array_Fin_precificacao['custos_direto'] = number_format($this->array_Fin_precificacao['custos_direto'], 2, ',', '.'); 
		$this->array_Fin_precificacao['CM1'] = number_format($this->array_Fin_precificacao['CM1'], 2, ',', '.'); 
		$this->array_Fin_precificacao['CM1%'] = number_format($this->array_Fin_precificacao['CM1%'], 2, ',', '.'); 			

		return $this->array_Fin_precificacao;
	}


	public function calcFinanceiro($id_projeto)
	{	
		//Carrega Primeira tabela
		//Define Mês atual
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT data_apontamento , Qtd_hrs_real FROM projetohoras WHERE id_projeto = %s ORDER BY data_apontamento DESC", $id_projeto);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos projetos";	
			return false;	
		}
		$result_1 = $result->fetch_array(MYSQLI_ASSOC);
		$mes_pesquisa_r = date( 'Y-m', strtotime( $result_1['data_apontamento']));
		$mes_atual = date( 'm/Y', strtotime( $result_1['data_apontamento']));
		$qtd_hrs = $result_1['Qtd_hrs_real'];
		$this->array_Fin['1']['mes_atual'] = $mes_atual;
		//Definido mes atual
		

		//define Valor com e sem imposto
		$query = sprintf("SELECT SUM(vlr_parcela_cimp) as vlr_parcela_cimp, SUM(vlr_parcela_simp) as vlr_parcela_simp FROM projetoprevisaofat 
						WHERE id_projeto = %d AND mes_previsao_fat = '%s'", $id_projeto, $mes_atual);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos projetos";	
			return false;	
		}
		$result_2 = $result->fetch_array(MYSQLI_ASSOC);
		$this->array_Fin['1']['vlr_parcela_cimp'] = 0;
		if (!empty($result_2['vlr_parcela_cimp'])) {
			$this->array_Fin['1']['vlr_parcela_cimp'] = $result_2['vlr_parcela_cimp'];
		}

		$this->array_Fin['1']['vlr_parcela_simp'] = 0;
		if (!empty($result_2['vlr_parcela_simp'])) {
			$this->array_Fin['1']['vlr_parcela_simp'] = $result_2['vlr_parcela_cimp'] - $result_2['vlr_parcela_simp'];
		}
		$imposto = $result_2['vlr_parcela_cimp'] - $result_2['vlr_parcela_simp'];

		$this->array_Fin['1']['valor_venda_l'] = $this->array_Fin['1']['vlr_parcela_cimp'] - $imposto; 
		
		//definido valores com e sem imposto

		//Define Custos do projeto
		//recursos
		$query = sprintf("SELECT SUM(Vlr_taxa_compra) as Vlr_taxa_compra FROM projetorecursos WHERE id_projeto = %d AND mes_alocacao = '%s'", $id_projeto, $mes_atual);

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos projetos";	
			return false;	
		}
		$result_3 = $result->fetch_array(MYSQLI_ASSOC);
		$valor_tx_compra = $result_3['Vlr_taxa_compra'];
		$gasto_recursos = $qtd_hrs * $valor_tx_compra;
		//Recursos

		$ini = $mes_pesquisa_r.'-01';
		$fim = $mes_pesquisa_r.'-31';
		
		//Despesas do projeto 
		$query = sprintf("SELECT SUM(A.Vlr_total) as Vlr_total FROM projetodespesas A INNER JOIN projetos B ON A.id_projeto = B.id WHERE A.id_projeto = %d AND A.Data_despesa between '%s' AND '%s' AND B.Cliente_reembolsa = 'N'", $id_projeto, $ini, $fim);

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos projetos";	
			return false;	
		}

		$result_4 = $result->fetch_array(MYSQLI_ASSOC);
		$gasto_despesas = $result_4['Vlr_total'];
		//Despesas do projeto

		$this->array_Fin['1']['custo_projeto'] = $gasto_despesas + $gasto_recursos;
		//definido custos do projeto

		//Verificar Margem
		$this->array_Fin['1']['margem_projeto'] = 0;
		//Verificar Margem


		$this->array_Fin['1']['margem_projeto_liquido'] = $this->array_Fin['1']['valor_venda_l'] - $this->array_Fin['1']['custo_projeto'];
		//Fim da primeira tabela
		$this->array_Fin['1']['margem_projeto'] = $this->projeto_margem($this->array_Fin['1']['valor_venda_l'], $this->array_Fin['1']['margem_projeto_liquido']);

		$this->array_Fin['1']['vlr_parcela_cimp'] = number_format($this->array_Fin['1']['vlr_parcela_cimp'], 2, ',', '.');
		$this->array_Fin['1']['vlr_parcela_simp'] = number_format($this->array_Fin['1']['vlr_parcela_simp'], 2, ',', '.');
		$this->array_Fin['1']['valor_venda_l'] = number_format($this->array_Fin['1']['valor_venda_l'], 2, ',', '.');
		$this->array_Fin['1']['custo_projeto'] = number_format($this->array_Fin['1']['custo_projeto'], 2, ',', '.');
		$this->array_Fin['1']['margem_projeto_liquido'] = number_format($this->array_Fin['1']['margem_projeto_liquido'], 2, ',', '.');


		//Carrega Segunda tabela

		//Define Mês atual
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT data_apontamento , Qtd_hrs_real FROM projetohoras WHERE id_projeto = %s ORDER BY data_apontamento ASC", $id_projeto);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos projetos";	
			return false;	
		}
		$result_1 = $result->fetch_array(MYSQLI_ASSOC);
		$mes_pesquisa_d = date( 'Y-m', strtotime( $result_1['data_apontamento']));
		$qtd_hrs = $result_1['Qtd_hrs_real'];
		

		//define Valor com e sem imposto
		$query = sprintf("SELECT SUM(vlr_parcela_cimp) as vlr_parcela_cimp, SUM(vlr_parcela_simp) as vlr_parcela_simp FROM projetoprevisaofat 
						WHERE id_projeto = %d AND mes_previsao_fat = '%s'", $id_projeto, $mes_atual);
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos projetos";	
			return false;	
		}
		$result_2 = $result->fetch_array(MYSQLI_ASSOC);
		$this->array_Fin['2']['vlr_parcela_cimp'] = 0;
		if (!empty($result_2['vlr_parcela_cimp'])) {
			$this->array_Fin['2']['vlr_parcela_cimp'] = $result_2['vlr_parcela_cimp'];
		}

		$this->array_Fin['2']['vlr_parcela_simp'] = 0;
		if (!empty($result_2['vlr_parcela_simp'])) {
			$this->array_Fin['2']['vlr_parcela_simp'] = $result_2['vlr_parcela_cimp'] - $result_2['vlr_parcela_simp'];
		}
		$imposto = $result_2['vlr_parcela_cimp'] - $result_2['vlr_parcela_simp'];
		$this->array_Fin['2']['valor_venda_l'] = $this->array_Fin['2']['vlr_parcela_cimp'] - $imposto; 
		
		//definido valores com e sem imposto

		//Define Custos do projeto

		//recursos 
		$query = sprintf("SELECT SUM(Vlr_taxa_compra) as Vlr_taxa_compra FROM projetorecursos WHERE id_projeto = %d", $id_projeto);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos projetos";	
			return false;	
		}
		$result_3 = $result->fetch_array(MYSQLI_ASSOC);
		$valor_tx_compra = $result_3['Vlr_taxa_compra'];
		$gasto_recursos = $qtd_hrs * $valor_tx_compra;
		//Recursos 

		$mes_pesquisa_d = ''.$mes_pesquisa_d.'-01';
		$mes_pesquisa_r = ''.$mes_pesquisa_r.'-31';

		//Despesas do projeto 
		$query = sprintf("SELECT SUM(A.Vlr_total) as Vlr_total FROM projetodespesas A INNER JOIN projetos B ON A.id_projeto = B.id WHERE A.id_projeto = %d AND A.Data_despesa between '%s' AND '%s' AND B.Cliente_reembolsa = 'N' ", $id_projeto, $mes_pesquisa_d, $mes_pesquisa_r);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos projetos";	
			return false;	
		}
		$result_4 = $result->fetch_array(MYSQLI_ASSOC);
		$gasto_despesas = $result_4['Vlr_total'];
		//Despesas do projeto 

		$this->array_Fin['2']['custo_projeto'] = $gasto_despesas + $gasto_recursos;
		//definido custos do projeto

		//Verificar Margem
		$this->array_Fin['2']['margem_projeto'] = 0;
		//Verificar Margem


		$this->array_Fin['2']['margem_projeto_liquido'] = $this->array_Fin['2']['valor_venda_l'] - $this->array_Fin['2']['custo_projeto'];

		$this->array_Fin['2']['margem_projeto'] = $this->projeto_margem($this->array_Fin['2']['valor_venda_l'], $this->array_Fin['2']['margem_projeto_liquido']);

		$this->array_Fin['2']['vlr_parcela_cimp'] = number_format($this->array_Fin['2']['vlr_parcela_cimp'], 2, ',', '.');
		$this->array_Fin['2']['vlr_parcela_simp'] = number_format($this->array_Fin['2']['vlr_parcela_simp'], 2, ',', '.');
		$this->array_Fin['2']['valor_venda_l'] = number_format($this->array_Fin['2']['valor_venda_l'], 2, ',', '.');
		$this->array_Fin['2']['custo_projeto'] = number_format($this->array_Fin['2']['custo_projeto'], 2, ',', '.');
		$this->array_Fin['2']['margem_projeto_liquido'] = number_format($this->array_Fin['2']['margem_projeto_liquido'], 2, ',', '.');
		//Fim da Segunda tabela


		//Carrega Terceira tabela
		//define Valor com e sem imposto
		$query = sprintf("SELECT SUM(vlr_parcela_cimp) as vlr_parcela_cimp, SUM(vlr_parcela_simp) as vlr_parcela_simp FROM projetoprevisaofat 
						WHERE id_projeto = %d", $id_projeto);
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos projetos";	
			return false;	
		}
		$result_2 = $result->fetch_array(MYSQLI_ASSOC);
		$this->array_Fin['3']['vlr_parcela_cimp'] = 0;
		if (!empty($result_2['vlr_parcela_cimp'])) {
			$this->array_Fin['3']['vlr_parcela_cimp'] = $result_2['vlr_parcela_cimp'];
		}

		$this->array_Fin['3']['vlr_parcela_simp'] = 0;
		if (!empty($result_2['vlr_parcela_simp'])) {
			$this->array_Fin['3']['vlr_parcela_simp'] = $result_2['vlr_parcela_cimp'] - $result_2['vlr_parcela_simp'];
		}
		$imposto = $result_2['vlr_parcela_cimp'] - $result_2['vlr_parcela_simp'];
		$this->array_Fin['3']['valor_venda_l'] = $this->array_Fin['3']['vlr_parcela_cimp'] - $imposto;
		//definido valores com e sem imposto

		//Define Custos do projeto

		//recursos
		$query = sprintf("SELECT SUM(Vlr_taxa_compra) as Vlr_taxa_compra FROM projetorecursos WHERE id_projeto = %d", $id_projeto);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos projetos";	
			return false;	
		}
		$result_3 = $result->fetch_array(MYSQLI_ASSOC);
		$valor_tx_compra = $result_3['Vlr_taxa_compra'];
		$gasto_recursos = $qtd_hrs * $valor_tx_compra;
		//Recursos

		//Despesas do projeto 
		$query = sprintf("SELECT SUM(A.Vlr_total) as Vlr_total FROM projetodespesas A INNER JOIN projetos B on A.id_projeto = B.id WHERE A.id_projeto = %d AND B.Cliente_reembolsa = 'N' ", $id_projeto);
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos projetos";	
			return false;	
		}
		$result_4 = $result->fetch_array(MYSQLI_ASSOC);
		$gasto_despesas = $result_4['Vlr_total'];
		//Despesas do projeto

		$this->array_Fin['3']['custo_projeto'] = $gasto_despesas + $gasto_recursos;
		//definido custos do projeto

		$this->array_Fin['3']['margem_projeto_liquido'] = $this->array_Fin['3']['valor_venda_l'] - $this->array_Fin['3']['custo_projeto'];

		//Verificar Margem

		$this->array_Fin['3']['margem_projeto'] = $this->projeto_margem($this->array_Fin['3']['valor_venda_l'], $this->array_Fin['3']['margem_projeto_liquido']);
		//Verificar Margem
		
		$this->array_Fin['3']['vlr_parcela_cimp'] = number_format($this->array_Fin['3']['vlr_parcela_cimp'], 2, ',', '.');
		$this->array_Fin['3']['vlr_parcela_simp'] = number_format($this->array_Fin['3']['vlr_parcela_simp'], 2, ',', '.');
		$this->array_Fin['3']['valor_venda_l'] = number_format($this->array_Fin['3']['valor_venda_l'], 2, ',', '.');
		$this->array_Fin['3']['custo_projeto'] = number_format($this->array_Fin['3']['custo_projeto'], 2, ',', '.');
		$this->array_Fin['3']['margem_projeto_liquido'] = number_format($this->array_Fin['3']['margem_projeto_liquido'], 2, ',', '.');
		//Fim da terceira tabela

		return $this->array_Fin;
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
						    A.id_projeto,
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
			$query .= " AND A.id_projeto = ".$this->id;
		}

		if (!empty($this->data_busca_ini) AND !empty($this->data_busca_fim) ) {
			$query .= " AND A.Data_apontamento BETWEEN "."'".$this->data_busca_ini."'"." AND "."'".$this->data_busca_fim."'";
		}
		$query .= " ORDER BY A.data_apontamento, C.id, A.id";

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		$this->array['valorTotalGeral'] = 0;
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$timestamp = strtotime($row['data_apont']);
			$row['data_apont'] = date("d/m/Y", $timestamp);
			$row['status'] = $this->formatStatusL($row['status']);
			if (empty($this->array['dados'][$row['id_projeto']])) {
				$this->array['dados'][$row['id_projeto']]['valorTotal'] = 0;	
			}
			$this->array['dados'][$row['id_projeto']][] = $row;
			$this->array['dados'][$row['id_projeto']]['valorTotal'] = $row['qtd_hrs'] + $this->array['dados'][$row['id_projeto']]['valorTotal'] ;	
			$this->array['valorTotalGeral'] = $row['qtd_hrs'] + $this->array['valorTotalGeral'];
		}
	}

	public function relatorioAcompanhamento(){
		$conn = $this->getDB->mysqli_connection;
		$query = 'SELECT
					A.id,
					B.descricao as status,
				    DATE_FORMAT(A.data_cadastro, "%d/%m/%Y") as fechado,
				    C.codigo as cliente,
				    D.nome as tipo,
				    E.nome as escopo,
				    F.apelido as gp,
				    DATE_FORMAT(A.data_inicio, "%d/%m/%Y") as inicio,
				    DATE_FORMAT(A.data_fim, "%d/%m/%Y") as termino_previsto,
				    GROUP_CONCAT(H.nome) as equipe
				FROM
					projetos A 
				INNER JOIN 
					projetostatus B on A.id_status = B.id
				INNER JOIN
					clientes C on A.id_cliente = C.id
				INNER JOIN
					pilares D on A.id_pilar = D.id
				INNER JOIN
					propostas E on A.id_proposta = E.id 
				LEFT JOIN
					funcionarios F on A.id_gerente = F.id
				LEFT JOIN
					liberarprojeto G on A.id = G.id_projeto
				LEFT JOIN 
					funcionarios H on H.id = G.id_funcionario
						';

		if (!empty($this->statusID)) {
			$query .= " WHERE A.id_status = ".$this->statusID;
		}

		$query .= " GROUP BY A.id;";

		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro, contate o administrador do sistema!";
			return false;	
		}
		
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$precificacao = $this->calcPrecificacao($row['id']);
			$row['valor_venda_total'] = $precificacao['receita_bruta'];
			$row['CM1%_Venda'] = $precificacao['CM1%'];
			
			//calculando cm1 do mes %%%%%
			$mesanterior = date('Y-m-d H:i:s', strtotime('-1 months', strtotime(date('Y-m-d H:i:s'))));
			$custosDiretosant = $this->calcGastos($row['id'], $mesanterior);
			
			$first = $precificacao['receita_liquida'] - $custosDiretosant;
			if ($precificacao['receita_liquida'] == 0) {
				$precificacao['receita_liquida'] = 1;
			}
			$row['CM1_Mes'] = ($first*100)/$precificacao['receita_liquida'];
			//fim calculo


			//calculando ytd
			$mesatual = date('Y-m-d H:i:s');
			$custosDiretosatual = $this->calcGastos($row['id'], $mesatual);
			$second = $precificacao['receita_liquida'] - $custosDiretosatual;
			if ($precificacao['receita_liquida'] == 0) {
				$precificacao['receita_liquida'] = 1;
			}
			$row['CM1_YTD'] = ($second*100)/$precificacao['receita_liquida'];
			//fim calculo

			//calculando EAD
			$custosDiretos = $this->calcGastos($row['id']);
			$third = $precificacao['receita_liquida'] - $custosDiretos;
			if ($precificacao['receita_liquida'] == 0) {
				$precificacao['receita_liquida'] = 1;
			}
			$row['CM1_EAC'] = ($third*100)/$precificacao['receita_liquida'];
			//fim calculo

			$this->array[] = $row;
		}

	return $this->array;
	}

	private function calcGastos($id_projeto, $data=null)
	{
		$conn = $this->getDB->mysqli_connection;

		$funcionarios = 'SELECT 
						    B.id, B.apelido, B.valor_taxa
						FROM
						    liberarprojeto A
						        INNER JOIN
						    funcionarios B ON A.id_funcionario = B.id
						WHERE 
							A.id_projeto ='.$id_projeto.'';

		$data = substr($data, 0,-9);
		$funcs = array();
		if($result = $conn->query($funcionarios))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				$funcs[$row['id']] = $row;
				$horasApontadas = 'SELECT
										id_funcionario, 
										SUM(qtd_hrs_real) as horas
									FROM
										projetohoras
									WHERE 
										id_projeto ='.$id_projeto.'
									AND 
										id_funcionario = '.$row['id'].'
									AND 
										data_apontamento <= "'.$data.'"
									GROUP BY id_funcionario';

				if (empty($data)) {
					$horasApontadas = 'SELECT
										id_funcionario, 
										SUM(qtd_hrs_real) as horas
									FROM
										projetohoras
									WHERE 
										id_projeto ='.$id_projeto.'
									AND 
										id_funcionario = '.$row['id'].'
									GROUP BY id_funcionario';	
				}

				if($result = $conn->query($horasApontadas))
				{
					while($rer = $result->fetch_array(MYSQLI_ASSOC)){
						$funcs[$rer['id_funcionario']]['horas'] = $rer['horas'];
					}
				}
			}
		}
		
		$valorTT = 0.00;
		foreach ($funcs as $key => $date) {
			if (!isset($date['horas'])) {
				$date['horas'] = 0;
			}
			$funcs[$key]['Valor_total'] = $date['horas'] * $date['valor_taxa'];
			$valorTT += $funcs[$key]['Valor_total'];	
		}

	return $valorTT;
	}

	public function montaSelect($selected=0, $gerente=false, $id_funcionario = 0)
	{
		$conn = $this->getDB->mysqli_connection;

		$query = "SELECT 
			    A.id AS id_projeto, B.nome AS Cliente, C.codigo AS Proposta
			FROM
			    projetos A
			        INNER JOIN
			    clientes B ON A.id_cliente = B.id
			        INNER JOIN
			    propostas C ON A.id_proposta = C.id
			        INNER JOIN
			    projetostatus D ON A.id_status = D.id
			        INNER JOIN
			    liberarprojeto E ON A.id = E.id_projeto
					INNER JOIN 
				funcionarios F ON A.id_gerente = F.id
			";

		$query .= "			    
			WHERE
			    D.id NOT IN (4, 5)
			        AND E.id_funcionario = (SELECT 
			            FSR.id
			        FROM
			            funcionarios FSR
			        WHERE
			            FSR.email = "."'".$_SESSION['email']."'".")
			  ";  
		
		if ($gerente) {
			$query .= " OR F.email = "."'".$_SESSION['email']."'"."";
		}

		if ($id_funcionario > 0) {
			$query .= " AND E.id_funcionario = ".$id_funcionario;
		}

		$query .= " GROUP BY A.id ;";
		
		if ($_SESSION['id_perfilusuario'] == funcionalidadeConst::ADMIN) {
			$query = sprintf("SELECT 
						    A.id AS id_projeto, B.nome AS Cliente, C.codigo AS Proposta
						FROM
						    projetos A
						        INNER JOIN
						    clientes B ON A.id_cliente = B.id
						        INNER JOIN
						    propostas C ON A.id_proposta = C.id
						        INNER JOIN
						    projetostatus D ON A.id_status = D.id
						WHERE
						    D.id NOT IN (4, 5)
						GROUP BY A.id;
						");
		} 
		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo sprintf("<option %s value='%d'>%d --  %s --  %s</option>\n", $selected == $row['id_projeto'] ? "selected" : "",
			$row['id_projeto'], $row['id_projeto'], $row['Cliente'], $row['Proposta']);
		}
	}

	private function projeto_margem ( $parcial, $total ) {
		if (!empty($total) and !empty($parcial)) {
	    	return number_format(( $total / $parcial) * 100 , 2, '.', '');
		}
	return '0.00';
	}

	public function lista()
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT A.id, A.nome, A.email, B.nome as id_perfilprojeto FROM projetos A INNER JOIN perfilprojeto B ON A.id_perfilprojeto = B.id");
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro no carregamento dos projetos";	
			return false;	
		}
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
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
							        LEFT JOIN
							    propostas B ON A.id_proposta = B.id
									LEFT JOIN 
								clientes C ON A.id_cliente = C.id
									LEFT JOIN 
								projetostatus D ON A.id_status = D.id
									LEFT JOIN 
								funcionarios E ON A.id_gerente = E.id
								");
		
		if ($_SESSION['id_perfilusuario'] != funcionalidadeConst::ADMIN) {
			$query .= " WHERE E.email = "."'".$_SESSION['email']."'";
		}
		
		$query .= " GROUP BY A.id";
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
		$query = sprintf("DELETE FROM projetos WHERE id = %d ", $id);
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro na exclusão do usuaŕio";	
			return false;	
		}

		$this->msg = 'Registro excluido com sucesso';
		return true;	
	}

	public function saveAnexo()
	{
		if (!$this->id) {
			$this->msg = 'Informar projeto para anexar arquivo';
			return false;
		}

		$an = new anexo;
		$an->file = $this->fileAnexo;
		$an->path = 'projetos';
		$an->typeFile = $an::FILE_PROJETO;
		$an->nameDir = $this->id;

		if (!$an->insert()) {
			$this->msg = 'Ocorreu um erro ao atualizar funcionario '. $an->msg;
			return false;
		}

		$this->msg = 'Arquivo Anexado com sucesso';
		return true;
	}
}

?>