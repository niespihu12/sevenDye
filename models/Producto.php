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
        'cantidad',
        'precio',
        'activo',
        'destacado',
        'recuento_ventas',
        'categorias_id',
        'subcategorias_id',
        'creado',
    ];

    public $id;
    public $referencia;
    public $slug;
    public $nombre;
    public $descripcion;
    public $cantidad; 
    public $precio;    
    public $activo;
    public $destacado;
    public $recuento_ventas;
    public $categorias_id;
    public $subcategorias_id;
    public $creado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->referencia = $args['referencia'] ?? '';
        $this->slug = $args['slug'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->cantidad = $args['cantidad'] ?? 0;
        $this->activo = $args['activo'] ?? '';
        $this->destacado = $args['destacado'] ?? '';
        $this->recuento_ventas = $args['recuento_ventas'] ?? '0';
        $this->categorias_id = $args['categorias_id'] ?? '';
        $this->subcategorias_id = $args['subcategorias_id'] ?? null;
        $this->creado =  $args['creado'] ?? '';
    }

    public function validar()
    {
        if (!$this->nombre) self::$alertas['error'][] = 'El nombre es obligatorio';
        if (!$this->slug) self::$alertas['error'][] = 'El slug es obligatorio';
        if (!$this->categorias_id) self::$alertas['error'][] = 'La categoria es obligatoria';
        if (!$this->descripcion) self::$alertas['error'][] = 'La descripcion es obligatoria';
        if (!is_numeric($this->precio)) self::$alertas['error'][] = 'El precio debe ser un numero';
        if (!is_numeric($this->cantidad)) self::$alertas['error'][] = 'La cantidad debe ser un número';

        return self::$alertas;
    }

    public function crearReferencia()
    {
        $this->referencia = uniqid();
    }
}
