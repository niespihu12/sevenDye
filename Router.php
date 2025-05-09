<?php

namespace MVC;

class Router {

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn) {
        $this->rutasGET[] = ['pattern' => $this->crearPatron($url), 'callback' => $fn];
    }

    public function post($url, $fn) {
        $this->rutasPOST[] = ['pattern' => $this->crearPatron($url), 'callback' => $fn];
    }

    private function crearPatron($url) {
        $regex = preg_replace('/\{(\w+)\}/', '(?P<\1>[^/]+)', $url);
        return '#^' . $regex . '$#';
    }

    public function comprobarRutas() {
        $urlActual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];
        $rutas = $metodo === 'GET' ? $this->rutasGET : $this->rutasPOST;

        foreach ($rutas as $ruta) {
            if (preg_match($ruta['pattern'], $urlActual, $coincidencias)) {
                $parametros = array_filter($coincidencias, 'is_string', ARRAY_FILTER_USE_KEY);
                call_user_func_array($ruta['callback'], array_merge([$this], $parametros));
                return;
            }
        }

        echo "Página no encontrada";
    }

    public function render($view, $datos = []) {
        foreach ($datos as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean();
        include __DIR__ . "/views/layout.php";
    }
}
