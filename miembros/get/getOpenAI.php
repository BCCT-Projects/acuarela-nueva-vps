<?php 
include '../includes/config.php';

// Obtener el cuerpo de la solicitud POST
$request_body = file_get_contents('php://input');
$request_data = json_decode($request_body, true);

$endpoint = $request_data['endpoint']; // Endpoint para el GET

// Enviar la solicitud GET al endpoint de OpenAI
$response = $a->getRequestOpenAi($endpoint);

// Devolver la respuesta
http_response_code($response['status']);
echo json_encode($response['response']);
