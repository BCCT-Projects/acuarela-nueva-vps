
<?php
include '../includes/config.php';
$array = array();
extract($_POST);
$emailSended = $a->sendCheckin($nameKid,$nameParent,$nameDaycare,$nameAcudiente,$time,$date,$mail,$subject = 'Check in');
$array['emailSended'] = $emailSended;
echo json_encode($array);
