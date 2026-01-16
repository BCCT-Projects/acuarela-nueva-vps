<?php
session_start();
include "../includes/sdk.php";
$a = new Acuarela();
$array = array();

// Explicit inputs
$nameKid = filter_input(INPUT_POST, 'nameKid', FILTER_SANITIZE_SPECIAL_CHARS);
$nameParent = filter_input(INPUT_POST, 'nameParent', FILTER_SANITIZE_SPECIAL_CHARS);
$nameDaycare = filter_input(INPUT_POST, 'nameDaycare', FILTER_SANITIZE_SPECIAL_CHARS);
$nameAcudiente = filter_input(INPUT_POST, 'nameAcudiente', FILTER_SANITIZE_SPECIAL_CHARS);
$time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_SPECIAL_CHARS);
$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_SPECIAL_CHARS);
$mail = filter_input(INPUT_POST, 'mail', FILTER_VALIDATE_EMAIL);

if (!$nameKid || !$nameParent || !$nameDaycare || !$nameAcudiente || !$time || !$date || !$mail) {
    $array['emailSended'] = false;
    $array['error'] = 'Invalid or missing parameters';
    echo json_encode($array);
    exit;
}

$emailSended = $a->sendCheckin($nameKid,$nameParent,$nameDaycare,$nameAcudiente,$time,$date,$mail,$subject = 'Check in');
$array['emailSended'] = $emailSended;
echo json_encode($array);
