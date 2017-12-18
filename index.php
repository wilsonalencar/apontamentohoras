<?php
require_once('model/app.php');

if (empty($_SESSION['logado'])) {
	header('LOCATION:login.php');
} 

require_once('view/index.php');
?> 	