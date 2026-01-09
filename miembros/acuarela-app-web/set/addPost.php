<?php
session_start();
include "../includes/sdk.php";

$a = new Acuarela();

// Validar si hay datos enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Datos enviados desde el cliente
    $content = $_POST['content'] ?? null;
    $activityID = $_POST['activity'] ?? null;
    $userID = $a->userID;
    $images = $_FILES['images'] ?? null;
    // Validar campos obligatorios
    if (!$content || !$activityID) {
        echo json_encode(['error' => 'El contenido y la actividad son obligatorios.']);
        http_response_code(400);
        exit;
    }

    // Subir imágenes a Strapi si existen
    $uploadedMedia = [];
    if ($images && is_array($images['tmp_name'])) {
        foreach ($images['tmp_name'] as $index => $tmpName) {
            $fileData = [
                'tmp_name' => $tmpName,
                'type' => $images['type'][$index],
                'name' => $images['name'][$index],
            ];
            $uploadResponse = $a->uploadImage($fileData);
            if (isset($uploadResponse['id'])) {
                $uploadedMedia[] = $uploadResponse['id'];
            } else {
                echo json_encode(['error' => 'Error al subir una de las imágenes.']);
                http_response_code(400);
                exit;
            }
        }
    }

    // Crear datos para el post

    // Create a DateTime object
    $date = new DateTime();

    // Format the date to ISO 8601 with milliseconds and Zulu time (UTC)
    $formattedDate = $date->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d\TH:i:s.v\Z');
    $postData = [
        'content' => $content,
        'activity' => $activityID,
        'media' => $uploadedMedia, // IDs de las imágenes subidas
        'acuarelauser' => $userID,
        'datetime' => $formattedDate,        
        'date' => $formattedDate,
    ];


    // Crear la publicación a través del SDK
    $postResponse = $a->createPost($postData);
    // var_dump($postResponse);
    // Responder según el resultado
    if ($postResponse->ok) {
        echo json_encode(['success' => 'Publicación creada correctamente', 'post' => $postResponse]);
        http_response_code(200);
    } else {
        echo json_encode(['error' => 'Error al crear la publicación.']);
        http_response_code(400);
    }
} else {
    echo json_encode(['error' => 'Método no permitido']);
    http_response_code(405);
}
