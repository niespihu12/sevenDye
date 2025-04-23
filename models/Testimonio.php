<?php
namespace Model;

class Testimonio extends ActiveRecord{
    protected static $tabla = 'testimonios';

    protected static $columnasDB = [
        'id',
        'imagen',
        'nombre',
        'rol',
        'mensaje',
        'creado',
    ];

    public $id;
    public $imagen;
    public $nombre;
    public $rol;
    public $mensaje;
    public $creado;
    public $actualizado;
    

    public function __construct($args=[]){
        $this->id = $args['id']?? null;
        $this->imagen = $args['imagen'] ?? '';
        $this->nombre = $args['nombre'] ??'';
        $this->rol = $args['rol'] ??'';
        $this->mensaje = $args['mensaje'] ??'';
        $this->creado = date('Y/m/d');
    }

    public function validar(){
        if (!$this->imagen) {
            self::$alertas['error'][] = "La imagen es obligatoria";
        }
        if(!$this->nombre){
            self::$alertas['error'][] = "El nombre es obligatorio";
        }
        if(!$this->rol){
            self::$alertas['error'][] = "El rol es obligatorio";
        }
        if (strlen($this->mensaje) < 50){
            self::$alertas['error'][] = "El mensaje es obligatorio y debe tener al menos 90 caracteres";
        }
        return self::$alertas; 
    }

}