<?php

namespace Controllers;

use MVC\Router;
use Model\ReseñaProducto;
use Model\Usuario;

class ReseñaController {
    
    // Método para guardar una nueva reseña
    public static function guardar() {
        session_start();
        if(!isset($_SESSION['login'])) {
            $respuesta = [
                'resultado' => false,
                'mensaje' => 'Usuario no autenticado'
            ];
            echo json_encode($respuesta);
            return;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = file_get_contents('php://input');
            $datos = json_decode($datos, true);
            $yaExiste = ReseñaProducto::usuarioTieneReseña($_SESSION['id'], $datos['producto_id']);
            
            if($yaExiste) {
                $respuesta = [
                    'resultado' => false,
                    'mensaje' => 'Ya has dejado una reseña para este producto'
                ];
                echo json_encode($respuesta);
                return;
            }
            
            // Crear nueva reseña
            $resena = new ReseñaProducto([
                'observaciones' => $datos['observaciones'],
                'calificacion' => $datos['calificacion'],
                'usuarios_id' => $_SESSION['id'],
                'productos_id' => $datos['producto_id']
            ]);
            
            $alertas = $resena->validar();
            
            if(empty($alertas)) {
                $resultado = $resena->guardar();
                
                $respuesta = [
                    'resultado' => $resultado,
                    'mensaje' => $resultado ? 'Reseña guardada correctamente' : 'Error al guardar la reseña'
                ];
            } else {
                $respuesta = [
                    'resultado' => false,
                    'mensaje' => $alertas['error'][0] ?? 'Error al validar la reseña'
                ];
            }
            
            echo json_encode($respuesta);
        }
    }
    public static function obtenerPorProducto() {
        if($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'] ?? null;
            
            if(!$id) {
                $respuesta = [
                    'resultado' => false,
                    'mensaje' => 'ID de producto no proporcionado'
                ];
                echo json_encode($respuesta);
                return;
            }
            
            $resenas = ReseñaProducto::porProducto($id);
            $resenasFormateadas = [];
            
            foreach($resenas as $resena) {
                $usuario = Usuario::find($resena->usuarios_id);
                
                $resenasFormateadas[] = [
                    'id' => $resena->id,
                    'observaciones' => $resena->observaciones,
                    'calificacion' => $resena->calificacion,
                    'creado' => $resena->creado,
                    'usuario' => $usuario ? $usuario->nombre : 'Usuario',
                    'inicial' => $usuario ? strtoupper(substr($usuario->nombre, 0, 1)) : 'U'
                ];
            }
            
            $promedio = ReseñaProducto::promedioCalificacion($id);
            $total = ReseñaProducto::contarReseñas($id);
            
            $respuesta = [
                'resultado' => true,
                'resenas' => $resenasFormateadas,
                'promedio' => $promedio,
                'total' => $total
            ];
            
            echo json_encode($respuesta);
        }
    }
}