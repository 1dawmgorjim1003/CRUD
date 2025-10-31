<?php
include('general_functions.php');

// ===============================
// ZONA DE INICIALIZACIÓN
// ===============================
bootstrap();

// ===============================
// LÓGICA DE NEGOCIO
// ===============================
// Incrementar un usuario cuando este se va a crear
function incrementUserID() {
    $lastID = (int)file_get_contents('../data/user_id_counter.txt');
    $newID = $lastID + 1;
    file_put_contents('../data/user_id_counter.txt', $newID);
    return $newID;
}

// Coger los datos del nuevo usuario a través de POST
function takePost() {
    $incomingData = [];
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $incomingData['id'] = incrementUserID();
        $incomingData['usuario'] = htmlspecialchars($_POST['usuario'] ?? '');
        $incomingData['email'] = htmlspecialchars($_POST['email'] ?? '');
        $incomingData['rol'] = htmlspecialchars($_POST['rol'] ?? '');
        $incomingData['fecha_alta'] = date('Y/m/d');
        $incomingData['nombre'] = htmlspecialchars($_POST['nombre'] ?? '');
        $incomingData['apellidos'] = htmlspecialchars($_POST['apellidos'] ?? '');
        $incomingData['fecha_nacimiento']  = htmlspecialchars($_POST['fecha_nacimiento'] ?? '');

        if (isset($_FILES['avatar'])) {
            $avatarTmpName = $_FILES['avatar']['tmp_name'];
            $avatarName = $_FILES['avatar']['name'];
            $avatarExt = pathinfo($avatarName, PATHINFO_EXTENSION);
            
            $avatarName = 'avatar_' . time() . '.' . $avatarExt;
            $avatarDir = '../src/avatars/';

            $avatarPath = $avatarDir . $avatarName;

            if (move_uploaded_file($avatarTmpName, $avatarPath)) {
                $incomingData['avatar'] = $avatarPath;
            } else {
                $incomingData['avatar'] = '';
            }
        }
    }
    return $incomingData;
}

// Escribir en el CSV el nuevo usuario
function writeCSV($routeFile, $incomingData) {
    if (!is_readable($routeFile)) {
        echo 'No se puede leer el archivo ' . $routeFile;
        return;
    }
    if (!empty($incomingData)) {
        $pointer = fopen($routeFile, 'ab');
        fputcsv($pointer, $incomingData);
        fclose($pointer);
    }
}

$incomingData = takePost();
$info = buildForm();
writeCSV('../data/users.csv', $incomingData);

// ===============================
// LÓGICA DE PRESENTACIÓN
// ===============================
// Pintar por pantalla el formulario
function paintForm($info) {
    $output  = '<form class="stack-2" action="' . $_SERVER['PHP_SELF'] . '" method="post" enctype="multipart/form-data" style="gap:0.8rem;">
    <div class="form-banner-invalid" role="alert" aria-live="polite">⚠️ <span>Revisa los campos marcados.</span></div>
    <div class="field"><label class="label" for="usuario">Usuario</label><input class="input" id="usuario" type="text" name="'.$info[0].'" required></div>
    <div class="field"><label class="label" for="email">Email</label><input class="input" id="email" type="email" name="'.$info[1].'" required></div>
    <div class="field"><label class="label" for="rol">Rol</label><input class="input" id="rol" type="text" name="'.$info[2].'" required></div>
    <div class="field"><label class="label" for="nombre">Nombre</label><input class="input" id="nombre" type="text" name="'.$info[3].'" required></div>
    <div class="field"><label class="label" for="apellidos">Apellidos</label><input class="input" id="apellidos" type="text" name="'.$info[4].'" required></div>
    <div class="field"><label class="label" for="fecha_nacimiento">Fecha de nacimiento</label><input class="input" id="fecha_nacimiento" type="date" name="'.$info[5].'" required></div>
    <div class="field"><label class="label" for="avatar">Avatar</label><input class="input" id="avatar" type="file" name="'.$info[6].'" accept="image/*" required></div>
    <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;margin-top:.8rem">
    <button class="btn" type="submit">Crear usuario</button>
    <a class="btn btn-outline" href="../index.php">Volver</a>   
    </div>
    </form>';
    return $output;
}

$formMarkup = paintForm($info);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Creación de usuario</title>
  <link rel="stylesheet" href="../src/styles.css">
</head>
<body>
  <main class="container center" style="min-height:100vh;">
    <section class="card gradient-border pad-3 stack-3" 
             style="width:min(480px,94%);padding:1.5rem;">
      <header class="stack-1" style="text-align:center;">
        <h1 class="halo" style="font-size:var(--step-2);margin-bottom:.2rem;">Creación de usuario</h1>
        <p class="text-soft" style="font-size:0.95rem;">Introduce los datos del nuevo usuario</p>
      </header>
      <?= $formMarkup ?>
    </section>
  </main>
</body>
</html>
