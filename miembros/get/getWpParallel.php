<?php
/**
 * Endpoint optimizado para múltiples consultas WordPress en paralelo
 * Reduce errores 524 al hacer todas las consultas en una sola petición PHP
 * usando multi-curl en lugar de múltiples peticiones HTTP separadas
 */
include '../includes/config.php';

// Obtener endpoints desde POST (puede ser JSON o array)
$endpoints = [];
if (isset($_POST["endpoints"])) {
    $endpoints = json_decode($_POST["endpoints"], true);
    if (!is_array($endpoints)) {
        $endpoints = [$_POST["endpoints"]];
    }
} elseif (isset($_POST["endpoint"])) {
    // Compatibilidad con el endpoint anterior
    $endpoints = [$_POST["endpoint"]];
}

if (empty($endpoints)) {
    http_response_code(400);
    echo json_encode(["error" => "No endpoints provided"]);
    exit;
}

// Usar queryWorpressParallel para hacer todas las consultas en paralelo
// Esto es mucho más eficiente que múltiples llamadas HTTP separadas
// Cache aumentado a 1 hora (3600s) para reducir carga en WordPress
$results = $a->queryWorpressParallel($endpoints, true, 3600);

// Si solo hay un endpoint, devolver directamente el resultado (compatibilidad)
if (count($endpoints) === 1) {
    echo json_encode($results[0] ?? []);
} else {
    // Devolver array asociativo con los resultados
    echo json_encode($results);
}
