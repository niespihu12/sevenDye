<?php 

namespace Model;

class ListaDeseo extends ActiveRecord{
    protected static $tabla = 'lista_deseos';
    protected static $columnasDB = [
        'id', 
        'usuarios_id', 
        'productos_id',
        'creado',
        'actualizado'
    ];

    public $id;
    public $usuarios_id;
    public $productos_id;
    public $creado;
    public $actualizado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->usuarios_id = $args['usuarios_id'] ?? '';
        $this->productos_id = $args['productos_id'] ?? '';
        $this->creado = $args['creado'] ?? '';
        $this->actualizado = $args['actualizado'] ?? '';
    }

}