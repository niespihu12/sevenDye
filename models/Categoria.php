<?php


namespace Model;


class Categoria extends ActiveRecord
{
    protected static $tabla = 'categorias';

    protected static $columnasDB =[
        'id',
        'slug',
        'nombre',
        'descripcion',
        'imagen',
        'importante',
        'creado',
        'actualizado'
    ];

    public $id;
    public $slug;
    public $nombre;
    public $descripcion;
    public $imagen;
    public $importante;
    public $creado;
    public $actualizado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->slug = $args['slug'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->importante = $args['importante'] ?? '';
        $this->creado = $args['creado'] ?? '';
        $this->actualizado = $args['actualizado'] ?? '';
    }

    public function validar()
    {
        if(!$this->slug){
            self::$alertas['error'][] = "El slug es obligatorio";
        }
        if(!$this->nombre){
            self::$alertas['error'][] = "El nombre es obligatorio";
        }
        if(strlen($this->descripcion)<50){
            self::$alertas['error'][] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
        }
        if($this->importante === ''){
            self::$alertas['error'][] = "El campo importante es obligatorio";
        }
        if(!$this->imagen){
            self::$alertas['error'][] = "La imagen es obligatoria";
        }

        return self::$alertas;
    }
}