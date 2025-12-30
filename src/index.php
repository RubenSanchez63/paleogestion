<?php

require_once 'autoload.php' ;
require_once './vendor/autoload.php';

use Controladores\EsqueletoController;
use Controladores\FosilController;
use Controladores\UsuarioController;

// --- Lógica de Rutas / Acciones ---

// --- Peticiones GET ---
if (isset($_GET['login'])) {
    if (isset($_POST['user']) && isset($_POST['password'])) {
        $controller = new UsuarioController();
        echo $controller->login();
        exit();
    }
    echo "false";
    exit();
} elseif (isset($_GET['logout'])) {
        $controller = new UsuarioController();
        $controller->logout();
        exit();
}

if (isset($_GET['id'])) { // Muestra los fósiles de un esqueleto
    $controller = new FosilController();

    $id = (int)$_GET['id'];

    if ($id !== null) {
        $controller->verFosiles($id);
    }
    exit();

} elseif (isset($_GET['borrar'])) { // Borra el esqueleto seleccionado
    $id = (int)$_GET['borrar']??null;

    if ($id !== null) {
        $controller = new EsqueletoController();
        $controller->borrarEsqueleto($id);
    }
    // Redirigir siempre para limpiar la URL
    header("Location: http://localhost:8080");
    exit();

} elseif (isset($_GET['formEditar'])) { // Devuelve el formulario para editar un esqueleto
    $id = (int)$_GET['formEditar']??null;

    if ($id === null) {
        header("Location: http://localhost:8080");
        exit();
    } else {
        $controller = new EsqueletoController();
        $controller->formularioEditarEsqueleto($id);
        exit(); 
    }

} elseif (isset($_GET['formFosil'])) { // Devuelve el formulario para añadir un fósil a un esqueleto
    $id = (int)$_GET['formFosil']??null;

    if ($id === null) {
        header("Location: http://localhost:8080");
        exit();
    } else {
        $controller = new FosilController();
        $controller->formularioFosil($id);
        exit(); 
    }
} elseif (isset($_GET['formNuevo'])) { // Devuelve el formulario para añadir un esqueleto 
    $controller = new EsqueletoController();
    $controller->nuevoEsqueleto();
    exit(); 
    
} elseif (isset($_GET['anadirFosil'])) { // Añade un fósil a un esqueleto
    $controller = new FosilController();

    $idEsq = (int)$_GET['anadirFosil'];
    return $controller->anadirFosil($idEsq);

} elseif (isset($_GET['borrarFosil'])) { // Borra un fosil
    $id = (int)$_GET['borrarFosil']??null;

    if ($id !== null) {
        $controller = new FosilController();
        $controller->borrarFosil($id);
    }
    // Redirigir siempre para limpiar la URL
    header("Location: http://localhost:8080");
    exit();

} elseif (isset($_GET['formEditarFosil'])) { // Devuelve el formulario para editar un fósil
    $id = (int)$_GET['formEditarFosil']??null;

    if ($id === null) {
        header("Location: http://localhost:8080");
        exit();
    } else {
        $controller = new FosilController();
        $controller->formularioEditarFosil($id);
        exit(); 
    }
}

// --- Peticiones POST ---

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['idFos'])) { // Edita un fósil
        $controller = new FosilController();
        $id = (int)$_POST['idFos'];
        $controller->editarFosil($id);
        // Recargar tras añadir
        header("Location: http://localhost:8080");
        exit();
    }

    $controller = new EsqueletoController();

    if (isset($_POST['idEsq'])) {  // Edita un esqueleto
        $id = (int)$_POST['idEsq'];
        $controller->editarEsqueleto($id);
        // Recargar tras añadir
        header("Location: http://localhost:8080");
        exit();
    } else if (isset($_POST['especie'])) {  // Añade un esqueleto
        $controller->anadirEsqueleto();
        // Recargar tras añadir
        header("Location: http://localhost:8080");
        exit();
    }
}


// Si no ha habido exits anteriores, muestra los esqueletos
if (empty($_GET)) {
    $controller = new EsqueletoController();
    $controller->index();
}
?>