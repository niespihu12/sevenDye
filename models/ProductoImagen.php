<?php


namespace Model;

class ProductoImagen extends ActiveRecord{
    protected static $tabla = 'producto_imagen';

    protected static $columnasDB = [
        'id',
        'imagen',
        'creado',
        'productos_id'
    ];
    public $id;
    public $imagen;
    public $creado;
    public $productos_id;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->imagen = $args['imagen'] ?? '';
        $this->creado =  $args['creado'] ?? '';
        $this->productos_id = $args['productos_id'] ?? '';
    }

    public function validar(){
        if(!$this->imagen){
            self::$alertas['error'][] = 'La imagen es obligatoria';
        }
        return self::$alertas;
    }

}