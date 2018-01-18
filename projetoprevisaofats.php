<?php
require_once('model/projetoprevisaofat.php');

define('SAVE', 1);
define('GET', 2);
define('DEL', 3);

$projetoprevisaofat 	= new projetoprevisaofat;
$projetoprevisaofat->id					= $projetoprevisaofat->getRequest('idFat', 0);
$projetoprevisaofat->id_projeto  		= $projetoprevisaofat->getRequest('id_projeto', 0);
$projetoprevisaofat->Num_parcela	  	= $projetoprevisaofat->getRequest('Num_parcela', 0);
$projetoprevisaofat->Vlr_parcela_cimp	= str_replace(',','.',str_replace('.','',$projetoprevisaofat->getRequest('Vlr_parcela_cimp', 0)));
$projetoprevisaofat->Vlr_parcela_simp	= $projetoprevisaofat->Vlr_parcela_cimp * funcionalidadeConst::IMPOSTO;
$projetoprevisaofat->mes_previsao_fat	= $projetoprevisaofat->getRequest('mes_previsao_fat', '');

$msg = '';
$action 								= $projetoprevisaofat->getRequest('action', 0);

if ($action == SAVE) {
	$success 		= $projetoprevisaofat->save();
	$msg     		= $projetoprevisaofat->msg; 
	header('LOCATION:projetos.php?id='.$projetoprevisaofat->id_projeto.'&success='.$success.'&msg='.$msg.'');
}

if ($action == GET) {
	echo json_encode(array('success'=>$projetoprevisaofat->get($projetoprevisaofat->getRequest('id')), 'msg'=>$projetoprevisaofat->msg, 'data'=>$projetoprevisaofat->array));
	exit;
}

if ($action == DEL) {
	$success = $projetoprevisaofat->deleta($projetoprevisaofat->id);
	$msg = $projetoprevisaofat->msg;
	header('LOCATION:projetos.php?id='.$projetoprevisaofat->id_projeto.'&success='.$success.'&msg='.$msg.'');
}

require_once('view/projetos/frm_projetos.php');
?>