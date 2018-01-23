<?php
require_once('model/apontamento.php');
require_once('model/apontamento.php');
require_once('model/projeto.php');
require_once('model/projetodespesa.php');
require_once('model/funcionario.php');
require_once('model/tipodespesa.php');


define('SAVE', 1);
define('FILTRA', 2);
define('DEL', 3);

$apontamento 				= new apontamento;
$projeto 					= new projeto;
$projetodespesas			= new projetodespesa;
$funcionario				= new funcionario;
$tipodespesa				= new tipodespesa;

$apontamento->id					= $apontamento->getRequest('id', 0);
$apontamento->id_cliente 			= $apontamento->getRequest('id_cliente', 0);
$apontamento->id_proposta 			= $apontamento->getRequest('id_proposta', 0);
$apontamento->id_funcionario		= $apontamento->getRequest('id_funcionario_ap', 0);
$apontamento->id_projeto  			= $apontamento->getRequest('id_projeto_ap', 0);
$apontamento->id_perfilprofissional = $apontamento->getRequest('id_perfilprofissional', 0);
$apontamento->Data_apontamento  	= $apontamento->getRequest('Data_apontamento', 0);
$apontamento->Qtd_hrs_real 			= $apontamento->getRequest('Qtd_hrs_real', 0);
$apontamento->observacao		  	= $apontamento->getRequest('observacao', '');
$apontamento->Aprovado 				= $apontamento->getRequest('Aprovado', 'N');

$success 	= $apontamento->getRequest('success', 0);
$msg 		= $apontamento->getRequest('msg', '');
$action		= $apontamento->getRequest('action', 0);

if ($action == SAVE) {
	$success = $apontamento->save();
	$msg     = $apontamento->msg; 
	header("LOCATION:apontamentos.php?id_projeto_ap=".$apontamento->id_projeto."&id_funcionario_ap=".$apontamento->id_funcionario."&msg=".$msg."&success=".$success);
}

if ($action == FILTRA) {
	header("LOCATION:apontamentos.php?id_projeto_ap=".$apontamento->id_projeto."&id_funcionario_ap=".$apontamento->id_funcionario."");
}

if ($action == DEL) {
	$ids = $apontamento->getRequest('funcionar_projeto_concat');
	$array = explode('-', $ids);
	$success = $apontamento->deleta($apontamento->id);
	$msg = $apontamento->msg;
	header("LOCATION:apontamentos.php?id_projeto_ap=".$array[1]."&id_funcionario_ap=".$array[0]."&msg=".$msg."&success=".$success);
}

require_once('view/apontamentos/frm_apontamentos.php');
?>