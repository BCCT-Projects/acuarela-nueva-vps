<?php
/**
 * Endpoint optimizado con manejo de errores y cache mejorado
 * Evita errores 524 con validación y respuestas defensivas
 */
include '../includes/config.php';

// Validar que se recibió el endpoint
if (!isset($_POST["endpoint"]) || empty($_POST["endpoint"])) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode(["error" => "No endpoint provided"]);
    exit;
}

$endpoint = $_POST["endpoint"];

// Intentar obtener resultado con cache
try {
    $w = $a->queryWorpress($endpoint, "", true, 3600); // Cache de 1 hora
    
    // Validar que el resultado sea válido
    if ($w === null) {
        // Si es null, intentar devolver array vacío en lugar de null
        $w = [];
    }
    
    // Asegurar que siempre sea un array
    if (!is_array($w)) {
        $w = [$w];
    }
    
    header('Content-Type: application/json');
    echo json_encode($w);
} catch (Exception $e) {
    // Manejo de errores: devolver array vacío en lugar de romper
    error_log("Error en getWp.php para endpoint: $endpoint - " . $e->getMessage());
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([]);
}