<?php
include '../includes/config.php';
require_once __DIR__ . '/../cron/AuditLogger.php';
require_once __DIR__ . '/../../includes/SecurityAuditLogger.php';

$logger = new AuditLogger();

header('Content-Type: application/json');

$response = ['ok' => false, 'message' => 'Código inválido'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($code)) {
        echo json_encode(['ok' => false, 'message' => 'Código requerido']);
        exit;
    }

    // Verificar si hay una sesión 2FA pendiente
    if (!isset($_SESSION['temp_2fa'])) {
        $logger->log('LOGIN_2FA_ERROR', ['message' => 'Attempted 2FA without active session']);
        echo json_encode(['ok' => false, 'message' => 'Sesión expirada. Por favor inicie sesión nuevamente.']);
        exit;
    }

    $tempData = $_SESSION['temp_2fa'];
    $email = $tempData['email'] ?? 'unknown';

    // Verificar código y expiración (15 minutos) con comparación estricta
    if ((string)$code === (string)$tempData['code'] && (time() - $tempData['timestamp'] < 900)) {

        // Session Fixation Protection: Regenerar ID de sesión al elevar privilegios
        session_regenerate_id(true);

        // RESTAURAR SESIÓN DE SEGURIDAD
        if (isset($tempData['session_backup'])) {
            $backup = $tempData['session_backup'];
            $_SESSION['user'] = $backup['user'];
            $_SESSION['userLogged'] = $backup['userLogged'];
            $_SESSION['userAll'] = $backup['userAll'];
        } else {
            // Fallback
            $_SESSION['user'] = $tempData['user_data'] ?? null;
        }

        // Log Success
        $logger->log('LOGIN_SUCCESS', [
            'email' => $email,
            'email' => $email,
            'message' => '2FA Verified successfully'
        ]);
        SecurityAuditLogger::log('auth_login_success', SecurityAuditLogger::SEVERITY_INFO, ['email' => $email]);

        // Limpiar temp
        unset($_SESSION['temp_2fa']);

        echo json_encode(['ok' => true, 'redirect' => '/miembros/acuarela-app-web/cambiar-daycare?fromLogin=1']);
    } else {
        $logger->log('LOGIN_2FA_FAILED', [
            'email' => $email,
            'reason' => 'Invalid code or expired'
        ]);
        SecurityAuditLogger::log('auth_login_failed', SecurityAuditLogger::SEVERITY_WARN, ['email' => $email, 'reason' => 'Invalid 2FA code']);
        // Retardo intencional
        usleep(rand(200000, 500000));
        echo json_encode(['ok' => false, 'message' => 'Código incorrecto o expirado']);
    }
} else {
    echo json_encode(['ok' => false, 'message' => 'Método no permitido']);
}
