<?php

	error_reporting(E_ALL & ~E_WARNING) ;

	session_start() ;
    spl_autoload_extensions(".php") ;
    spl_autoload_register(function ($class) {
        // Convierte Namespace\Clase en Namespace/Clase.php
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
        if (file_exists($path)) {
            require_once $path;
        } else {
            error_log("Autoload fallido: No se encontró el archivo en " . $path);
        }
    });
