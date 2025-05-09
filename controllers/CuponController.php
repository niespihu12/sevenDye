<?php

namespace Controllers;

use MVC\Router;
use Model\Cupon;

class CuponController
{
    public static function index(Router $router)
    {
        session_start();

        isAdmin();
        $cupones = Cupon::all();
        
        $router->render('cupones/admin', [
            'cupones' => $cupones,
            'pageTitle' => 'cupones',
            'titulo' => 'admin'
        ]);
    }
    
    public static function crear(Router $router)
    {
        session_start();

        isAdmin();
        $cupon = new Cupon;
        $alertas = Cupon::getAlertas();
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $cupon = new Cupon($_POST);
            
            // Definir fecha de creación
            $cupon->creado = date('Y-m-d');
            $cupon->actualizado = date('Y-m-d');
            
            // Validar
            $alertas = $cupon->validar();
            
            if (empty($alertas)) {
                $resultado = $cupon->guardar();

                if ($resultado) {
                    header('location: /coupons/admin?resultado=1');
                }
            }
        }
        
        $router->render('cupones/crear', [
            'cupon' => $cupon,
            'alertas' => $alertas,
            'pageTitle' => 'cupones',
            'titulo' => 'admin'
        ]);
    }

    public static function actualizar(Router $router)
    {
        session_start();

        isAdmin();
        $id = validarORedireccionar('/coupons/admin');
        $cupon = Cupon::find($id);
        $alertas = Cupon::getAlertas();
        
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $args = $_POST;
            $cupon->sincronizar($args);
            
            // Actualizar fecha
            $cupon->actualizado = date('Y-m-d');
            
            // Validar
            $alertas = $cupon->validar();
            
            if (empty($alertas)) {
                $resultado = $cupon->guardar();

                if ($resultado) {
                    header('location: /coupons/admin?resultado=2');
                }
            }
        }

        $router->render('cupones/actualizar', [
            'cupon' => $cupon,
            'alertas' => $alertas,
            'pageTitle' => 'cupones',
            'titulo' => 'admin'
        ]);
    }
    
    public static function eliminar(Router $router)
    {
        session_start();

        isAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $cupon = Cupon::find($id);
                $resultado = $cupon->eliminar();
                
                if ($resultado) {
                    header('location: /coupons/admin?resultado=3');
                }
            }
        }
    }
}