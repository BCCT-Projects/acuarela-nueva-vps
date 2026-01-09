<?php 
    session_start();
    include "../includes/sdk.php";
    $a = new Acuarela();
    $data = file_get_contents('php://input');
    $inscripcion = $a->putInscripcion($data);
    echo json_encode($inscripcion);
?>