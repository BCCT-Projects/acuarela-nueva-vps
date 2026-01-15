<?php
session_start();
include "../includes/sdk.php";

$a = new Acuarela();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$files = $_FILES['files'] ?? null;

if (!$files) {
    http_response_code(400);
    echo json_encode(['error' => 'No files uploaded']);
    exit;
}

// Configuración de seguridad
$MAX_FILE_SIZE = 5 * 1024 * 1024; // 5 MB
$ALLOWED_MIME_TYPES = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp',
    'application/pdf' => 'pdf', // Permitir PDF para documentos de inscripción
];

// Estandarizar la estructura de archivos (handle single vs multiple uploads)
// Si es un solo archivo, convertirlo a array para procesarlo igual
if (!is_array($files['tmp_name'])) {
    $files = [
        'name' => [$files['name']],
        'type' => [$files['type']],
        'tmp_name' => [$files['tmp_name']],
        'error' => [$files['error']],
        'size' => [$files['size']],
    ];
}

$uploadedResults = [];

foreach ($files['tmp_name'] as $index => $tmpName) {
    // 1. Validar errores de subida
    if ($files['error'][$index] !== UPLOAD_ERR_OK) {
        $msg = 'Error upload: ' . $files['name'][$index];
        error_log("[SECURITY] Upload error: $msg IP:" . $_SERVER['REMOTE_ADDR']);
        http_response_code(400);
        echo json_encode(['error' => $msg]);
        exit;
    }

    // 2. Validar tamaño
    if ($files['size'][$index] > $MAX_FILE_SIZE) {
        $msg = 'File ' . $files['name'][$index] . ' exceeds limit of 5MB.';
        error_log("[SECURITY] Upload rejected (Size): " . $files['name'][$index] . " Size:" . $files['size'][$index] . " IP:" . $_SERVER['REMOTE_ADDR']);
        http_response_code(400);
        echo json_encode(['error' => $msg]);
        exit;
    }

    // 3. Validar MIME Type Real
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $realMime = $finfo->file($tmpName);

    if (!array_key_exists($realMime, $ALLOWED_MIME_TYPES)) {
        $msg = 'Tipo de archivo no permitido. Solo se permiten imágenes (JPG, PNG, WebP) o documentos PDF.';
        error_log("[SECURITY] Upload rejected (MIME): " . $files['name'][$index] . " Detected: $realMime IP:" . $_SERVER['REMOTE_ADDR']);
        http_response_code(400);
        echo json_encode(['error' => $msg]);
        exit;
    }

    // 4. Renombrado Seguro
    $extension = $ALLOWED_MIME_TYPES[$realMime];
    $randomName = bin2hex(random_bytes(16));
    $safeFileName = $randomName . '.' . $extension;

    // Datos saneados para enviar al SDK
    $fileData = [
        'tmp_name' => $tmpName,
        'type' => $realMime,
        'name' => $safeFileName,
    ];

    // Usamos el metodo del SDK para subir a Strapi
    $uploadResponse = $a->uploadImage($fileData);

    if (isset($uploadResponse['id'])) {
        $uploadedResults[] = $uploadResponse;
    } else {
        error_log("[ERROR] SDK uploadImage failed for: $safeFileName");
        http_response_code(500);
        echo json_encode(['error' => 'Error uploading to backend storage']);
        exit;
    }
}

// Devuelve el array de resultados esperado por el frontend
echo json_encode($uploadedResults);
?>