<?php 
namespace Controladores;

use modelos\Fosil;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class FosilController {

    private Environment $twig;

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
            'auto_reload' => true  // Recompila solo si cambias el archivo twig
        ]);
    }

    public function formularioFosil(int $idEsq): void {
        echo $this->twig->render('partials/form_nuevo_fosil.twig', ['idEsq' => $idEsq]);
    }

    public function anadirFosil(int $idEsq): bool|string {
        if (isset($_POST['parte'], $_POST['estadoFos'])) {
            $fosil = [
                ':parte' => $_POST['parte'],
                ':fechaFos' => date('Y-m-d', strtotime($_POST['fechaFos']))??null,
                ':estadoFos' => $_POST['estadoFos'],
                ':idEsq' => $idEsq,
            ];
            
            $_POST = [];
            return Fosil::anadirFosil($fosil);
        }

        return "No se han podido añadir los siguientes datos" . print_r($_POST, true);
    }

    public function borrarFosil (int $id) : bool {
        return Fosil::borrarEsqueletoPorId($id);
    }

    public function formularioEditarFosil(int $id) : void {
        $fosil = Fosil::getFosilPorId($id);
        echo $this->twig->render('partials/form_editar_fosil.twig', ['fosil' => $fosil]);
    }

    public function editarFosil(int $id) : bool|string {
        if (isset($_POST['idFos'], $_POST['parte'], $_POST['estadoFos'])) {
            $fosil = [
                ':parte' => $_POST['parte'],
                ':fechaFos' => date('Y-m-d', strtotime($_POST['fechaFos']))??null,
                ':estadoFos' => $_POST['estadoFos'],
            ];
            
            $_POST = [];
            return Fosil::editarFosilPorId($id, $fosil);
        }
        return "No se han podido editar los siguientes datos" . print_r($_POST, true);
    }
}