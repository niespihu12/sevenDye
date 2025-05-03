<?php


namespace Model;


class BlogComentario extends ActiveRecord
{
    protected static $tabla = 'blog_comentarios';

    protected static $columnasDB =[
        'id',
        'comentario',
        'nombre',
        'email',
        'blog_id',
        'aprobado',
        'creado',
    ];

    public $id;
    public $comentario;
    public $nombre;
    public $email;
    public $blog_id;
    public $aprobado;
    public $creado;
    

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->comentario = $args['comentario'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->blog_id = $args['blog_id'] ?? '';
        $this->creado = $args['aprobado'] ?? '0';
        $this->aprobado = $args['creado'] ?? '';
    }

    public function validar(){
        if(!$this->aprobado) {
            self::$alertas['error'][] = "El aprobado es obligatorio";
        }
        return self::$alertas;
    }
    public function validarComentario()
    {
        if(!$this->comentario) {
            self::$alertas['error'][] = "El comentario es obligatorio";
        }
        if(!$this->nombre) {
            self::$alertas['error'][] = "El nombre es obligatorio";
        }
        if(!$this->email) {
            self::$alertas['error'][] = "El email es obligatorio";
        }
        if(!$this->blog_id) {
            self::$alertas['error'][] = "El blog es obligatorio";
        }
        return self::$alertas;

    }

    
}