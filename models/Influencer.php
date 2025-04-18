<?php

namespace Model;

class Influencer extends ActiveRecord
{
    protected static $tabla = 'influencer';

    protected static $columnasDB = [
        'id',
        'nombre',
        'youtube',
        'tiktok',
        'instagram',
        'imagen',
        'descripcion',
        'creado'
    ];
    public $id;
    public $nombre;
    public $youtube;    
    public $tiktok;
    public $instagram;
    public $imagen;
    public $descripcion;
    public $creado;
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->youtube = $args['youtube'] ?? '';
        $this->tiktok = $args['tiktok'] ?? '';
        $this->instagram = $args['instagram'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->creado = date('Y/m/d');
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = "El nombre es obligatorio";
        }
        if (!$this->youtube) {
            self::$alertas['error'][] = "El youtube es obligatorio";
        }
        if (!$this->tiktok) {
            self::$alertas['error'][] = "El tiktok es obligatorio";
        }
        if (!$this->instagram) {
            self::$alertas['error'][] = "El instagram es obligatorio";
        }
        if (!$this->imagen) {
            self::$alertas['error'][] = "La imagen es obligatoria";
        }
        if (strlen($this->descripcion) < 50) {
            self::$alertas['error'][] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
        }
        return self::$alertas;
    }
}