<?php
define('TEMPLATES_URL', __DIR__ . '/templates');  // constantes para las rutas
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . "/imagenes/"); // carpeta de imagenes
define("MONEDA","USD");
define("KEY_TOKEN", "APR.wqc-354*");

function incluirTemplate(string $nombre, bool $inicio = false)
{

    // echo TEMPLATES_URL . "/{$nombre}.php";
    include TEMPLATES_URL . "/{$nombre}.php";
}

function estaAutenticado(): void
{
    session_start();

    if (!$_SESSION['login']) {
        header('location: /');
    }
}

function debuguear($variable)
{
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';

    exit;
}

// Escapa / sanitizar el HTML
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

// Validar tipo de Contenido

// Muestra los mensajes
function mostrarNotificacion($codigo)
{
    $mensaje = "";

    switch ($codigo) {
        case 1:
            $mensaje = "Creado Correctamente";
            break;
        case 2:
            $mensaje = "Actualizado Correctamente";
            break;
        case 3:
            $mensaje = "Eliminado Correctamente";
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}

function validarORedireccionar(string $url)
{
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header("Location: {$url}");
    }

    return $id;
}

function isAuth() : void {
    if(!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

function isAdmin() : void {
    if(!isset($_SESSION['rolId']) || $_SESSION['rolId'] === '1') {
        header('Location: /');
    }
}