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
            debuguear($fn);
        } else {
            call_user_func // call_user_func es una funcion que nos va a permitir llamar a una funcion cuando np sabemos como se llama esa funcion 
        }
    }
}