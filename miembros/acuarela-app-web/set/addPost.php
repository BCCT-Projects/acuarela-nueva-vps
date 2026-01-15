<?php
session_start();
include "../includes/sdk.php";

$a = new Acuarela();

header('Content-Type: application/json');

try {
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
            // Configuración de seguridad
            $MAX_FILE_SIZE = 5 * 1024 * 1024; // 5 MB
            $ALLOWED_MIME_TYPES = [
                'image/jpeg' => 'jpg',
                'image/png' => 'png',
                'image/webp' => 'webp'
            ];

            foreach ($images['tmp_name'] as $index => $tmpName) {
                // 1. Validar errores de subida
                if ($images['error'][$index] !== UPLOAD_ERR_OK) {
                    $msg = 'Error en la subida del archivo: ' . $images['name'][$index];
                    error_log("[SECURITY] Upload error: $msg IP:" . $_SERVER['REMOTE_ADDR']);
                    echo json_encode(['error' => $msg]);
                    http_response_code(400);
                    exit;
                }

                // 2. Validar tamaño
                if ($images['size'][$index] > $MAX_FILE_SIZE) {
                    $msg = 'El archivo ' . $images['name'][$index] . ' excede el límite de 5MB.';
                    error_log("[SECURITY] Upload rejected (Size limit): " . $images['name'][$index] . " Size:" . $images['size'][$index] . " IP:" . $_SERVER['REMOTE_ADDR']);
                    echo json_encode(['error' => $msg]);
                    http_response_code(400);
                    exit;
                }

                // 3. Validar MIME Type Real (Fileinfo)
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $realMime = $finfo->file($tmpName);

                if (!array_key_exists($realMime, $ALLOWED_MIME_TYPES)) {
                    $msg = 'Tipo de archivo no permitido. Solo se permiten imágenes (JPG, PNG, WebP).';
                    error_log("[SECURITY] Upload rejected (Invalid MIME): " . $images['name'][$index] . " Detected: $realMime IP:" . $_SERVER['REMOTE_ADDR']);
                    echo json_encode(['error' => $msg]);
                    http_response_code(400);
                    exit;
                }

                // 4. Renombrado Seguro
                $extension = $ALLOWED_MIME_TYPES[$realMime];
                $randomName = bin2hex(random_bytes(16)); // 32 caracteres hex
                $safeFileName = $randomName . '.' . $extension;

                // Datos saneados para enviar al SDK
                $fileData = [
                    'tmp_name' => $tmpName,
                    'type' => $realMime,     // Usar el MIME real detectado, no el del cliente
                    'name' => $safeFileName, // Usar nombre aleatorio generado
                ];

                $uploadResponse = $a->uploadImage($fileData);
                if (isset($uploadResponse['id'])) {
                    $uploadedMedia[] = $uploadResponse['id'];
                } else {
                    $msg = 'Error al subir la imagen procesada a Strapi.';
                    error_log("[ERROR] SDK uploadImage failed for sanitized file: $safeFileName");
                    echo json_encode(['error' => $msg]);
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
} catch (Throwable $e) {
    error_log("[SECURITY] Uncaught Exception in addPost: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor: ' . $e->getMessage()]);
}
