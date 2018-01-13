<?php
	/**
	* Lucas Alencar
	*/
	class statusProj extends app
	{
		public function montaSelect($selected=0)
		{
			$conn = $this->getDB->mysqli_connection;
			$query = sprintf("SELECT id,descricao FROM projetostatus WHERE Situacao = '%s' ORDER BY id", $this::STATUS_SISTEMA_ATIVO);

			if($result = $conn->query($query))
			{
				while($row = $result->fetch_array(MYSQLI_ASSOC))
				echo utf8_encode(sprintf("<option %s value='%d'>%s</option>\n", $selected == $row['id'] ? "selected" : "",
				$row['id'], $row['descricao']));
			}
		}
	}

?>