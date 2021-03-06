<?php
require_once('app.php');
/**
* Wilson Jr
*/
class anexo extends app
{
	public $file;
	public $path;
	public $name;
	public $nameDir;
	public $msg;

	private $dir = 'files/';
	private $typesCV = array('application/pdf','text/pdf');
	private $typesCP = array('application/pdf','text/pdf', 'application/word', 'application/msword');
	private $permissionSize = 1024 * 1000;

	const FILE_CV = 'cv';
	const FILE_CP = 'cp';
	const FILE_PROJETO = 'pj';

	public function insert()
	{
		if (!$this->file) {
			$this->msg = 'Arquivo não enviado';
			return false;
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
		
		if ($this->typeFile == $this::FILE_CV && !in_array($arqType, $this->typesCV)) {
      		$this->msg = 'Tipo de arquivo inválido - Enviar PDF';
      		return false;
	    }

		if ($this->typeFile == $this::FILE_CP && !in_array($arqType, $this->typesCP)) {
      		$this->msg = 'Tipo de arquivo inválido - Enviar PDF ou DOC';
      		return false;
	    }

	    if (!$arqSize > $this->permissionSize) {
	      	$this->msg = 'O tamanho do arquivo enviado é maior que o limite!';
	    	return false;
	    }

	    $ext = pathinfo($arqName, PATHINFO_EXTENSION);

	    if ( $this->typeFile == $this::FILE_PROJETO && ($ext == 'bat' || $ext == 'exe') ) {
      		$this->msg = 'Tipo de arquivo inválido';
      		return false;
	    }	

	    if (empty($this->name)) {
	    	$this->name = $this->renameFile(str_replace('.'.$ext, '', $this->file['name']));
	    }

	    if ($ext == 'doc') {

	    	$file_comp = app::path.$this->dir.$this->path.'/'.$this->name.'.pdf';

	    	if (file_exists($file_comp)) {
				unlink($file_comp);
			}
	    }

	    if ($ext == 'pdf') {

	    	$file_comp = app::path.$this->dir.$this->path.'/'.$this->name.'.doc';

	    	if (file_exists($file_comp)) {
				unlink($file_comp);
			}
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
			$this->msg = 'ocorreu um erro ao inserir currículo'; 
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
