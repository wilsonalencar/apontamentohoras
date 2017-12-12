<?php
require_once('model/cliente.php');
$cliente = new cliente;
$dominio = $cliente->dominio;

include_once('view/clientes/frm_clientes.php');
?>