<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../includes/config.php";
$_SESSION['activeDaycare'] = $_GET['daycare']; // También actualizas la sesión
$a->setDaycare($_GET['daycare']); // Esto actualiza internamente los valores

if (isset($_GET['inscripcion'])) {
    header("Location: /miembros/acuarela-app-web/agregar-ninx");
} else if(isset($_GET['marketplace'])){
    header("Location: /miembros/acuarela-app-web/marketplaceapp");
} else if(isset($_GET['fromLogin'])){
    // Si viene del login, redirigir a la app principal
    header("Location: /miembros/acuarela-app-web/");
} else {
    header("Location: /miembros/acuarela-app-web/");
}
exit;
?>
