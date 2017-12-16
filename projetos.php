<?php
require_once('model/projeto.php');

define('SAVE', 1);
define('GET', 2);

$projeto = new projeto;
$projeto->id 			= $projeto->getRequest('id', 0);
$projeto->codigo 		= $projeto->getRequest('codigo', '');
$projeto->nome 			= $projeto->getRequest('nome', '');
$projeto->status 		= $projeto->getRequest('status', 'A');
		
$msg = '';
$action 				= $projeto->getRequest('action', 0);


if ($action == SAVE) {	
	$success = $projeto->save();
	$msg     = $projeto->msg; 
}

if ($action == GET) {
	echo json_encode(array('success'=>$projeto->get($projeto->getRequest('id')), 'msg'=>$projeto->msg, 'data'=>$projeto->array));
	exit;
}

if ($action == 3) {
	$success = $projeto->deleta($projeto->get($projeto->getRequest('id')));
	$msg = $projeto->msg;
}

if ($action == 4) {
	//list
}

require_once('view/projetos/frm_projetos.php');
?>