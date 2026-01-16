<?php
include '../includes/config.php';
$array = array();
$array['message'] = 1;

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$daycare = filter_input(INPUT_POST, 'daycare', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
$city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS);
$country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$name || !$email) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid parameters']);
    exit;
}

if (isset($a)) {
    $a->sendInvitationAdmin($name, $daycare, $email, $phone, $city, $country);
}
echo json_encode($array);
