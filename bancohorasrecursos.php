<?php

require_once('model/fechamentoapontamento.php');
require_once('model/funcionario.php');
require_once('model/projeto.php');

define('SAVE', 1);
define('GET', 2);

$fechamentoapontamento = new fechamentoapontamento;

$fechamentoapontamento->periodo						= $fechamentoapontamento->getRequest('periodo', '');
$fechamentoapontamento->saldo_atual 				= $fechamentoapontamento->getRequest('saldo_atual', '');
$fechamentoapontamento->create_request 				= $fechamentoapontamento->getRequest('create_request', 0);

$msg 					= $fechamentoapontamento->getRequest('msg', '');	
$success 				= $fechamentoapontamento->getRequest('success', '');	
$action 				= $fechamentoapontamento->getRequest('action', 0);

if ($action == SAVE) {

	$success 		= $fechamentoapontamento->save();
	$msg     		= $fechamentoapontamento->msg; 	
	$create_request = $fechamentoapontamento->create_request; 	

	header("LOCATION:fechamentoapontamentos.php?id_funcionario=".$fechamentoapontamento->id_funcionario."&periodo=".$fechamentoapontamento->periodo."&msg=".$msg."&success=".$success."&create_request=".$create_request);
}

if ($action == GET) {
	header("LOCATION:fechamentoapontamentos.php?id_funcionario=".$fechamentoapontamento->id_funcionario."&periodo=".$fechamentoapontamento->periodo);
}

require_once('view/banco_horas/frm_bancohorasrecurso.php');
?>