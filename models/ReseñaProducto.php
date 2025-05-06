<?php

namespace Model;

class ReseñaProducto extends ActiveRecord {
    protected static $tabla = 'reseñas_productos';
    protected static $columnasDB = ['id', 'observaciones', 'calificacion', 'creado', 'actualizado', 'usuarios_id', 'productos_id'];

    public $id;
    public $observaciones;
    public $calificacion;
    public $creado;
    public $actualizado;
    public $usuarios_id;
    public $productos_id;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->observaciones = $args['observaciones'] ?? '';
        $this->calificacion = $args['calificacion'] ?? 5;
        $this->creado = $args['creado'] ?? date('Y-m-d');
        $this->actualizado = date('Y-m-d');
        $this->usuarios_id = $args['usuarios_id'] ?? '';
        $this->productos_id = $args['productos_id'] ?? '';
    }

    public function validar() {
        if(!$this->observaciones) {
            self::$alertas['error'][] = 'La observación es obligatoria';
        }
        
        if(!$this->calificacion) {
            self::$alertas['error'][] = 'La calificación es obligatoria';
        }
        
        if(!$this->usuarios_id) {
            self::$alertas['error'][] = 'Usuario no válido';
        }
        
        if(!$this->productos_id) {
            self::$alertas['error'][] = 'Producto no válido';
        }
        
        return self::$alertas;
    }

    // Método para obtener todas las reseñas de un producto específico
    public static function porProducto($productoId) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE productos_id = {$productoId} ORDER BY creado DESC";
        return self::consultarSQL($query);
    }

    // Método para calcular el promedio de calificaciones para un producto
    public static function promedioCalificacion($productoId) {
        $query = "SELECT AVG(calificacion) as promedio FROM " . static::$tabla . " WHERE productos_id = {$productoId}";
        $resultado = self::ejecutarSQL($query);
        $promedio = $resultado->fetch_assoc();
        return $promedio['promedio'] ? round($promedio['promedio'], 1) : 0;
    }

    // Método para contar las reseñas de un producto
    public static function contarReseñas($productoId) {
        $query = "SELECT COUNT(*) as total FROM " . static::$tabla . " WHERE productos_id = {$productoId}";
        $resultado = self::ejecutarSQL($query);
        $total = $resultado->fetch_assoc();
        return $total['total'] ?? 0;
    }

    // Método para verificar si un usuario ya ha dejado una reseña en un producto
    public static function usuarioTieneReseña($usuarioId, $productoId) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE usuarios_id = {$usuarioId} AND productos_id = {$productoId} LIMIT 1";
        $resultado = self::consultarSQL($query);
        return !empty($resultado);
    }
}