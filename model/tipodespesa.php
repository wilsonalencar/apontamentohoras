<?php
require_once('app.php');
/**
* Lucas Barbosa de Alencar
*/
class tipodespesa extends app
{
	public function montaSelect($selected=0)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = sprintf("SELECT id,descricao FROM tiposdespesas ORDER BY descricao");

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo utf8_encode(sprintf("<option %s value='%d'>%s</option>\n", $selected == $row['id'] ? "selected" : "",
			$row['id'], $row['descricao']));
		}
	}

}

?>