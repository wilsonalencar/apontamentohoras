<?php
require_once('model/pilar.php');

define('SAVE', 1);
define('GET', 2);
define('DEL', 3);

$pilar = new pilar;
$pilar->id 			= $pilar->getRequest('id', 0);
$pilar->codigo 		= $pilar->getRequest('codigo', '');
$pilar->nome 		= $pilar->getRequest('nome', '');
$pilar->status 		= $pilar->getRequest('status', 'A');
		
$msg = '';
$action 				= $pilar->getRequest('action', 0);


if ($action == SAVE) {	
	$success = $pilar->save();
	$msg     = $pilar->msg; 
}

if ($action == GET) {
	echo json_encode(array('success'=>$pilar->get($pilar->getRequest('id')), 'msg'=>$pilar->msg, 'data'=>$pilar->array));
	exit;
}

if ($action == DEL) {
	$success = $pilar->deleta($pilar->id);
	$msg = $pilar->msg;
}


require_once('view/pilares/frm_pilares.php');
?>