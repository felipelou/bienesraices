<?php

function conectarDB() : mysqli {
    $db = mysqli_connect('localhost','root','F3lip3lou','bienesraices_crud');

    if(!$db){
        echo "Error no se pudo conectar";
        exit;

    }
    return $db;
}