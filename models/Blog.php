<?php


namespace Model;


class Blog extends ActiveRecord
{
    protected static $tabla = 'blog';

    protected static $columnasDB =[
        'id',
        'slug',
        'titulo',
        'contenido',
        'imagen',
        'activo',
        'blog_categorias_id',
        'creado',
    ];

    public $id;
    public $slug;
    public $titulo;
    public $contenido;
    public $imagen;
    public $activo;
    public $blog_categorias_id;
    public $creado;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->slug = $args['slug'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->contenido = $args['contenido'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->activo = $args['activo'] ?? '1';
        $this->blog_categorias_id = $args['blog_categorias_id'] ?? '';
        $this->creado = date('Y/m/d');
    }

    public function validar()
    {
        if (!$this->titulo) {
            self::$alertas['error'][] = "Debes añadir un titulo";
        }
        if (strlen($this->titulo) < 10) {
            self::$alertas['error'][] = "El titulo es muy corto";
        }
        if (!$this->slug) {
            self::$alertas['error'][] = "Debes añadir un slug";
        }
        if (!$this->contenido) {
            self::$alertas['error'][] = "Debes añadir un contenido";
        }
        if (strlen($this->contenido) < 50) {
            self::$alertas['error'][] = "El contenido es muy corto";
        }
        if (!$this->imagen) {
            self::$alertas['error'][] = "Debes añadir una imagen";
        }
        if (!$this->blog_categorias_id) {
            self::$alertas['error'][] = "Debes añadir una categoria";
        }
        return self::$alertas;
    }
}