<?php
include "miembros/acuarela-app-web/includes/sdk.php";
$a = new Acuarela();
$childId = "696a4721fcd9b368decd6392"; // ID de Alejandro del ejemplo anterior
$kid = $a->getChildren($childId);

echo "<pre>";
print_r($kid);
echo "</pre>";
?>