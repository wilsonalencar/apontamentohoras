<?php
require_once('model/contratacao.php');

define('SAVE', 1);
define('GET', 2);

$contratacao = new contratacao;
$contratacao->id 			= $contratacao->getRequest('id', 0);
$contratacao->codigo 		= $contratacao->getRequest('codigo', '');
$contratacao->nome 			= $contratacao->getRequest('nome', '');
$contratacao->status 		= $contratacao->getRequest('status', 'A');
		
$msg = '';
$action 				= $contratacao->getRequest('action', 0);


if ($action == SAVE) {	
	$success = $contratacao->save();
	$msg     = $contratacao->msg; 
}

if ($action == GET) {
	echo json_encode(array('success'=>$contratacao->get($contratacao->getRequest('id')), 'msg'=>$contratacao->msg, 'data'=>$contratacao->array));
	exit;
}

if ($action == 3) {
	$success = $contratacao->deleta($contratacao->get($contratacao->getRequest('id')));
	$msg = $contratacao->msg;
}

if ($action == 4) {
	//list
}

require_once('view/contratacao/frm_contratacao.php');
?>