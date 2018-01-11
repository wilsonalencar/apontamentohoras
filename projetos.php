<?php
require_once('model/projeto.php');
require_once('model/proposta.php');
require_once('model/cliente.php');
require_once('model/pilar.php');
require_once('model/statusProj.php');

define('SAVE', 1);
define('GET', 2);
define('DEL', 3);

$projeto 	= new projeto;
$proposta 	= new proposta;
$cliente 	= new cliente;
$pilar  	= new pilar;
$statusProj = new statusProj;

$projeto->id					= $projeto->getRequest('id', 0);
$projeto->id_cliente		  	= $projeto->getRequest('id_cliente', 0);
$projeto->id_proposta  			= $projeto->getRequest('id_proposta', 0);
$projeto->id_pilar  			= $projeto->getRequest('id_pilar', 0);
$projeto->data_inicio  			= $projeto->getRequest('data_inicio', 0);
$projeto->data_fim  			= $projeto->getRequest('data_fim', 0);
$projeto->status		  		= $projeto->getRequest('status', 0);


$msg = '';
$action 						= $projeto->getRequest('action', 0);

if ($action == SAVE) {
	
	$success = $projeto->save();
	$msg     = $projeto->msg; 
}

if ($action == GET) {
	echo json_encode(array('success'=>$projeto->get($projeto->getRequest('projetoID')), 'msg'=>$projeto->msg, 'data'=>$projeto->array));
	exit;
}

require_once('view/projetos/frm_projetos.php');
?>