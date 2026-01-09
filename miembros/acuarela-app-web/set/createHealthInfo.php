<?php 
    session_start();
    include "../includes/sdk.php";
    $a = new Acuarela();
    $data = file_get_contents('php://input');
    $healthinfo = $a->postHealthinfo($data);
    echo json_encode($healthinfo);
?> 