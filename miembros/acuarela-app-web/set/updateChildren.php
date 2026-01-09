<?php 
    session_start();
    include "../includes/sdk.php";
    $a = new Acuarela();
    $data = file_get_contents('php://input');
    $data = json_decode($data);

    $posts = $a->updateChildren($data->id, $data->data);
    echo json_encode($posts);
?>