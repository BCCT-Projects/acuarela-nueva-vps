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

    // Si no hay activeDaycare en sesión pero el usuario tiene daycares, establecer el primero
    // Esto es necesario para los archivos en /set/ que no cargan head.php
    if ((!isset($_SESSION['activeDaycare']) || empty($_SESSION['activeDaycare'])) && isset($_SESSION["user"]->daycares)) {
        $daycares = $_SESSION["user"]->daycares;
        if (!empty($daycares)) {
            // Si solo hay un daycare, establecerlo automáticamente
            if (count($daycares) == 1) {
                $_SESSION['activeDaycare'] = $daycares[0]->id;
                $a->setDaycare($daycares[0]->id);
            } else {
                // Si hay múltiples daycares, usar el primero por defecto
                // (el usuario debería haber seleccionado uno en la UI)
                $_SESSION['activeDaycare'] = $daycares[0]->id;
                $a->setDaycare($daycares[0]->id);
            }
        }
    }
?>