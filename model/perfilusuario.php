<?php 
/**
* 
*/
class perfilusuario extends app
{
	public function montaSelect($selected=0)
	{
		$conn = $this->getDB->mysqli_connection;
		$query = "SELECT id,nome FROM perfilusuario ORDER BY nome";

		if($result = $conn->query($query))
		{
			while($row = $result->fetch_array(MYSQLI_ASSOC))
			echo utf8_encode(sprintf("<option %s value='%d'>%s</option>\n", $selected == $row['id'] ? "selected" : "",
			$row['id'], $row['nome']));
		}
	}	
}