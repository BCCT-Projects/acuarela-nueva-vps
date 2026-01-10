<?php
// Iniciar la sesión
session_start();

// Verificar si la sesión del usuario está activa
if (isset($_SESSION["user"]) && isset($_SESSION["user"]->id)) {
    $userSessionID = $_SESSION["user"]->id;

    // Si se recibe un ID del cuerpo de la solicitud, lo podemos utilizar
    $data = json_decode(file_get_contents("php://input"), true);
    
    if (isset($data['userSessionID'])) {
        $userSessionID = $data['userSessionID'];
    }

    // URL de la API de Strapi
    $url = "https://acuarelacore.com/api/acuarelausers?bilingual_user=$userSessionID";

    // Inicializar cURL
    $curl = curl_init($url);
    
    // Configuración de cURL
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);

    // Ejecutar la llamada y obtener la respuesta
    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    
    // Cerrar cURL
    curl_close($curl);

    // Comprobar si la llamada fue exitosa
    if ($httpCode === 200) {
        header('Content-Type: application/json');
        echo $response;
    } else {
        http_response_code($httpCode);
        echo json_encode(['error' => 'Error fetching user data from Strapi.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'User session is required.']);
}