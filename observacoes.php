<?php
require_once('model/observacao.php');

define('SAVE', 1);
define('GET', 2);

$observacao = new observacao;
$observacao->id_projeto = $observacao->getRequest('id_projeto', '');
$observacao->observacao = $observacao->getRequest('observacao', '');
	
$msg 								= $observacao->getRequest('msg', '');	
$success 							= $observacao->getRequest('success', '');	
$action 							= $observacao->getRequest('action', 0);


if ($action == SAVE) {	
	$success = $observacao->save();
	$msg     = $observacao->msg; 

	header("LOCATION:acompanhamento_projetos.php?msg=".$msg."&success=".$success);
}

if ($action == GET) {
	$observacoes = $observacao->getObservacoes($observacao->id_projeto);
	echo $observacoes;
	exit;
}

?>