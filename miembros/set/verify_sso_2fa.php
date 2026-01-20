<?php
/**
 * Endpoint para verificar código 2FA del auto-login SSO
 * Establece sesión completa y activa el daycare
 */
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display, we'll log them
ini_set('log_errors', 1);
ob_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../includes/config.php';

// Limpiar cualquier output previo
ob_clean();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'message' => 'Método no permitido']);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$code = $data['code'] ?? null;
$token = $data['token'] ?? null;

if (!$code || !$token) {
    ob_clean();
    echo json_encode(['ok' => false, 'message' => 'Código y token requeridos']);
    exit;
}

// Verificar sesión temporal 2FA
error_log("DEBUG SSO: Verificando sesión temp_sso_2fa. Session ID: " . session_id());
error_log("DEBUG SSO: Session keys: " . print_r(array_keys($_SESSION), true));

if (!isset($_SESSION['temp_sso_2fa'])) {
    error_log("ERROR SSO: temp_sso_2fa no existe en sesión");
    ob_clean();
    echo json_encode(['ok' => false, 'message' => 'Sesión expirada. Por favor intenta nuevamente desde el portal.']);
    exit;
}

error_log("DEBUG SSO: temp_sso_2fa encontrada. Código esperado: " . $_SESSION['temp_sso_2fa']['code']);

$tempData = $_SESSION['temp_sso_2fa'];

// SEGURIDAD: Verificar límite de intentos fallidos (máximo 5)
if (isset($tempData['attempts']) && $tempData['attempts'] >= 5) {
    unset($_SESSION['temp_sso_2fa']);
    ob_clean();
    echo json_encode(['ok' => false, 'message' => 'Demasiados intentos fallidos. Por favor genera un nuevo código desde el portal.']);
    exit;
}

// Verificar código y expiración (15 minutos)
if ($code != $tempData['code']) {
    // SEGURIDAD: Incrementar contador de intentos fallidos
    $_SESSION['temp_sso_2fa']['attempts'] = ($tempData['attempts'] ?? 0) + 1;

    $attemptsLeft = 5 - $_SESSION['temp_sso_2fa']['attempts'];
    ob_clean();
    echo json_encode([
        'ok' => false,
        'message' => "Código incorrecto. Te quedan $attemptsLeft intentos."
    ]);
    exit;
}

if ((time() - $tempData['timestamp']) > 900) {
    unset($_SESSION['temp_sso_2fa']);
    ob_clean();
    echo json_encode(['ok' => false, 'message' => 'Código expirado. Por favor intenta nuevamente.']);
    exit;
}

// Código válido - Establecer sesión completa
$userId = $tempData['user_id'];
$daycareId = $tempData['daycare_id'];

try {
    // Obtener información completa del usuario
    $userInfo = $a->queryStrapi("bilingual-users/" . $userId);
    $userInfoAll = $a->queryStrapi("bilingual-users/single/" . $userId);

    if (!isset($userInfo->id)) {
        throw new Exception("Usuario no encontrado");
    }

    // Establecer sesión
    $_SESSION['user'] = $userInfo;
    $_SESSION['userLogged'] = true;
    $_SESSION['userAll'] = $userInfoAll[0] ?? $userInfo;

    // Establecer daycare activo
    $_SESSION['activeDaycare'] = $daycareId;

    // Limpiar datos temporales
    unset($_SESSION['temp_sso_2fa']);

    error_log("SSO Auto-login successful for user: $userId, daycare: $daycareId");

    ob_clean();
    echo json_encode([
        'ok' => true,
        'message' => 'Verificación exitosa',
        'redirect' => '/miembros/acuarela-app-web/'
    ]);

} catch (Exception $e) {
    error_log("Error establishing SSO session: " . $e->getMessage());
    unset($_SESSION['temp_sso_2fa']);

    ob_clean();
    echo json_encode([
        'ok' => false,
        'message' => 'Error al establecer sesión. Intenta nuevamente.'
    ]);
}
?>