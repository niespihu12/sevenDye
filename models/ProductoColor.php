<?php 


namespace Model;


class ProductoColor extends ActiveRecord{
    protected static $tabla = 'productos_colores';

    protected static $columnasDB = [
        'id',
        'colores_id',
        'productos_id'
    ];

    public $id;
    public $colores_id;
    public $productos_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->colores_id = $args['colores_id'] ?? '';
        $this->productos_id = $args['productos_id'] ?? '';
    }

    public function validar(){
        if(!$this->productos_id){
            self::$alertas['error'][] = "El producto es obligatorio";
        }
        if(!$this->colores_id){
            self::$alertas['error'][] = "El color es obligatorio";
        }
        return self::$alertas;
    }
}