<?php
/**
 * Endpoint para activar cuenta de asistente (crear contraseña)
 * Recibe: asistenteId, password
 * Actualiza la contraseña del asistente en el API
 */
header('Content-Type: application/json');

require_once '../includes/env.php';

// Leer datos del body
$input = file_get_contents('php://input');
$data = json_decode($input, true);

$asistenteId = $data['asistenteId'] ?? null;
$password = $data['password'] ?? null;

// Validaciones
if (!$asistenteId || !$password) {
    echo json_encode([
        'ok' => false,
        'message' => 'Datos incompletos'
    ]);
    exit;
}

// Validar requisitos de contraseña
$passwordRegex = '/^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*_\-\.]).{6,}$/';
if (!preg_match($passwordRegex, $password)) {
    echo json_encode([
        'ok' => false,
        'message' => 'La contraseña no cumple con los requisitos de seguridad'
    ]);
    exit;
}

// Primero verificar si la cuenta ya fue activada
$domain = Env::get('ACUARELA_API_URL', 'https://acuarelacore.com/api/');
$checkEndpoint = $domain . "acuarelausers/$asistenteId";

$checkCurl = curl_init();
curl_setopt_array($checkCurl, [
    CURLOPT_URL => $checkEndpoint,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
]);
$checkResponse = curl_exec($checkCurl);
curl_close($checkCurl);

$userData = json_decode($checkResponse);
$user = $userData->response[0] ?? $userData;

// Verificar si ya está activada - múltiples métodos
$isAlreadyActivated = false;

// Método 1: Campo activated (si existe)
if (isset($user->activated) && $user->activated === true) {
    $isAlreadyActivated = true;
}

// Método 2: Campo passwordChanged (si existe)
if (isset($user->passwordChanged) && $user->passwordChanged === true) {
    $isAlreadyActivated = true;
}

// Método 3: Verificar si updatedAt es significativamente diferente a createdAt
// (indica que el usuario fue modificado después de ser creado)
if (isset($user->createdAt) && isset($user->updatedAt)) {
    $createdAt = strtotime($user->createdAt);
    $updatedAt = strtotime($user->updatedAt);
    $timeDiff = $updatedAt - $createdAt;
    
    // Si fue actualizado más de 1 minuto después de ser creado, probablemente ya se activó
    // (1 minuto es suficiente para distinguir entre creación inicial y activación)
    // También verificamos que la diferencia no sea muy pequeña (< 5 segundos) que sería creación normal
    if ($timeDiff > 60 && $timeDiff < 300) { 
        // Entre 1 minuto y 5 minutos = probablemente ya se activó antes
        $isAlreadyActivated = true;
    } elseif ($timeDiff >= 300) {
        // Más de 5 minutos = definitivamente ya se activó
        $isAlreadyActivated = true;
    }
}

if ($isAlreadyActivated) {
    echo json_encode([
        'ok' => false,
        'message' => 'Esta cuenta ya fue activada anteriormente. Si olvidaste tu contraseña, usa la opción de recuperar contraseña.',
        'alreadyActivated' => true
    ]);
    exit;
}

// Actualizar contraseña en el API
$endpoint = $domain . "acuarelausers/$asistenteId";

$updateData = [
    'pass' => $password,
    'password' => $password
    // Nota: El backend no guarda accountActivated, por lo que usamos validación de tiempo
];

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $endpoint,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_POSTFIELDS => json_encode($updateData),
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$curlError = curl_error($curl);
curl_close($curl);

if ($curlError) {
    error_log("Error activando asistente $asistenteId: $curlError");
    echo json_encode([
        'ok' => false,
        'message' => 'Error de conexión. Intenta nuevamente.'
    ]);
    exit;
}

$responseData = json_decode($response, true);

if ($httpCode >= 200 && $httpCode < 300) {
    // Log de auditoría
    error_log("SEGURIDAD: Asistente $asistenteId activó su cuenta - " . date('Y-m-d H:i:s'));
    
    echo json_encode([
        'ok' => true,
        'message' => 'Cuenta activada exitosamente'
    ]);
} else {
    error_log("Error activando asistente $asistenteId: HTTP $httpCode - $response");
    echo json_encode([
        'ok' => false,
        'message' => 'Error al actualizar la contraseña'
    ]);
}

