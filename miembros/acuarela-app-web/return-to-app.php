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

// Iniciar sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Variables iniciales
$error = null;
$success = false;
$stripeAccountId = isset($_GET["id"]) ? $_GET["id"] : null;
$daycareId = isset($_GET["daycare"]) ? $_GET["daycare"] : null;
$redirectUrl = '/miembros/acuarela-app-web/configuracion#metodos';

// Verificar si hay sesión de usuario
$hasSession = isset($_SESSION["userLogged"]) || isset($_SESSION["user"]);

if (!$stripeAccountId) {
    $error = "No se recibió el ID de la cuenta Stripe";
} elseif ($hasSession) {
    // ========================================
    // CASO 1: Hay sesión activa - guardar directamente
    // ========================================
    try {
        require_once __DIR__ . "/includes/config.php";

        if (empty($a->daycareID)) {
            $error = "No se pudo determinar el Daycare ID";
        } else {
            // Guardar el idStripe
            $data = ['idStripe' => $stripeAccountId];
            $result = $a->updateDaycareInfo($data);

            if ($result && (isset($result->id) || isset($result->response) || isset($result->data))) {
                $success = true;
                // Invalidar caché del daycare
                $a->invalidateStrapiCache("daycares/{$a->daycareID}");
            } else {
                $error = "La API no confirmó el guardado";
            }
        }

    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }

} else {
    // ========================================
    // CASO 2: No hay sesión - redirigir al login
    // ========================================

    // Guardar temporalmente el ID de Stripe en la sesión para cuando el usuario inicie sesión
    $_SESSION['pending_stripe_id'] = $stripeAccountId;
    if ($daycareId) {
        $_SESSION['pending_daycare_id'] = $daycareId;
    }

    // Redirigir al login con mensaje
    $redirectUrl = '/miembros/?message=stripe_pending';
}
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
      <p>Tu cuenta de Stripe ha sido vinculada correctamente. Ya puedes recibir pagos de los padres.</p>
      <div class="account-id"><?= htmlspecialchars($stripeAccountId) ?></div>
      <p class="countdown">Redirigiendo en <span id="countdown">3</span> segundos...</p>
    <?php elseif (!$hasSession && $stripeAccountId): ?>
      <div class="icon warning">!</div>
      <h1>Sesión expirada</h1>
      <p>Tu sesión ha expirado durante el proceso de vinculación.</p>
      <p>Por favor, inicia sesión para completar la vinculación de tu cuenta de Stripe.</p>
      <p class="countdown">Redirigiendo en <span id="countdown">10</span> segundos...</p>
    <?php else: ?>
      <div class="icon error">✗</div>
      <h1>Error al vincular</h1>
      <p style="color: #dc2626;"><?= htmlspecialchars($error) ?></p>
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
