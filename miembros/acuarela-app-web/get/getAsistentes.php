<?php 
    session_start();
    include "../includes/sdk.php";
    $a = new Acuarela();
    $asistentes = $a->getAsistentes(isset($_GET['id']) ? $_GET['id']:"");
    echo json_encode($asistentes);