<?php 
require_once( "_config.php" );

// Excluir um usuário
$usuario = new Usuario();

$usuario->loadById( 7 );
$usuario->delete();

echo $usuario;
?>