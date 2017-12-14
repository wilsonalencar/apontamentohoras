<?php
require_once('model/cliente.php');

define('SAVE', 1);
define('GET', 2);

$cliente = new cliente;
$cliente->id 			= $cliente->getRequest('id', 6);
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

$msg = '';
$action 				= $cliente->getRequest('action', 0);

if ($action == SAVE) {	
	$success = $cliente->save();
	$msg     = $cliente->msg; 
}

if ($action == GET) {
	echo json_encode(array('success'=>$cliente->get($cliente->getRequest('id')), 'msg'=>$cliente->msg, 'data'=>$cliente->array));
	exit;
}

if ($action == 3) {
	//delete
}

if ($action == 4) {
	//list
}

require_once('view/clientes/frm_clientes.php');
?>