<?php

namespace Model;

class BillingDetail extends ActiveRecord {
    protected static $tabla = 'billing_details';
    protected static $columnasDB = [
        'id',
        'nombre',
        'apellido',
        'compania',
        'direccion',
        'apartamento',
        'ciudad',
        'postal',
        'telefono',
        'email',
        'creado',
        'terminos',
        'ordenes_id'
    ];
    
    public $id;
    public $nombre;
    public $apellido;
    public $compania;
    public $direccion;
    public $apartamento;
    public $ciudad;
    public $postal;
    public $telefono;
    public $email;
    public $creado;
    public $terminos;
    public $ordenes_id;
    
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? null;
        $this->apellido = $args['apellido'] ?? null;
        $this->compania = $args['compania'] ?? null;
        $this->direccion = $args['direccion'] ?? null;
        $this->apartamento = $args['apartamento'] ?? null;
        $this->ciudad = $args['ciudad'] ?? null;
        $this->postal = $args['postal'] ?? null;
        $this->telefono = $args['telefono'] ?? null;
        $this->email = $args['email'] ?? null;
        $this->creado = $args['creado'] ?? date('Y-m-d');
        $this->terminos = $args['terminos'] ?? null;
        $this->ordenes_id = $args['ordenes_id'] ?? null;
    }
    
    public function validar() {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        
        if (!$this->apellido) {
            self::$alertas['error'][] = 'El apellido es obligatorio';
        }
        
        if (!$this->direccion) {
            self::$alertas['error'][] = 'La dirección es obligatoria';
        }
        
        if (!$this->ciudad) {
            self::$alertas['error'][] = 'La ciudad es obligatoria';
        }
        
        if (!$this->postal) {
            self::$alertas['error'][] = 'El código postal es obligatorio';
        }
        
        if (!$this->telefono) {
            self::$alertas['error'][] = 'El teléfono es obligatorio';
        }
        
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'El email no es válido';
        }
        
        if (!$this->terminos) {
            self::$alertas['error'][] = 'Debes aceptar los términos y condiciones';
        }
        
        return self::$alertas;
    }
}