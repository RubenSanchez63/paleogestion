<?php
namespace Controladores;

use modelos\Esqueleto;
use modelos\Fosil;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class EsqueletoController {

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

    public function index(): void {
        $listaEsqueletos = Esqueleto::listarEsqueletos();
        echo $this->twig->render('index.twig', ['listaEsqueletos' => $listaEsqueletos]);
    }

    public function nuevoEsqueleto(): void {
        echo $this->twig->render('partials/form_nuevo.twig');
    }

    public function verFosiles(int $id): void {
        $fosiles = Fosil::mostrarFosilesPorId($id);
        echo $this->twig->render('partials/fila_fosiles.twig', ['fosiles' => $fosiles]);

    }

    public function anadirEsqueleto(): bool|string {
        if (isset($_POST['especie'], $_POST['periodo'], $_POST['estadoEsq'])) {
            $esqueleto = [
                ':especie' => $_POST['especie'],
                ':periodo' => $_POST['periodo'],
                ':lugar' => $_POST['lugar']??null,
                ':descripcion' => $_POST['descripcion']??null,
                ':fechaEsq' => date('Y-m-d', strtotime($_POST['fechaEsq']))??null,
                ':estadoEsq' => $_POST['estadoEsq'],
            ];
            
            $_POST = [];
            return Esqueleto::anadirEsqueleto($esqueleto);
        }
        return "No se han podido añadir los siguientes datos" . print_r($_POST, true);
    }

    public function borrarEsqueleto(int $id) : bool {
        return Esqueleto::borrarEsqueletoPorId($id);
    }

    public function formularioEditarEsqueleto(int $id) : void {
        $esqueleto = Esqueleto::getEsqueletoPorId($id);
        echo $this->twig->render('partials/form_editar.twig', ['esqueleto' => $esqueleto]);
    }

    public function editarEsqueleto(int $id) : bool|string {
        if (isset($_POST['idEsq'], $_POST['especie'], $_POST['periodo'], $_POST['estadoEsq'])) {
            $esqueleto = [
                ':especie' => $_POST['especie'],
                ':periodo' => $_POST['periodo'],
                ':lugar' => $_POST['lugar']??null,
                ':descripcion' => $_POST['descripcion']??null,
                ':fechaEsq' => date('Y-m-d', strtotime($_POST['fechaEsq']))??null,
                ':estadoEsq' => $_POST['estadoEsq'],
            ];
            
            $_POST = [];
            return Esqueleto::editarEsqueletoPorId($id, $esqueleto);
        }
        return "No se han podido editar los siguientes datos" . print_r($_POST, true);
    }
}