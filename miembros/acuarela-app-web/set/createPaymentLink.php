<?php
/**
 * Crea una sesión de Checkout en Stripe con application_fee
 *
 * Este archivo implementa el cobro de comisiones usando Stripe Connect
 * de la forma correcta:
 * - El dinero va directamente a la cuenta del daycare (idStripe)
 * - Acuarela recibe su comisión automáticamente (application_fee)
 * - Stripe cobra su comisión aparte
 *
 * IMPORTANTE: Usamos Checkout Session en lugar de Payment Links porque
 * Payment Links NO soportan application_fee directamente.
 *
 * Variables de entorno requeridas en .env:
 * - STRIPE_SECRET_KEY: API key secreta de Stripe
 * - STRIPE_APPLICATION_FEE: Comisión de Acuarela en centavos (default: 50 = $0.50)
 * - APP_URL: URL base de la aplicación para callbacks
 */

session_start();
require_once __DIR__ . "/../includes/env.php";
include "../includes/sdk.php";

header('Content-Type: application/json');

// Obtener parámetros
$priceId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$amount = filter_input(INPUT_GET, 'amount', FILTER_VALIDATE_INT); // Monto en centavos

if (!$priceId || $amount === false || $amount <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid or missing parameters (id, amount)']);
    exit;
}

// Obtener configuración desde variables de entorno
$stripeSecretKey = Env::get('STRIPE_SECRET_KEY');
$appUrl = Env::get('APP_URL', 'https://bilingualchildcaretraining.com');

if (!$stripeSecretKey) {
    http_response_code(500);
    echo json_encode(['error' => 'Stripe configuration missing: STRIPE_SECRET_KEY']);
    exit;
}

// Obtener el idStripe del daycare actual y verificar tipo de cuenta
$a = new Acuarela();
$daycareInfo = $a->daycareInfo;

// Determinar si el usuario es PRO (sin comisión) o LITE (con comisión)
// IDs de los planes PRO: anual y mensual
$validProIds = ["66df29c33f91241d635ae818", "66dfcce23f91241d635ae934"];
$isProUser = false;

$suscripciones = isset($daycareInfo->suscriptions) ? $daycareInfo->suscriptions : [];
if (is_array($suscripciones) || is_object($suscripciones)) {
    foreach ($suscripciones as $suscripcion) {
        if (isset($suscripcion->service->id) && in_array($suscripcion->service->id, $validProIds)) {
            $isProUser = true;
            break;
        }
    }
}

// Aplicar comisión solo a usuarios LITE
// PRO: $0.00 (sin comisión)
// LITE: $0.50 (comisión por transacción)
$applicationFee = $isProUser ? 0 : (int) Env::get('STRIPE_APPLICATION_FEE', 50);

if (!isset($daycareInfo->idStripe) || empty($daycareInfo->idStripe)) {
    http_response_code(400);
    echo json_encode(['error' => 'Daycare no tiene cuenta Stripe vinculada. Configure los pagos en Configuración.']);
    exit;
}

$idStripe = $daycareInfo->idStripe;

try {
    // Crear Checkout Session con application_fee
    // Documentación: https://stripe.com/docs/connect/destination-charges#checkout
    $curl = curl_init();

    // Estructura correcta para Stripe Connect con Checkout Session:
    // - Se crea en la plataforma (sin Stripe-Account header)
    // - payment_intent_data.application_fee_amount: comisión para la plataforma
    // - payment_intent_data.transfer_data.destination: cuenta conectada que recibe el pago
    $params = [
        'mode' => 'payment',
        'line_items' => [
            [
                'price' => $priceId,
                'quantity' => 1
            ]
        ],
        'payment_intent_data' => [
            'application_fee_amount' => $applicationFee,
            'transfer_data' => [
                'destination' => $idStripe
            ]
        ],
        'success_url' => $appUrl . '/finanzas?payment=success&session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => $appUrl . '/finanzas?payment=cancelled',
        'allow_promotion_codes' => 'false',
        'billing_address_collection' => 'required'
    ];

    $postFields = http_build_query($params);

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.stripe.com/v1/checkout/sessions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $postFields,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $stripeSecretKey
        ]
    ]);

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl);

    curl_close($curl);

    if ($curlError) {
        error_log("Stripe API cURL Error: " . $curlError);
        http_response_code(500);
        echo json_encode(['error' => 'Error connecting to Stripe: ' . $curlError]);
        exit;
    }

    $responseData = json_decode($response, true);

    if ($httpCode >= 400) {
        error_log("Stripe API Error: " . $response);
        http_response_code($httpCode);
        echo json_encode(['error' => $responseData['error']['message'] ?? 'Unknown Stripe error']);
        exit;
    }

    // Retornar la respuesta de Stripe (incluye url para el checkout)
    echo $response;

} catch (Exception $e) {
    error_log("Error creating checkout session: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor']);
}
