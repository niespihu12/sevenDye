<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\CarritoController;
use MVC\Router;
use Controllers\InfluencerController;
use Controllers\TestimonioController;
use Controllers\PaginasController;
use Controllers\LoginController;
use Controllers\DashboardController;
use Controllers\GoogleController;
use Controllers\CategoriaController;
use Controllers\UsuarioController;
use Controllers\ColorController;
use Controllers\TallaController;
use Controllers\ProductoController;
use Controllers\TiendaController;

$router = new Router();

// Zona privada
$router->get('/admin', [DashboardController::class, 'index']);
$router->get('/testimonios/admin', [TestimonioController::class, 'index']);
$router->get('/testimonios/crear', [TestimonioController::class, 'crear']);
$router->post('/testimonios/crear', [TestimonioController::class, 'crear']);
$router->get('/testimonios/actualizar', [TestimonioController::class, 'actualizar']);
$router->post('/testimonios/actualizar', [TestimonioController::class, 'actualizar']);
$router->post('/testimonios/eliminar', [TestimonioController::class, 'eliminar']);

$router->get('/influencers/admin', [InfluencerController::class, 'index']);
$router->get('/influencers/crear', [InfluencerController::class, 'crear']);
$router->post('/influencers/crear', [InfluencerController::class, 'crear']);
$router->get('/influencers/actualizar', [InfluencerController::class, 'actualizar']);
$router->post('/influencers/actualizar', [InfluencerController::class, 'actualizar']);
$router->post('/influencers/eliminar', [InfluencerController::class, 'eliminar']);

$router->get('/categorias/admin', [CategoriaController::class, 'index']);
$router->get('/categorias/crear', [CategoriaController::class, 'crear']);
$router->post('/categorias/crear', [CategoriaController::class, 'crear']);
$router->get('/categorias/actualizar', [CategoriaController::class, 'actualizar']);
$router->post('/categorias/actualizar', [CategoriaController::class, 'actualizar']);
$router->post('/categorias/eliminar', [CategoriaController::class, 'eliminar']);

$router->get('/colores/admin', [ColorController::class, 'index']);
$router->get('/colores/crear', [ColorController::class, 'crear']);
$router->post('/colores/crear', [ColorController::class, 'crear']);
$router->get('/colores/actualizar', [ColorController::class, 'actualizar']);
$router->post('/colores/actualizar', [ColorController::class, 'actualizar']);
$router->post('/colores/eliminar', [ColorController::class, 'eliminar']);

$router->get('/tallas/admin', [TallaController::class, 'index']);
$router->get('/tallas/crear', [TallaController::class, 'crear']);
$router->post('/tallas/crear', [TallaController::class, 'crear']);
$router->get('/tallas/actualizar', [TallaController::class, 'actualizar']);
$router->post('/tallas/actualizar', [TallaController::class, 'actualizar']);
$router->post('/tallas/eliminar', [TallaController::class, 'eliminar']);


$router->get('/productos/admin', [ProductoController::class, 'index']);
$router->get('/productos/crear', [ProductoController::class, 'crear']);
$router->post('/productos/crear', [ProductoController::class, 'crear']);
$router->get('/productos/actualizar', [ProductoController::class, 'actualizar']);
$router->post('/productos/actualizar', [ProductoController::class, 'actualizar']);
$router->post('/productos/eliminar', [ProductoController::class, 'eliminar']);


// Login 
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/register',[LoginController::class, 'registro']);
$router->post('/register',[LoginController::class, 'registro']);
$router->get('/logout', [LoginController::class, 'logout']);

// Autenticacion con google Oauth2
$router->get('/google/login', [GoogleController::class, 'login']);
$router->get('/google/callback', [GoogleController::class, 'callback']);


//recuperar password
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/recuperar', [LoginController::class, 'recuperar']);
$router->post('/recuperar', [LoginController::class, 'recuperar']);

// Confirmar cuenta
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);

// Zona usuario
$router->get('/perfil', [UsuarioController::class, 'actualizar']);
$router->post('/perfil', [UsuarioController::class, 'actualizar']);


// Zona publica
$router->get('/', [PaginasController::class, 'index']);
$router->get('/nosotros', [PaginasController::class, 'nosotros']);
$router->get('/contacto', [PaginasController::class, 'contacto']);
$router->post('/contacto', [PaginasController::class, 'contacto']);

// Carrito
$router->get('/carrito', [CarritoController::class, 'index']);
$router->post('/carrito/agregar', [CarritoController::class, 'agregar']);
$router->post('/carrito/actualizar', [CarritoController::class, 'actualizar']);
$router->post('/carrito/eliminar', [CarritoController::class, 'eliminar']);




// Tienda 
$router->get('/tienda', [TiendaController::class, 'index']);
$router->get('/tienda/{slug}', [TiendaController::class, 'index']);

$router->get('/detalles/{slug}', [TiendaController::class, 'detalles']);


$router->comprobarRutas();



