<?php 
//Este archivo nos da la info de los usuarios  y los posts realizados en sus daycares
    session_start();
    include "../includes/sdk.php";
    $a = new Acuarela();
    $posts = $a->getPostsDaycares($a->daycareID,$_GET['page']);
    // $posts = $a->getPostsDaycares("65d7d5c58cf368c869172f17", $_GET['page']);
    echo json_encode($posts);