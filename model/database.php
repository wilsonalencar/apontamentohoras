<?php
$mysqli_connection = new MySQLi('127.0.0.1', 'root', 'cpd123');
if($mysqli_connection->connect_error){
   echo "Desconectado! Erro: " . $mysqli_connection->connect_error;
}
?>