<?php
namespace Controladores;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class BaseController {

    protected Environment $twig;

    public function __construct() {
        $loader = new FilesystemLoader('./vistas');
    
        // Define una ruta para guardar la caché de Twig
        $cachePath = './cache'; 
        if (!is_dir($cachePath)) {
            mkdir($cachePath, 0777, true);
        }

        $this->twig = new Environment($loader, [
            'cache' => $cachePath,
            'debug' => true,  
            'auto_reload' => true  // Recompila solo si cambia el archivo twig
        ]);
    }
}