<?php
require_once('model/responsabilidade.php');

define('SAVE', 1);
define('GET', 2);

$responsabilidades = new responsabilidade;
$responsabilidades->id 			= $responsabilidades->getRequest('id', 0);
$responsabilidades->codigo 		= $responsabilidades->getRequest('codigo', '');
$responsabilidades->nome 		= $responsabilidades->getRequest('nome', '');
$responsabilidades->status 		= $responsabilidades->getRequest('status', 'A');
		
$msg = '';
$action 				= $responsabilidades->getRequest('action', 0);


if ($action == SAVE) {	
	$success = $responsabilidades->save();
	$msg     = $responsabilidades->msg; 
}

if ($action == GET) {
	echo json_encode(array('success'=>$responsabilidades->get($responsabilidades->getRequest('id')), 'msg'=>$responsabilidades->msg, 'data'=>$responsabilidades->array));
	exit;
}

if ($action == 3) {
	$success = $responsabilidades->deleta($responsabilidades->get($responsabilidades->getRequest('id')));
	$msg = $responsabilidades->msg;
}

if ($action == 4) {
	//list
}

require_once('view/responsabilidades/frm_responsabilidades.php');
?>