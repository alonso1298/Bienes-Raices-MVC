<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;

class PropiedadController {
    public static function index(Router $router) { // Agregamos Router para no crear una nueva instancia y seguir manteniendo la referencia pasando el objeto que viene de index.php
        
        $propiedades = Propiedad::all();
        $resultado = null;

        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
        ]);
    }

    public static function crear(Router $router) { // Se agrega el static ya que de esta forma no requerimos de crear una nueva instancia

        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores
        ]);
    }

    public static function actualizar() {
        echo "Actualizar propiedad";
    }
}