<?php 
    session_start();
    include "../includes/sdk.php";
    $a = new Acuarela();
    $data = file_get_contents('php://input');

    // Debug para ver qué datos llegan
    error_log("Datos recibidos en PHP: " . $data);

    $healthinfo = $a->putHealthinfo($data);

    // Debug para ver la respuesta de Strapi
    error_log("Respuesta de Strapi: " . json_encode($healthinfo));

    echo json_encode($healthinfo);
?>
