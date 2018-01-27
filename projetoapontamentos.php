<?php
require_once('model/projetoapontamento.php');

define('SAVE', 1);
define('GET', 2);

$projetoapontamento = new projetoapontamento;
$projetoapontamento->id 				= $projetoapontamento->getRequest('id', 0);
$projetoapontamento->periodo_libera 	= $projetoapontamento->getRequest('periodo_libera', '');
$projetoapontamento->libera 			= $projetoapontamento->getRequest('libera', 'N');
		
$msg 					= $projetoapontamento->getRequest('msg', '');	
$success 				= $projetoapontamento->getRequest('success', '');	
$action 				= $projetoapontamento->getRequest('action', 0);


if ($action == SAVE) {	
	$success = $projetoapontamento->save();
	$msg     = $projetoapontamento->msg; 

	header("LOCATION:projetoapontamentos.php?id=".$projetoapontamento->id."&libera=".$projetoapontamento->libera."&periodo_libera=".$projetoapontamento->periodo_libera."&msg=".$msg."&success=".$success);
}

if ($action == GET) {
	$projetoapontamento->loadPeriodo();
	header("LOCATION:projetoapontamentos.php?id=".$projetoapontamento->id."&libera=".$projetoapontamento->libera."&periodo_libera=".$projetoapontamento->periodo_libera);
}

require_once('view/projetoapontamentos/frm_projetoapontamento.php');
?>