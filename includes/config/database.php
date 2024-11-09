<?php 

function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', '56457977Ac*', 'biernesraices_crud');

    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    } 

    return $db;
    
}