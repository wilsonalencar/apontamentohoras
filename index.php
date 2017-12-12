<?php
require_once('model/app.php');

if (!empty($_SESSION['logado'])) {
	header('LOCATION:view/index.php');
} 

header('LOCATION:login.php');
?> 	