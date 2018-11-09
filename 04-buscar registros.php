<?php 
require_once( "_config.php" );

// Carrega registros buscando por parâmetro
$search = Usuario::search( "ro" );

echo json_encode( $search );
?>