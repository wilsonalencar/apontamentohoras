<?php
require_once('model/projetobancodehora.php');

define('SAVE', 1);
define('DEL', 2);

$projetobancodehora = new ProjetoBancoDeHora();

$projetobancodehora->funcionario_id = $projetobancodehora->getRequest('funcionario_id');

$msg 		= $projetobancodehora->getRequest('msg', '');	
$success 	= $projetobancodehora->getRequest('success', '');
$action 	= $projetobancodehora->getRequest('action', 0);

if ($action == SAVE) {	
	$success = $projetobancodehora->save();
	$msg     = $projetobancodehora->msg;

	header("LOCATION:projetobancodehoras.php?msg=".$msg."&success=".$success);
}

if ($action == DEL) {
	$success = $projetobancodehora->remove();
	$msg     = $projetobancodehora->msg;

	header("LOCATION:projetobancodehoras.php?msg=".$msg."&success=".$success);
}

//VARIÁVEIS DA VIEW
$funcionarios = $projetobancodehora->funcionarios();
$acessos = $projetobancodehora->acesso_funcionarios();

require_once('view/projetobancodehora/frm_projetobancodehora.php');
?>

<script>
$('.table').dataTable({
        language: {                        
            "url": "//cdn.datatables.net/plug-ins/1.10.9/i18n/Portuguese-Brasil.json"
        },
        dom: '<B>frtip',
        searching:false,
        buttons: []
});

</script>