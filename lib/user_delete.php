<?php
include('general_functions.php');
// ===============================
// ZONA DE INICIALIZACIÓN
// ===============================
bootstrap();

// ===============================
// LÓGICA DE NEGOCIO
// ===============================
//Obtener el id del usuario a borrar a través de la URL
function takeGet() {
    $userID = 0;
    if (isset($_GET['id'])) {
        $userID = htmlspecialchars($_GET['id']);
    }
    return $userID;
}

// Eliminar el usuario BBDD
function deleteUserOfDataBase($userID) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sql = 'DELETE FROM users where ID=' . $userID . ';';
        $stmt = getPDO()->prepare($sql);
        $stmt->execute();
        return true;
    }   
}


$isDeleted = false;

// Si el formulario ha sido enviado, se borra el usuario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    global $isDeleted;
    $userID = htmlspecialchars($_POST['id']); // ID del usuario a eliminar
    $isDeleted = deleteUserOfDataBase($userID); // Eliminar el usuario
}

// Obtener el ID del usuario desde la URL
$incomingData = takeGet();

//Si se ha eliminado el usuario, se vuelve al listado de usuarios

goBack($isDeleted);

// ===============================
// LÓGICA DE PRESENTACIÓN
// ===============================
//Se pinta el formulario con la confirmación
function paintForm($userID) {
    $output = '<form class="stack-2" action="' . $_SERVER['PHP_SELF'] . '" method="post" style="gap:.8rem;">
    <input type="hidden" name="id" value="' . htmlspecialchars($userID, ENT_QUOTES, 'UTF-8') . '">
    <div style="display:flex;gap:.75rem;justify-content:center;flex-wrap:wrap;margin-top:.6rem">
    <button class="btn btn-danger" type="submit">Sí, borrar usuario</button>
    <a class="btn btn-outline" href="user_index.php">Cancelar</a>
    </div>
    </form>';
    return $output;
}

$formMarkup = paintForm($incomingData);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar usuario</title>
    <link rel="stylesheet" href="../src/styles.css">
</head>
<body>
  <main class="container center" style="min-height:100vh;">
    <section class="card gradient-border pad-3 stack-3"
             style="width:min(520px,96%);padding:1.4rem;">
      <header class="stack-1" style="text-align:center;">
        <h1 class="halo" style="font-size:var(--step-2);margin-bottom:.2rem;">Eliminar usuario</h1>
        <p class="text-soft" style="font-size:.95rem;">
          ¿Confirmas que deseas eliminar el usuario con ID
          <span class="badge" style="margin-left:.25rem;"><?php echo htmlspecialchars($incomingData, ENT_QUOTES, 'UTF-8'); ?> </span> ?
        </p>
      </header>

      <?php echo $formMarkup; ?>
    </section>
  </main>
</body>
</html>
