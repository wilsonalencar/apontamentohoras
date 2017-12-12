<?php
require_once('model/usuario.php');
$usuario = new usuario;

if (!empty($_POST['login']) && !empty($_POST['senha'])) {
	$login = $_POST['login'];
	$senha = md5($_POST['senha']);

	if (!$usuario->login($login, $senha)) {
		echo "usuario ou senha invalidos";
		return false;
	}
	
header('LOCATION:view/index.php');
}

require_once('view/frm_login.php');
?>