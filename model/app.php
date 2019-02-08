<?php
session_start();
require_once('database.php');
require_once('funcionalidadeConst.php');
require_once('PHPMailer/PHPMailer.php');
/**
* Lucas Alencar
*/
class app extends config
{	
	const STATUS_SISTEMA_ATIVO = 'A';
	const STATUS_SISTEMA_INATIVO = 'I';
	public $mail;
	public $getDB;
 	public function __construct(){
 		$this->validLogin();
 		$this->getDB = new dba;
 		$this->mail = new PHPMailer;

 		if (!$this->validAccess()) {
 			header('LOCATION:index.php');
 			//redireciona
 		}
 	}
 	private function validLogin()
 	{
 		if (empty($_SESSION) && $_SERVER['SCRIPT_NAME'] != '/login.php') {
 			header('LOCATION:login.php');
 		}
 	}
 	
 	public function deslogar(){
 		session_destroy();
 	}

 	public function getRequest($variable, $default_value = '') 
 	{
	   //Correção para todo o SCID, CORREÇÃO DE FALHA DE SEGURANÇA - XSS E SQL INJECTION
	   if($variable == "scid" && isset($_REQUEST[$variable]))
	       return intval($_REQUEST[$variable]);
	   
	   if (isset($_POST[$variable]))
	       return $_POST[$variable];

	   if (isset($_GET[$variable]))
	       return $_GET[$variable];

	   if (isset($_REQUEST[$variable]))
	       return $_REQUEST[$variable];

	   return $default_value;
	}

