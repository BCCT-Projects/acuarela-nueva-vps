<?php
include '../includes/config.php';
$array = array();
$array['message'] = 1;

// Explicit inputs with sanitization
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
$daycare_name = filter_input(INPUT_POST, 'daycare_name', FILTER_SANITIZE_SPECIAL_CHARS);
$country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_SPECIAL_CHARS);
$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$name || !$email) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid parameters']);
    exit;
}

$array['info']['name'] = $name;
$array['info']['email'] = $email;
$array['info']['phone'] = $phone;
$array['info']['daycare'] = $daycare_name;
$array['info']['country'] = $country;
$array['info']['city'] = $city;

if (isset($a)) {
    $a->sendDemoEmail($name, $email, $phone, $daycare_name, $country, $city);
}

echo json_encode($array);
