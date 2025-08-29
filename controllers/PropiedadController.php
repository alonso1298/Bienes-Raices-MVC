<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController {
    public static function index(Router $router) { // Agregamos Router para no crear una nueva instancia y seguir manteniendo la referencia pasando el objeto que viene de index.php
        
        $propiedades = Propiedad::all();
        
         // Muestra mensaje condicional
        $resultado = $_GET['resultado'] ?? null; // El paceholder ?? null busca el valor $_GET['resultado'] y si no existe le asigna null }

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
            if($_FILES['propiedad']['tmp_name']['imagen']){

                // Realiza un resize a la imagen con intervetion
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }

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

    public static function actualizar(Router $router) {
        $id = \validarORedireccionar("/admin");
        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();

        $errores = Propiedad::getErrores();

        // Metodo POST para actualizar
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Asignar los atributos
            $args = $_POST['propiedad'];

            $propiedad->sincronizar($args);

            // Validación 
            $errores = $propiedad->validar();

            /* Subida de archivos */

            // Generar un nombre único a la imagen
            $nombreImagen = md5( uniqid( rand(), true ) ) . '.jpg';

            if($_FILES['propiedad']['tmp_name']['imagen']){
                // Realiza un resize a la imagen con intervetion
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }

            // Revisar que el arreglo de errores este vacio
            if(empty($errores)) { // Empty revisa que un arreglo este vacío
                if($_FILES['propiedad']['tmp_name']['imagen']){
                    // Almacenar la imagen
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }

                $propiedad->guardar();
            }

        }

        $router->render('/propiedades/actualizar', [
            'propiedad' => $propiedad,
            'errores' => $errores,
            'vendedores' => $vendedores
        ]);
    }
}