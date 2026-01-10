<?php
// Ruta al archivo JSON
$jsonFile = '../interfaz.json';

// Leer el contenido del archivo JSON
$jsonData = file_get_contents($jsonFile);

// Decodificar el contenido JSON en un array PHP
$arrayData = json_decode($jsonData, true);

// Verificar si la decodificación fue exitosa
if ($arrayData === null && json_last_error() !== JSON_ERROR_NONE) {
    die('Error al decodificar el archivo JSON.');
}

// Imprimir el JSON decodificado
echo json_encode($arrayData, JSON_PRETTY_PRINT);

?>
