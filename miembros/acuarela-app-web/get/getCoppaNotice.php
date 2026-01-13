<?php
session_start();
include __DIR__ . "/../includes/sdk.php";
$a = new Acuarela();

// Obtener versión específica si se proporciona, sino la activa
$version = isset($_GET['version']) ? $_GET['version'] : null;

if ($version) {
    $coppaNotice = $a->getCoppaNoticeByVersion($version);
} else {
    $coppaNotice = $a->getCoppaNotice();
}

header('Content-Type: application/json');

$foundNotice = null;

// Normalizar la respuesta de Strapi (puede ser array directo o objeto con propiedad response)
if (is_array($coppaNotice) && !empty($coppaNotice)) {
    $foundNotice = $coppaNotice[0];
} elseif (is_object($coppaNotice)) {
    if (isset($coppaNotice->response) && is_array($coppaNotice->response) && !empty($coppaNotice->response)) {
        $foundNotice = $coppaNotice->response[0];
    } elseif (isset($coppaNotice->id)) {
        // Si devuelve un solo objeto directamente
        $foundNotice = $coppaNotice;
    }
}

if (!$foundNotice) {
    http_response_code(404);
    echo json_encode([
        "success" => false,
        "error" => "Aviso COPPA no encontrado"
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "data" => $foundNotice
]);
?>