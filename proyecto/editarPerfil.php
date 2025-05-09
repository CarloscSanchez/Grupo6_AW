<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/clases/usuarios/formularioUsuario.php';

$usuario = Usuario::buscaUsuario($_SESSION['nombre']);

$form = new FormularioUsuario($usuario);
$htmlForm = $form->gestiona();

$tituloPagina = 'Editar Perfil';
$contenidoPrincipal = <<<EOS
<h1>Editar Perfil</h1>
$htmlForm
EOS;

require __DIR__ . '/includes/vistas/plantillas/plantilla.php';