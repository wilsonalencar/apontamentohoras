<?php
require_once('model/apontamento.php');
require_once('model/apontamento.php');
require_once('model/projeto.php');
require_once('model/projetodespesa.php');
require_once('model/funcionario.php');
require_once('model/tipodespesa.php');


define('SAVE', 1);
define('GET', 2);

$apontamento 				= new apontamento;
$projeto 					= new projeto;
$projetodespesas			= new projetodespesa;
$funcionario				= new funcionario;
$tipodespesa				= new tipodespesa;

$apontamento->id					= $apontamento->getRequest('id', 0);
$apontamento->id_cliente		  	= $apontamento->getRequest('id_cliente', 0);
$apontamento->id_projeto  			= $apontamento->getRequest('id_projeto', 0);
$apontamento->Cliente_reembolsa  	= $apontamento->getRequest('Cliente_reembolsa', 0);
$apontamento->data_inicio  			= $apontamento->getRequest('data_inicio', 0);
$apontamento->data_fim  			= $apontamento->getRequest('data_fim', 0);
$apontamento->status		  		= $apontamento->getRequest('status', 1);

$success 	= $apontamento->getRequest('success', 0);
$msg 		= $apontamento->getRequest('msg', '');
$action		= $apontamento->getRequest('action', 0);

if ($action == SAVE) {
	
	$success = $apontamento->save();
	$msg     = $apontamento->msg; 

	header("LOCATION:apontamentos.php?id=".$apontamento->id."&msg=".$msg."&success=".$success);
}

if ($action == GET) {
	echo json_encode(array('success'=>$apontamento->get($apontamento->getRequest('id')), 'msg'=>$apontamento->msg, 'data'=>$apontamento->array));
	exit;
}

require_once('view/apontamentos/frm_apontamentos.php');
?>