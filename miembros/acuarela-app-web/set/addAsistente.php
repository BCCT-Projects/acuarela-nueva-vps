<?php 
session_start();
include "../includes/sdk.php";
$a = new Acuarela();

// Asegúrate de validar y sanitizar los datos antes de usarlos.
$calle = $_POST['calle'] ?? '';
$depto_unidad = $_POST['depto-unidad'] ?? '';
$fecha_nacimiento = $_POST['fecha-de-nacimiento'] ?? '';
$ciudad = $_POST['ciudad'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';
$email = $_POST['email'] ?? '';
$nombres = $_POST['nombres'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$photoID = $_POST['photoID'] ?? '';
$estado = $_POST['estado'] ?? '';
$nivel_educativo = $_POST['nivel-educativo'] ?? '';
$codigo_postal = $_POST['codigo-postal'] ?? '';

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