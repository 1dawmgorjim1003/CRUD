<?php 
// ===============================
// INICIALIZACIÓN DEL ENTORNO
// ===============================
function bootstrap() {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// ===============================
// FUNCIONES DE DEBUGUEO
// ===============================
function dump($var){
    echo '<pre>'.print_r($var,1).'</pre>';
}

// ===============================
// FUNCIONES DE LÓGICA DE NEGOCIO
// ===============================
//Tras hacer una operación sensible, vuelve al listado de usuarios
function goBack($boolean) {
    if ($boolean == true) {
        header('Location: user_index.php');
        exit();
    }
}

//Define los valores de los campos name cuando creamos un usuario o editamos la información de este
function buildForm() {
    return array('usuario','email','rol','nombre','apellidos','fecha_nacimiento','avatar');
}

//Cargar un CSV en una variable
function loadCSV($routeFile) {
    $data = [];
    if (!is_readable($routeFile)) {
        echo 'No se ha podido leer el archivo'. $routeFile;
    } else {
        if (($pointer = fopen($routeFile, 'r')) !== FALSE) {
            while (($row = fgetcsv($pointer)) !== FALSE) {
                $data[] = $row;
            }
            fclose($pointer);
        }
    }
    return $data;
}

?>