<?php

namespace Model;

class Propiedad extends ActiveRecord{
    
    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedores_id'];

    public $id;
    public $titulo;
    public $precio;
    public $descripcion;
    public $imagen;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? '';
    }

    public function validar() {
        
        if(!$this->titulo) { // !$titulo significa que si no hay titulo o si esta vacío 
            self::$errores[] = "Debes añadir un titulo"; // Detecta que $errores es un arreglo y la sintaxias va agregarlo en el arreglo
        }
        if(!$this->precio) { 
            self::$errores[] = "Debes añadir un precio"; 
        }
        if(strlen( $this->descripcion ) < 50 || strlen( $this->descripcion ) > 500 ) { // Validamos que la descripción tenga al menos 50 caracteres y maximo 500 caracteres
            self::$errores[] = "La descripción es obligatoria y debe tener al menos 50 caracteres";
        }
        if(!$this->habitaciones) { 
            self::$errores[] = "El número de habitaciones es obligatorio"; 
        }
        if(!$this->wc) { 
            self::$errores[] = "El número de baños es obligatorio"; 
        }
        if(!$this->estacionamiento) { 
            self::$errores[] = "El número de lugares de estacionamiento es obligatorio"; 
        }
        if(!$this->vendedores_id) { 
            self::$errores[] = "Elige un vendedor"; 
        }

        if(!$this->imagen) {
            self::$errores[] = "La imagen de la propiedad es obligatoria";
        }

        return self::$errores;
    }
}