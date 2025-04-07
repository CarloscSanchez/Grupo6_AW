<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <title><?= $tituloPagina ?></title>
    <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/estilos.css" />
</head>
<body>
<div id="contenedor">
<?php
// require(RAIZ_APP.'/vistas/comun/cabecera.php');
// require(RAIZ_APP.'/vistas/comun/sidebarIzq.php');
require(RAIZ_APP.'/vistas/comun/navBar.php');
?>
	<main>
		<article>
			<?= $contenidoPrincipal ?>
		</article>
	</main>
<?php
// require(RAIZ_APP.'/vistas/comun/sidebarDer.php');
// require(RAIZ_APP.'/vistas/comun/pie.php');
?>
</div>
</body>
</html>
