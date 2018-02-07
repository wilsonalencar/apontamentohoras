<?php
require_once('model/projetodespesa.php');

define('SAVE', 1);
define('GET', 2);
define('DEL', 3);
define('DEL_APONT', 4);
define('SAVE_APONT', 5);

$projetodespesa 	= new projetodespesa;
$projetodespesa->id					= $projetodespesa->getRequest('idDesp', 0);
$projetodespesa->id_projeto  		= $projetodespesa->getRequest('id_projeto', 0);
$projetodespesa->Data_despesa	  	= $projetodespesa->getRequest('Data_despesa', 0);
$projetodespesa->id_funcionario		= $projetodespesa->getRequest('id_funcionario', 0);
$projetodespesa->id_tipodespesa		= $projetodespesa->getRequest('id_tipodespesa', 0);
$projetodespesa->Num_doc			= $projetodespesa->getRequest('Num_doc', '');
$projetodespesa->Qtd_despesa		= $projetodespesa->getRequest('Qtd_despesa', 0);
$projetodespesa->Vlr_unit			= str_replace(',','.',str_replace('.','',$projetodespesa->getRequest('Vlr_unit', 0)));
$projetodespesa->Vlr_total			= $projetodespesa->Vlr_unit * $projetodespesa->Qtd_despesa;

$msg = '';
$action 								= $projetodespesa->getRequest('action', 0);

if ($action == SAVE) {
	$success 		= $projetodespesa->save();
	$msg     		= $projetodespesa->msg; 
	header('LOCATION:projetos.php?id='.$projetodespesa->id_projeto.'&success='.$success.'&msg='.$msg.'#despesa');
}

if ($action == GET) {
	echo json_encode(array('success'=>$projetodespesa->get($projetodespesa->getRequest('id')), 'msg'=>$projetodespesa->msg, 'data'=>$projetodespesa->array));
	exit;
}

if ($action == DEL) {
	$success = $projetodespesa->deleta($projetodespesa->id);
	$msg = $projetodespesa->msg;
	header('LOCATION:projetos.php?id='.$projetodespesa->id_projeto.'&success='.$success.'&msg='.$msg.'#despesa');
}

if ($action == DEL_APONT) {
	$success = $projetodespesa->deleta($projetodespesa->id);
	$msg = $projetodespesa->msg;
	header("LOCATION:apontamentos.php?id_projeto_ap=".$projetodespesa->id_projeto."&id_funcionario_ap=".$projetodespesa->id_funcionario."&msg=".$msg."&success=".$success.'#despesa');
}

if ($action == SAVE_APONT) {
	$success 		= $projetodespesa->save();
	$msg     		= $projetodespesa->msg; 
	header("LOCATION:apontamentos.php?id_projeto_ap=".$projetodespesa->id_projeto."&id_funcionario_ap=".$projetodespesa->id_funcionario."&msg=".$msg."&success=".$success.'#despesa');
}

require_once('view/projetos/frm_projetos.php');
?>