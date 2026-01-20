<?php
// Test env loading in acuarela-app-web context
session_start();
include "../includes/sdk.php";

header('Content-Type: application/json');

$debug = [
    'env_class_exists' => class_exists('Env'),
    'env_vars' => class_exists('Env') ? Env::all() : null,
    'sdk_domain' => (new Acuarela())->domain,
    'session_daycare' => $_SESSION['activeDaycare'] ?? 'not_set',
    'session_user' => isset($_SESSION['user']) ? 'set' : 'not_set',
    'strapi_url' => Env::get('ACUARELA_API_URL', 'default_used'),
    'mandrill_key' => Env::get('MANDRILL_API_KEY')
];

echo json_encode($debug);
