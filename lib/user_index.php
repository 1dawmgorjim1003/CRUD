<?php 
include('general_functions.php');
// ===============================
// ZONA DE INICIALIZACIÓN
// ===============================
bootstrap();

// ===============================
// LÓGICA DE NEGOCIO
// ===============================
//Leer todos los usuarios de BBDD
function getData(){
    $sql = 'SELECT id,usuario,email,rol,fecha_alta,nombre,apellidos,fecha_nacimiento FROM users';
    $stmt = getPDO()->query($sql);
    $rowCount = $stmt->rowCount();
    $data = array_fill(0,$rowCount,[]);
    $counter = 0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      array_push($data[$counter],$row['id']);
      array_push($data[$counter],$row['usuario']);
      array_push($data[$counter],$row['email']);
      array_push($data[$counter],$row['rol']);
      array_push($data[$counter],$row['fecha_alta']);
      $counter++;
    }
    return $data;
}
$data = getData();
// dump($data);
// ===============================
// PRESENTACIÓN
// ===============================
//Se muestra los usuarios de BBDD
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

$dataMarkup = getDataMarkup($data);
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

      <?php echo $dataMarkup; ?>

      <div style="text-align:center;margin-top:1rem;">
        <a class="btn btn-outline" href="../index.php">Volver al panel</a>
      </div>
    </section>
  </main>
</body>
</html>
