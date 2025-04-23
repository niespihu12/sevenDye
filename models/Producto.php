<?php 


namespace Model;

class Producto extends ActiveRecord{
    protected static $tabla = 'productos';
    protected static $columnasDB = [
        'id',
        'referencia',
        'nombre',
        'descripcion',
        'precio',
        'precio_descuento',
        'colores_id',
        'activo',
        'destacado',
        'recuento_ventas',
        'categorias_id',
        'creado',
        'actualizado',
    ];


    public $id;
    public $referencia;
    public $nombre; 
    public $descripcion;
    public $precio;
    public $precio_descuento;
    public $colores_id;
    public $activo;
    public $destacado;
    public $recuento_ventas;
    public $categorias_id;
    public $creado;
    public $actualizado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->referencia = $args['referencia'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->precio_descuento = $args['precio_descuento'] ?? 0.0;
        $this->colores_id = $args['colores_id'] ?? '';
        $this->activo = $args['activo'] ?? '';
        $this->destacado = $args['destacado'] ?? '';
        $this->recuento_ventas = $args['recuento_ventas'] ?? '0';
        $this->categorias_id = $args['categorias_id'] ?? '';
        $this->creado = date('Y/m/d');
        $this->actualizado = date('Y/m/d');
    }

    public function validar(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if(!$this->precio){
            self::$alertas['error'][] = 'El precio es obligatorio';
        }
        if(!$this->categorias_id){
            self::$alertas['error'][] = 'La categoria es obligatoria';
        }
        if(!$this->colores_id){
            self::$alertas['error'][] = 'El color es obligatorio';
        }
        if(!$this->descripcion){
            self::$alertas['error'][] = 'La descripcion es obligatoria';
        }
        if(!$this->descripcion){
            self::$alertas['error'][] = 'La descripcion es obligatoria';
        }
        if(!is_numeric($this->precio)){
            self::$alertas['error'][] = 'El precio debe ser un numero';
        }
        return self::$alertas;
    }

    public function crearReferencia(){
        $this->referencia = uniqid();
    }




}