<?php
require_once('model/proposta.php');

define('SAVE', 1);
define('GET', 2);
define('DEL', 3);

$proposta = new proposta;
$proposta->id 			= $proposta->getRequest('id', 0);
$proposta->codigo 		= $proposta->getRequest('codigo', '');
$proposta->nome 		= $proposta->getRequest('nome', '');
$proposta->status 		= $proposta->getRequest('status', 'A');
		
$msg 								= $proposta->getRequest('msg', '');	
$success 							= $proposta->getRequest('success', '');	
$action 				= $proposta->getRequest('action', 0);


if ($action == SAVE) {	
	$success = $proposta->save();
	$msg     = $proposta->msg; 

	header("LOCATION:propostas.php?id=".$proposta->id."&msg=".$msg."&success=".$success);
}

if ($action == GET) {
	echo json_encode(array('success'=>$proposta->get($proposta->getRequest('id')), 'msg'=>$proposta->msg, 'data'=>$proposta->array));
	exit;
}

if ($action == DEL) {
	$success = $proposta->deleta($proposta->id);
	$msg = $proposta->msg;
	require_once('consulta_propostas.php');
	exit;
}

require_once('view/propostas/frm_propostas.php');
?>