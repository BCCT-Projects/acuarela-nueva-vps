<?php
header('Content-Type: application/json');

// Obtener el contenido de la solicitud POST
$input = json_decode(file_get_contents('php://input'), true);

// Verificar si se recibió el activityId
if (isset($input['activityId'])) {
    $activityId = $input['activityId'];

    $url = "https://acuarelacore.com/api/actividades?id_wordpress=" . $activityId; 

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ejecutar la llamada cURL
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Verificar el código de respuesta
    if ($httpCode === 200) {
        // Devolver la respuesta del endpoint
        echo $response;
    } else {
        echo json_encode(['error' => 'Error al obtener los datos del endpoint']);
    }
} else {
    echo json_encode(['error' => 'No se proporcionó activityId']);
}