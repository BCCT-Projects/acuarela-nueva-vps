<?php
/**
 * Crea una cuenta conectada de Stripe para el daycare
 *
 * Este endpoint crea una cuenta de Stripe Connect para que el daycare
 * pueda recibir pagos directamente.
 *
 * Variables de entorno requeridas en .env:
 * - STRIPE_SECRET_KEY: API key secreta de Stripe
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/env.php';

header('Content-Type: application/json');

$stripeSecretKey = Env::get('STRIPE_SECRET_KEY');

if (!$stripeSecretKey) {
    http_response_code(500);
    echo json_encode(['error' => 'Stripe configuration missing: STRIPE_SECRET_KEY']);
    exit;
}

$stripe = new \Stripe\StripeClient([
    "api_key" => $stripeSecretKey,
]);

try {
    // Crear cuenta conectada con tipo "express" para onboarding simplificado
    $account = $stripe->accounts->create([
        'type' => 'express',
        'capabilities' => [
            'transfers' => ['requested' => true],
            'card_payments' => ['requested' => true],
        ],
        'business_type' => 'company',
        'metadata' => [
            'platform' => 'acuarela',
            'created_at' => date('Y-m-d H:i:s')
        ]
    ]);

    echo json_encode([
        'account' => $account->id
    ]);

} catch (Exception $e) {
    error_log("An error occurred when calling the Stripe API to create an account: {$e->getMessage()}");
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
