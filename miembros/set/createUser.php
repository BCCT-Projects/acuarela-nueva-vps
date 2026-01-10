<?php
include '../includes/config.php';
$array = array();

extract($_POST);

// Lista de IDs de imágenes predeterminadas
$defaultImageIDs = array(
    '66bd1a08815f2bf34da9dc89', 
    '66bd1a28815f2bf34da9dc8a', 
    '66bd1a3d815f2bf34da9dc8b', 
    '66bd1a4b815f2bf34da9dc8c', 
    '66bd1a5a815f2bf34da9dc8d',
    '66bd1a6a815f2bf34da9dc8e' 
);

// Verificar si `photoID` está vacío para asignarle una imagen por default
if (empty($photoID)) {
    $photoID = $defaultImageIDs[array_rand($defaultImageIDs)];
}

$response = $a->createAcuarelaUser($name, $lastname, $email, $phone, $password, $daycare, $license, $state, $phonedaycare, $emaildaycare, $expiration, $threadId, $estadoValue, $daycareValue, $photoID);
$array['response'] = $response;

// Realizar el login
$userLogin = $a->loginBilingualUser($email, $password);

echo json_encode($array);
