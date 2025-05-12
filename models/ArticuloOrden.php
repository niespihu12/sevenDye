<?php

namespace Model;

class ArticuloOrden extends ActiveRecord {
    protected static $tabla = 'articulos_pedidos';
    protected static $columnasDB = [
        'id',
        'cantidad',
        'costo_por_unidad',
        'tallas_id',
        'ordenes_id',
        'productos_id'
    ];
    
    public $id;
    public $cantidad;
    public $costo_por_unidad;
    public $tallas_id;
    public $ordenes_id;
    public $productos_id;
    
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->cantidad = $args['cantidad'] ?? '';
        $this->costo_por_unidad = $args['costo_por_unidad'] ?? '';
        $this->tallas_id = $args['tallas_id'] ?? null;
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
        if (!$this->tallas_id) {
            self::$alertas['error'][] = 'La talla es obligatoria';
        }
        if (!$this->productos_id) {
            self::$alertas['error'][] = 'El producto es obligatorio';
        }
        
        return self::$alertas;
    }
}