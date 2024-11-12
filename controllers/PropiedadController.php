<?php

namespace Controllers;
use MVC\Router;

class PropiedadController {
    public static function index(Router $router) { // Agregamos Router para no crear una nueva instancia y seguir manteniendo la referencia pasando el objeto que viene de index.php
        
        $router->render('propiedades/admin', [
            'mensaje' => 'Desde la vista',
        ]);
    }

    public static function crear() { // Se agrega el static ya que de esta forma no requerimos de crear una nueva instancia
        echo "propiedades/crear";
    }

    public static function actualizar() {
        echo "Actualizar propiedad";
    }
}