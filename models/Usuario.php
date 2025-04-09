<?php

namespace Model;


class Usuario extends ActiveRecord
{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = [
        'id',
        'referencia',
        'nombre',
        'email',
        'contraseña',
        'telefono',
        'direccion',
        'rol',
        'avatar',
        'creado',
        'actualizado'
    ];

    public $id;
    public $referencia;
    public $nombre;
    public $email;
    public $contraseña;
    public $telefono;
    public $direccion;
    public $rol;
    public $avatar;
    public $creado;
    public $actualizado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->referencia = $args['referencia'] ?? '';
        $this->referencia = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->contraseña = $args['contraseña'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->rol = $args['rol'] ?? '';
        $this->avatar = $args['avatar'] ?? '';
        $this->creado = $args['creado'] ?? '';
        $this->actualizado = $args['actualizado'] ?? '';
    }

    public function validar(){
        if(!$this->email){
            self::$errores[] = "El email es obligatorio";
        }

        if(!$this->contraseña){
            self::$errores[] = "La contraseña es obligatoria";
        }

        return self::$errores;

    }

    public function existeUsuario(){

        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);
        if(!$resultado->num_rows){
            self::$errores[] = "El Usuario no Existe";
            return;
        }

        return $resultado;

    }

    public function comprobarPassword($resultado){
        $usuario = $resultado->fetch_object();

        $autenticado = password_verify($this->contraseña, $usuario->contraseña);

        if(!$autenticado){
            self::$errores[] = "El Password es Incorrecto";
        }
        return $autenticado;

    }

    
}
