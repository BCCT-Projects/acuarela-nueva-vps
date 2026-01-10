<?php
include '../includes/config.php';
echo json_encode($a->getElof($_GET["id"]));

