<?php 
require_once( "config.php" );

// Testa a conexão com a classe
$sql = new sql();

$usuarios = $sql->select( "SELECT * FROM tb_usuarios;" );

echo json_encode( $usuarios );
?>