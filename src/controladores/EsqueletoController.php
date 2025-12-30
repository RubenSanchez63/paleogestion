<?php
namespace Controladores;

use Clases\Sesion;
use Modelos\Esqueleto;

class EsqueletoController extends BaseController {
    
    /**
     * Method index
     * Renderiza la página por defecto
     *
     * @return void
     */
    public function index(): void {
        $listaEsqueletos = Esqueleto::listarEsqueletos();
        echo $this->twig->render('index.twig', ['listaEsqueletos' => $listaEsqueletos , 'sesionActiva' => UsuarioController::sesionActiva() , 'usuarioActivo' => Sesion::get('user')]);
    }
    
    /**
     * Method nuevoEsqueleto
     * Renderiza el formulario para añadir un nuevo esqueleto
     *
     * @return void
     */
    public function nuevoEsqueleto(): void {
        echo $this->twig->render('partials/form_nuevo.twig');
    }
    
    /**
     * Method anadirEsqueleto
     *
     * @return bool
     */
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
    
    /**
     * Method borrarEsqueleto
     *
     * @param int $id
     *
     * @return bool
     */
    public function borrarEsqueleto(int $id) : bool {
        return Esqueleto::borrarEsqueletoPorId($id);
    }
    
    /**
     * Method formularioEditarEsqueleto
     *
     * @param int $id
     *
     * @return void
     */
    public function formularioEditarEsqueleto(int $id) : void {
        $esqueleto = Esqueleto::getEsqueletoPorId($id);
        echo $this->twig->render('partials/form_editar.twig', ['esqueleto' => $esqueleto]);
    }
    
    /**
     * Method editarEsqueleto
     *
     * @param int $id 
     *
     * @return bool
     */
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