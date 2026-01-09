<?php 
//Este archivo nos da la info de los usuarios  y los posts realizados en sus daycares
    session_start();
    include "../includes/sdk.php";
    $a = new Acuarela();
    $posts = $a->getInscripciones("",$a->daycareID);
    echo json_encode($posts);