<?php
error_reporting(0);
ob_start();
include '../includes/config.php';
require_once '../acuarela-app-web/includes/env.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['ok' => false, 'message' => 'Método no permitido']);
    exit;
}

if (!isset($_SESSION['temp_2fa'])) {
    ob_clean();
    echo json_encode(['ok' => false, 'message' => 'Sesión expirada. Por favor inicia sesión nuevamente.']);
    exit;
}

$tempData = $_SESSION['temp_2fa'];
$email = $tempData['email'];
// Intentar obtener el nombre del backup de la sesión
$name = $tempData['session_backup']['user']->name ?? 'Usuario';

// Generar NUEVO código
$code = rand(100000, 999999);

// Actualizar sesión con nuevo código y renovar tiempo
$_SESSION['temp_2fa']['code'] = $code;
$_SESSION['temp_2fa']['timestamp'] = time();

$mergeVars = [
    'CODE' => $code,
    'FNAME' => $name
];

try {
    $a->send_notification(
        'info@acuarela.app',
        $email,
        $name,
        $a->transformMergeVars($mergeVars),
        "Tu código de verificación",
        'portal-miembros-2fa',
        Env::get('MANDRILL_API_KEY', 'maRkSStgpCapJoSmwHOZDg'),
        "Bilingual Childcare Training"
    );

    ob_clean();
    echo json_encode(['ok' => true, 'message' => 'Código reenviado correctamente']);
} catch (Exception $e) {
    error_log("Error resending 2FA: " . $e->getMessage());
    ob_clean();
    echo json_encode(['ok' => false, 'message' => 'Error al enviar el correo. Intenta nuevamente.']);
}
