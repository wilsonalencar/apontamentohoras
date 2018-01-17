<?php
require_once('model/projetorecurso.php');
require_once('model/perfilprof.php');

define('SAVE', 1);
define('GET', 2);
define('DEL', 3);

$projetorecurso 	= new projetorecurso;
$perfilprofissional = new perfilprof;


$projetorecurso->id						= $projetorecurso->getRequest('idRec', 0);
$projetorecurso->id_projeto  			= $projetorecurso->getRequest('id_projeto', 0);
$projetorecurso->id_perfilprofissional 	= $projetorecurso->getRequest('id_perfilprofissional', 0);
$projetorecurso->id_funcionario			= $projetorecurso->getRequest('id_funcionario', 0);
$projetorecurso->mes_alocacao			= $projetorecurso->getRequest('mes_alocacao', 0);
$projetorecurso->Qtd_hrs_estimada		= $projetorecurso->getRequest('qtd_hrs_estimada', 0);
$projetorecurso->Vlr_taxa_compra		= $projetorecurso->getRequest('vlr_taxa_compra', 0);

$msg = '';
$action 						= $projetorecurso->getRequest('action', 0);

if ($action == SAVE) {
	$success = $projetorecurso->save();
	$msg     = $projetorecurso->msg; 
	header('LOCATION:projetos.php?id='.$projetorecurso->id_projeto.'&success='.$success.'&msg='.$msg.'');
}

if ($action == GET) {
	echo json_encode(array('success'=>$projetorecurso->get($projetorecurso->getRequest('id')), 'msg'=>$projetorecurso->msg, 'data'=>$projetorecurso->array));
	exit;
}

if ($action == DEL) {
	$success = $projetorecurso->deleta($projetorecurso->id);
	$msg = $projetorecurso->msg;
	header('LOCATION:projetos.php?id='.$projetorecurso->id_projeto.'&success='.$success.'&msg='.$msg.'');
}

require_once('view/projetos/frm_projetos.php');
?>