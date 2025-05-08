<?php

namespace Model;

class Subcategoria extends ActiveRecord
{
    protected static $tabla = 'subcategorias';
    protected static $columnasDB = [
        'id',
        'nombre',
        'descripcion',
        'categorias_id',
        'creado'
    ];

    public $id;
    public $nombre;
    public $descripcion;
    public $categorias_id;
    public $creado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->categorias_id = $args['categorias_id'] ?? '';
        $this->creado = $args['creado'] ?? '';
    }

    public function validar()
    {
        if (!$this->nombre) self::$alertas['error'][] = 'El nombre es obligatorio';
        if (!$this->descripcion) self::$alertas['error'][] = 'La descripción es obligatoria';
        if (!$this->categorias_id) self::$alertas['error'][] = 'La categoría es obligatoria';
        return self::$alertas;
    }

    // Método para obtener la categoría relacionada
    public function categoria()
    {
        return Categoria::find($this->categorias_id);
    }

    // Método para obtener los productos de esta subcategoría
    public function productos()
    {
        $query = "SELECT * FROM productos WHERE subcategorias_id = {$this->id}";
        return Producto::consultarSQL($query);
    }

    // Obtener subcategorías por categoría
    public static function porCategoria($categorias_id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE categorias_id = {$categorias_id} ORDER BY nombre ASC";
        return static::consultarSQL($query);
    }
}