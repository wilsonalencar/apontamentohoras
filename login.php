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
		header('LOCATION:/');
		exit();
	}	
}

if (isset($_SESSION) && !empty($_SESSION)) {
	session_destroy();
}

require_once('view/frm_login.php');
?>