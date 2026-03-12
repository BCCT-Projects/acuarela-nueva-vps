<?php
// Activar mostrar errores para debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Variables iniciales
$error = null;
$success = false;
$stripeAccountId = isset($_GET["id"]) ? $_GET["id"] : null;
$redirectUrl = '/miembros/acuarela-app-web/configuracion#metodos';

// Incluir archivos con manejo de errores
try {
    require_once __DIR__ . "/includes/config.php";
    require_once __DIR__ . "/includes/sdk.php";
} catch (Exception $e) {
    $error = "Error al cargar dependencias: " . $e->getMessage();
}

// Guardar el idStripe en el daycare
if (!$error && $stripeAccountId) {
    try {
        $a = new Acuarela();
        $result = $a->updateDaycareInfo(['idStripe' => $stripeAccountId]);

        if ($result && (isset($result->id) || isset($result->data))) {
            $success = true;
        } else {
            $error = "La API no respondió como se esperaba";
        }
    } catch (Exception $e) {
        $error = "Error al guardar: " . $e->getMessage();
    }
} elseif (!$error && !$stripeAccountId) {
    $error = "No se recibió el ID de la cuenta Stripe";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultado - Acuarela</title>
  <meta http-equiv="refresh" content="5; url=<?= $redirectUrl ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      padding: 20px;
    }
    .container {
      background: white;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.2);
      text-align: center;
      max-width: 400px;
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
    .icon.success { background: #00A099; }
    .icon.error { background: #ef4444; }
    h1 {
      font-size: 24px;
      margin-bottom: 12px;
      color: #1e293b;
    }
    p {
      font-size: 16px;
      color: #64748b;
      margin-bottom: 20px;
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
    }
    .btn:hover { opacity: 0.9; }
    .info {
      font-size: 12px;
      color: #94a3b8;
      margin-top: 16px;
      padding-top: 16px;
      border-top: 1px solid #e2e8f0;
    }
  </style>
</head>
<body>
  <div class="container">
    <?php if ($success): ?>
      <div class="icon success">✓</div>
      <h1>¡Cuenta vinculada!</h1>
      <p>Tu cuenta de Stripe ha sido vinculada correctamente. Ya puedes recibir pagos.</p>
      <p style="font-size: 12px; color: #94a3b8;"><?= htmlspecialchars($stripeAccountId) ?></p>
    <?php elseif ($error): ?>
      <div class="icon error">✗</div>
      <h1>Error</h1>
      <p style="color: #dc2626;"><?= htmlspecialchars($error) ?></p>
      <?php if ($stripeAccountId): ?>
        <p style="font-size: 12px; color: #94a3b8;">Cuenta: <?= htmlspecialchars($stripeAccountId) ?></p>
      <?php endif; ?>
    <?php else: ?>
      <div class="icon" style="background: #94a3b8;">?</div>
      <h1>Sin datos</h1>
      <p>No se recibió información de Stripe.</p>
    <?php endif; ?>
    <a href="<?= $redirectUrl ?>" class="btn">Ir a Configuración</a>
    <p class="info">Redirigiendo en 5 segundos...</p>
  </div>
</body>
</html>
