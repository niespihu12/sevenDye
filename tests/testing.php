<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Model\Producto;
use Model\Carrito;
use Model\ActiveRecord;
use mysqli; 

require_once __DIR__ . '/../vendor/autoload.php';

class Testing extends TestCase
{
    protected function setUp(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['carrito'] = ['productos' => [], 'cupon' => null];
        $db = new mysqli('localhost', 'root', 'admin', 'sevendye_crud');
        if ($db->connect_error) {
            die('Error de conexión a la base de datos: ' . $db->connect_error);
        }
        ActiveRecord::setDB($db);
    }

    public function testProductoTienePrecioCorrecto()
    {
        $producto = new Producto([
            'precio' => 25.99,
            'cantidad' => 10,
            'nombre' => 'Camiseta Tie Dye'
        ]);
        $this->assertEquals(25.99, $producto->precio, 'El precio del producto no coincide');
    }

    public function testProductoTieneStockCorrecto()
    {
        $producto = new Producto([
            'precio' => 25.99,
            'cantidad' => 10,
            'nombre' => 'Camiseta Tie Dye'
        ]);
        $this->assertEquals(10, $producto->cantidad, 'El stock del producto no coincide');
    }

    public function testAgregarProductoAlCarrito()
    {
        $id = 50; 
        $cantidad = 2;
        $numItems = Carrito::añadirproducto($id, $cantidad);

        $this->assertEquals(1, $numItems, 'La cantidad de productos en el carrito no es correcta');

        $carritoItems = Carrito::obtenerCarrito();
        $this->assertCount(1, $carritoItems, 'El carrito debería tener un item');
        $this->assertEquals($id, $carritoItems[0]['id'], 'El ID del producto no coincide');
        $this->assertEquals($cantidad, $carritoItems[0]['cantidad'], 'La cantidad no coincide');
    }

    public function testNoSePuedeAgregarMasDelStock()
    {
        $this->markTestSkipped('La verificación de stock no está implementada en Carrito::añadirproducto');
    }

    protected function tearDown(): void
    {
        session_destroy();
    }
}