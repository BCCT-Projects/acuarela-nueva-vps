<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/env.php';

header('Content-Type: application/json');

$stripeSecretKey = Env::get('STRIPE_SECRET_KEY');

$stripe = new \Stripe\StripeClient([
  "api_key" => $stripeSecretKey,
]);

try {
  $account = $stripe->accounts->create();

  echo json_encode(array(
    'account' => $account->id
  ));
} catch (Exception $e) {
  error_log("An error occurred when calling the Stripe API to create an account: {$e->getMessage()}");
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}

?>