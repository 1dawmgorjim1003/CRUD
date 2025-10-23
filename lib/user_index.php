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
//Se carga el CSV
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

$data = loadCSV('../data/users.csv');

// ===============================
// PRESENTACIÓN
// ===============================
//Se muestra los datos del archivo CSV
function getDataMarkup($data) {
    $output = '';
    if (empty($data)) {
        return '<p class="text-soft" style="text-align:center;">No hay usuarios registrados todavía.</p>';
    } else {
        $output .= '<div class="table-wrap" style="overflow-x:auto; max-width:100%;">
        <table class="data" style="min-width:100%;">
        <thead><tr>
        <th>ID</th><th>Usuario</th><th>Email</th><th>Rol</th><th>Fecha Alta</th><th>Acciones</th>
        </tr></thead><tbody>';

        foreach ($data as $row) {
            $output .= '<tr>
            <td>' . htmlspecialchars($row[0] ?? '') .'</td>
            <td>' . htmlspecialchars($row[1] ?? '') . '</td>
            <td>' . htmlspecialchars($row[2] ?? '') . '</td>
            <td>' . htmlspecialchars($row[3] ?? '') . '</td>
            <td>' . htmlspecialchars($row[4] ?? '') . '</td>
            <td class="actions" style="white-space:nowrap;">
            <a class="btn btn-outline" href="user_info.php?id=' . htmlspecialchars($row[0] ?? '') . '">Ver</a>
            <a class="btn" href="user_edit.php?id=' . htmlspecialchars($row[0] ?? '') . '">Editar</a>
            <a class="btn btn-danger" href="user_delete.php?id=' . htmlspecialchars($row[0] ?? '') . '">Eliminar</a>
            </td>
            </tr>';
        }

        $output .= '</tbody></table></div>';
        return $output;
    }
}

$datMarkup = getDataMarkup($data);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listado de usuarios</title>
  <link rel="stylesheet" href="../src/styles.css">
</head>
<body>
  <main class="container center" style="min-height:100vh;">
    <section class="card gradient-border pad-4 stack-4" 
             style="width:min(1100px,96%);">
      <header class="stack-2" style="text-align:center;">
        <h1 class="halo">Listado de usuarios</h1>
        <p class="text-soft" style="font-size:0.95rem;">Consulta los usuarios registrados en el sistema</p>
      </header>

      <?= $datMarkup ?>

      <div style="text-align:center;margin-top:1rem;">
        <a class="btn btn-outline" href="../index.php">Volver al panel</a>
      </div>
    </section>
  </main>
</body>
</html>
