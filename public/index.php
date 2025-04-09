<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\InfluencerController;
use MVC\Router;
use Controllers\TestimonioController;
use Controllers\PaginasController;
use Model\Influencer;

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
$router->post('/login', [LoginController::class, 'login']);
$router->post('/register',[LoginController::class, 'registro']);

// Zona publica
$router->get('/', [PaginasController::class, 'index']);
$router->get('/nosotros', [PaginasController::class, 'nosotros']);
$router->get('/contacto', [PaginasController::class, 'contacto']);
$router->post('/contacto', [PaginasController::class, 'contacto']);

$router->comprobarRutas();



