<?php 
session_start();
include "../includes/sdk.php";

// Crear instancia de Acuarela
$a = new Acuarela();

// Leer datos de entrada
$data = file_get_contents('php://input');
$data = json_decode($data);

// Verificar si la lectura de datos fue exitosa
if ($data === false) {
    http_response_code(400);
    echo json_encode(['error' => 'Error al leer los datos de entrada']);
    exit();
}

// Validar y procesar el tipo de operación
if (isset($_GET['type'])) {
    $type = $_GET['type'];
    
    if ($type === 'checkin') {
        try {
            $result = $a->checkIn($data);
            echo json_encode($result);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error en el proceso de check-in: ' . $e->getMessage()]);
        }
    } elseif ($type === 'checkout') {
        try {
            $result = $a->checkOut($data);
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
