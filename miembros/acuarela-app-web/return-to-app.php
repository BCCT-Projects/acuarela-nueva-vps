<?php
session_start();
include "includes/sdk.php";
include "includes/env.php";

$error = null;
$success = false;
$stripeAccountId = isset($_GET["id"]) ? $_GET["id"] : null;

// Guardar el idStripe en el daycare
if ($stripeAccountId) {
    try {
        $a = new Acuarela();
        $result = $a->updateDaycareInfo(['idStripe' => $stripeAccountId]);

        if ($result && isset($result->id)) {
            $success = true;
        } else {
            $error = "La respuesta de la API no fue la esperada";
            error_log("Stripe Connect - updateDaycareInfo response: " . json_encode($result));
        }
    } catch (Exception $e) {
        $error = "Error al guardar: " . $e->getMessage();
        error_log("Stripe Connect - Error saving idStripe: " . $e->getMessage());
    }
} else {
    $error = "No se recibió el ID de la cuenta Stripe";
}

// URL de redirección para la web
$appUrl = Env::get('APP_URL', 'https://acuarela.app/miembros/acuarela-app-web');
$redirectUrl = $appUrl . '/configuracion#metodos';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultado de vinculación - Acuarela</title>
  <meta http-equiv="refresh" content="5; url=<?= $redirectUrl ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #333;
      margin: 0;
    }
    .container {
      background: #fff;
      padding: 2.5rem 3rem;
      border-radius: 1rem;
      box-shadow: 0 4px 20px rgba(0,0,0,0.15);
      text-align: center;
      max-width: 420px;
    }
    .success-icon {
      background: #00A099;
      color: white;
      width: 70px;
      height: 70px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem auto;
      font-size: 2rem;
    }
    .error-icon {
      background: #ef4444;
    }
    h1 {
      font-size: 1.6rem;
      margin-bottom: 0.5rem;
      color: #1e293b;
    }
    p {
      font-size: 1rem;
      margin-bottom: 1rem;
      color: #64748b;
      line-height: 1.6;
    }
    .btn {
      display: inline-block;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 12px 28px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
    .status {
      font-size: 0.85rem;
      color: #94a3b8;
      margin-top: 1.5rem;
      padding-top: 1rem;
      border-top: 1px solid #e2e8f0;
    }
    .spinner {
      display: inline-block;
      width: 16px;
      height: 16px;
      border: 2px solid #e2e8f0;
      border-top-color: #667eea;
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin-right: 8px;
      vertical-align: middle;
    }
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
</head>
<body>
  <div class="container">
    <?php if ($success): ?>
      <div class="success-icon">✓</div>
      <h1>¡Cuenta vinculada!</h1>
      <p>Tu cuenta de Stripe ha sido vinculada correctamente. Ya puedes recibir pagos de los padres.</p>
      <p style="font-size: 0.85rem; color: #94a3b8; margin-bottom: 1rem;">ID: <?= htmlspecialchars($stripeAccountId) ?></p>
    <?php elseif ($error): ?>
      <div class="success-icon error-icon">✗</div>
      <h1>Error al vincular</h1>
      <p style="color: #dc2626;"><?= htmlspecialchars($error) ?></p>
      <?php if ($stripeAccountId): ?>
        <p style="font-size: 0.85rem; color: #94a3b8;">ID de cuenta: <?= htmlspecialchars($stripeAccountId) ?></p>
      <?php endif; ?>
    <?php else: ?>
      <div class="success-icon" style="background: #94a3b8;">?</div>
      <h1>Sin datos</h1>
      <p>No se recibió información de Stripe.</p>
    <?php endif; ?>
    <a href="<?= $redirectUrl ?>" class="btn">Ir a Configuración</a>
    <div class="status">
      <span class="spinner"></span> Redirigiendo automáticamente...
    </div>
  </div>
</body>
</html>
