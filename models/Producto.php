<?php


namespace Model;

class Producto extends ActiveRecord
{
    protected static $tabla = 'productos';
    protected static $columnasDB = [
        'id',
        'referencia',
        'slug',
        'nombre',
        'descripcion',
        'precio',
        'precio_descuento',
        'activo',
        'destacado',
        'recuento_ventas',
        'categorias_id',
        'creado',
        'actualizado',
    ];


    public $id;
    public $referencia;
    public $slug;
    public $nombre;
    public $descripcion;
    public $precio;
    public $precio_descuento;
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
        $this->slug = $args['slug'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->precio_descuento = $args['precio_descuento'] ?? 0.0;
        $this->activo = $args['activo'] ?? '';
        $this->destacado = $args['destacado'] ?? '';
        $this->recuento_ventas = $args['recuento_ventas'] ?? '0';
        $this->categorias_id = $args['categorias_id'] ?? '';
        $this->creado =  $args['creado'] ?? '';
        $this->actualizado =  $args['actualizado'] ?? '';
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if (!$this->slug) {
            self::$alertas['error'][] = 'El slug es obligatorio';
        }
        if (!$this->precio) {
            self::$alertas['error'][] = 'El precio es obligatorio';
        }
        if (!$this->categorias_id) {
            self::$alertas['error'][] = 'La categoria es obligatoria';
        }
        if (!$this->descripcion) {
            self::$alertas['error'][] = 'La descripcion es obligatoria';
        }
        if (!is_numeric($this->precio)) {
            self::$alertas['error'][] = 'El precio debe ser un numero';
        }
        return self::$alertas;
    }

    public function crearReferencia()
    {
        $this->referencia = uniqid();
    }
}
