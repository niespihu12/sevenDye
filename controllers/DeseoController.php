<?php

namespace Controllers;

use Model\ListaDeseo;

class DeseoController
{
    public static function index(){

    }

    public static function guardar(){
        session_start();
        $producto = $_POST['producto'];
        debuguear($producto);
        $args = array(
            'usuarios_id' => $_SESSION['id'],
            'productos_id' => $producto,
            'creado'
        );
        $listaDeseos = new ListaDeseo($args);
        $resultado = $listaDeseos->guardar();

        echo json_encode(['resultado' => $resultado]);

    }

    public static function eliminar(){
        $producto = $_POST['producto'];
        $listaDeseos = new ListaDeseo();
        $resultado = $listaDeseos->eliminar($producto);

    }
}