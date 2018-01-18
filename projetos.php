<?php
require_once('model/projeto.php');
require_once('model/proposta.php');
require_once('model/cliente.php');
require_once('model/pilar.php');
require_once('model/statusProj.php');
require_once('model/perfilprof.php');
require_once('model/funcionario.php');
require_once('model/projetoprevisaofat.php');
require_once('model/projetorecurso.php');
require_once('model/projetodespesa.php');
require_once('model/tipodespesa.php');

define('SAVE', 1);
define('GET', 2);

$projeto 				= new projeto;
$proposta 				= new proposta;
$cliente 				= new cliente;
$pilar  				= new pilar;
$statusProj 			= new statusProj;
$perfilprofissional 	= new perfilprof;
$funcionario 			= new funcionario;
$projetoprevisaofat 	= new projetoprevisaofat;
$projetorecursos		= new projetorecurso;
$projetodespesas		= new projetodespesa;
$tipodespesa			= new tipodespesa;

$projeto->id					= $projeto->getRequest('id', 0);
$projeto->id_cliente		  	= $projeto->getRequest('id_cliente', 0);
$projeto->id_proposta  			= $projeto->getRequest('id_proposta', 0);
$projeto->id_pilar  			= $projeto->getRequest('id_pilar', 0);
$projeto->Cliente_reembolsa  	= $projeto->getRequest('Cliente_reembolsa', 0);
$projeto->data_inicio  			= $projeto->getRequest('data_inicio', 0);
$projeto->data_fim  			= $projeto->getRequest('data_fim', 0);
$projeto->status		  		= $projeto->getRequest('status', 1);
$financeiro = $projeto->calcFinanceiro($projeto->getRequest('id'));

$success 	= $projeto->getRequest('success', 0);
$msg 		= $projeto->getRequest('msg', '');
$action		= $projeto->getRequest('action', 0);

if ($action == SAVE) {
	
	$success = $projeto->save();
	$msg     = $projeto->msg; 

	header("LOCATION:projetos.php?id=".$projeto->id."&msg=".$msg."&success=".$success);
}

if ($action == GET) {
	echo json_encode(array('success'=>$projeto->get($projeto->getRequest('id')), 'msg'=>$projeto->msg, 'data'=>$projeto->array));
	exit;
}

require_once('view/projetos/frm_projetos.php');
?>