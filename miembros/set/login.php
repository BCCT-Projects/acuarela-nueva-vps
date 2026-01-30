<?php
error_reporting(0);
ob_start();
include '../includes/config.php';
require_once __DIR__ . '/../cron/AuditLogger.php';
require_once __DIR__ . '/../../includes/SecurityAuditLogger.php';

$logger = new AuditLogger();

// Normaliza los datos
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_UNSAFE_RAW);

if (!$email || !$password) {
    echo json_encode(['status' => 'error', 'message' => 'Email y contraseña requeridos']);
    exit;
}
$email = strtolower(trim($email));

// SECURITY FIX: Removed password storage in session (was $_SESSION["estanoesunacontrasena"])
$userLogin = $a->loginBilingualUser($email, $password);

// Asegurar que los daycares estén disponibles en la respuesta
// Si $userLogin tiene estructura response[0], extraer el objeto
if (isset($userLogin->response) && is_array($userLogin->response) && !empty($userLogin->response)) {
    $userLogin = $userLogin->response[0];
}

if (isset($userLogin->id)) {
    // 2FA IMPLEMENTATION
    // Generar código de 6 dígitos
    $code = rand(100000, 999999);

    // Guardar datos temporales para 2FA
    $_SESSION['temp_2fa'] = [
        'session_backup' => [
            'user' => $_SESSION['user'],
            'userLogged' => $_SESSION['userLogged'],
            'userAll' => $_SESSION['userAll']
        ],
        'code' => $code,
        'timestamp' => time(),
        'email' => $email
    ];

    // SEGURIDAD CRÍTICA: Destruir sesión autenticada para evitar bypass
    // El usuario no debe tener acceso hasta que verifique el código
    unset($_SESSION['user']);
    unset($_SESSION['userLogged']);
    unset($_SESSION['userAll']);

    // Log 2FA Initiation
    $logger->log('LOGIN_CHALLENGE', [
        'email' => $email,
        'user_id' => $userLogin->id,
        'message' => 'Credentials verified, 2FA code sent'
    ]);
    SecurityAuditLogger::log('auth_mfa_challenge', SecurityAuditLogger::SEVERITY_INFO, ['email' => $email], $userLogin->id);

    // Enviar correo con el código
    // Usamos el template 'portal-miembros-2fa' (deberás crearlo en Mandrill o usar uno genérico por ahora)
    $mergeVars = [
        'CODE' => $code,
        'FNAME' => $userLogin->name ?? 'Usuario'
    ];

    try {


        $a->send_notification(
            'info@acuarela.app',
            $email,
            $userLogin->name,
            $a->transformMergeVars($mergeVars),
            "Tu código de verificación",
            'portal-miembros-2fa', // NOMBRE DEL TEMPLATE A CREAR
            '', // Dejar vacío para que use Env::get automáticamente
            "Bilingual Childcare Training",
            true // ASYNC = true para no bloquear el login esperando respuesta de Mandrill
        );
    } catch (Exception $e) {
        error_log("Error al enviar email 2FA: " . $e->getMessage());
        $logger->log('LOGIN_ERROR', [
            'email' => $email,
            'error' => 'Failed to send 2FA email: ' . $e->getMessage()
        ]);
        SecurityAuditLogger::log('system_mail_error', SecurityAuditLogger::SEVERITY_ERROR, ['email' => $email, 'error' => $e->getMessage()]);

        // Retornar error más descriptivo
        ob_clean();
        echo json_encode(['getError' => true, 'message' => 'Error al enviar email de verificación.']);
        exit;
    }

    // No iniciamos sesión completa aún, solo retornamos flag
    ob_clean(); // Limpiar cualquier output previo (warnings, espacios, etc)
    echo json_encode(['require_2fa' => true]);
    exit;
}

$logger->log('LOGIN_FAILED', [
    'email' => $email,
    'reason' => 'Invalid credentials or user not found'
]);
SecurityAuditLogger::log('auth_login_failed', SecurityAuditLogger::SEVERITY_WARN, ['email' => $email, 'reason' => 'Invalid credentials']);
ob_clean();
echo json_encode(['status' => 'error', 'message' => 'Email o contraseña incorrectos']);

