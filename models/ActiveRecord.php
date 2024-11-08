<?php 

namespace App;

class ActiveRecord {
    // Base de datos 
    protected static $db; // Si creamos una propiedad estatico el metodo tiene que se estatico también
    protected static $columnasDB = [];
    protected static $tabla = '';

    // Errores
    protected static $errores = [];

    //Definir la conexión a la base de datos
    public static function setDB($database) {
        self::$db = $database; // Accedemos con self a los registros estaticas
    }

    public function guardar() {
        if(!is_null($this->id)) {
            // Actualizar
            $this->actualizar();
        }else {
            // Creando un nuevo registro
            $this->crear();
        }
    }

    public function crear() {

        // Sanitizar la entrada de los datos 
        $atributos = $this->sanitizarAtributos(); // Para mandar llamar un método dentro de otro método es con this 

        // Insertar en la Base de Datos
        $query = " INSERT INTO ". static::$tabla ." ( ";
        $query .= join(', ', array_keys($atributos)); // Join crea un nuevo string a partir de un arreglo toma dos valores el primero es el separador y el segundo el arreglo
        $query .= " ) VALUES (' ";  
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);

        // Mensaje de exito o error
        if($resultado) {
            // redireccionar al usuario
            header('Location: /admin?resultado=1'); // Esta funcion sirve para redireccionar al usuario, solo sirve si no hay nada de html previo y se recomienda usarlo poco
            // Para mostrar mensajes en otra pantalla se utiliza el query string con un signo ? seguido de llaves y valores, para registrar mas de un valor es con & y seguido devalor,ejmplo: Location: /admin?mensaje=Registrado Correctamente&registrado=1
        }
    }

    public function actualizar() {
        // Sanitizar la entrada de los datos 
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE ". static::$tabla ." SET "; 
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";

        // Esto imprime : "UPDATE propiedades SET titulo='Casa hermosa (Actualizado) ', precio='1320000.00', imagen='7436905e8073cfca2000823c1c68b363.jpg', descripcion='Esta descripción si se insertara en la base de datos ya que cumple con todo (Actualizado) ', habitaciones='5', wc='4', estacionamiento='3', creado='', vendedores_id='2' WHERE id = '22'  LIMIT 1 "
        
        $resultado = self::$db->query($query);

        if($resultado) {
            // Redireccionar al usuario
            header('Location: /admin?resultado=2'); // Esta funcion sirve para redireccionar al usuario, solo sirve si no hay nada de html previo y se recomienda usarlo poco
        }
    }

    // Eliminar un registro
    public function eliminar() {
        //Eliminar el registro 
        $query = "DELETE FROM ". static::$tabla ." WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado) {
            $this->borrarImagen();
            // Redireccionar al usuario
            header('Location: /admin?resultado=3'); // Esta funcion sirve para redireccionar al usuario, solo sirve si no hay nada de html previo y se recomienda usarlo poco
        }
    }

    // Identificar y unir los atributos de la base de datos 
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue; // continue hace que cuando de cumpla la condicion ignora y se va a la siguiente elemento del foreach
            $atributos[$columna] = $this->$columna; // Se le pone el signo de $ despues del this ya que es una variable del foreach
        }
        return $atributos;
    }

    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    // Subida de archivos
    public function setImagen($imagen){

        // Elimina la imagen previa
        if(!is_null($this->id)) {
            $this->borrarImagen();
        }

        // Asignar al atributo de imagen el nombre de la imagen
        if($imagen){
            $this->imagen = $imagen;
        }
    }

    // Eliminar archivo
    public function borrarImagen() {
        // Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo) {
            // Si existe el archivo se elimina con Unlink
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    // Validacion
    public static function getErrores() {
        return static::$errores;
    }

    public function validar() {
        static::$errores;
        return static::$errores;
    }

    // Lista todos los registros
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla; // static hereda el método y busca el atributo en la clase que se esta heredando 

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // Obtiene determinado numero de registros 
    public static function get($cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad; // static hereda el método y busca el atributo en la clase que se esta heredando 

        $resultado = self::consultarSQL($query);

        return $resultado;
    }
 
    // Busca un registro por su ID
    public static function find($id) {
        $query = "SELECT * FROM ". static::$tabla ." WHERE id = {$id}";

        $resultado = self::consultarSQL($query);

        return array_shift($resultado); // array_shift nos retorna el primer elemento de un arreglo
    }

    public static function consultarSQL($query){
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = static::crearObjeto($registro);
        }

        // Liberar la memoria 
        $resultado->free();

        // Retornar los resultados 
        return $array;
    }

    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value){
            if(property_exists($objeto, $key)) { // property_exists verifica si que propiedad exista ya sea key o titulo
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Sincroniza el objeto en memoria por los cambios realizados por el usuario
    public function sincronizar( $args = [] ){
        foreach($args as $key => $value){
            if(property_exists($this, $key) && !is_null($value)) { // This es el objeto actual y si no esta nullo el valor sigue siendo el del value
                $this->$key = $value;
            } 
        }
    }
}