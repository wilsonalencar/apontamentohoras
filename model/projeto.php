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
	public $id_pilar;
	public $data_inicio;
	public $data_fim;
	public $PilarNome;
	public $ClienteNome;
	public $Cliente_reembolsa;
	public $status;
	public $msg;
	public $array;
	public $array_Fin;
	public $fileAnexo;


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

		$query = sprintf(" INSERT INTO projetos (id_cliente, id_proposta, id_pilar, data_inicio, data_fim, id_status, Cliente_reembolsa, usuario)
		VALUES (%d, %d, %d, %s, %s, %d, '%s', '%s')", 
			$this->id_cliente, $this->id_proposta,$this->id_pilar, $this->quote($this->data_inicio, true, true), $this->quote($this->data_fim, true, true), $this->status, $this->Cliente_reembolsa, $_SESSION['email']);
		
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
		$query = sprintf(" UPDATE projetos SET id_cliente= %d, id_proposta= %d, id_pilar= %d, data_inicio= %s, data_fim= %s, id_status= %d, Cliente_reembolsa= '%s', usuario= '%s', data_alteracao = NOW() WHERE id = %d", 
			$this->id_cliente , $this->id_proposta, $this->id_pilar, $this->quote($this->data_inicio, true, true), $this->quote($this->data_fim, true, true), $this->status, $this->Cliente_reembolsa, $_SESSION['email'], $this->id);	
	
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
						ORDER BY 
							A.data_apontamento, C.id, A.id");

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

	public function montaSelect($selected=0)
	{
		$conn = $this->getDB->mysqli_connection;

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
			        INNER JOIN
			    projetorecursos E ON A.id = E.id_projeto
			WHERE
			    D.id NOT IN (4, 5)
			        AND E.id_funcionario = (SELECT 
			            id
			        FROM
			            funcionarios
			        WHERE
			            email = '%s');
			", $_SESSION['email']);
		
		if ($_SESSION['id_perfilusuario'] == '1') {
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
						    D.id NOT IN (4, 5);
						");
		} 

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo utf8_encode(sprintf("<option %s value='%d'>%d --  %s --  %s</option>\n", $selected == $row['id_projeto'] ? "selected" : "",
			$row['id_projeto'], $row['id_projeto'], $row['Cliente'], $row['Proposta']));
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