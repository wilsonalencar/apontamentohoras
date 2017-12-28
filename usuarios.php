<?php
require_once('model/usuario.php');
require_once('model/responsabilidade.php');
require_once('model/perfilusuario.php');

define('SAVE', 1);
define('GET', 2);
define('DEL', 3);

$usuario = new usuario;
$responsabilidade = new responsabilidade;
$perfilusuario = new perfilusuario;
$usuario->usuarioID				= $usuario->getRequest('usuarioID', 0);
$usuario->nome 					= $usuario->getRequest('nome', '');
$usuario->email 				= $usuario->getRequest('email', '');
$usuario->id_perfilusuario  	= $usuario->getRequest('id_perfilusuario', 0);
$usuario->id_responsabilidade  	= $usuario->getRequest('id_responsabilidade', 0);
$usuario->reset_senha		  	= $usuario->getRequest('reset_senha', 0);
$usuario->status		  		= $usuario->getRequest('status', 'A');
$usuario->senha 				= md5($usuario->getRequest('senha', ''));

$msg = '';
$action 						= $usuario->getRequest('action', 0);

if ($action == SAVE) {
	echo "<pre>";
	print_r($usuario->usuarioID);
	echo "</pre>";
	echo "<hr />";
	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	echo "<hr />";
	echo "<pre>";
	print_r($usuario);
	echo "</pre>";exit;
	$success = $usuario->save();
	$msg     = $usuario->msg; 
}

if ($action == GET) {
	echo json_encode(array('success'=>$usuario->get($usuario->getRequest('usuarioID')), 'msg'=>$usuario->msg, 'data'=>$usuario->array));
	exit;
}

if ($action == DEL) {
	$success = $usuario->deleta($usuario->usuarioID);
	$msg = $usuario->msg;
	require_once('consulta_usuarios.php');
	exit;
}

require_once('view/usuarios/frm_usuarios.php');
?>