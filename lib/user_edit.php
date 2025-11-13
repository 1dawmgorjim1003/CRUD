<?php 
include('general_functions.php');
// ===============================
// ZONA DE INICIALIZACIÓN
// ===============================
bootstrap();

// ===============================
// LÓGICA DE NEGOCIO
// ===============================
//Leer los datos del formulario por defecto del usuario
function getData() {
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        $sql = 'SELECT id,usuario,email,rol,fecha_alta,nombre,apellidos,fecha_nacimiento FROM users where ID=' . $_GET['id'] . ';';
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
        }
        return $user;
    }   
}

//Actualizar BBDD con los nuevos datos del usuario
function writeDatabase($user) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $user = $_POST['user'];
        dump($user);
        $pdo = getPDO();
        $sql = "UPDATE users 
                SET 
                    usuario = " . $pdo->quote($user[1]) . ",
                    email = " . $pdo->quote($user[2]) . ",
                    rol = " . $pdo->quote($user[3]) . ",
                    nombre = " . $pdo->quote($user[4]) . ",
                    apellidos = " . $pdo->quote($user[5]) . ",
                    fecha_nacimiento = " . $pdo->quote($user[6]) . "
                WHERE id = " . intval($user[0]) . ";";
        dump($sql);
        $stmt = $pdo->query($sql);
        // return true;
    }
    return false;
}


$user = getData();
// dump($user);
$form = buildForm();
$isWrited = writeDatabase($user);
goBack($isWrited);

// ===============================
// LÓGICA DE PRESENTACIÓN
// ===============================
//Se pinta el formulario para editar la información del usuario, mostrando por defecto los datos antiguos en sus respectivos campos
//Se envía por POST un array con los nuevos datos del usuario.
function paintForm($form, $user) {
    $output  = '<form class="stack-2" action="' . $_SERVER['PHP_SELF'] . '" method="post" style="gap:.8rem;">
    <input type="hidden" name="user[]" value="' . htmlspecialchars($user[0] ?? '', ENT_QUOTES, 'UTF-8') . '">
    <div class="form-banner-invalid" role="alert" aria-live="polite">⚠️ <span>Revisa los campos marcados.</span></div>
    <div class="field"><label class="label" for="usuario">Usuario</label><input class="input" id="usuario" type="text" name="user[]" value="' . htmlspecialchars($user[1] ?? '', ENT_QUOTES, 'UTF-8') . '" required></div>
    <div class="field"><label class="label" for="email">Email</label><input class="input" id="email" type="email" name="user[]" value="' . htmlspecialchars($user[2] ?? '', ENT_QUOTES, 'UTF-8') . '" required></div>
    <div class="field"><label class="label" for="rol">Rol</label><input class="input" id="rol" type="text" name="user[]" value="' . htmlspecialchars($user[3] ?? '', ENT_QUOTES, 'UTF-8') . '" required></div>
    <div class="field"><label class="label" for="nombre">Nombre</label><input class="input" id="nombre" type="text" name="user[]" value="' . htmlspecialchars($user[5] ?? '', ENT_QUOTES, 'UTF-8') . '" required></div>
    <div class="field"><label class="label" for="apellidos">Apellidos</label><input class="input" id="apellidos" type="text" name="user[]" value="' . htmlspecialchars($user[6] ?? '', ENT_QUOTES, 'UTF-8') . '" required></div>
    <div class="field"><label class="label" for="fecha_nacimiento">Fecha de nacimiento</label><input class="input" id="fecha_nacimiento" type="date" name="user[]" value="' . htmlspecialchars($user[7] ?? '', ENT_QUOTES, 'UTF-8') . '" required></div>
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
