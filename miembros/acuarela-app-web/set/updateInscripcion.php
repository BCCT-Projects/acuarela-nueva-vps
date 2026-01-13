<?php
session_start();
include "../includes/sdk.php";
$a = new Acuarela();
$data = file_get_contents('php://input');

// Validación Backend de COPPA
$obj = json_decode($data);
if (isset($obj->status) && $obj->status == 'Finalizado') {
    if (empty($obj->coppa_consent) || $obj->coppa_consent !== true) {
        http_response_code(400);
        echo json_encode([
            "statusCode" => 400,
            "error" => "Bad Request",
            "message" => "El consentimiento COPPA es obligatorio para finalizar la inscripción."
        ]);
        exit;
    }
}

$inscripcion = $a->putInscripcion($data);
echo json_encode($inscripcion);
?>