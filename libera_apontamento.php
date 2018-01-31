<?php
require_once('model/apontamento.php');
require_once('model/projeto.php');
require_once('model/funcionario.php');
require_once('model/projetodespesa.php');


define('APROVA_H', 1);
define('FILTRA', 2);
define('APROVA_D', 3);
define('MONTASELECTAJAXFUNCIONARIOS', 4);


$apontamento 				= new apontamento;
$projeto 					= new projeto;
$funcionario 				= new funcionario;
$projetodespesa	 			= new projetodespesa;
$aprova = array();
$aprova							 	= $apontamento->getRequest('Aprova', 'N');
$apontamento->id					= $apontamento->getRequest('id', 0);
$apontamento->id_cliente 			= $apontamento->getRequest('id_cliente', 0);
$apontamento->id_projeto 			= $apontamento->getRequest('id_projeto', 0);
$projetodespesa->id_funcionario 	= $projetodespesa->getRequest('id_funcionario', 0);
$projetodespesa->id_projeto 		= $projetodespesa->getRequest('id_projeto', 0);
$apontamento->id_funcionario		= $apontamento->getRequest('id_funcionario', 0);
$apontamento->data_busca_ini		= $apontamento->getRequest('data_busca_ini', '');
$apontamento->data_busca_fim		= $apontamento->getRequest('data_busca_fim', '');
$projetodespesa->data_busca_ini		= $projetodespesa->getRequest('data_busca_ini', '');
$projetodespesa->data_busca_fim		= $projetodespesa->getRequest('data_busca_fim', '');

$success	= $apontamento->getRequest('success', 0);
$msg		= $apontamento->getRequest('msg', '');
$action		= $apontamento->getRequest('action', 0);

if ($action == APROVA_H) {
	if (!empty($aprova)) {
		foreach ($aprova as $id => $Aprovado) {
			$success = $apontamento->Aprova($id, $Aprovado);
		}
	}
	$msg     = $apontamento->msg; 
	header("LOCATION:libera_apontamento.php?id_projeto=".$apontamento->id_projeto."&id_funcionario=".$apontamento->id_funcionario."&msg=".$msg."&success=".$success);
}

if ($action == APROVA_D) {
	if (!empty($aprova)) {
		foreach ($aprova as $id => $Aprovado) {
			$success = $projetodespesa->Aprova($id, $Aprovado);
		}
	}
	$msg     = $projetodespesa->msg; 
	header("LOCATION:libera_apontamento.php?id_projeto=".$projetodespesa->id_projeto."&id_funcionario=".$projetodespesa->id_funcionario."&msg=".$msg."&success=".$success.'#despesa');
}

if ($action == FILTRA) {
	header("LOCATION:libera_apontamento.php?id_projeto=".$apontamento->id_projeto."&id_funcionario=".$apontamento->id_funcionario."&data_busca_ini=".$projetodespesa->data_busca_ini."&data_busca_fim=".$projetodespesa->data_busca_fim."");
}

if ($action == MONTASELECTAJAXFUNCIONARIOS) {
	$funcionario->id_projeto = $funcionario->getRequest('id_projeto', '');
	echo $funcionario->montaSelect(0, $funcionario->id_projeto, 0, true);
	exit;
}


require_once('consulta_aprovacao.php');
?>