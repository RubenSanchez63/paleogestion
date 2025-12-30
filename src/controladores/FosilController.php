<?php 
namespace Controladores;

use modelos\Fosil;

class FosilController extends BaseController {
        
    /**
     * Method verFosiles
     * Muestra los todos los fósiles de un esqueleto
     *
     * @param int $id 
     *
     * @return void
     */
    public function verFosiles(int $id): void {
        $fosiles = Fosil::mostrarFosilesPorId($id);
        echo $this->twig->render('partials/fila_fosiles.twig', ['fosiles' => $fosiles, 'sesionActiva' =>UsuarioController::sesionActiva() ]);
    }
    
    /**
     * Method formularioFosil
     * Renderiza el formulario para añadir un fósil a un esqueleto
     *
     * @param int $idEsq
     *
     * @return void
     */
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
    
    /**
     * Method borrarFosil
     *
     * @param int $id 
     *
     * @return bool
     */
    public function borrarFosil (int $id) : bool {
        return Fosil::borrarFosilPorId($id); 
    }
    
    /**
     * Method formularioEditarFosil
     *
     * @param int $id
     *
     * @return void
     */
    public function formularioEditarFosil(int $id) : void {
        $fosil = Fosil::getFosilPorId($id);
        echo $this->twig->render('partials/form_editar_fosil.twig', ['fosil' => $fosil]);
    }
    
    /**
     * Method editarFosil
     *
     * @param int $id [explicite description]
     *
     * @return bool
     */
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