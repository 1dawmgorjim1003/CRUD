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

//LOGICA DE NEGOCIO
function buildLinks() {
    return $output = array(
        'Crear usuario' => array('lib/user_create.php'),
        'Leer usuarios' => array('lib/read_users.php'),
        'Actualizar usuario' => array('lib/update_user.php'),
        'Eliminar usuario' => array('lib/delete_user.php')
    );
}

$links = buildLinks();
//dump($links);

//LOGICA DE PRESENTACIÓN
function paintLinks($links)  {
    $output = '';
    foreach($links as $rowIndex => $rowData) {
        foreach($rowData as $colIndex => $colData) {
            $output .= '<p> || <a href="' . $colData . '">' . $rowIndex . '</a> || <p>';
        }
    }
    return $output;
}

$linksMarkup = paintLinks($links);
//dump($linksMarkup);
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
    <h1>Create Read Update Delete</h1>
    <div style="display: flex;">
        <?php echo $linksMarkup?>
    </div>
</body>
</html>