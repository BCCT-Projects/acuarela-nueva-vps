<?php 
session_start();
include "../includes/sdk.php";
$a = new Acuarela();

// Explicit inputs with sanitization
$calle = filter_input(INPUT_POST, 'calle', FILTER_SANITIZE_SPECIAL_CHARS);
$depto_unidad = filter_input(INPUT_POST, 'depto-unidad', FILTER_SANITIZE_SPECIAL_CHARS);
$fecha_nacimiento = filter_input(INPUT_POST, 'fecha-de-nacimiento', FILTER_SANITIZE_SPECIAL_CHARS);
$ciudad = filter_input(INPUT_POST, 'ciudad', FILTER_SANITIZE_SPECIAL_CHARS);
$apellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$nombres = filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_SPECIAL_CHARS);
$telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_SPECIAL_CHARS);
$photoID = filter_input(INPUT_POST, 'photoID', FILTER_SANITIZE_SPECIAL_CHARS);
$estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_SPECIAL_CHARS);
$nivel_educativo = filter_input(INPUT_POST, 'nivel-educativo', FILTER_SANITIZE_SPECIAL_CHARS);
$codigo_postal = filter_input(INPUT_POST, 'codigo-postal', FILTER_SANITIZE_SPECIAL_CHARS);

// Basic validation for required fields
if (!$nombres || !$apellidos || !$email) {
    echo json_encode(['error' => 'Missing required fields (nombres, apellidos, email)']);
    exit;
}

// Generar contraseña temporal segura (12 caracteres alfanuméricos)
function generarContrasenaTemporal($length = 12) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    $max = strlen($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $password .= $chars[random_int(0, $max)];
    }
    return $password;
}

$contrasenaTemporal = generarContrasenaTemporal();

// Reestructurar los datos
$data = [
    "address" => [
        "number" => $calle,
        "street" => $depto_unidad,
        "complement" => ""
    ],
    "birthdate" => $fecha_nacimiento,
    "city" => $ciudad,
    "lastname" => $apellidos,
    "mail" => $email,
    "name" => $nombres,
    "phone" => $telefono,
    "photo" => $photoID,
    "rols" => ["5ff78fd55d6f2e272cfd7392"],
    "state" => $estado,
    "status" => true,
    "study" => $nivel_educativo,
    "zipcode" => $codigo_postal,
    "pass" => $contrasenaTemporal
];

$asistente = $a->createAsistente($data);

// Si se creó correctamente, enviar email de activación
// La respuesta del API tiene estructura: {"status":200,"entity":{"_id":"..."}}
if (isset($asistente->entity->_id) || isset($asistente->entity->id)) {
    $asistente_id = $asistente->entity->_id ?? $asistente->entity->id;
    
    // Enviar correo de activación al nuevo asistente
    $mergeVars = [
        'NOMBRE' => $nombres,
        'APELLIDO' => $apellidos,
        'EMAIL' => $email,
        'DAYCARE' => $a->daycareInfo->name ?? 'Acuarela'
    ];
    
    try {
        $a->sendActivacionAsistente(
            $email,
            $nombres . ' ' . $apellidos,
            $asistente_id,
            $a->daycareInfo->name ?? 'Acuarela'
        );
    } catch (Exception $e) {
        // Log del error pero no interrumpir el flujo
        error_log("Error enviando email de activación: " . $e->getMessage());
    }
}

echo json_encode($asistente);
?>
