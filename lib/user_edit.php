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
//Leer los datos del formulario al modificar los datos
function takePost($user) {
    $incomingData = [];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $incomingData[0] = $_POST['id'];  // Obtener el ID del formulario
        $incomingData[1] = htmlspecialchars($_POST['usuario'] ?? '');
        $incomingData[2] = htmlspecialchars($_POST['email'] ?? '');
        $incomingData[3] = htmlspecialchars($_POST['rol'] ?? '');
        $incomingData[4] = $user[4];
        $incomingData[5] = htmlspecialchars($_POST['nombre'] ?? '');
        $incomingData[6] = htmlspecialchars($_POST['apellidos'] ?? '');
        $incomingData[7] = htmlspecialchars($_POST['fecha_nacimiento'] ?? '');
    }
    return $incomingData;
}

//Cargar el CSV
function loadCSV($routeFile) {
    $data = [];
    if (!is_readable($routeFile)) {
        echo 'No se ha podido leer el archivo '. $routeFile;
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

//Sacar la información del usuario modificado según ID
function readInput($data) {
    $user_id = isset($_GET['id']) ? $_GET['id'] : null;
    if ($user_id == null) {
        $user_id = $_POST['id'];
    }
    if ($user_id !== null) {
        $user = null;
        foreach ($data as $rowIndex => $rowData) {
            if ($rowData[0] == $user_id) {
                $user = $rowData;
                break;
            }
        }
        if ($user === null) {
            echo "Usuario no encontrado.";
            return null;
        }
        return $user;
    }
    echo "No se ha proporcionado un ID de usuario.";
    return null;
}

//Definir los campos del formulario
function buildForm() {
    return array('usuario','email','rol','nombre','apellidos','fecha_nacimiento');
}

//Actualizar en el archivo CSV los nuevos datos del usuario
function writeCSV($routeFile, $incomingData, $data) {    
    $isWrited = false;
    if (!empty($incomingData)){
        foreach ($data as $rowIndex => $rowData) {
            if ($rowData[0] == $incomingData[0]) {
                $data[$rowIndex] = $incomingData;
                break;
            }
        }
        if (($pointer = fopen($routeFile, 'w')) !== FALSE) {
            foreach ($data as $row) {
                fputcsv($pointer, $row);
            }
            fclose($pointer);
            echo 'Datos del usuario actualizados correctamente.';
            $isWrited = true;
        } else {
            echo 'No se pudo abrir el archivo para escribir.';
        }
        return $isWrited;
    }
   
}

$data = loadCSV('../data/users.csv');
$user = readInput($data);
$incomingData = takePost($user);
$form = buildForm();
$isWrited = writeCSV('../data/users.csv', $incomingData, $data);

//Cuando se han modificado los datos, se vuelve al listado de usuarios
function goBack($isWrited) {
    if ($isWrited == true) {
        header('Location: user_index.php');
        exit();
    }
}

goBack($isWrited);

// ===============================
// LÓGICA DE PRESENTACIÓN
// ===============================
//Se pinta el formulario para editar la información del usuario, mostrando por defecto los datos antiguos en sus respectivos campos
function paintForm($form, $user) {
    $output  = '<form class="stack-2" action="' . $_SERVER['PHP_SELF'] . '" method="post" style="gap:.8rem;">
    <input type="hidden" name="id" value="' . htmlspecialchars($user[0] ?? '', ENT_QUOTES, 'UTF-8') . '">
    <div class="form-banner-invalid" role="alert" aria-live="polite">⚠️ <span>Revisa los campos marcados.</span></div>
    <div class="field"><label class="label" for="usuario">Usuario</label><input class="input" id="usuario" type="text" name="'.$form[0].'" value="' . htmlspecialchars($user[1] ?? '', ENT_QUOTES, 'UTF-8') . '" required></div>
    <div class="field"><label class="label" for="email">Email</label><input class="input" id="email" type="email" name="'.$form[1].'" value="' . htmlspecialchars($user[2] ?? '', ENT_QUOTES, 'UTF-8') . '" required></div>
    <div class="field"><label class="label" for="rol">Rol</label><input class="input" id="rol" type="text" name="'.$form[2].'" value="' . htmlspecialchars($user[3] ?? '', ENT_QUOTES, 'UTF-8') . '" required></div>
    <div class="field"><label class="label" for="nombre">Nombre</label><input class="input" id="nombre" type="text" name="'.$form[3].'" value="' . htmlspecialchars($user[5] ?? '', ENT_QUOTES, 'UTF-8') . '" required></div>
    <div class="field"><label class="label" for="apellidos">Apellidos</label><input class="input" id="apellidos" type="text" name="'.$form[4].'" value="' . htmlspecialchars($user[6] ?? '', ENT_QUOTES, 'UTF-8') . '" required></div>
    <div class="field"><label class="label" for="fecha_nacimiento">Fecha de nacimiento</label><input class="input" id="fecha_nacimiento" type="date" name="'.$form[5].'" value="' . htmlspecialchars($user[7] ?? '', ENT_QUOTES, 'UTF-8') . '" required></div>
    <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;margin-top:.6rem">
    <button class="btn" type="submit">Actualizar usuario</button>
    <a class="btn btn-outline" href="user_index.php">Cancelar</a>
    </div>
    </form>';
    return $output;
}

$formMarkup = paintForm($form, $user);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar usuario</title>
    <link rel="stylesheet" href="../src/styles.css">
</head>
<body>
    <main class="container center" style="min-height:100vh;">
        <section class="card gradient-border pad-3 stack-3"
                 style="width:min(520px,96%);padding:1.4rem;">
            <header class="stack-1" style="text-align:center;">
                <h1 class="halo" style="font-size:var(--step-2);margin-bottom:.2rem;">Editar usuario</h1>
                <p class="text-soft" style="font-size:.95rem;">Modifica los datos y guarda los cambios</p>
            </header>

            <?php echo $formMarkup; ?>
        </section>
    </main>
</body>
</html>
