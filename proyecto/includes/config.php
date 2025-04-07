<?php

use \includes\aplicacion;

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
define('RUTA_APP', '/Grupo6_AW/proyecto/');
define('RUTA_IMGS', RUTA_APP.'/img/');
define('RUTA_CSS', RUTA_APP.'/CSS/');
define('RUTA_JS', RUTA_APP.'/js/');


/**
 * Configuración de UTF-8 y zona horaria
 */
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF-8');
date_default_timezone_set('Europe/Madrid');

/**
 * Autocarga de clases
 * @param string $class Nombre de la clase a cargar
 * 
 */
spl_autoload_register(function ($class) {
    // Namespace base de tu aplicación
    $prefix = 'includes\\';
    
    // Directorio base donde están tus clases
    $base_dir = __DIR__ . '/';
    
    // Verifica si la clase usa el namespace prefix
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // No usa nuestro namespace, pasar al siguiente autoloader
        return;
    }
    
    // Obtiene el nombre relativo de la clase
    $relative_class = substr($class, $len);
    
    // Reemplaza namespace separators con directory separators
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    
    // Si el archivo existe, cargarlo
    if (file_exists($file)) {
        require $file;
    } else {
        // Opcional: mensaje de depuración
        error_log("Autoloader: Archivo no encontrado para clase {$class}: {$file}");
    }
});

// Inicializa la aplicación
$app = Aplicacion::getInstance();
$app->init(['host'=>BD_HOST, 'bd'=>BD_NAME, 'user'=>BD_USER, 'pass'=>BD_PASS]);

/**
 * @see http://php.net/manual/en/function.register-shutdown-function.php
 * @see http://php.net/manual/en/language.types.callable.php
 */
register_shutdown_function([$app, 'shutdown']);



?>