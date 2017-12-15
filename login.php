<?php
require_once('model/usuario.php');

$usuario = new usuario;
$usuario->email = $usuario->getRequest('login', '');
$usuario->senha = md5($usuario->getRequest('senha', ''));

$msg = '';

if (!empty($_POST)) {
	$success = $usuario->login();
	$msg = $usuario->msg;
	
	if ($success) {	
		header('LOCATION:view/index.php');
	}	

	$msg = $usuario->msg;
	header('LOCATION:login.php');
}

require_once('view/frm_login.php');
?>