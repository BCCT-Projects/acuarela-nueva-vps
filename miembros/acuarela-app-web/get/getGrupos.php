<?php 
    session_start();
    include "../includes/sdk.php";
    $a = new Acuarela();
    $grupos = $a->getGrupos(isset($_GET['id']) ? $_GET['id']:"");
    echo json_encode($grupos);