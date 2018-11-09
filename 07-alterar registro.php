<?php 
require_once( "_config.php" );

// Alterar um usuário
$usuario = new Usuario();

$usuario->loadById( 8 );

$usuario->update( "professor", "!@#$%¨&*" );

echo $usuario;
?>