<?php 

namespace Model;

class Vendedor extends ActiveRecord {

    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar() {
        
        if(!$this->nombre) { // !$titulo significa que si no hay titulo o si esta vacío 
            self::$errores[] = "Debes añadir un Nombre"; // Detecta que $errores es un arreglo y la sintaxias va agregarlo en el arreglo
        }

        if(!$this->apellido) { 
            self::$errores[] = "Debes añadir un Apellido";
        }

        if(!$this->telefono) { 
            self::$errores[] = "Debes añadir un Teléfono";
        }

        if(!preg_match( '/[0-9]{10}/', $this->telefono )) { // preg_match se usa para hacer experesiones regulares
            self::$errores[] = "Formato de teléfono no válido";
        }

        return self::$errores;
    }
}