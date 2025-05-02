<?php 
namespace Model;

class ProductoTalla extends ActiveRecord
{
    protected static $tabla = 'productos_tallas';

    protected static $columnasDB = [
        'id',
        'precio',    
        'activo',     
        'tallas_id',
        'productos_id',
        
    ];

    public $id;
    public $precio; 
    public $activo; 
    public $tallas_id;
    public $productos_id;
        
        

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->precio = $args['precio'] ?? null;
        $this->activo = $args['activo'] ?? 0;
        $this->tallas_id = $args['tallas_id'] ?? '';
        $this->productos_id = $args['productos_id'] ?? '';
        
    }

    public function validar()
    {
        if (!$this->tallas_id) self::$alertas['error'][] = "La talla es obligatoria";
        if (!$this->productos_id) self::$alertas['error'][] = "El producto es obligatorio";
        if ($this->activo && $this->precio !== null && !is_numeric($this->precio)) {
            self::$alertas['error'][] = "El precio de la talla debe ser numérico si está activo";
        }

        return self::$alertas;
    }
}
