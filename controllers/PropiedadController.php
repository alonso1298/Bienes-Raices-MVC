<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

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

        // Arreglo con mensajes de errores
        $errores = Propiedad::getErrores();

         // Ejecutar el código después que el usuario envia el formulario 
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            /** Crea una nueva instancia **/
            $propiedad = new Propiedad($_POST['propiedad']);

            /** SUBIDA DE ARCHIVOS **/

            // Generar un nombre unico a la imagen
            $nombreImagen = md5( uniqid( rand(), true ) ) . '.jpg';

            // Setear la imagen
            if($_FILES){
                // Realiza un resize a la imagen con intervetion
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }

            debuguear();

            // Validar
            $errores = $propiedad->validar();

            // Revisar que el arreglo de errores este vacio
            if(empty($errores)) { // Empty revisa que un arreglo este vacío

                // Crear la carpeta
                if(!is_dir(CARPETA_IMAGENES)){ //La función is_dir retorna si una carpeta existe o no existe
                        mkdir(CARPETA_IMAGENES);
                }

                // Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                // Guarda en la base de datos
                $propiedad->guardar();
            }
        }

        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores,
        ]);
    }

    public static function actualizar() {
        echo "Actualizar propiedad";
    }
}