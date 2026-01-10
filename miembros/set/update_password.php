<?php 
include '../includes/config.php';
$array = array();
extract($_POST);
$data = array("password"=> $password, "pass"=> $password);

$response = $a->updatePassword($userId, $buserId, json_encode($data), $isRecover == 1 ? false : true);
$array["response"] = $response;
$array["data"] = $data;
echo json_encode($array);