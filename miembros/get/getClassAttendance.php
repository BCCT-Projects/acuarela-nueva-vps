<?php

include '../includes/config.php';
$result = $a->queryStrapi("asistencia-cdas");
echo json_encode($result);



