<?php
	/**
	* Lucas Alencar
	*/
	class municipio extends app
	{
		public function montaSelect($selected=0)
		{
			$conn = $this->getDB->mysqli_connection;
			$query = "SELECT codigo,nome,uf FROM municipios ORDER BY nome";

			if($result = $conn->query($query))
			{
				while($row = $result->fetch_array(MYSQLI_ASSOC))
				echo utf8_encode(sprintf("<option %s value='%d'>%s - %s</option>\n", $selected == $row['codigo'] ? "selected" : "",
				$row['codigo'], $row['nome'], $row['uf']));
			}
		}
	}

?>