<?php
/**
 * @deprecated Este archivo ya no se usa.
 *
 * Se ha reemplazado por el uso de price_data en createPaymentLink.php
 * que crea precios "al vuelo" sin contaminar el catálogo de Stripe.
 *
 * ANTES: Se creaba un precio permanente en Stripe (contaminaba el catálogo)
 * AHORA: Se usa price_data para crear precios dinámicos en una sola llamada
 *
 * Este archivo se mantiene solo como referencia histórica.
 * No eliminar por si se necesita revertir en el futuro.
 *
 * Variables de entorno requeridas en .env:
 * - STRIPE_SECRET_KEY: API key secreta de Stripe
 * - STRIPE_PAYMENT_PRODUCT_ID: ID del producto en Stripe (opcional, tiene default)
 */

require_once __DIR__ . "/../includes/env.php";

header('Content-Type: application/json');

$price = filter_input(INPUT_GET, 'price', FILTER_VALIDATE_INT);

if (!$price || $price <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid or missing price']);
    exit;
}

// Obtener configuración desde variables de entorno
$stripeSecretKey = Env::get('STRIPE_SECRET_KEY');
$productId = Env::get('STRIPE_PAYMENT_PRODUCT_ID');

if (!$stripeSecretKey) {
    http_response_code(500);
    echo json_encode(['error' => 'Stripe configuration missing: STRIPE_SECRET_KEY']);
    exit;
}

if (!$productId) {
    http_response_code(500);
    echo json_encode(['error' => 'Stripe configuration missing: STRIPE_PAYMENT_PRODUCT_ID. Create a product first using s/createproduct.php']);
    exit;
}

try {
    $curl = curl_init();

    $postFields = http_build_query([
        'currency' => 'usd',
        'unit_amount' => $price,
        'product' => $productId
    ]);

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.stripe.com/v1/prices',
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
        error_log("Stripe API cURL Error (createPrices): " . $curlError);
        http_response_code(500);
        echo json_encode(['error' => 'Error connecting to Stripe: ' . $curlError]);
        exit;
    }

    $responseData = json_decode($response, true);

    if ($httpCode >= 400) {
        error_log("Stripe API Error (createPrices): " . $response);
        http_response_code($httpCode);
        echo json_encode(['error' => $responseData['error']['message'] ?? 'Unknown Stripe error']);
        exit;
    }

    echo $response;

} catch (Exception $e) {
    error_log("Error creating price: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor']);
}
