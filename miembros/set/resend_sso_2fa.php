<?php
/**
 * Endpoint para reenviar código 2FA en auto-login SSO
 */
error_reporting(0);
ob_start();
include '../includes/config.php';
require_once __DIR__ . '/../acuarela-app-web/includes/env.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Método no permitido']);
    exit;
}

if (!isset($_SESSION['temp_sso_2fa'])) {
    ob_clean();
    echo json_encode(['ok' => false, 'message' => 'Sesión expirada. Por favor intenta nuevamente desde el portal.']);
    exit;
}

$tempData = $_SESSION['temp_sso_2fa'];
$email = $tempData['email'];
$userName = $tempData['token_data']['name'] ?? 'Usuario';

// Generar NUEVO código
$code = rand(100000, 999999);

// Actualizar sesión con nuevo código y renovar tiempo
$_SESSION['temp_sso_2fa']['code'] = $code;
$_SESSION['temp_sso_2fa']['timestamp'] = time();

$mergeVars = [
    'CODE' => $code,
    'FNAME' => $userName
];

try {
    $a->send_notification(
        'info@acuarela.app',
        $email,
        $userName,
        $a->transformMergeVars($mergeVars),
        "Tu código de verificación - Auto-login",
        'portal-miembros-2fa',
        Env::get('MANDRILL_API_KEY', 'maRkSStgpCapJoSmwHOZDg'),
        "Acuarela App"
    );

    error_log("SSO 2FA code resent to: $email");

    ob_clean();
    echo json_encode(['ok' => true, 'message' => 'Código reenviado correctamente']);
} catch (Exception $e) {
    error_log("Error resending SSO 2FA: " . $e->getMessage());
    ob_clean();
    echo json_encode(['ok' => false, 'message' => 'Error al enviar el correo. Intenta nuevamente.']);
}
?>