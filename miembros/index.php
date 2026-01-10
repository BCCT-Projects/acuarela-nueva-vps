<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si la sesión del usuario está activa
if (isset($_SESSION['user'])) {
    $user = (array) $_SESSION['user'];

    if (!empty($user['id'])) {
        // Si el usuario está logueado, redirigir a la página de selección de daycare
        header("Location: /miembros/acuarela-app-web/cambiar-daycare?fromLogin=1");
        exit();
    }
}

// Si no hay sesión activa, continuar mostrando el from de login
$classBody = "login";
include 'includes/header.php'; 
?>
<main>
    <form action="s/login/" method="POST" id="loginB" autocomplete="off">
        <h1>
            Iniciar sesión
        </h1>
        <span>
            <label for="email">
                E-mail
            </label>
            <input type="email" placeholder="name@mail.com" name="email" id="email"
                value="<?=isset($_GET['email']) ?  $_GET['email'] : ""?>"
                oninput="this.value = this.value.toLowerCase()" />
        </span>
        <span>
            <label for="password">Contraseña</label>
            <input type="password" placeholder="*******" name="password" id="password" />
            <button id="viewPassword" type="button" onclick="togglePasswordVisibility()"><svg width="32" height="32"
                    viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_318_107687)">
                        <path
                            d="M16 11.6362C13.5927 11.6362 11.6364 13.5926 11.6364 15.9999C11.6364 18.4072 13.5927 20.3635 16 20.3635C18.4073 20.3635 20.3636 18.4072 20.3636 15.9999C20.3636 13.5926 18.4072 11.6362 16 11.6362Z"
                            fill="currentColor" />
                        <path
                            d="M16 5.09082C8.72728 5.09082 2.51639 9.61441 0 15.9999C2.51639 22.3854 8.72728 26.909 16 26.909C23.28 26.909 29.4837 22.3854 32.0001 15.9999C29.4837 9.61441 23.28 5.09082 16 5.09082ZM16 23.2726C11.9855 23.2726 8.72728 20.0144 8.72728 15.9999C8.72728 11.9853 11.9855 8.72716 16 8.72716C20.0146 8.72716 23.2728 11.9854 23.2728 15.9999C23.2728 20.0145 20.0146 23.2726 16 23.2726Z"
                            fill="currentColor" />
                    </g>
                    <defs>
                        <clipPath id="clip0_318_107687">
                            <rect width="32" height="32" fill="white" />
                        </clipPath>
                    </defs>
                </svg></button>
        </span>
        <div class="noAccount">
            No se encontró un usuario registrado!
        </div>
        <button type="submit">INICIAR SESIÓN</button>
        <a href="/miembros/recuperar-contrasena" class="link">Recuperar Contraseña</a>
        <a href="/" class="link register">Volver al inicio</a>
    </form>
</main>
<?php include 'includes/disclaimer-cookies.php'; ?>
<?php include 'includes/footer.php';  ?>
