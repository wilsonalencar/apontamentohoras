<?php
require_once('model/usuario.php');

define('RESET', 1);

$usuario = new usuario;
$usuario->senha 				= md5($usuario->getRequest('senha', ''));
$usuario->senha2 				= md5($usuario->getRequest('senha2', ''));

$msg = '';
$action 						= $usuario->getRequest('action', 0);

if ($action == RESET) {
	$success = $usuario->reset();
	$msg = $usuario->msg;
}

require_once('view/usuarios/frm_reset_senha.php');
?>