<?php 
session_start();
include "../includes/sdk.php";
$a = new Acuarela();
// Asegúrate de validar y sanitizar los datos antes de usarlos.
$id = $_POST['id'] ?? '';
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