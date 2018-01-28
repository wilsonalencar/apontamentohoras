<?php
require_once('model/cliente.php');
require_once('model/municipio.php');


define('SAVE', 1);
define('GET', 2);
define('DEL', 3);

$cliente = new cliente;
$municipio = new municipio;

$cliente->id 			= $cliente->getRequest('id', 0);
$cliente->codigo 		= $cliente->getRequest('codigo', '');
$cliente->nome 			= $cliente->getRequest('nome', '');
$cliente->cnpj 			= $cliente->getRequest('cnpj', '');
$cliente->endereco 		= $cliente->getRequest('endereco', '');
$cliente->complemento 	= $cliente->getRequest('complemento', '');
$cliente->cod_municipio	= $cliente->getRequest('cod_municipio', '');
$cliente->cep 			= $cliente->getRequest('cep', '');
$cliente->telefone 		= $cliente->getRequest('telefone', '');
$cliente->email 		= $cliente->getRequest('email', '');
$cliente->contato 		= $cliente->getRequest('contato', '');
$cliente->status 		= $cliente->getRequest('status', 'A');

$msg  					= $cliente->getRequest('msg', '');
$success  				= $cliente->getRequest('success', 0);
$action 				= $cliente->getRequest('action', 0);

if ($action == SAVE) {	
	$success = $cliente->save();
	$msg     = $cliente->msg; 

	header("LOCATION:clientes.php?id=".$cliente->id."&msg=".$msg."&success=".$success);
}

if ($action == GET) {
	echo json_encode(array('success'=>$cliente->get($cliente->getRequest('id')), 'msg'=>$cliente->msg, 'data'=>$cliente->array));
	exit;
}

if ($action == DEL) {
	$success = $cliente->deleta($cliente->id);
	$msg = $cliente->msg;
	require_once('consulta_clientes.php');
	exit;
}

require_once('view/clientes/frm_clientes.php');
?>