<?php 
    session_start();
    include "../includes/sdk.php";
    $a = new Acuarela();
    $data = file_get_contents('php://input');
    $posts = $a->setReactionPost($data);
    echo json_encode($posts);
?>