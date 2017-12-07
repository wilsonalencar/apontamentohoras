<?php

session_start();

if (!empty($_SESSION['logado'])) {
	//header('LOCATION:painel.php');
	echo "usuario logado";exit;
} 

header('LOCATION:login.php');

?>