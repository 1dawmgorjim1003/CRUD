<?php 
include('lib/general_functions.php');
// ===============================
// ZONA DE INICIALIZACIÓN
// ===============================
bootstrap();

// ===============================
// LÓGICA DE NEGOCIO
// ===============================
function buildLinks() {
    return [
        'Crear usuario' => 'lib/user_create.php',
        'Leer usuarios' => 'lib/user_index.php',
    ];
}

$links = buildLinks();

// ===============================
// LÓGICA DE PRESENTACIÓN
// ===============================
function paintLinks($links) {
    $output = '';
    foreach ($links as $rowIndex => $rowData) {
        $output .= '<a class="btn" href="' . $rowData . '">' . $rowIndex . '</a>';
    }
    return $output;
}

$linksMarkup = paintLinks($links);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>CRUD</title>
  <link rel="stylesheet" href="src/styles.css"/>
</head>
<body>
  <main class="container center" style="min-height:100vh;">
    <section class="card gradient-border pad-4 stack-4 center" style="max-width:500px;">
      <h1 class="halo" style="text-align:center;">Create Read Update Delete</h1>
      <div class="stack-3" style="text-align:center;">
        <?php echo $linksMarkup; ?>
      </div>
    </section>
  </main>
</body>
</html>
