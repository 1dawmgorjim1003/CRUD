<?php 
// ===============================
// INICIALIZACIÓN DEL ENTORNO
// ===============================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ===============================
// FUNCIONES DE DEBUGUEO
// ===============================
function dump($var){
    echo '<pre>'.print_r($var,1).'</pre>';
}

// ===============================
// LÓGICA DE NEGOCIO
// ===============================
//Se carga el archivo CSV
function loadCSV($routeFile) {
    $data = [];
    if (!is_readable($routeFile)) {
        echo '<p>No se ha podido leer el archivo <strong>'. htmlspecialchars($routeFile) .'</strong></p>';
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

//Se lee el la ID de usuario dada en la URL y se carga la información de este
function readInput($data) {
    $user_id = $_GET['id'] ?? null;
    if ($user_id === null) return null;
    foreach ($data as $row) {
        if ($row[0] == $user_id) return $row;
    }
    return null;
}

$data = loadCSV('../data/users.csv');
$user = readInput($data);

// ===============================
// LÓGICA DE PRESENTACIÓN
// ===============================
//Se pinta por pantalla la información del usuario
function getUserMarkup($user) {
    if (!$user) {
        return '<p class="text-soft" style="text-align:center;">Usuario no encontrado.</p>';
    }

    $fields = [
        'ID' => $user[0] ?? '',
        'Usuario' => $user[1] ?? '',
        'Email' => $user[2] ?? '',
        'Rol' => $user[3] ?? '',
        'Fecha Alta' => $user[4] ?? '',
        'Nombre' => $user[5] ?? '',
        'Apellidos' => $user[6] ?? '',
        'Fecha de nacimiento' => $user[7] ?? ''
    ];

    $output  = '<div class="card" style="
        box-shadow: var(--elev-1);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        padding: 1rem 1.5rem;
        background: var(--surface-2);
    ">
    <table style="
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 0.8rem;
    ">
    <tbody>';

    foreach ($fields as $rowIndex => $rowData) {
        $output .= '<tr>
        <th style="
            width: 38%;
            text-align: left;
            font-weight: 600;
            color: var(--text-soft);
            background: color-mix(in oklab, var(--surface) 60%, var(--surface-2));
            border-radius: var(--r-md) 0 0 var(--r-md);
            padding: .7rem 1rem;
        ">'.htmlspecialchars($rowIndex).'</th>
        <td style="
            padding: .7rem 1rem;
            background: var(--surface);
            border-radius: 0 var(--r-md) var(--r-md) 0;
            box-shadow: inset 0 0 0 1px var(--border);
            color: var(--text);
        ">'.htmlspecialchars($rowData).'</td>
        </tr>';
    }
    
    $output .= '</tbody></table></div>';
    return $output;
}

$userMarkup = getUserMarkup($user);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Información del usuario</title>
  <link rel="stylesheet" href="../src/styles.css">
</head>
<body>
  <main class="container center" style="min-height:100vh;">
    <section class="card gradient-border pad-4 stack-4" 
             style="width:min(600px,96%);padding:1.8rem;">
      <header class="stack-2" style="text-align:center;">
        <h1 class="halo">Información del usuario</h1>
        <p class="text-soft" style="font-size:0.95rem;">Detalles completos del registro seleccionado</p>
      </header>

      <?= $userMarkup ?>

      <div style="text-align:center;margin-top:1rem;">
        <a class="btn btn-outline" href="user_index.php">Volver al listado</a>
      </div>
    </section>
  </main>
</body>
</html>
