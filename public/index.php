<?php 

require_once __DIR__ . '/../includes/app.php';


use MVC\Router;
use Controllers\InfluencerController;
use Controllers\TestimonioController;
use Controllers\PaginasController;
use Controllers\LoginController;
use Controllers\DashboardController;

$router = new Router();

// Zona privada
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


// Login 
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/register',[LoginController::class, 'registro']);
$router->post('/register',[LoginController::class, 'registro']);


//recuperar password
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/recuperar', [LoginController::class, 'recuperar']);
$router->post('/recuperar', [LoginController::class, 'recuperar']);

// Confirmar cuenta
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router->get('/mensaje', [LoginController::class, 'mensaje']);

$router->get('/logout', [LoginController::class, 'logout']);

// Zona publica
$router->get('/', [PaginasController::class, 'index']);
$router->get('/nosotros', [PaginasController::class, 'nosotros']);
$router->get('/contacto', [PaginasController::class, 'contacto']);
$router->post('/contacto', [PaginasController::class, 'contacto']);

// dashboard-general
$router->get('/admin', [DashboardController::class, 'index']);


$router->comprobarRutas();



