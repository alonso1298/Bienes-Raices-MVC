<?php

namespace Controllers;

class PropiedadController {
    public static function index() { // Se agrega el static ya que de esta forma no requerimos de crear una nueva instancia
        echo "Index";
    }

    public static function crear() {
        echo "Crear propiedad";
    }

    public static function actualizar() {
        echo "Actualizar propiedad";
    }
}