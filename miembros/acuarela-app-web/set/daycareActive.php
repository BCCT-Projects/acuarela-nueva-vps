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
    $_SESSION['activeDaycare'] = $daycare; // También actualizas la sesión
    $a->setDaycare($daycare); // Esto actualiza internamente los valores
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
