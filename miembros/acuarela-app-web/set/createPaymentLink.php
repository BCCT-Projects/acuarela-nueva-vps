<?php
/**
 * Crea una sesión de Checkout en Stripe con application_fee usando price_data
 *
 * Este archivo implementa el cobro de comisiones usando Stripe Connect
 * de la forma correcta:
 * - El dinero va directamente a la cuenta del daycare (idStripe)
 * - Acuarela recibe su comisión automáticamente (application_fee)
 * - Stripe cobra su comisión aparte
 *
 * IMPORTANTE:
 * - Usamos Checkout Session en lugar de Payment Links porque Payment Links NO soportan application_fee directamente.
 * - Usamos price_data en lugar de price para crear precios "al vuelo" sin contaminar el catálogo de Stripe.
 *   Esto es ideal para facturas con montos arbitrarios y dinámicos (cada pago es diferente).
 *
 * Variables de entorno requeridas en .env:
 * - STRIPE_SECRET_KEY: API key secreta de Stripe
 * - STRIPE_APPLICATION_FEE: Comisión de Acuarela en centavos (default: 50 = $0.50)
 * - APP_URL: URL base de la aplicación para callbacks
 */

require_once __DIR__ . "/../includes/config.php";
require_once __DIR__ . "/../includes/env.php";

header('Content-Type: application/json');

// Obtener parámetros - ahora recibimos concepto y monto directamente (no priceId)
$concept = filter_input(INPUT_GET, 'concept', FILTER_SANITIZE_SPECIAL_CHARS); // Concepto del pago
$amount = filter_input(INPUT_GET, 'amount', FILTER_VALIDATE_INT); // Monto en centavos

if (!$concept || $amount === false || $amount <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid or missing parameters (concept, amount)']);
    exit;
}

// Obtener configuración desde variables de entorno
$stripeSecretKey = Env::get('STRIPE_SECRET_KEY');

// Construir la URL de la app dinámicamente para evitar redirecciones a dominios incorrectos
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https');
$protocol = $isHttps ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$appUrl = "{$protocol}://{$host}/miembros/acuarela-app-web";

if (!$stripeSecretKey) {
    http_response_code(500);
    echo json_encode(['error' => 'Stripe configuration missing: STRIPE_SECRET_KEY']);
    exit;
}

// $a ya está definido por config.php
$daycareInfo = $a->daycareInfo;

// Validar que el daycareID esté disponible
if (empty($a->daycareID) || empty($daycareInfo)) {
    http_response_code(400);
    echo json_encode(['error' => 'No hay un daycare activo seleccionado']);
    exit;
}

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

// Calcular comisión total
// PRO: Solo comisión de Stripe (2.9% + 30 centavos)
// LITE: Comisión de Acuarela ($0.50) + comisión de Stripe (2.9% + 30 centavos)
//
// Fórmula: application_fee = comisión_acuarela + (monto * 0.029 + 30)
// - Stripe cobra: 2.9% + 30 centavos por transacción
// - Acuarela cobra: 50 centavos adicionales (solo LITE)
$acuarelaFee = $isProUser ? 0 : (int)Env::get('STRIPE_APPLICATION_FEE', 50); // $0.50 para LITE, $0 para PRO
$stripeFee = round($amount * 0.029) + 30; // 2.9% + 30 centavos
$applicationFee = $acuarelaFee + $stripeFee;

// Log para debug (opcional, puede eliminarse en producción)
error_log("Fee calculation - Amount: $amount, Acuarela: $acuarelaFee, Stripe: $stripeFee, Total: $applicationFee, IsPRO: " . ($isProUser ? 'Yes' : 'No'));

if (!isset($daycareInfo->paypal->client_id) || empty($daycareInfo->paypal->client_id)) {
    http_response_code(400);
    echo json_encode(['error' => 'Daycare no tiene cuenta Stripe vinculada. Configure los pagos en Configuración.']);
    exit;
}

$idStripe = $daycareInfo->paypal->client_id;

try {
    // Crear Checkout Session con application_fee
    // Documentación: https://stripe.com/docs/connect/destination-charges#checkout
    $curl = curl_init();

    // Estructura correcta para Stripe Connect con Checkout Session:
    // - Se crea en la plataforma (sin Stripe-Account header)
    // - payment_intent_data.application_fee_amount: comisión para la plataforma
    // - payment_intent_data.transfer_data.destination: cuenta conectada que recibe el pago
    // - price_data: crea el precio al vuelo sin guardarlo en el catálogo de Stripe
    $params = [
        'mode' => 'payment',
        'line_items' => [
            [
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $amount,
                    'product_data' => [
                        'name' => $concept
                    ]
                ]
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

    // Añadir comisiones al resultado para que el frontend las muestre correctamente
    $responseData['acuarela_fee'] = $acuarelaFee;
    $responseData['stripe_fee'] = $stripeFee;
    $responseData['is_pro'] = $isProUser;

    // Retornar la respuesta enriquecida
    echo json_encode($responseData);

}
catch (Exception $e) {
    error_log("Error creating checkout session: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor']);
}
