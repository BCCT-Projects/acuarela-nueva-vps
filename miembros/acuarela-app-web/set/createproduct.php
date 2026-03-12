<?php
/**
 * Crea un producto en Stripe para pagos
 *
 * IMPORTANTE: Este archivo es para uso ADMINISTRATIVO únicamente.
 * El producto debe crearse UNA VEZ y luego configurarse en .env
 *
 * Flujo recomendado:
 * 1. Ejecutar este script UNA vez (o crear manualmente en Stripe Dashboard)
 * 2. Copiar el ID del producto retornado (prod_xxx)
 * 3. Agregar a .env: STRIPE_PAYMENT_PRODUCT_ID=prod_xxx
 *
 * Variables de entorno requeridas en .env:
 * - STRIPE_SECRET_KEY: API key secreta de Stripe
 */

require_once __DIR__ . "/../includes/env.php";

header('Content-Type: application/json');

$stripeSecretKey = Env::get('STRIPE_SECRET_KEY');

if (!$stripeSecretKey) {
    http_response_code(500);
    echo json_encode(['error' => 'Stripe configuration missing: STRIPE_SECRET_KEY']);
    exit;
}

// Nombre del producto (puede personalizarse via GET param)
$productName = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_SPECIAL_CHARS) ?: 'Pago de Servicios de Guardería';

try {
    $curl = curl_init();

    $postFields = http_build_query([
        'name' => $productName,
        'type' => 'service',
        'description' => 'Servicios de cuidado infantil',
        'metadata' => [
            'platform' => 'acuarela',
            'created_for' => 'payment_links'
        ]
    ]);

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.stripe.com/v1/products',
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
        error_log("Stripe API cURL Error (createProduct): " . $curlError);
        http_response_code(500);
        echo json_encode(['error' => 'Error connecting to Stripe: ' . $curlError]);
        exit;
    }

    $responseData = json_decode($response, true);

    if ($httpCode >= 400) {
        error_log("Stripe API Error (createProduct): " . $response);
        http_response_code($httpCode);
        echo json_encode(['error' => $responseData['error']['message'] ?? 'Unknown Stripe error']);
        exit;
    }

    // Retornar el ID del producto creado
    echo json_encode([
        'success' => true,
        'id' => $responseData['id'],
        'name' => $responseData['name'],
        'message' => 'Agrega este ID a tu .env: STRIPE_PAYMENT_PRODUCT_ID=' . $responseData['id']
    ]);

} catch (Exception $e) {
    error_log("Error creating product: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Error interno del servidor']);
}
