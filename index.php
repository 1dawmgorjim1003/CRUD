<?php 
// ===============================
// ENTORNO (debug)
// ===============================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ===============================
// LÓGICA DE NEGOCIO
// ===============================
function buildLinks(): array {
    return [
        'Crear usuario' => 'lib/user_create.php',
        'Leer usuarios' => 'lib/user_index.php',
    ];
}

$links = buildLinks();

function paintLinks(array $links): string {
    $out = '';
    foreach ($links as $label => $href) {
        $safeLabel = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
        $safeHref  = htmlspecialchars($href, ENT_QUOTES, 'UTF-8');
        $out .= '<a class="btn" href="'.$safeHref.'">'.$safeLabel.'</a>';
    }
    return $out;
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
        <?= $linksMarkup ?>
      </div>
    </section>
  </main>
</body>
</html>
