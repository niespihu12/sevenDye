<?php

namespace Model;

class Color extends ActiveRecord{
    protected static $tabla = 'colores';

    protected static $columnasDB = [
        'id',
        'nombre',
        'hexadecimal'
    ];

    public $id;
    public $nombre;
    public $hexadecimal;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->hexadecimal = $args['hexadecimal'] ?? '';
    }

    public function validar(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre del color es obligatorio';
        }
        if(!$this->hexadecimal){
            self::$alertas['error'][] = 'El color es obligatorio';
        }
        if(strlen($this->hexadecimal) !== 7) {
            self::$alertas['error'][] = 'El color debe tener 7 caracteres';
        }
        if(!preg_match('/^#[a-f0-9]{6}$/i', $this->hexadecimal)) {
            self::$alertas['error'][] = 'El color debe tener el formato correcto';
        }
        return self::$alertas;
    }
}