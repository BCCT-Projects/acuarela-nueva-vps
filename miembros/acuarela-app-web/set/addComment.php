<?php 
    session_start();
    include "../includes/sdk.php";
    $a = new Acuarela();
    $data = file_get_contents('php://input');
    $data = json_decode($data);
    $data->acuarelauser = $a->userID;
    $data->date = date("Y-m-d");
    $posts = $a->addComment($data);
    echo json_encode($posts);
?>