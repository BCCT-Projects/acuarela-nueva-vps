<?php
include '../includes/config.php';
$array = array();
$array['message'] = 1;
extract($_POST);
$array['info']['name'] = $name;

$array['info']['email'] = $email;
$array['info']['phone'] = $phone;
$array['info']['daycare'] = $daycare_name;
$array['info']['country'] = $country;
$array['info']['city'] = $city;

$a->sendDemoEmail($name, $email, $phone, $daycare_name, $country, $city);
echo json_encode($array);
