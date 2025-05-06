<?php

namespace Model;

class ArticuloOrden extends ActiveRecord {
    protected static $tabla = 'articulos_pedidos';
    protected static $columnasDB = [
        'id',
        'cantidad',
        'costo_por_unidad',
        'ordenes_id',
        'productos_id'
    ];
    
    public $id;
    public $cantidad;
    public $costo_por_unidad;
    public $ordenes_id;
    public $productos_id;
    
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->cantidad = $args['cantidad'] ?? '';
        $this->costo_por_unidad = $args['costo_por_unidad'] ?? '';
        $this->ordenes_id = $args['ordenes_id'] ?? null;
        $this->productos_id = $args['productos_id'] ?? null;
    }
    
    public function validar() {
        if (!$this->cantidad) {
            self::$alertas['error'][] = 'La cantidad es obligatoria';
        }
        
        if (!$this->costo_por_unidad) {
            self::$alertas['error'][] = 'El costo por unidad es obligatorio';
        }
        
        if (!$this->ordenes_id) {
            self::$alertas['error'][] = 'La orden es obligatoria';
        }
        
        if (!$this->productos_id) {
            self::$alertas['error'][] = 'El producto es obligatorio';
        }
        
        return self::$alertas;
    }
}