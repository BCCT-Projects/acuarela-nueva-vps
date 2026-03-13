<?php
/**
 * Página de retorno después de completar el onboarding de Stripe Connect
 *
 * Esta página recibe el ID de la cuenta Stripe conectada y la guarda en la API
 *
 * Flujo:
 * 1. Si hay sesión activa → guardar idStripe directamente
 * 2. Si no hay sesión → redirigir al login con mensaje de "completa tu vinculación"
 */

// Activar mostrar errores para debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    $lifetime = 28800; // 8 horas
    ini_set('session.gc_maxlifetime', $lifetime);
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https');
    session_set_cookie_params([
        'lifetime' => $lifetime,
        'path' => '/',
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

$success = true;
$stripeAccountId = isset($_GET["id"]) ? $_GET["id"] : "Stripe Account";
$redirectUrl = '/miembros/acuarela-app-web/configuracion#metodos';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultado - Acuarela</title>
  <meta http-equiv="refresh" content="<?= $success ? '3' : '10' ?>; url=<?= $redirectUrl ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      margin: 0;
      padding: 20px;
    }
    .container {
      background: white;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.2);
      text-align: center;
      max-width: 450px;
      width: 100%;
    }
    .icon {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      font-size: 32px;
      color: white;
    }
    .success { background: #10b981; }
    .error { background: #ef4444; }
    .warning { background: #f59e0b; }
    h1 { margin: 0 0 10px; color: #1e293b; font-size: 1.3rem; }
    p { margin: 0 0 15px; color: #64748b; line-height: 1.5; }
    .btn {
      display: inline-block;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 12px 24px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
    }
    .btn:hover { opacity: 0.9; }
    .account-id {
      font-family: monospace;
      background: #f1f5f9;
      padding: 8px 12px;
      border-radius: 6px;
      font-size: 0.85rem;
      color: #64748b;
      margin: 10px 0;
    }
    .countdown {
      font-size: 0.85rem;
      color: #94a3b8;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php if ($success): ?>
      <div class="icon success">✓</div>
      <h1>¡Cuenta vinculada!</h1>
      <p>Tu cuenta de Stripe ha sido configurada. Ya puedes recibir pagos de los padres.</p>
      <div class="account-id"><?= htmlspecialchars($stripeAccountId) ?></div>
      <p class="countdown">Redirigiendo en <span id="countdown">3</span> segundos...</p>
    <?php endif; ?>

    <a href="<?= $redirectUrl ?>" class="btn">Ir a Configuración</a>
  </div>

  <script>
    // Countdown timer
    let seconds = <?= $success ? 3 : 10 ?>;
    const countdownEl = document.getElementById('countdown');
    const interval = setInterval(() => {
      seconds--;
      if (countdownEl) countdownEl.textContent = seconds;
      if (seconds <= 0) clearInterval(interval);
    }, 1000);
  </script>
</body>
</html>
