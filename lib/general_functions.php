<?php 
// ===============================
// INICIALIZACIÓN DEL ENTORNO
// ===============================
function bootstrap() {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

//Conexión BBDD
function getPDO() {
    // var_dump(new PDO('mysql:dbname=crud_mysql;host=localhost','crud_mysql','crud_mysql'));
    // var_dump(new PDO('mysql:dbname=database1;host=172.22.235.10','root','root'));
    // return new PDO('mysql:dbname=database1;host=172.22.235.10','root','root');
    return new PDO('mysql:dbname=crud_mysql;host=localhost','crud_mysql','crud_mysql');
}

getPDO();

// ===============================
// FUNCIONES DE DEBUGUEO
// ===============================
//Función debugueo simple
function dump($var){
    echo '<pre>'.print_r($var,1).'</pre>';
}

//Función debugeo que devuelve la estrucutra de la clase
function getClassStructure($var) {
    if (is_object($var)) {
        $ref = new ReflectionClass($var);
        $props = $ref->getMethods(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);
        foreach($props as $prop) {
            echo '<pre>'.$prop->getName().'</pre>';
        }
    }
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

?>