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
	public $msg;

	private $dir = 'files/';
	private $types = array('application/pdf', 'application/docx');
	private $permissionSize = 1024 * 1000;

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
		
		if (!in_array($arqType, $this->types)) {
      		$this->msg = 'Tipo de arquivo inválido - Informar PDF ou DOC';
      		return false;
	    }

	    if (!$arqSize > $this->permissionSize) {
	      	$this->msg = 'O tamanho do arquivo enviado é maior que o limite!';
	    	return false;
	    }

	    $ext = pathinfo($arqName, PATHINFO_EXTENSION);
	    $name = $this->name.'.'.$ext;
	    
		$dir = app::path.$this->dir.$this->path;
		$upload = move_uploaded_file($arqTemp, $dir .'/'. $name);

		if (!$upload) {
			$this->msg = 'ocorreu um erro ao inserir currículo'; 
			return false;
		}

		return true;
	}
}

?>