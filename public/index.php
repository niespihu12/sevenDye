<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\BlogCategoriaController;
use Controllers\BlogController;
use Controllers\BlogsController;
use Controllers\CarritoController;
use MVC\Router;
use Controllers\InfluencerController;
use Controllers\TestimonioController;
use Controllers\PaginasController;
use Controllers\LoginController;
use Controllers\DashboardController;
use Controllers\GoogleController;
use Controllers\CategoriaController;
use Controllers\ClienteController;
use Controllers\UsuarioController;
use Controllers\ColorController;
use Controllers\CuponController;
use Controllers\DeseoController;
use Controllers\OrdenController;
use Controllers\PagoController;
use Controllers\TallaController;
use Controllers\ProductoController;
use Controllers\ReseñaController;
use Controllers\SubcategoriaController;
use Controllers\TiendaController;
use Model\BlogCategoria;
use Model\Orden;
use Model\Subcategoria;

$router = new Router();

$router->get('/admin', [DashboardController::class, 'index']);

$router->get('/orders/admin', [OrdenController::class, 'index']);
$router->get("/orders/see", [OrdenController::class, 'see']);


$router->get('/testimonials/admin', [TestimonioController::class, 'index']);
$router->get('/testimonials/create', [TestimonioController::class, 'crear']);
$router->post('/testimonials/create', [TestimonioController::class, 'crear']);
$router->get('/testimonials/update', [TestimonioController::class, 'actualizar']);
$router->post('/testimonials/update', [TestimonioController::class, 'actualizar']);
$router->post('/testimonials/delete', [TestimonioController::class, 'eliminar']);


$router->get('/influencers/admin', [InfluencerController::class, 'index']);
$router->get('/influencers/create', [InfluencerController::class, 'crear']);
$router->post('/influencers/create', [InfluencerController::class, 'crear']);
$router->get('/influencers/update', [InfluencerController::class, 'actualizar']);
$router->post('/influencers/update', [InfluencerController::class, 'actualizar']);
$router->post('/influencers/delete', [InfluencerController::class, 'eliminar']);

$router->get('/categories/admin', [CategoriaController::class, 'index']);
$router->get('/categories/create', [CategoriaController::class, 'crear']);
$router->post('/categories/create', [CategoriaController::class, 'crear']);
$router->get('/categories/update', [CategoriaController::class, 'actualizar']);
$router->post('/categories/update', [CategoriaController::class, 'actualizar']);
$router->post('/categories/delete', [CategoriaController::class, 'eliminar']);

$router->get('/subcategories/admin', [SubcategoriaController::class, 'index']);
$router->get('/subcategories/create', [SubcategoriaController::class, 'crear']);
$router->post('/subcategories/create', [SubcategoriaController::class, 'crear']);
$router->get('/subcategories/update', [SubcategoriaController::class, 'actualizar']);
$router->post('/subcategories/update', [SubcategoriaController::class, 'actualizar']);
$router->post('/subcategories/delete', [SubcategoriaController::class, 'eliminar']);


$router->get('/colors/admin', [ColorController::class, 'index']);
$router->get('/colors/create', [ColorController::class, 'crear']);
$router->post('/colors/create', [ColorController::class, 'crear']);
$router->get('/colors/update', [ColorController::class, 'actualizar']);
$router->post('/colors/update', [ColorController::class, 'actualizar']);
$router->post('/colors/delete', [ColorController::class, 'eliminar']);

$router->get('/sizes/admin', [TallaController::class, 'index']);
$router->get('/sizes/create', [TallaController::class, 'crear']);
$router->post('/sizes/create', [TallaController::class, 'crear']);
$router->get('/sizes/update', [TallaController::class, 'actualizar']);
$router->post('/sizes/update', [TallaController::class, 'actualizar']);
$router->post('/sizes/delete', [TallaController::class, 'eliminar']);


$router->get('/products/admin', [ProductoController::class, 'index']);
$router->get('/products/create', [ProductoController::class, 'crear']);
$router->post('/products/create', [ProductoController::class, 'crear']);
$router->get('/products/update', [ProductoController::class, 'actualizar']);
$router->post('/products/update', [ProductoController::class, 'actualizar']);
$router->post('/products/delete', [ProductoController::class, 'eliminar']);
$router->get('/products/search', [ProductoController::class, 'buscar']);
$router->get('/products/get-subcategories', [ProductoController::class, 'obtenerSubcategorias']);

