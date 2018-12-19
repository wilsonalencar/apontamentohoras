<?php
require_once('model/usuario.php');

$usuario = new usuario;
$usuario->email = $usuario->getRequest('login', '');
$usuario->senha = md5($usuario->getRequest('senha', ''));
$msg = '';
$logout = $usuario->getRequest('logout', false);;

if (!empty($_POST)) {
	$success = $usuario->login();
	$msg = $usuario->msg;
	
	if ($success) {	
		header('LOCATION:/');
		exit();
	}	
}

if (isset($_SESSION) && !empty($_SESSION) && !$logout) {
	@session_destroy();
	header('LOCATION:'.app::dominio_platform);
}

if (isset($_SESSION) && !empty($_SESSION) && $logout) {
	@session_destroy();
	header('LOCATION:'.app::dominio_platform.'login.php');
}

require_once('view/frm_login.php');
?>