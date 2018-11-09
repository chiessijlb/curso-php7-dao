<?php 
require_once( "_config.php" );

// Carrega uma lista de usuários
$lista = Usuario::getList();

echo json_encode( $lista );
?>