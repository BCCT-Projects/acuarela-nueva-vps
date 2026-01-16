<?php
// Test simple del flujo COPPA
header('Content-Type: application/json');
ini_set('display_errors', 0);
error_log("TEST COPPA: Iniciando");

echo json_encode([
    "status" => "test_ok",
    "message" => "Script PHP funcionando correctamente",
    "timestamp" => date('Y-m-d H:i:s')
]);
error_log("TEST COPPA: Fin");
