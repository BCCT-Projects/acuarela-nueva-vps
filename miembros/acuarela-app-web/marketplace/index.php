<?php
/**
 * Página de onboarding de Stripe Connect
 *
 * Esta página permite al daycare conectar su cuenta de Stripe
 * Incluye el daycare ID en las peticiones para asegurar que se guarde correctamente
 */

// Iniciar sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si hay sesión de usuario
$hasSession = isset($_SESSION["userLogged"]) || isset($_SESSION["user"]);

if (!$hasSession) {
    // Sin sesión, redirigir al login
    header("Location: /miembros/");
    exit;
}

// Incluir config para obtener el daycare ID
require_once __DIR__ . '/../includes/config.php';

// Obtener el daycare ID actual
$daycareId = $a->daycareID ?? null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Conectar con Stripe - Acuarela</title>
    <meta name="description" content="Conecta tu cuenta de Stripe para recibir pagos de los padres.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 550px;
            width: 100%;
        }
        .logo {
            height: 40px;
            margin-bottom: 20px;
        }
        h1 {
            color: #1e293b;
            margin: 0 0 10px;
            font-size: 1.5rem;
        }
        h2 {
            color: #64748b;
            margin: 0 0 25px;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px 28px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            margin: 5px;
        }
        .btn:hover { opacity: 0.9; }
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .btn-secondary {
            background: #e2e8f0;
            color: #475569;
        }
        .status {
            margin: 20px 0;
            padding: 15px;
            border-radius: 8px;
            font-size: 0.95rem;
        }
        .status.loading {
            background: #f0f9ff;
            color: #0369a1;
        }
        .status.success {
            background: #f0fdf4;
            color: #166534;
        }
        .status.error {
            background: #fef2f2;
            color: #dc2626;
        }
        .hidden { display: none !important; }
        .account-id {
            font-family: monospace;
            background: #f1f5f9;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            color: #64748b;
            margin: 10px 0;
        }
        .debug {
            margin-top: 20px;
            padding: 15px;
            background: #f1f5f9;
            border-radius: 8px;
            text-align: left;
            font-size: 12px;
            color: #64748b;
        }
        .debug p { margin: 3px 0; font-family: monospace; }
        .steps {
            display: flex;
            gap: 15px;
            margin: 25px 0;
            justify-content: center;
        }
        .step {
            text-align: center;
            padding: 15px 10px;
            background: #f8fafc;
            border-radius: 8px;
            flex: 1;
        }
        .step-number {
            background: #667eea;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            font-weight: bold;
            font-size: 0.9rem;
        }
        .step p {
            margin: 0;
            color: #475569;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="../img/stripeLogo.png" alt="Stripe" class="logo" style="filter: none;">

        <div id="initial-content">
            <h1 id="title">Conecta tu cuenta de Stripe</h1>
            <h2 id="subtitle">En Acuarela puedes recibir pagos de los padres de forma fácil y segura. Conecta tu cuenta bancaria a través de Stripe.</h2>

            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <p>Crear cuenta</p>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <p>Completar datos</p>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <p>¡Listo!</p>
                </div>
            </div>

            <button id="sign-up-button" class="btn">Conectar con Stripe</button>
            <a href="../configuracion#metodos" class="btn btn-secondary">Volver</a>
        </div>

        <div id="status-loading" class="status loading hidden">
            <p id="creating-account">⏳ Creando tu cuenta de Stripe...</p>
            <p id="adding-info" class="hidden">⏳ Preparando el formulario de verificación...</p>
        </div>

        <div id="status-success" class="status success hidden">
            <p>✓ Cuenta creada correctamente</p>
            <div id="account-id-display" class="account-id hidden"></div>
            <button id="add-info-button" class="btn hidden">Completar verificación</button>
        </div>

        <div id="status-error" class="status error hidden">
            <p id="error-message">❌ Ocurrió un error</p>
            <button id="retry-button" class="btn">Intentar de nuevo</button>
        </div>

        <div id="debug-info" class="debug hidden">
            <strong>Debug:</strong>
            <div id="debug-content"></div>
        </div>
    </div>

    <script>
        // Pasar el daycare ID desde PHP a JavaScript
        const DAYCARE_ID = <?= json_encode($daycareId) ?>;

        let connectedAccountId = null;

        // Elementos del DOM
        const initialContent = document.getElementById('initial-content');
        const statusLoading = document.getElementById('status-loading');
        const statusSuccess = document.getElementById('status-success');
        const statusError = document.getElementById('status-error');
        const signUpButton = document.getElementById('sign-up-button');
        const addInfoButton = document.getElementById('add-info-button');
        const retryButton = document.getElementById('retry-button');
        const creatingAccount = document.getElementById('creating-account');
        const addingInfo = document.getElementById('adding-info');
        const accountIdDisplay = document.getElementById('account-id-display');
        const errorMessage = document.getElementById('error-message');
        const debugInfo = document.getElementById('debug-info');
        const debugContent = document.getElementById('debug-content');

        // Función para mostrar debug
        function showDebug(message) {
            debugInfo.classList.remove('hidden');
            const p = document.createElement('p');
            p.textContent = new Date().toLocaleTimeString() + ' - ' + message;
            debugContent.appendChild(p);
        }

        // Función para crear la cuenta conectada
        async function createAccount() {
            showDebug('Iniciando creación de cuenta...');
            showDebug('Daycare ID: ' + DAYCARE_ID);

            // Mostrar estado de carga
            initialContent.classList.add('hidden');
            statusLoading.classList.remove('hidden');
            statusError.classList.add('hidden');
            statusSuccess.classList.add('hidden');
            creatingAccount.classList.remove('hidden');

            try {
                const response = await fetch('account.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' }
                });

                const data = await response.json();
                showDebug('Respuesta account.php: ' + JSON.stringify(data));

                if (data.error) {
                    throw new Error(data.error);
                }

                connectedAccountId = data.account;
                showDebug('Account ID: ' + connectedAccountId);

                // Mostrar éxito
                statusLoading.classList.add('hidden');
                statusSuccess.classList.remove('hidden');
                accountIdDisplay.textContent = 'ID: ' + connectedAccountId;
                accountIdDisplay.classList.remove('hidden');
                addInfoButton.classList.remove('hidden');

            } catch (error) {
                showDebug('Error: ' + error.message);
                statusLoading.classList.add('hidden');
                statusError.classList.remove('hidden');
                errorMessage.textContent = '❌ Error: ' + error.message;
            }
        }

        // Función para obtener el enlace de onboarding
        async function getOnboardingLink() {
            if (!connectedAccountId) {
                showDebug('Error: No hay account ID');
                return;
            }

            showDebug('Solicitando enlace de onboarding...');

            // Actualizar UI
            statusSuccess.classList.add('hidden');
            statusLoading.classList.remove('hidden');
            creatingAccount.classList.add('hidden');
            addingInfo.classList.remove('hidden');

            try {
                const response = await fetch('account_link.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        account: connectedAccountId,
                        daycare: DAYCARE_ID
                    })
                });

                const data = await response.json();
                showDebug('Respuesta account_link.php: ' + JSON.stringify(data));

                if (data.error) {
                    throw new Error(data.error);
                }

                if (data.url) {
                    showDebug('Redirigiendo a Stripe...');
                    window.location.href = data.url;
                }

            } catch (error) {
                showDebug('Error: ' + error.message);
                statusLoading.classList.add('hidden');
                statusError.classList.remove('hidden');
                errorMessage.textContent = '❌ Error: ' + error.message;
            }
        }

        // Event listeners
        signUpButton.addEventListener('click', createAccount);
        addInfoButton.addEventListener('click', getOnboardingLink);
        retryButton.addEventListener('click', () => {
            debugContent.innerHTML = '';
            statusError.classList.add('hidden');
            initialContent.classList.remove('hidden');
        });
    </script>
</body>

</html>
