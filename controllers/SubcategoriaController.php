<?php

namespace Controllers;

use MVC\Router;
use Model\Subcategoria;
use Model\Categoria;

class SubcategoriaController
{
    public static function index(Router $router)
    {
        session_start();

        isAdmin();
        $subcategorias = Subcategoria::all();
        
        $categorias = [];
        foreach ($subcategorias as $subcategoria) {
            $categoria = Categoria::find($subcategoria->categorias_id);
            $categorias[$subcategoria->id] = $categoria->nombre ?? 'Sin categoría';
        }

        $router->render('subcategorias/admin', [
            'subcategorias' => $subcategorias,
            'categorias' => $categorias,
            'pageTitle' => 'Subcategorías',
            'titulo' => 'admin'
        ]);
    }

    public static function crear(Router $router)
    {
        session_start();

        isAdmin();

        $subcategoria = new Subcategoria;
        $categorias = Categoria::all();
        $alertas = Subcategoria::getAlertas();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subcategoria = new Subcategoria($_POST);
            $alertas = $subcategoria->validar();

            if (empty($alertas)) {
                $subcategoria->creado = date('Y/m/d');
                $resultado = $subcategoria->guardar();

                if ($resultado) {
                    header('Location: /subcategories/admin');
                }
            }
        }

        $alertas = Subcategoria::getAlertas();

        $router->render('subcategorias/crear', [
            'subcategoria' => $subcategoria,
            'alertas' => $alertas,
            'categorias' => $categorias,
            'pageTitle' => 'Crear Subcategoría',
            'titulo' => 'admin'
        ]);
    }

    public static function actualizar(Router $router)
    {
        session_start();

        isAdmin();
        $id = validarORedireccionar('/subcategories/admin');
        $subcategoria = Subcategoria::find($id);
        $alertas = Subcategoria::getAlertas();
        $categorias = Categoria::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $args = $_POST;
            $subcategoria->sincronizar($args);
            $alertas = $subcategoria->validar();

            if (empty($alertas)) {
                $resultado = $subcategoria->guardar();

                if ($resultado) {
                    header('Location: /subcategories/admin');
                    exit;
                }
            }
        }

        $alertas = Subcategoria::getAlertas();

        $router->render('subcategorias/actualizar', [
            'subcategoria' => $subcategoria,
            'alertas' => $alertas,
            'categorias' => $categorias,
            'pageTitle' => 'Editar Subcategoría',
            'titulo' => 'admin'
        ]);
    }

    public static function eliminar()
    {
        session_start();

        isAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                $subcategoria = Subcategoria::find($id);

                if ($subcategoria) {
                    $query = "SELECT COUNT(*) as total FROM productos WHERE subcategorias_id = {$id}";
                    $resultado = Subcategoria::ejecutarSQL($query);
                    $total = $resultado->fetch_assoc()['total'];

                    if ($total > 0) {
                        $queryUpdate = "UPDATE productos SET subcategorias_id = NULL WHERE subcategorias_id = {$id}";
                        Subcategoria::ejecutarSQL($queryUpdate);
                    }
                    $resultado = $subcategoria->eliminar();

                    if ($resultado) {
                        header('Location: /subcategories/admin');
                    }
                }
            }
        }
    }
}