<?php 


namespace Model;


class ProductoTalla extends ActiveRecord{
    protected static $tabla = 'productos_tallas';

    protected static $columnasDB = [
        'id',
        'cantidad',
        'tallas_id',
        'productos_id'
    ];

    public $id;
    public $cantidad;
    public $tallas_id;
    public $productos_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->cantidad = $args['cantidad'] ?? '';
        $this->tallas_id = $args['tallas_id'] ?? '';
        $this->productos_id = $args['productos_id'] ?? '';
    }

    public function validar(){
        if(!$this->cantidad){
            self::$alertas['error'][] = "La cantidad es obligatoria";
        }
        if(!$this->tallas_id){
            self::$alertas['error'][] = "La talla es obligatoria";
        }
        if(!$this->productos_id){
            self::$alertas['error'][] = "El producto es obligatorio";
        }
        return self::$alertas;
    }
}