	public function checkAccess($perfil, $funcionalidadeID)
	{	
		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT count(1) as acesso FROM permissaoacesso where (select count(1) FROM funcionalidades where id = %d AND status = '%s') > 0 AND id_perfilusuario = %d and id_funcionalidade = %d", 
			$funcionalidadeID, $this::STATUS_SISTEMA_ATIVO ,$perfil, $funcionalidadeID);	
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do perfil";
			return false;	
		}		
		
		$return = $result->fetch_array(MYSQLI_ASSOC);
		if ( (int) $return['acesso'] > 0) {
			return true;	
		}

		return false;
	}

	public function checkAccessRelatorio($funcionario)
	{	
		$conn = $this->getDB->mysqli_connection;		
		$query = sprintf("SELECT count(1) as acesso FROM acessobancohoras where funcionario_id = %d", $funcionario);	
		
		if (!$result = $conn->query($query)) {
			$this->msg = "Ocorreu um erro durante a verificação do perfil";
			return false;	
		}		
		
		$return = $result->fetch_array(MYSQLI_ASSOC);
		if ( (int) $return['acesso'] > 0) {
			return true;	
		}

		return false;
	}

	public function validaCPF( $cpf = false ) 
	{
	    if ( ! function_exists('calc_digitos_posicoes') ) {
	        function calc_digitos_posicoes( $digitos, $posicoes = 10, $soma_digitos = 0 ) {
	            for ( $i = 0; $i < strlen( $digitos ); $i++  ) {
	                $soma_digitos = $soma_digitos + ( $digitos[$i] * $posicoes );
	                $posicoes--;
	            }
	     
	            $soma_digitos = $soma_digitos % 11;
	     
	            if ( $soma_digitos < 2 ) {
	                $soma_digitos = 0;
	            } else {
	                $soma_digitos = 11 - $soma_digitos;
	            }
	            $cpf = $digitos . $soma_digitos;
	            
	            return $cpf;
	        }
	    }
	    
	    if ( ! $cpf ) {
	        return false;
	    }
	 
	    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
	 
	    if ( strlen( $cpf ) != 11 ) {
	        return false;
	    }   
	    $digitos = substr($cpf, 0, 9);
	    $novo_cpf = calc_digitos_posicoes( $digitos );
	    $novo_cpf = calc_digitos_posicoes( $novo_cpf, 11 );
	    
	    if ( $novo_cpf === $cpf ) {
	        return true;
	    } else {
	        return false;
	    }
	}
	function validaEmail($email) 
	{
	    $er = "/^(([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}){0,1}$/";
	    if (preg_match($er, $email)){
		return true;
	    } else {
		return false;
	    }
	}
	public function validaCNPJ($cnpj)
 	{
		$j=0;
		for($i=0; $i<(strlen($cnpj)); $i++)
			{
				if(is_numeric($cnpj[$i]))
					{
						$num[$j]=$cnpj[$i];
						$j++;
					}
			}
	
		if(count($num)!=14)
			{
				$isCnpjValid=false;
			}
	
		if ($num[0]==0 && $num[1]==0 && $num[2]==0 && $num[3]==0 && $num[4]==0 && $num[5]==0 && $num[6]==0 && $num[7]==0 && $num[8]==0 && $num[9]==0 && $num[10]==0 && $num[11]==0)
			{
				$isCnpjValid=false;
			}
	
		else
			{
				$j=5;
				for($i=0; $i<4; $i++)
					{
						$multiplica[$i]=$num[$i]*$j;
						$j--;
					}
				$soma = array_sum($multiplica);
				$j=9;
				for($i=4; $i<12; $i++)
					{
						$multiplica[$i]=$num[$i]*$j;
						$j--;
					}
				$soma = array_sum($multiplica);	
				$resto = $soma%11;			
				if($resto<2)
					{
						$dg=0;
					}
				else
					{
						$dg=11-$resto;
					}
				if($dg!=$num[12])
					{
						$isCnpjValid=false;
					} 
			}
	
		if(!isset($isCnpjValid))
			{
				$j=6;
				for($i=0; $i<5; $i++)
					{
						$multiplica[$i]=$num[$i]*$j;
						$j--;
					}
				$soma = array_sum($multiplica);
				$j=9;
				for($i=5; $i<13; $i++)
					{
						$multiplica[$i]=$num[$i]*$j;
						$j--;
					}
				$soma = array_sum($multiplica);	
				$resto = $soma%11;			
				if($resto<2)
					{
						$dg=0;
					}
				else
					{
						$dg=11-$resto;
					}
				if($dg!=$num[13])
					{
						$isCnpjValid=false;
					}
				else
					{
						$isCnpjValid=true;
					}
			}
	
		return $isCnpjValid;			
	}

	private function validAccess()
	{	
		$file = $_SERVER['SCRIPT_NAME'];
		$funcConst = new funcionalidadeConst;
		
		if ((!empty($_SESSION)) && $_SESSION['reset_senha'] == $funcConst::RESET_TRUE && $file <> '/reset_senha.php') {
			header('LOCATION:reset_senha.php');
		}

		if ((!empty($_SESSION)) && $file == '/reset_senha.php' && $_SESSION['reset_senha'] == $funcConst::RESET_FALSE) {
			return false;
		}

		if (($file == '/consulta_clientes.php' || $file == '/clientes.php') && !$this->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_cliente)) {
			return false;
		}

		if (($file == '/consulta_contratacoes.php' || $file == '/contratacoes.php') && !$this->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_contratacoes)) {
			return false;
		}

		if (($file == '/projetos.php') && !$this->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_projetos)) {
			return false;
		}

		if (($file == '/consulta_perfil_prof.php' || $file == '/perfil_prof.php') && !$this->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_perfilprofissional)) {
			return false;
		}

		if (($file == '/consulta_pilares.php' || $file == '/pilares.php') && !$this->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_pilares)) {
			return false;
		}

		if (($file == '/consulta_propostas.php' || $file == '/propostas.php') && !$this->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_propostas)) {
			return false;
		}

		if (($file == '/consulta_responsabilidades.php' || $file == '/responsabilidades.php') && !$this->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_responsabilidade)) {
			return false;
		}

		if (($file == '/consulta_usuarios.php' || $file == '/usuarios.php') && !$this->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_usuario)) {
			return false;
		}

		if (($file == '/consulta_funcionarios.php' || $file == '/funcionarios.php') && !$this->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_usuario)) {
			return false;
		}
		
		return true;
	}
}

$app = new app;
$funcConst = new funcionalidadeConst;
?>