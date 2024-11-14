<?php

namespace MVC;

class Router {

    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn) {
        $this->rutasGET[$url] = $fn;
    }
    
    public function comprobarRutas() {
        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        if($metodo === 'GET'){
            $fn = $this->rutasGET[$urlActual] ?? null;
        }

        if($fn) {
            // La url existe y hay una funcion asociada
            call_user_func($fn, $this); // call_user_func es una funcion que nos va a permitir llamar a una funcion cuando no sabemos como se llama esa funcion 
        } else {
            echo "La pagina no existe";
        }
    }

    // Muestra una vista 
    public function render($view, $datos = []) {

        foreach($datos as $key => $value) {
            $$key = $value; // Con $$ creamos una variable de variable 
        }

        ob_start(); // ob_start Inicia un almacenamiento en memoria
        include __DIR__ . "/views/$view.php"; // Guarda en memoria esa vista
        $contenido = ob_get_clean(); // ob_get_clean Limpia el Buffer
        include __DIR__ . "/views/layout.php";
    }
}