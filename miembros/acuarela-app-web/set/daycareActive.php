<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../includes/config.php";

$daycare = filter_input(INPUT_GET, 'daycare', FILTER_SANITIZE_SPECIAL_CHARS);
$inscripcion = filter_input(INPUT_GET, 'inscripcion', FILTER_SANITIZE_SPECIAL_CHARS);
$marketplace = filter_input(INPUT_GET, 'marketplace', FILTER_SANITIZE_SPECIAL_CHARS);
$fromLogin = filter_input(INPUT_GET, 'fromLogin', FILTER_SANITIZE_SPECIAL_CHARS);

if ($daycare) {
    // Verificar que el usuario tenga permiso para acceder a este daycare
    $allowed = false;
    if (isset($_SESSION['user']->daycares) && is_array($_SESSION['user']->daycares)) {
        foreach ($_SESSION['user']->daycares as $d) {
            if ($d->id == $daycare) {
                $allowed = true;
                break;
            }
        }
    }

    if ($allowed) {
        $_SESSION['activeDaycare'] = $daycare;
        $a->setDaycare($daycare);
    } else {
        // Log unauthorized attempt or handle error
        // Por consistencia, simplemente no hacemos el cambio si no está autorizado
        // Opcional: error_log("Intento de acceso no autorizado al daycare $daycare por usuario " . $_SESSION['user']->id);
    }
}

if ($inscripcion) {
    header("Location: /miembros/acuarela-app-web/agregar-ninx");
} else if($marketplace){
    header("Location: /miembros/acuarela-app-web/marketplaceapp");
} else if($fromLogin){
    // Si viene del login, redirigir a la app principal
    header("Location: /miembros/acuarela-app-web/");
} else {
    header("Location: /miembros/acuarela-app-web/");
}
exit;
?>
