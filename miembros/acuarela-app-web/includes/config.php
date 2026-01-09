<?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // Verificar si hay una sesión de usuario iniciada (compatible con ambos sistemas)
    if (isset($_SESSION["userLogged"]) || isset($_SESSION["user"])) {
        // Si hay una sesión iniciada, no se realizan acciones adicionales
    } else {
        // Si no hay sesión, se redirige al usuario a la página de inicio de sesión
        $currentURL = $_SERVER['REQUEST_URI'];
        if ($currentURL != '/miembros/') {
            header("Location: /miembros/");
            exit(); // Salir del script después de la redirección
        }
    }
    include "sdk.php";
    $a = new Acuarela();
?>