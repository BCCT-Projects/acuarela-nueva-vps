<?php
/**
 * Crea un enlace de onboarding para que el daycare complete su información en Stripe
 *
 * Este endpoint genera una URL donde el daycare completa el proceso de verificación
 * de Stripe Connect (datos bancarios, información fiscal, etc.)
 *
 * Variables de entorno requeridas en .env:
 * - STRIPE_SECRET_KEY: API key secreta de Stripe
 * - APP_URL: URL base de la aplicación para callbacks
 */

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/env.php';

header('Content-Type: application/json');

$stripeSecretKey = Env::get('STRIPE_SECRET_KEY');
$appUrl = Env::get('APP_URL', 'https://bilingualchildcaretraining.com');

if (!$stripeSecretKey) {
    http_response_code(500);
    echo json_encode(['error' => 'Stripe configuration missing: STRIPE_SECRET_KEY']);
    exit;
}

$stripe = new \Stripe\StripeClient([
    "api_key" => $stripeSecretKey,
]);

try {
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $connectedAccountId = $data->account ?? null;
    $daycareId = $data->daycare ?? null;

    if (!$connectedAccountId) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing account parameter']);
        exit;
    }

    // Construir URL de retorno con daycare ID si está disponible
    // Esto permite guardar el idStripe incluso si la sesión PHP se pierde
    $returnUrl = "{$appUrl}/return-to-app.php?id={$connectedAccountId}";
    if ($daycareId) {
        $returnUrl .= "&daycare={$daycareId}";
    }

    // Crear enlace de onboarding
    $account_link = $stripe->accountLinks->create([
        'account' => $connectedAccountId,
        'return_url' => $returnUrl,
        'refresh_url' => "{$appUrl}/configuracion#metodos",
        'type' => 'account_onboarding',
    ]);

    echo json_encode([
        'url' => $account_link->url
    ]);

} catch (Exception $e) {
    error_log("An error occurred when calling the Stripe API to create an account link: {$e->getMessage()}");
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
