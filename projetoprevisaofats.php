<?php
require_once('model/projetoprevisaofat.php');

define('SAVE', 1);
define('GET', 2);
define('DEL', 3);

$projetoprevisaofat 	= new projetoprevisaofat;

$projetoprevisaofat->id					= $projetoprevisaofat->getRequest('id', 0);
$projetoprevisaofat->id_projeto  		= $projetoprevisaofat->getRequest('id_projeto', 0);
$projetoprevisaofat->Num_parcela	  	= $projetoprevisaofat->getRequest('Num_parcela', 0);
$projetoprevisaofat->Vlr_parcela_cimp	= $projetoprevisaofat->getRequest('Vlr_parcela_cimp', 0);
$projetoprevisaofat->Vlr_parcela_simp	= $projetoprevisaofat->getRequest('Vlr_parcela_simp', 0);
$projetoprevisaofat->mes_previsao_fat	= $projetoprevisaofat->getRequest('mes_previsao_fat', '');

$msg = '';
$action 						= $projetoprevisaofat->getRequest('action', 0);

if ($action == SAVE) {
	$success = $projetoprevisaofat->save();
	$msg     = $projetoprevisaofat->msg; 
}

if ($action == GET) {
	echo json_encode(array('success'=>$projetoprevisaofat->get($projetoprevisaofat->getRequest('id')), 'msg'=>$projetoprevisaofat->msg, 'data'=>$projetoprevisaofat->array));
	exit;
}

if ($action == DEL) {
	$success = $usuario->deleta($usuario->usuarioID);
	$msg = $usuario->msg;
	require_once('projetos.php?id=70');
	exit;
}

require_once('view/projetos/frm_projetos.php');
?>