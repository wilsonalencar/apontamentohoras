<?php

session_start();

if (!empty($_SESSION['logado'])) {
	header('LOCATION:view/index.php');
} 

header('LOCATION:login.php');
?> 	