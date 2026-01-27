<?php
/**
 * Endpoint para validar token SSO y generar código 2FA
 * Similar a login.php pero para auto-login desde portal
 */
error_reporting(E_ALL);
ini_set('display_errors', 0); // SEGURIDAD: No mostrar errores en producción
ini_set('log_errors', 1);
ob_start();
include '../includes/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$token = $data['token'] ?? null;

if (!$token) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Token requerido']);
    exit;
}

// Separar payload y firma
$parts = explode('.', $token);
if (count($parts) !== 2) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Formato de token inválido']);
    exit;
}

list($tokenPayload, $signature) = $parts;

// Clave secreta compartida (debe ser igual que en portal)
$ssoSecret = 'BCCT_SSO_SECRET_KEY_2025_ACUARELA_PORTAL';

// Verificar firma
$expectedSignature = hash_hmac('sha256', $tokenPayload, $ssoSecret);

if (!hash_equals($expectedSignature, $signature)) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token inválido - firma no coincide']);
    exit;
}

// Decodificar payload
$tokenData = json_decode(base64_decode($tokenPayload), true);

if (!$tokenData) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Token corrupto']);
    exit;
}

// Verificar expiración (5 minutos)
$currentTime = time();
if ($currentTime > $tokenData['exp']) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token expirado. Por favor intenta nuevamente desde el portal.']);
    exit;
}

// SEGURIDAD: Validar que el token no haya sido usado antes (anti-replay)
$tokenHash = hash('sha256', $token);
if (isset($_SESSION['used_sso_tokens'][$tokenHash])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Token ya utilizado. Por favor genera uno nuevo desde el portal.']);
    exit;
}

// Extraer datos del token
$email = $tokenData['email'];
$userId = $tokenData['user_id'];
$daycareId = $tokenData['daycare_id'];
$userName = $tokenData['name'] ?? 'Usuario';

// Verificar que el usuario existe en Strapi
$userInfo = $a->queryStrapi("bilingual-users/" . $userId);

if (!isset($userInfo->id)) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
    exit;
}

// Generar código 2FA
$code = rand(100000, 999999);

// Guardar datos temporales para 2FA con el token SSO
$_SESSION['temp_sso_2fa'] = [
    'code' => $code,
    'timestamp' => time(),
    'email' => $email,
    'user_id' => $userId,
    'daycare_id' => $daycareId,
    'token_data' => $tokenData,
    'attempts' => 0,  // SEGURIDAD: Contador de intentos fallidos
    'token_hash' => $tokenHash  // SEGURIDAD: Hash del token para marcarlo como usado después
];

// SEGURIDAD: Marcar token como en uso (se marcará como completamente usado después de verificación exitosa)
if (!isset($_SESSION['used_sso_tokens'])) {
    $_SESSION['used_sso_tokens'] = [];
}
$_SESSION['used_sso_tokens'][$tokenHash] = time();

// SEGURIDAD: Limpiar tokens usados viejos (más de 1 hora)
foreach ($_SESSION['used_sso_tokens'] as $hash => $timestamp) {
    if (time() - $timestamp > 3600) {
        unset($_SESSION['used_sso_tokens'][$hash]);
    }
}

// Integrar AuditLogger
require_once __DIR__ . '/../cron/AuditLogger.php';
$logger = new AuditLogger();

// Enviar correo con el código de manera ASÍNCRONA
$mergeVars = [
    'CODE' => $code,
    'FNAME' => $userName
];

try {
    // SECURITY UPDATE: Async email sending (last param = true) to prevent login blocking
    $a->send_notification(
        'info@acuarela.app',
        $email,
        $userName,
        $a->transformMergeVars($mergeVars),
        "Tu código de verificación - Auto-login",
        'portal-miembros-2fa',
        '',
        "Acuarela App",
        true // ASYNC = TRUE corrección de velocidad
    );

    // Logging seguro usando AuditLogger
    $logger->log('SSO_CHALLENGE', [
        'email' => $email,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'status' => 'success',
        'method' => 'portal_autologin'
    ]);

    // CRÍTICO: Escribir la sesión antes de responder
    // Sin esto, la sesión podría no guardarse antes de que llegue la siguiente petición
    session_write_close();

    // Limpiar buffers antes de enviar JSON
    // (Importante si el logger o algo más imprimió output accidentalmente)
    while (ob_get_level())
        ob_end_clean();

    echo json_encode([
        'success' => true,
        'message' => 'Código de verificación enviado',
        'email_hint' => substr($email, 0, 3) . '***@' . substr(strstr($email, '@'), 1),
        'debug_async' => true
    ]);
} catch (Exception $e) {
    error_log("Error sending SSO 2FA email: " . $e->getMessage());
    ob_clean();
    echo json_encode([
        'success' => false,
        'message' => 'Error al enviar código de verificación. Intenta nuevamente.'
    ]);
}
?>