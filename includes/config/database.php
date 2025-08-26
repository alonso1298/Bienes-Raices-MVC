<?php 

function conectarDB() : mysqli {
    $db = new mysqli(
        getenv('DB_HOST'), 
        getenv('DBMYSQL_USER'), 
        getenv('56457977Ac*'), 
        getenv('DB_BienesRaices')
    );

    if(!$db) {
        echo "Error no se pudo conectar";
        exit;
    } 

    return $db;
    
}