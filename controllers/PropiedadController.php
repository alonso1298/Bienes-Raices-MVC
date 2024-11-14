<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;

class PropiedadController {
    public static function index(Router $router) { // Agregamos Router para no crear una nueva instancia y seguir manteniendo la referencia pasando el objeto que viene de index.php
        
        $propiedades = Propiedad::all();
        $resultado = null;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
        ]);
    }

    public static function crear() { // Se agrega el static ya que de esta forma no requerimos de crear una nueva instancia
        echo "propiedades/crear";
    }

    public static function actualizar() {
        echo "Actualizar propiedad";
    }
}