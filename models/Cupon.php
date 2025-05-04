<?php

namespace Model;

class Cupon extends ActiveRecord
{
    protected static $tabla = 'cupones';

    protected static $columnasDB = [
        'id',
        'codigo',
        'descripcion',
        'tipo_descuento',
        'descuento',
        'tipo_pedido_minimo',
        'minimo_pedido',
        'expira',
        'creado',
        'actualizado'
    ];

    public $id;
    public $codigo;
    public $descripcion;
    public $tipo_descuento;
    public $descuento;
    public $tipo_pedido_minimo;
    public $minimo_pedido;
    public $expira;
    public $creado;
    public $actualizado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->codigo = $args['codigo'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->tipo_descuento = $args['tipo_descuento'] ?? '';
        $this->descuento = $args['descuento'] ?? '';
        $this->tipo_pedido_minimo = $args['tipo_pedido_minimo'] ?? '';
        $this->minimo_pedido = $args['minimo_pedido'] ?? '';
        $this->expira = $args['expira'] ?? '';
        $this->creado = $args['creado'] ?? '';
        $this->actualizado = $args['actualizado'] ?? '';
    }

    public function validar()
    {
        if (!$this->codigo) {
            self::$alertas['error'][] = "El código del cupón es obligatorio";
        }
        
        if (!$this->descripcion) {
            self::$alertas['error'][] = "La descripción es obligatoria";
        }
        
        if (!$this->tipo_descuento) {
            self::$alertas['error'][] = "El tipo de descuento es obligatorio";
        }
        
        if (!$this->descuento) {
            self::$alertas['error'][] = "El monto o porcentaje de descuento es obligatorio";
        }
        
        if ($this->descuento <= 0) {
            self::$alertas['error'][] = "El descuento debe ser mayor a cero";
        }
        
        if (!$this->tipo_pedido_minimo) {
            self::$alertas['error'][] = "Debe especificar el tipo de mínimo para el pedido";
        }
        
        if ($this->tipo_pedido_minimo !== 'ninguno' && !$this->minimo_pedido) {
            self::$alertas['error'][] = "Debe especificar el valor mínimo para el pedido";
        }
        
        if (!$this->expira) {
            self::$alertas['error'][] = "La fecha de expiración es obligatoria";
        }

        return self::$alertas;
    }

    public function estaActivo() {
        $hoy = date('Y-m-d H:i:s');
        return $this->expira > $hoy;
    }

    public static function verificarCupon($codigo) {
        // Buscar cupón por código
        $query = "SELECT * FROM " . static::$tabla . " WHERE codigo = '{$codigo}'";
        $resultado = self::consultarSQL($query);
    
        if (empty($resultado)) {
            return false;
        }
    
        $cupon = array_shift($resultado);
    
        // Verificar si el cupón está activo (no expirado)
        if (!$cupon->estaActivo()) {
            return false;
        }
    
        // Verificar requisitos de pedido mínimo
        if ($cupon->tipo_pedido_minimo !== 'ninguno') {
            $total = Carrito::obtenerTotal();
    
            if ($total < $cupon->minimo_pedido) {
                return false;
            }
        }
    
        // Devolver datos necesarios para aplicar el cupón
        return [
            'id' => $cupon->id,
            'codigo' => $cupon->codigo,
            'descripcion' => $cupon->descripcion,
            'tipo_descuento' => $cupon->tipo_descuento,
            'descuento' => $cupon->descuento
        ];
    }
}