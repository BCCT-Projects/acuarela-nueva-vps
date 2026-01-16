<?php 
session_start();
include "../includes/sdk.php";
$a = new Acuarela();

// Explicit inputs with sanitization
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$calle = filter_input(INPUT_POST, 'calle', FILTER_SANITIZE_SPECIAL_CHARS);
$depto_unidad = filter_input(INPUT_POST, 'depto-unidad', FILTER_SANITIZE_SPECIAL_CHARS);
$fecha_nacimiento = filter_input(INPUT_POST, 'fecha-de-nacimiento', FILTER_SANITIZE_SPECIAL_CHARS);
$ciudad = filter_input(INPUT_POST, 'ciudad', FILTER_SANITIZE_SPECIAL_CHARS);
$apellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL); // Captured but not used in data? Original didn't use it in $data.
$nombres = filter_input(INPUT_POST, 'nombres', FILTER_SANITIZE_SPECIAL_CHARS);
$telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_SPECIAL_CHARS);
$photoID = filter_input(INPUT_POST, 'photoID', FILTER_SANITIZE_SPECIAL_CHARS);
$estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_SPECIAL_CHARS);
$nivel_educativo = filter_input(INPUT_POST, 'nivel-educativo', FILTER_SANITIZE_SPECIAL_CHARS);
$codigo_postal = filter_input(INPUT_POST, 'codigo-postal', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$id) {
    echo json_encode(['error' => 'Missing ID']);
    exit;
}

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
    "name" => $nombres,
    "phone" => $telefono,
    "photo" => $photoID,
    "state" => $estado,
    "study" => $nivel_educativo,
    "zipcode" => $codigo_postal
];
$asistente = $a->editAsistente($id, $data);
echo json_encode($asistente);
?>
