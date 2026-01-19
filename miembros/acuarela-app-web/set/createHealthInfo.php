<?php
session_start();
include "../includes/sdk.php";
$a = new Acuarela();
$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true); // Decodificar como array

// Cifrar datos sensibles de salud antes de enviar
$data = $a->encryptHealthData($data);

$healthinfo = $a->postHealthinfo(json_encode($data));
echo json_encode($healthinfo);
?>