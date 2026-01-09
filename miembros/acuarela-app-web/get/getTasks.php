<?php 
    session_start();
    include "../includes/sdk.php";
    $a = new Acuarela();
    $tasks = $a->getTasks();
    echo json_encode($tasks);