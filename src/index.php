<?php

require_once 'autoload.php' ;
require_once './vendor/autoload.php';

use Controladores\EsqueletoController;
use Controladores\FosilController;
use Modelos\Fosil;

// --- Lógica de Rutas / Acciones ---

// --- Peticiones GET ---
if (isset($_GET['id'])) {
    $controller = new EsqueletoController();

    $id = (int)$_GET['id'];

    if ($id !== null) {
        $controller = new EsqueletoController();
        $controller->verFosiles($id);
    }
    exit();

} elseif (isset($_GET['borrar'])) {
    $id = (int)$_GET['borrar']??null;

    if ($id !== null) {
        $controller = new EsqueletoController();
        $controller->borrarEsqueleto($id);
    }
    // Redirigir siempre para limpiar la URL
    header("Location: http://localhost:8080");
    exit();

} elseif (isset($_GET['formEditar'])) {
    $id = (int)$_GET['formEditar']??null;

    if ($id === null) {
        header("Location: http://localhost:8080");
        exit();
    } else {
        $controller = new EsqueletoController();
        $controller->formularioEditarEsqueleto($id);
        exit(); 
    }
} elseif (isset($_GET['formFosil'])) {
    $id = (int)$_GET['formFosil']??null;

    if ($id === null) {
        header("Location: http://localhost:8080");
        exit();
    } else {
        $controller = new FosilController();
        $controller->formularioFosil($id);
        exit(); 
    }
} elseif (isset($_GET['formNuevo'])) {
    $controller = new EsqueletoController();
    $controller->nuevoEsqueleto();
    exit(); 
    
} elseif (isset($_GET['anadirFosil'])) {
    $controller = new FosilController();

    $idEsq = (int)$_GET['anadirFosil'];
    return $controller->anadirFosil($idEsq);

} elseif (isset($_GET['borrarFosil'])) {
    $id = (int)$_GET['borrarFosil']??null;

    if ($id !== null) {
        $controller = new FosilController();
        $controller->borrarFosil($id);
    }
    // Redirigir siempre para limpiar la URL
    header("Location: http://localhost:8080");
    exit();

} elseif (isset($_GET['formEditarFosil'])) {
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

    if (isset($_POST['idFos'])) {
        $controller = new FosilController();
        $id = (int)$_POST['idFos'];
        $controller->editarFosil($id);
        // Recargar tras añadir
        header("Location: http://localhost:8080");
        exit();
    }

    $controller = new EsqueletoController();

    if (isset($_POST['idEsq'])) {
        $id = (int)$_POST['idEsq'];
        $controller->editarEsqueleto($id);
        // Recargar tras añadir
        header("Location: http://localhost:8080");
        exit();
    } else if (isset($_POST['especie'])) {
        $controller->anadirEsqueleto();
        // Recargar tras añadir
        header("Location: http://localhost:8080");
        exit();
    }
}


// Si no ha habido exits anteriores, mostramos la home
if (empty($_GET)) {
    $controller = new EsqueletoController();
    $controller->index();
}
?>