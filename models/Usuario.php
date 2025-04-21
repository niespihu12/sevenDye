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
        'rolId',
        'imagen',
        'creado',
        'actualizado',
        'confirmado', 
        'token'
    ];

    public $id;
    public $referencia;
    public $nombre;
    public $email;
    public $contraseña;
    public $telefono;
    public $direccion;
    public $rolId;
    public $imagen;
    public $creado;
    public $actualizado;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->referencia = $args['referencia'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->contraseña = $args['contraseña'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->direccion = $args['direccion'] ?? '';
        $this->rolId = $args['rolId'] ?? 1;
        $this->imagen = $args['imagen'] ?? '';
        $this->creado =  date('Y/m/d');
        $this->actualizado =  date('Y/m/d');
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
    }


    public function validarRegistro($contraseña_repetida){
        if(!$this->email){
            self::$alertas['error'][] = "El email es obligatorio";
        }
        if(!$this->contraseña){
            self::$alertas['error'][] = "El password es obligatorio";
        }
        if(strlen($this->contraseña) < 8){
            self::$alertas['error'][] = "El password debe tener al menos 8 caracteres";
        }
        if(!$contraseña_repetida){
            self::$alertas['error'][] = "Repetir password es obligatorio";
        }

        if($this->contraseña !== $contraseña_repetida){
            self::$alertas['error'][] = "El password es distinto";
        }
        return self::$alertas;
    }

    // validar login
    public function validarLogin(){
        if(!$this->email){
            self::$alertas['error'][] = "El email es obligatorio";
        }
        if(!$this->contraseña){
            self::$alertas['error'][] = "El password es obligatorio";
        }
        return self::$alertas;
    }

    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El email es Obligatorio';
        }
        return self::$alertas;
    }

    public function validarPassword() {
        if(!$this->contraseña) {
            self::$alertas['error'][] = 'El Password es obligatorio';
        }
        if(strlen($this->contraseña) < 8) {
            self::$alertas['error'][] = 'El Password debe tener al menos 8 caracteres';
        }

        return self::$alertas;
    }

    public function existeUsuario(){
        $query = " SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El Usuario ya esta registrado';
        }

        return $resultado;
    }

    public function hashPassword() {
        $this->contraseña = password_hash($this->contraseña, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid();
    } 

    public function crearReferencia(){
        $this->referencia = uniqid();
    }

    public function comprobarPasswordAndVerificado($password) {
        $resultado = password_verify($password, $this->contraseña);
        
        if(!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Password Incorrecto o tu cuenta no ha sido confirmada';
        } else {
            return true;
        }
    }

    
}
