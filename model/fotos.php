<?php
require_once('app.php');
/**
* Wilson Jr
*/
class fotos extends app
{
	public $file;
	public $path;
	public $name;
	public $nameDir;
	public $msg;

	private $dir = 'files/';
	private $typesIMG = array('image/jpg','image/jpe','image/jpeg','image/png');
	private $permissionSize = 1024 * 1000;

	public function insert()
	{
		if (!$this->file) {
			$this->msg = 'Arquivo não enviado';
			return false;
		}

		$diretorio = app::path.$this->dir.$this->path;
		$dirFiles = scandir($diretorio);
		$search = $this->name;
		
		foreach($dirFiles as $file) {
		    if (is_file($diretorio.'/'.$file) AND pathinfo($diretorio.'/'.$file, PATHINFO_FILENAME) == $search) {
		        $this->msg = 'Já existe uma foto para esse funcionário'; 
				return false;
		    }
		}
		

		 // O nome original do arquivo no computador do usuário
		$arqName = $this->file['name'];
		 // O tipo mime do arquivo. Um exemplo pode ser "image/gif"
		$arqType = $this->file['type'];
		 // O tamanho, em bytes, do arquivo
		$arqSize = $this->file['size'];
		 // O nome temporário do arquivo, como foi guardado no servidor
		$arqTemp = $this->file['tmp_name'];
		 // O código de erro associado a este upload de arquivo
		$arqError = $this->file['error'];

		if ($arqError > 0) {	
			$this->msg = 'Arquivo inválido';
			return false;   
		}
		
		if (!in_array($arqType, $this->typesIMG)) {
      		$this->msg = 'Tipo de arquivo inválido - Enviar Imagem';
      		return false;
	    }

	    if (!$arqSize > $this->permissionSize) {
	      	$this->msg = 'O tamanho do arquivo enviado é maior que o limite!';
	    	return false;
	    }

	    $ext = pathinfo($arqName, PATHINFO_EXTENSION);

	    if ( $ext == 'bat' || $ext == 'exe' )  {
      		$this->msg = 'Tipo de arquivo inválido';
      		return false;
	    }	

	    if (empty($this->name)) {
	    	$this->name = $this->renameFile(str_replace('.'.$ext, '', $this->file['name']));
	    }
	   	
	    $name = $this->name.'.'.$ext;
		$dir = app::path.$this->dir.$this->path;
		
		if (!empty($this->nameDir)) {
			$dir = $dir.'/'.$this->nameDir;

			if (!file_exists($dir)) {
				mkdir($dir, 0777, true);	
			}
		}

		$upload = move_uploaded_file($arqTemp, $dir .'/'. $name);

		if (!$upload) {
			$this->msg = 'ocorreu um erro ao inserir imagem'; 
			return false;
		}

		return true;
	}

	private function renameFile($str) {
	    $str = preg_replace('/[áàãâä]/ui', 'a', $str);
	    $str = preg_replace('/[éèêë]/ui', 'e', $str);
	    $str = preg_replace('/[íìîï]/ui', 'i', $str);
	    $str = preg_replace('/[óòõôö]/ui', 'o', $str);
	    $str = preg_replace('/[úùûü]/ui', 'u', $str);
	    $str = preg_replace('/[ç]/ui', 'c', $str);
	    //$str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
	    $str = preg_replace('/[^a-z0-9]/i', '_', $str);
	    $str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
    	return $str;
	}
}
