<?php include __DIR__ . "/config.php";
$daycares = isset($_SESSION["user"]->daycares) ? $_SESSION["user"]->daycares : [];
function findDaycareById($daycares, $id)
{
  if (empty($id) || empty($daycares)) {
    return null;
  }
  foreach ($daycares as $daycare) {
    if (isset($daycare->id) && $daycare->id === $id) {
      return $daycare;
    }
  }
  return null; // Si no se encuentra
}
$foundDaycare = null;
if (isset($a->daycareID) && !empty($a->daycareID)) {
  $foundDaycare = findDaycareById($daycares, $a->daycareID);
}
// Si no se encuentra, usar el primer daycare disponible
if (!$foundDaycare && !empty($daycares) && isset($daycares[0])) {
  $foundDaycare = $daycares[0];
  if (isset($a) && method_exists($a, 'setDaycare')) {
    $a->setDaycare($daycares[0]->id);
    $_SESSION['activeDaycare'] = $daycares[0]->id;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <base href="/miembros/acuarela-app-web/">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Acuarela web app</title>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
  <link rel="stylesheet" href="css/acuarela_theme.css?v=3.0" />
  <link rel="stylesheet" href="css/styles.css?v=3.0" />
  <link rel="shortcut icon" href="img/favicon.png" />
  <script>
    let userMainT = "<?= $a->token ?>";
    let userNameAdmin = "<?= $_SESSION["user"]->name ?>";
    let emailAdmin = "<?= $_SESSION["user"]->email ?>";
    let daycareName = "<?= isset($_SESSION["user"]->daycares[0]) && isset($_SESSION["user"]->daycares[0]->name) ? $_SESSION["user"]->daycares[0]->name : '' ?>";
    let daycareActiveId = "<?= isset($a->daycareID) ? $a->daycareID : '' ?>";

    // Assuming the daycares array is available in the session
    let daycares = <?php echo json_encode($_SESSION["user"]->daycares); ?>;
    let acuarelaId = "<?= $_SESSION["user"]->acuarelauser->id ?>";

    // Function to find a daycare by ID
    function findDaycareById(daycares, id) {
      return daycares.find(daycare => daycare.id === id);
    }

    // Example usage
    let daycareId = 1; // Replace with the ID you are looking for
    let foundDaycare = findDaycareById(daycares, "<?= isset($a->daycareID) ? $a->daycareID : '' ?>");
    document.addEventListener("DOMContentLoaded", function () {
      // El botón de logout siempre debe apuntar a cerrar sesión
      const logoutLink = document.querySelector('.logout a');
      if (logoutLink) {
        logoutLink.href = '/miembros/cerrar-sesion';
      }
    })
  </script>
</head>

<body class="<?= $classBody ?>">