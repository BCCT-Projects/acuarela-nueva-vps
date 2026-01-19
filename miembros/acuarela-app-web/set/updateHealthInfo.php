<?php
session_start();
include "../includes/sdk.php";
$a = new Acuarela();
$rawData = file_get_contents('php://input');

// Debug para ver qué datos llegan
error_log("Datos recibidos en PHP: " . $rawData);

$data = json_decode($rawData, true); // Decodificar como array

// Cifrar datos sensibles de salud antes de enviar
$data = $a->encryptHealthData($data);

$healthinfo = $a->putHealthinfo(json_encode($data));

// Debug para ver la respuesta de Strapi
error_log("Respuesta de Strapi: " . json_encode($healthinfo));

echo json_encode($healthinfo);
?>