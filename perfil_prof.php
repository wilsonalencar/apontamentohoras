<?php
require_once('model/perfilprof.php');

define('SAVE', 1);
define('GET', 2);
define('DEL', 3);

$perfilprof = new perfilprof;
$perfilprof->id 			= $perfilprof->getRequest('id', 0);
$perfilprof->codigo 		= $perfilprof->getRequest('codigo', '');
$perfilprof->nome 			= $perfilprof->getRequest('nome', '');
$perfilprof->status 		= $perfilprof->getRequest('status', 'A');
		
$msg 								= $perfilprof->getRequest('msg', '');	
$success 							= $perfilprof->getRequest('success', '');
$action 					= $perfilprof->getRequest('action', 0);


if ($action == SAVE) {	
	$success = $perfilprof->save();
	$msg     = $perfilprof->msg; 

	header("LOCATION:perfil_prof.php?id=".$perfilprof->id."&msg=".$msg."&success=".$success);
}

if ($action == GET) {
	echo json_encode(array('success'=>$perfilprof->get($perfilprof->getRequest('id')), 'msg'=>$perfilprof->msg, 'data'=>$perfilprof->array));
	exit;
}

if ($action == DEL) {
	$success = $perfilprof->deleta($perfilprof->id);
	$msg = $perfilprof->msg;
	require_once('consulta_perfil_prof.php');
	exit;
}


require_once('view/perfil_profissional/frm_perfilprof.php');
?>