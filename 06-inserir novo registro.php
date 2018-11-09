<?php 
require_once( "_config.php" );

// Criando um novo usuário
$usuario = new Usuario( "aluno2", "@lun0-0" );

$usuario->insert();

echo $usuario;
?>