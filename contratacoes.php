<?php
require_once('model/contratacao.php');

define('SAVE', 1);
define('GET', 2);
define('DEL', 3);

$contratacao = new contratacao;
$contratacao->id 			= $contratacao->getRequest('id', 0);
$contratacao->codigo 		= $contratacao->getRequest('codigo', '');
$contratacao->nome 			= $contratacao->getRequest('nome', '');
$contratacao->status 		= $contratacao->getRequest('status', 'A');
		
$msg 								= $contratacao->getRequest('msg', '');	
$success 							= $contratacao->getRequest('success', '');
$action 				= $contratacao->getRequest('action', 0);


if ($action == SAVE) {	
	$success = $contratacao->save();
	$msg     = $contratacao->msg; 

	header("LOCATION:contratacoes.php?id=".$contratacao->id."&msg=".$msg."&success=".$success);
}

if ($action == GET) {
	echo json_encode(array('success'=>$contratacao->get($contratacao->getRequest('id')), 'msg'=>$contratacao->msg, 'data'=>$contratacao->array));
	exit;
}

if ($action == DEL) {
	$success = $contratacao->deleta($contratacao->id);
	$msg = $contratacao->msg;
	require_once('consulta_contratacoes.php');
	exit;
}


require_once('view/contratacao/frm_contratacao.php');
?>