<?php
require_once('model/usuario.php');

define('SAVE', 1);
define('GET', 2);

$usuario = new usuario;
$usuario->usuarioID			= $usuario->getRequest('usuarioID', 1);
$usuario->nome 				= $usuario->getRequest('nome', '');
$usuario->email 			= $usuario->getRequest('email', '');
$usuario->data_nascimento	= $usuario->getRequest('data_nascimento', '');
$usuario->senha 			= md5($usuario->getRequest('senha', ''));
		
$msg = '';
$action 					= $usuario->getRequest('action', 0);

if ($action == SAVE) {
	$success = $usuario->save();
	$msg     = $usuario->msg; 
}

if ($action == GET) {
	echo json_encode(array('success'=>$usuario->get($usuario->getRequest('usuarioID')), 'msg'=>$usuario->msg, 'data'=>$usuario->array));
	exit;
}

if ($action == 3) {
	$success = $usuario->deleta($usuario->get($usuario->getRequest('usuarioID')));
	$msg = $usuario->msg;
}

if ($action == 4) {
	//list
}

require_once('view/usuarios/frm_usuarios.php');
?>