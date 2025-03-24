<?php

require_once __DIR__.'/Aplicacion.php';

/**
 * Parámetros de conexión a la BD (local, con XAMPP)
 */


define('BD_HOST', 'localhost');
define('BD_NAME', 'bookswap');
define('BD_USER', 'root');
define('BD_PASS', ''); // Vacío si no se configura contraseña

/**
 * Parámetros de configuración para rutas locales
 */

define('RAIZ_APP', __DIR__);
define('RUTA_APP', '/Grupo7_AW/Practica_1');
define('RUTA_IMGS', RUTA_APP.'/img/');
define('RUTA_CSS', RUTA_APP.'/CSS/');
define('RUTA_JS', RUTA_APP.'/js/');


/**
 * Configuración de UTF-8 y zona horaria
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF-8');
date_default_timezone_set('Europe/Madrid');

// Inicializa la aplicación
$app = Aplicacion::getInstance();
$app->init(['host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS]);

/**
 * @see http://php.net/manual/en/function.register-shutdown-function.php
 * @see http://php.net/manual/en/language.types.callable.php
 */
register_shutdown_function([$app, 'shutdown']);

?>