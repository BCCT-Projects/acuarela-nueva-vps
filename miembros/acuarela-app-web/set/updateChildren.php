<?php
session_start();
include "../includes/sdk.php";
$a = new Acuarela();
$data = file_get_contents('php://input');
$data = json_decode($data, true); // Decodificar como array

// Cifrar datos sensibles antes de enviar a Strapi
if (isset($data['data'])) {
    $data['data'] = $a->encryptChildData($data['data']);
}

$posts = $a->updateChildren($data['id'], json_encode($data['data']));
echo json_encode($posts);
?>