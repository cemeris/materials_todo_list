<?php
define('DEBUG_MODE', true);
if (DEBUG_MODE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

define('CLASS_DIR', __DIR__ . '/classes/');

spl_autoload_register(function ($class) {
    $file = CLASS_DIR . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});