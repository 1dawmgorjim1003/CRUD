<?php 
include('general_functions.php');
// ===============================
// ZONA DE INICIALIZACIÓN
// ===============================
bootstrap();

// ===============================
// LÓGICA DE NEGOCIO
// ===============================
//Se lee el la ID de usuario dada en la URL y se carga la información de este
function getData() {
    $sql = 'SELECT id,usuario,email,rol,fecha_alta,nombre,apellidos,fecha_nacimiento,avatar FROM users where ID=' . $_GET['id'] . ';';
    $user = [];
    foreach  (getPDO()->query($sql) as $row) {
        array_push($user,$row['id']);    
        array_push($user,$row['usuario']);    
        array_push($user,$row['email']);    
        array_push($user,$row['rol']);    
        array_push($user,$row['fecha_alta']);    
        array_push($user,$row['nombre']);    
        array_push($user,$row['apellidos']);
        array_push($user,$row['fecha_nacimiento']);
        array_push($user,$row['avatar']);
    }
    return $user;
}

$user = getData();

// ===============================
// LÓGICA DE PRESENTACIÓN
// ===============================
//Se pinta por pantalla la información del usuario
function getUserMarkup($user) {
    if (!$user) {
        return '<p class="text-soft" style="text-align:center;">Usuario no encontrado.</p>';
    }

    $fields = [
        'Avatar' => $user[8] ?? '',
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
        if ($rowIndex == 'Avatar') {
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
            "><img src="'.htmlspecialchars($rowData).'" width="100px" height="100px" /></td>
            </tr>';
        } else {
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
