<?php 
require_once( "_config.php" );

// Carrega um registro
$usuario = new Usuario();

$usuario->loadbyId( 3 );

echo $usuario;
?>