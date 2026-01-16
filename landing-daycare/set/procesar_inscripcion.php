<?php
// Mostrar errores de PHP (esto es útil para depuración, puedes desactivarlo en producción)
// Mostrar errores desactivado para producción
ini_set('display_errors', 0);
error_reporting(E_ALL);

// Explicit inputs
$correo_acudiente = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);
$nombre_acudiente = filter_input(INPUT_POST, 'acudiente', FILTER_SANITIZE_SPECIAL_CHARS);
$nombre_nino = filter_input(INPUT_POST, 'nino', FILTER_SANITIZE_SPECIAL_CHARS);
$edad_nino = filter_input(INPUT_POST, 'edad', FILTER_SANITIZE_SPECIAL_CHARS);
$daycare = filter_input(INPUT_POST, 'daycare', FILTER_SANITIZE_SPECIAL_CHARS);

// Verificar que los datos estén presentes
if (empty($nombre_acudiente) || empty($correo_acudiente) || empty($nombre_nino) || empty($edad_nino)) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos en el formulario.']);
    exit();
}

// Obtener el ID del website (daycare)
$api_url = "https://acuarelacore.com/api/websites?nombre=" . urlencode($daycare);
$response = file_get_contents($api_url);

// Verificar que la respuesta de la API sea válida
if ($response === false) {
    echo json_encode(['success' => false, 'message' => 'Error al obtener los datos del daycare.']);
    exit();
}

// Decodificar la respuesta de la API
$data = json_decode($response, true);

// Verificar que el JSON sea válido y contenga el campo 'id'
if (isset($data[0]['id'])) {
    $websiteId = $data[0]['id'];
} else {
    echo json_encode(['success' => false, 'message' => 'No se encontró el ID del daycare.']);
    exit();
}

if (isset($data[0]['correo'])) {
    $websiteEmail = $data[0]['correo'];
}

if (isset($data[0]['idioma'])) {
    $websiteIdioma = $data[0]['idioma'];
}

if (isset($data[0]['color_1'])) {
    $websiteColor = $data[0]['color_1'];
}

if (isset($data[0]['logo_web']['url'])) {
    $logoUrl = $data[0]['logo_web']['url'];
}

// POST para registrar la preinscripción
$api_url_preinscripcion = "https://acuarelacore.com/api/preinscripciones";

// Datos a enviar en el POST
$post_data = [
    'nombre_acudiente' => $nombre_acudiente,
    'correo_acudiente' => $correo_acudiente,
    'nombre_nino' => $nombre_nino,
    'edad_nino' => $edad_nino,
    'website' => $websiteId
];

// Configurar los encabezados para enviar la solicitud como JSON
$options = [
    'http' => [
        'method' => 'POST',
        'header' => "Content-Type: application/json\r\n",
        'content' => json_encode($post_data)
    ]
];

$context = stream_context_create($options);
$response_preinscripcion = file_get_contents($api_url_preinscripcion, false, $context);

// Verificar la respuesta del POST
if ($response_preinscripcion === false) {
    echo json_encode(['success' => false, 'message' => 'Error al enviar la preinscripción.']);
    exit();
}

// Decodificar la respuesta del POST
$data_preinscripcion = json_decode($response_preinscripcion, true);

// Verificar si la respuesta fue decodificada correctamente
if ($data_preinscripcion === null) {
    echo json_encode(['success' => false, 'message' => 'Error al decodificar la respuesta de la API.']);
    exit();
}

// Verificar si la preinscripción fue exitosa, basado en la presencia de 'id'
if ($data_preinscripcion && isset($data_preinscripcion['id']) && !empty($data_preinscripcion['id'])) {

    // Enviar datos al webhook de Make
    $webhook_url = "https://hook.us1.make.com/d1upss6udmll79jeliqdjkvw6ble3opa";
    $webhook_data = json_encode([
        'nombre_acudiente' => $nombre_acudiente,
        'correo_acudiente' => $correo_acudiente,
        'nombre_nino' => $nombre_nino,
        'edad_nino' => $edad_nino,
        'daycare' => $daycare,
        'website_email' => $websiteEmail,
        'website_idioma' => $websiteIdioma,
        'website_color' => $websiteColor,
        'website_logo' => $logoUrl
    ]);

    $webhook_options = [
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => $webhook_data
        ]
    ];

    $webhook_context = stream_context_create($webhook_options);
    file_get_contents($webhook_url, false, $webhook_context);

    echo json_encode(['success' => true, 'message' => 'Inscripción exitosa.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al registrar la preinscripción.']);
}