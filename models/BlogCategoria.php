<?php

namespace Model;

class BlogCategoria extends ActiveRecord{
    protected static $tabla = 'blog_categorias';
    protected static $columnasDB = [
        'id',
        'nombre',
        'slug',
        'creado'
    ];

    public $id;
    public $nombre;
    public $slug;
    public $creado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->slug = $args['slug'] ?? '';
        $this->creado =  date('Y/m/d');
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = "El nombre es obligatorio";
        }
        if (!$this->slug) {
            self::$alertas['error'][] = "El slug es obligatorio";
        }
        return self::$alertas;
    }
}