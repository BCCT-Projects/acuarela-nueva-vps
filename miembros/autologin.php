<?php
/**
 * Página de entrada para auto-login desde portal de miembros
 * Valida token SSO y solicita verificación 2FA
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$classBody = "login autologin";
include 'includes/header.php';

// Si ya hay sesión activa, redirigir
if (isset($_SESSION['user']) && !empty($_SESSION['user']->id)) {
    header("Location: /miembros/acuarela-app-web/changeDaycare?fromLogin=1");
    exit();
}

// Obtener token de URL
$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING) ?? null;

if (!$token) {
    // Sin token, mostrar error
    ?>
    <main>
        <div class="error-container">
            <h1>Error de Acceso</h1>
            <p>Token de auto-login inválido o no proporcionado.</p>
            <a href="/miembros/" class="link">Volver al inicio de sesión</a>
        </div>
    </main>
    <?php
    include 'includes/footer.php';
    exit();
}
?>

<main>
    <!-- Formulario de verificación 2FA para auto-login -->
    <form action="set/verify_sso_2fa" method="POST" id="formAutoLogin2FA" autocomplete="off">
        <input type="hidden" name="sso_token" id="ssoToken" value="<?= htmlspecialchars($token) ?>">

        <h1>Verificación de Seguridad</h1>
        <p>Hemos enviado un código de verificación a tu correo electrónico.</p>

        <span>
            <label for="code">Código de Verificación</label>
            <input type="text" placeholder="123456" name="code" id="code" maxlength="6" required autofocus />
        </span>

        <div class="noAccount" id="errorAutoLogin2fa" style="display:none;">
            Código incorrecto o expirado
        </div>

        <div style="margin-bottom: 20px; text-align: right; font-size: 0.9em;">
            <a href="#" id="resendCodeAutoLogin" class="link"
                style="pointer-events: none; color: #aaa; text-decoration: none;">Reenviar código en 60s</a>
        </div>

        <button type="submit">VERIFICAR</button>
        <a href="/miembros/" class="link register">Cancelar</a>
    </form>
</main>

<script>
    // Procesamiento inicial del token SSO
    document.addEventListener('DOMContentLoaded', function () {
        const token = document.getElementById('ssoToken').value;
        const errorDiv = document.getElementById('errorAutoLogin2fa');
        const form = document.getElementById('formAutoLogin2FA');

        // Validar token y generar código 2FA
        fetch('/miembros/set/validate_sso_token.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ token: token })
        })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    errorDiv.textContent = data.message || 'Token inválido o expirado';
                    errorDiv.style.display = 'block';
                    form.querySelector('button[type="submit"]').disabled = true;
                    return;
                }

                console.log('Token SSO validado. Código 2FA enviado.');
            })
            .catch(error => {
                console.error('Error validando token SSO:', error);
                errorDiv.textContent = 'Error de conexión. Intenta nuevamente.';
                errorDiv.style.display = 'block';
            });

        // Manejo del formulario de verificación
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const code = document.getElementById('code').value;
            const submitBtn = form.querySelector('button[type="submit"]');

            submitBtn.disabled = true;
            submitBtn.textContent = 'VERIFICANDO...';
            errorDiv.style.display = 'none';

            fetch('/miembros/set/verify_sso_2fa.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    token: token,
                    code: code
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        // Redirigir al daycare seleccionado
                        window.location.href = data.redirect;
                    } else {
                        errorDiv.textContent = data.message || 'Código incorrecto';
                        errorDiv.style.display = 'block';
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'VERIFICAR';
                    }
                })
                .catch(error => {
                    console.error('Error verificando código:', error);
                    errorDiv.textContent = 'Error de conexión. Intenta nuevamente.';
                    errorDiv.style.display = 'block';
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'VERIFICAR';
                });
        });

        // Timer de reenvío de código
        let countdown = 60;
        const resendLink = document.getElementById('resendCodeAutoLogin');

        const countdownInterval = setInterval(() => {
            countdown--;
            resendLink.textContent = `Reenviar código en ${countdown}s`;

            if (countdown <= 0) {
                clearInterval(countdownInterval);
                resendLink.style.pointerEvents = 'auto';
                resendLink.style.color = '#00A099';
                resendLink.textContent = 'Reenviar código';
            }
        }, 1000);

        resendLink.addEventListener('click', function (e) {
            e.preventDefault();

            if (countdown > 0) return;

            // Reenviar código
            fetch('/miembros/set/resend_sso_2fa.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ token: token })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        alert('Código reenviado correctamente');
                        countdown = 60;
                        resendLink.style.pointerEvents = 'none';
                        resendLink.style.color = '#aaa';

                        const newInterval = setInterval(() => {
                            countdown--;
                            resendLink.textContent = `Reenviar código en ${countdown}s`;

                            if (countdown <= 0) {
                                clearInterval(newInterval);
                                resendLink.style.pointerEvents = 'auto';
                                resendLink.style.color = '#00A099';
                                resendLink.textContent = 'Reenviar código';
                            }
                        }, 1000);
                    } else {
                        alert(data.message || 'Error al reenviar código');
                    }
                });
        });
    });
</script>

<script>
    // Ocultar preloader inicialmente
    document.addEventListener('DOMContentLoaded', function () {
        const preloader = document.querySelector('.preloader');
        if (preloader) {
            preloader.style.display = 'none';
        }
    });
</script>

<?php include 'includes/footer.php'; ?>