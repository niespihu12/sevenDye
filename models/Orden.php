<?php

namespace Model;

class Orden extends ActiveRecord {
    protected static $tabla = 'ordenes';
    protected static $columnasDB = [
        'id',
        'referencia',
        'estado',
        'creado',
        'actualizado',
        'usuarios_id'
    ];
    
    public $id;
    public $referencia;
    public $estado;
    public $creado;
    public $actualizado;
    public $usuarios_id;
    
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->referencia = $args['referencia'] ?? '';
        $this->estado = $args['estado'] ?? '';
        $this->creado = $args['creado'] ?? date('Y-m-d');
        $this->actualizado = $args['actualizado'] ?? date('Y-m-d');
        $this->usuarios_id = $args['usuarios_id'] ?? null;
    }
    
    public function validar() {
        if (!$this->referencia) {
            self::$alertas['error'][] = 'La referencia es obligatoria';
        }
        
        if (!$this->estado) {
            self::$alertas['error'][] = 'El estado es obligatorio';
        }
        
        if (!$this->usuarios_id) {
            self::$alertas['error'][] = 'El usuario es obligatorio';
        }
        
        return self::$alertas;
    }
}