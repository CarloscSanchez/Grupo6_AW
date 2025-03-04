<?php

/**
 * Parámetros de conexión a la BD
 */
//define('BD_HOST', 'vm007.db.swarm.test');
//define('BD_NAME', 'bookswap');
//define('BD_USER', 'bsuser');
//define('BD_PASS', 'bsuser');

/**
 * Parámetros de conexión a la BD (local, con XAMPP)
 */
define('BD_HOST', 'localhost');
define('BD_NAME', 'bookswap');
define('BD_USER', 'bsuser');
define('BD_PASS', 'bsuser'); // Vacío si no se configura contraseña

/**
 * Parámetros de configuración para rutas locales
 */
define('RAIZ_APP', __DIR__);
define('RUTA_APP', '/');
define('RUTA_IMGS', RUTA_APP.'/img/');
define('RUTA_CSS', RUTA_APP.'/css/');
define('RUTA_JS', RUTA_APP.'/js/');

/**
 * Configuración de UTF-8 y zona horaria
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF-8');
date_default_timezone_set('Europe/Madrid');

?>