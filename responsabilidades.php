<?php
require_once('model/responsabilidade.php');

define('SAVE', 1);
define('GET', 2);
define('DEL', 3);

$responsabilidades = new responsabilidade;
$responsabilidades->id 			= $responsabilidades->getRequest('id', 0);
$responsabilidades->codigo 		= $responsabilidades->getRequest('codigo', '');
$responsabilidades->nome 		= $responsabilidades->getRequest('nome', '');
$responsabilidades->status 		= $responsabilidades->getRequest('status', 'A');
		
$msg 								= $responsabilidades->getRequest('msg', '');	
$success 							= $responsabilidades->getRequest('success', '');
$action 				= $responsabilidades->getRequest('action', 0);


if ($action == SAVE) {	
	$success = $responsabilidades->save();
	$msg     = $responsabilidades->msg; 

	header("LOCATION:responsabilidades.php?id=".$responsabilidades->id."&msg=".$msg."&success=".$success);
}

if ($action == GET) {
	echo json_encode(array('success'=>$responsabilidades->get($responsabilidades->getRequest('id')), 'msg'=>$responsabilidades->msg, 'data'=>$responsabilidades->array));
	exit;
}

if ($action == DEL) {
	$success = $responsabilidades->deleta($responsabilidades->id);
	$msg = $responsabilidades->msg;
	require_once('consulta_responsabilidades.php');
	exit;
}

require_once('view/responsabilidades/frm_responsabilidades.php');
?>