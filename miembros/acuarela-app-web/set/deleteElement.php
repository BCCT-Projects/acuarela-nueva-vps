<?php 
    session_start();
    include "../includes/sdk.php";
    $a = new Acuarela();
    extract($_GET);
    $posts = $a->deleteElement($type, $id);
    echo json_encode($posts);
?>