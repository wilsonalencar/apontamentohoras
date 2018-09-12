<?php
require_once('model/funcionario.php');
require_once('model/anexo.php');
require_once('model/fotos.php');
require_once('model/contratacao.php');
require_once('model/perfilprof.php');
require_once('model/municipio.php');
require_once('model/responsabilidade.php');

define('SAVE', 1);
define('GET', 2);
define('DEL', 3);
define('MONTASELECTAJAX', 4);
define('MONTASELECTAJAXFUNCIONARIOPROJETO', 5);

$contratacao 			= new contratacao;
$funcionario 			= new funcionario;
$perfilprofissional 	= new perfilprof;
$municipio 				= new municipio;
$responsabilidade 		= new responsabilidade;

$funcionario->id					= $funcionario->getRequest('id', 0);
$funcionario->nome 					= $funcionario->getRequest('nome', '');
$funcionario->apelido 				= $funcionario->getRequest('apelido', '');
$funcionario->cpf  					= $funcionario->getRequest('cpf', '');
$funcionario->rg  					= $funcionario->getRequest('rg', '');
$funcionario->razao_social			= $funcionario->getRequest('razao_social', '');
$funcionario->data_nascimento		= $funcionario->getRequest('data_nascimento', '');
$funcionario->id_tipocontratacao	= $funcionario->getRequest('id_tipocontratacao', '');
$funcionario->id_perfilprofissional	= $funcionario->getRequest('id_perfilprofissional', '');
$funcionario->id_projeto			= $funcionario->getRequest('id_projeto', '');
$funcionario->id_responsabilidade	= $funcionario->getRequest('id_responsabilidade', '');
$funcionario->endereco				= $funcionario->getRequest('endereco', '');
$funcionario->complemento			= $funcionario->getRequest('complemento', '');
$funcionario->cod_municipio			= $funcionario->getRequest('cod_municipio', '');
$funcionario->cep  					= $funcionario->getRequest('cep', '');
$funcionario->valor_taxa  			= $funcionario->getRequest('valor_taxa', 0.00);
$funcionario->telefone  			= $funcionario->getRequest('telefone', '');
$funcionario->email  				= $funcionario->getRequest('email', '');
$funcionario->status  				= $funcionario->getRequest('status', 'A');		
$funcionario->emailParticular 		= $funcionario->getRequest('emailParticular', '');

$excluirAnexo 						= $funcionario->getRequest('excluir_anexo');
$excluirFoto 						= $funcionario->getRequest('excluir_foto');

$msg 								= $funcionario->getRequest('msg', '');	
$success 							= $funcionario->getRequest('success', '');	
$action 							= $funcionario->getRequest('action', 0);

if ($action == SAVE) {

	if ((int)$excluirAnexo || (int)$excluirFoto) {
		
		if ((int)$excluirFoto) {
			if (file_exists($_POST['foto'])) {
				unlink($_POST['foto']);
			}
		} else {
			if (file_exists($_POST['file'])) {
				unlink($_POST['file']);
			}
		}
		
		$msg = 'Registro atualizado';
		$success = true;

	} else {

		if ($_FILES['curriculo']['size'] > 0) {
			$funcionario->fileCV = $_FILES['curriculo'];
		}

		if ($_FILES['foto']['size'] > 0) {
			$funcionario->fileFOTO = $_FILES['foto'];
		}

		$success = $funcionario->save();
		$msg     = $funcionario->msg; 
	}

	if ($success) {
		header("LOCATION:funcionarios.php?id=".$funcionario->id."&msg=".$msg."&success=".$success);
	}
}

if ($action == GET) {
	echo json_encode(array('success'=>$funcionario->get($funcionario->getRequest('id')), 'msg'=>$funcionario->msg, 'data'=>$funcionario->array));
	exit;
}

if ($action == DEL) {
	$success = $funcionario->deleta($funcionario->id);
	$msg = $funcionario->msg;
	require_once('consulta_funcionarios.php');
	exit;
}

if ($action == MONTASELECTAJAX) {
	echo $funcionario->montaSelect(0, 0, $funcionario->id_perfilprofissional, true);
	exit;
}

if ($action == MONTASELECTAJAXFUNCIONARIOPROJETO) {
	echo $funcionario->montaSelect(0, $funcionario->id_projeto, 0, true);
	exit;
}

require_once('view/funcionario/frm_funcionarios.php');
?>