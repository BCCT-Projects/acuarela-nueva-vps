<?php 
session_start();
include "../includes/sdk.php";

// Crear instancia de Acuarela
$a = new Acuarela();

// Leer datos de entrada
$data = file_get_contents('php://input');
$jsonData = json_decode($data); // Renamed to avoid confusion

// Verificar si la lectura de datos fue exitosa
if ($jsonData === null && json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['error' => 'Error al leer los datos de entrada']);
    exit();
}

// Validar y procesar el tipo de operación
$type = filter_input(INPUT_GET, 'type', FILTER_SANITIZE_SPECIAL_CHARS);

if ($type) {
    if ($type === 'checkin') {
        try {
            $result = $a->checkIn($jsonData);
            // Invalidar caché de niños para que Asistencia muestre el niño en daycare de inmediato
            $a->invalidateStrapiCache("children/?daycare=" . $a->daycareID);
            echo json_encode($result);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error en el proceso de check-in: ' . $e->getMessage()]);
        }
    } elseif ($type === 'checkout') {
        try {
            $result = $a->checkOut($jsonData);
            // Invalidar caché de niños para que Asistencia muestre el niño en casa de inmediato
            $a->invalidateStrapiCache("children/?daycare=" . $a->daycareID);
            echo json_encode($result);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error en el proceso de check-out: ' . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Tipo de operación no válido']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Falta el tipo de operación']);
}
?>
