<?php 
//INICIALIZACIÓN DEL ENTORNO
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//FUNCIÓN PARA DEBUGUEAR
function dump($var){
    global $miVariable;
    echo $miVariable;
    echo '<pre>'.print_r($var,1).'</pre>';
}

//LÓGICA DE NEGOCIO
function buildForm() {
    return $output = array('nombre', 'email', 'rol');
}

$info = buildForm();

//LÓGICA DE PRESENTACIÓN
function paintForm($info) {
    $output = '<form action="'.$_SERVER['PHP_SELF'].'" method="post">';
    $output .= 'Nombre del usuario: <input type="text" name=' . $info[0] . '><br><br>';
    $output .= 'Email del usuario: <input type="text" name=' . $info[1] . '><br><br>';
    $output .= 'Rol del usuario: <input type="text" name=' . $info[2] . '><br><br>';
    $output .= '<input type="submit" value="Crear usuario">';
    $output .= '<input type="submit" value="Crear usuario">';
    $output .= '<input type="submit" value="Crear usuario">';
    $output .= '<input type="submit" value="Crear usuario">';
    $output .= '</form>';
    return $output;
}

$formMarkup = paintForm($info);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.css">
</head>
<body>
    <h1>Creación de usuario </h1>
    <?php echo $formMarkup;?>
    <br>    
    <a href="../index.php">Volver al panel de control</a>
</body>
</html>