$router->get('/blog/admin', [BlogController::class, 'index']);
$router->get('/blog/create', [BlogController::class, 'crear']);
$router->post('/blog/create', [BlogController::class, 'crear']);
$router->get('/blog/update', [BlogController::class, 'actualizar']);
$router->post('/blog/update', [BlogController::class, 'actualizar']);
$router->post('/blog/delete', [BlogController::class, 'eliminar']);
$router->get('/blog/search', [BlogController::class, 'buscar']);


$router->get('/blog_categories/admin', [BlogCategoriaController::class, 'index']);
$router->get('/blog_categories/create', [BlogCategoriaController::class, 'crear']);
$router->post('/blog_categories/create', [BlogCategoriaController::class, 'crear']);
$router->get('/blog_categories/update', [BlogCategoriaController::class, 'actualizar']);
$router->post('/blog_categories/update', [BlogCategoriaController::class, 'actualizar']);
$router->post('/blog_categories/delete', [BlogCategoriaController::class, 'eliminar']);

$router->get('/customers/admin', [ClienteController::class, 'index']);
$router->get('/customers/update', [ClienteController::class, 'actualizar']);
$router->post('/customers/update', [ClienteController::class, 'actualizar']);


$router->get('/coupons/admin', [CuponController::class, 'index']);
$router->get('/coupons/create', [CuponController::class, 'crear']);
$router->post('/coupons/create', [CuponController::class, 'crear']);
$router->get('/coupons/update', [CuponController::class, 'actualizar']);
$router->post('/coupons/update', [CuponController::class, 'actualizar']);
$router->post('/coupons/delete', [CuponController::class, 'eliminar']);

$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/register',[LoginController::class, 'registro']);
$router->post('/register',[LoginController::class, 'registro']);
$router->get('/logout', [LoginController::class, 'logout']);

$router->get('/google/login', [GoogleController::class, 'login']);
$router->get('/google/callback', [GoogleController::class, 'callback']);


$router->get('/forgot', [LoginController::class, 'olvide']);
$router->post('/forgot', [LoginController::class, 'olvide']);
$router->get('/recover', [LoginController::class, 'recuperar']);
$router->post('/recover', [LoginController::class, 'recuperar']);

$router->get('/confirm-account', [LoginController::class, 'confirmar']);
$router->get('/message', [LoginController::class, 'mensaje']);

$router->get('/reviews/product', [ReseñaController::class, 'obtenerPorProducto']);
$router->post('/reviews/save', [ReseñaController::class, 'guardar']);

$router->get('/profile', [UsuarioController::class, 'actualizar']);
$router->post('/profile', [UsuarioController::class, 'actualizar']);

$router->get('/', [PaginasController::class, 'index']);
$router->get('/about', [PaginasController::class, 'nosotros']);
$router->get('/contact', [PaginasController::class, 'contacto']);
$router->post('/contact', [PaginasController::class, 'contacto']);

$router->get('/cart', [CarritoController::class, 'index']);
$router->post('/cart/add', [CarritoController::class, 'agregar']);
$router->post('/cart/update', [CarritoController::class, 'actualizar']);
$router->post('/cart/delete', [CarritoController::class, 'eliminar']);
$router->get('/cart/count', [CarritoController::class, 'contarCarrito']);
$router->post('/cart/apply-coupon', [CarritoController::class, 'aplicarCupon']);
$router->post('/cart/remove-coupon', [CarritoController::class, 'quitarCupon']);

$router->get('/store', [TiendaController::class, 'index']);
$router->get('/store/{slug}', [TiendaController::class, 'indexSlug']);
$router->get('/details/{slug}', [TiendaController::class, 'detalles']);

$router->get('/wishlist', [DeseoController::class, 'index']);
$router->get('/wishlist/verify', [DeseoController::class, 'verificar']);
$router->post('/wishlist/save', [DeseoController::class, 'guardar']);
$router->post('/wishlist/delete', [DeseoController::class, 'eliminar']);
$router->get('/wishlist/count', [DeseoController::class, 'contarDeseos']);

$router->get('/blog', [PaginasController::class, 'blog']);
$router->get('/blog/category/{slug}', [PaginasController::class, 'blogCategoria']);
$router->get('/blog/{slug}', [PaginasController::class, 'blogDetalle']);


$router->get('/payment', [PagoController::class, 'checkout']);
$router->post('/process-payment', [PagoController::class, 'procesarPago']);
$router->post('/process-payment-product', [PagoController::class, 'procesarPagoProducto']);
$router->get('/buy-now', [PagoController::class, 'buyNow']);


$router->comprobarRutas();