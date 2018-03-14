<?php
require_once('model/libera_projeto.php');
require_once('model/projeto.php');
require_once('model/funcionario.php');

define('SAVE', 1);
define('GET', 2);
define('DEL', 3);

$liberaprojetos = new liberaprojetos;
$projeto 		= new projeto;
$funcionario	= new funcionario;

$liberaprojetos->id 			= $liberaprojetos->getRequest('id', 0);
$liberaprojetos->id_funcionario = $liberaprojetos->getRequest('id_funcionario', 0);
$liberaprojetos->id_projeto     = $liberaprojetos->getRequest('id_projeto', 0);
$liberaprojetos->id_projeto_D   = $liberaprojetos->getRequest('id_projeto_D', 0);

if (!empty($liberaprojetos->id_projeto_D)) {
	$liberaprojetos->id_projeto = $liberaprojetos->id_projeto_D;
}


$msg 							= $liberaprojetos->getRequest('msg', '');	
$success 						= $liberaprojetos->getRequest('success', '');	
$action 						= $liberaprojetos->getRequest('action', 0);

$lista = $liberaprojetos->list($liberaprojetos->id_projeto);

if ($action == SAVE) {	
	$success = $liberaprojetos->save();
	$msg     = $liberaprojetos->msg; 

	header("LOCATION:liberar_projetos.php?id_projeto=".$liberaprojetos->id_projeto."&msg=".$msg."&success=".$success);
}

if ($action == GET) {
	echo json_encode(array('success'=>$liberaprojetos->get($liberaprojetos->getRequest('id')), 'msg'=>$liberaprojetos->msg, 'data'=>$liberaprojetos->array));
	exit;
}

if ($action == DEL) {
	$success = $liberaprojetos->deleta($liberaprojetos->id);
	$msg = $liberaprojetos->msg;

	header("LOCATION:liberar_projetos.php?id_projeto=".$liberaprojetos->id_projeto."&msg=".$msg."&success=".$success);
}

require_once('view/liberaprojetos/frm_liberaprojetos.php');
?>