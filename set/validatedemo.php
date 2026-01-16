<?php
include '../includes/config.php';

// Obtener el cuerpo de la solicitud POST
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

function createLead($data, $a)
{
    $name = filter_var($data['name'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $lastName = filter_var($data['lastName'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_var($data['email'] ?? '', FILTER_VALIDATE_EMAIL);
    // $phone = $data['phone'];
    $fuenteComunicacion = filter_var($data['fuenteComunicacion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $servicioInteres = filter_var($data['servicioInteres'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $daycareName = filter_var($data['daycareName'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($email && isset($a)) {
        $leadCreated = $a->createLead($name, $lastName, $email, "0000000000", $servicioInteres, $fuenteComunicacion, $daycareName);
        if ($leadCreated) {
            return ['success' => true, 'message' => 'Lead creado.'];
        } else {
            return ['success' => false, 'message' => 'Lead no creado.'];
        }
    } else {
        return ['success' => false, 'message' => 'Correo no proporcionado o inválido.'];
    }
}

$response = ['success' => false, 'message' => 'Error interno'];
if (isset($a)) {
    $response = createLead($data, $a);
}

http_response_code($response['success'] ? 200 : 400);
echo json_encode($response);
