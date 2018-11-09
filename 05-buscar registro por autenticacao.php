<?php 
require_once( "_config.php" );

// carrega um usuário usando o login e a senha
$usuario = new Usuario();

$usuario->login( "root1", "!@#$" );

echo $usuario;
?>