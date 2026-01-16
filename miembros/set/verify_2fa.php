<?php
include '../includes/config.php';

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
        echo json_encode(['ok' => false, 'message' => 'Sesión expirada. Por favor inicie sesión nuevamente.']);
        exit;
    }

    $tempData = $_SESSION['temp_2fa'];

    // Verificar código y expiración (ej. 15 minutos)
    if ($code == $tempData['code'] && (time() - $tempData['timestamp'] < 900)) {

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

        // Limpiar temp
        unset($_SESSION['temp_2fa']);

        echo json_encode(['ok' => true, 'redirect' => '/miembros/acuarela-app-web/cambiar-daycare?fromLogin=1']);
    } else {
        echo json_encode(['ok' => false, 'message' => 'Código incorrecto o expirado']);
    }
} else {
    echo json_encode(['ok' => false, 'message' => 'Método no permitido']);
}
