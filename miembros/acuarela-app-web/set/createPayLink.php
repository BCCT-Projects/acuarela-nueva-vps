<?php
/**
 * Guarda un nuevo pago pendiente en la base de datos
 *
 * Recibe los datos del formulario y crea un registro en movements
 * con el link de pago de Stripe en extra_info
 */
require_once __DIR__ . "/../includes/config.php";

header('Content-Type: application/json');

// Debug info
$debug = [
    'session_activeDaycare' => $_SESSION['activeDaycare'] ?? 'NO DEFINIDO',
    'session_user_exists' => isset($_SESSION['user']),
    'sdk_daycareID' => $a->daycareID ?? 'NULL',
];

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
$payment_link = filter_input(INPUT_POST, 'payment_link', FILTER_SANITIZE_URL);

// Validar parámetros requeridos
if (!$name || !$amount || !$date || !$payment_link) {
    http_response_code(400);
    echo json_encode(["error" => "Missing required parameters", "debug" => $debug]);
    exit;
}

try {
    // $a ya está definido por config.php

    // Validar que el daycareID esté disponible
    if (empty($a->daycareID)) {
        http_response_code(400);
        echo json_encode([
            "error" => "No hay un daycare activo seleccionado",
            "debug" => $debug
        ]);
        exit;
    }

    // Preparar los datos - guardar el link de Stripe en extra_info
    $data = [
        "name" => $name,
        "type_category" => "pago",
        "amount" => $amount,
        "date" => $date,
        "status" => true,
        "type" => 2,  // 2 = Pago pendiente
        "daycare" => $a->daycareID,
        "extra_info" => $payment_link,
        "payer_name" => "Pago pendiente"
    ];

    $debug['data_to_save'] = $data;

    // Guardar en la base de datos
    $movements = $a->setMovements($data);

    $debug['api_response'] = $movements;

    // Devolver respuesta con debug incluido
    echo json_encode([
        "success" => true,
        "data" => $movements,
        "debug" => $debug
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "An unexpected error occurred",
        "debug" => $debug,
        "exception" => $e->getMessage()
    ]);
}
?>
