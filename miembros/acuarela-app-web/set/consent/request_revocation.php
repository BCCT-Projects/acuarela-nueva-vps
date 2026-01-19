<?php
// set/consent/request_revocation.php
session_start();

// PREVENIR ERRORES HTML EN RESPUESTA JSON
ini_set('display_errors', 0);
ini_set('log_errors', 1);

include "../../includes/sdk.php";
$a = new Acuarela();

header('Content-Type: application/json');

$parentEmail = $_POST['parent_email'] ?? '';
$childName = $_POST['child_name'] ?? '';

if (empty($parentEmail) || empty($childName)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit;
}

// 0. Validar reCAPTCHA
require_once __DIR__ . '/../../includes/env.php';
$secretKey = Env::get('RECAPTCHA_SECRET_KEY');
$captchaResponse = $_POST['g-recaptcha-response'] ?? '';

if ($secretKey && !empty($captchaResponse)) {
    $verifyUrl = "https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$captchaResponse}";
    // Usar curl para mayor compatibilidad si file_get_contents está bloqueado, pero start simple
    $verifyResponse = file_get_contents($verifyUrl);
    $responseData = json_decode($verifyResponse);

    if (!$responseData->success) {
        echo json_encode(['success' => false, 'message' => 'Validación de seguridad fallida. Por favor confirme que no es un robot.']);
        exit;
    }
} elseif ($secretKey && empty($captchaResponse)) {
    // Si hay secret key configurada pero no se envió response
    echo json_encode(['success' => false, 'message' => 'Por favor complete la verificación de seguridad (reCAPTCHA).']);
    exit;
}

// 1. Buscar en Strapi: Consentimientos con ese email Y que estén 'granted'
$queryParams = http_build_query([
    'parent_email' => $parentEmail,
    'consent_status' => 'granted'
]);

$consents = $a->queryStrapi("parental-consents?$queryParams", null, "GET");

// Lógica de seguridad: Siempre responder con el mismo mensaje genérico para evitar enumeración de usuarios,
// a menos que sea un error obvio de validación.
// Respuesta inicial por defecto (Error)
$responseMessage = ['success' => false, 'message' => 'No encontramos ningún consentimiento activo con esos datos. Verifique que el correo sea el del tutor registrado y el nombre del niño sea correcto.'];

if (empty($consents) || !is_array($consents)) {
    echo json_encode($responseMessage);
    exit;
}

$foundMatch = false;
$consentToRevoke = null;
$childNameForEmail = ''; // Variable para almacenar el nombre real del niño para el correo

foreach ($consents as $consent) {
    // Verificar si existe la relación y tiene datos
    if (isset($consent->child_id) && is_object($consent->child_id)) {
        $child = $consent->child_id;

        // Strapi v3 devuelve los campos en minúscula según tu JSON de debug
        $realName = isset($child->name) ? $child->name : '';
        $realLastname = isset($child->lastname) ? $child->lastname : '';

        // DESENCRIPTAR NOMBRES SI ESTÁN cifrados
        if (isset($a->crypto) && $a->crypto) {
            try {
                if ($a->crypto->isEncrypted($realName)) {
                    $realName = $a->crypto->decrypt($realName);
                }
                if ($a->crypto->isEncrypted($realLastname)) {
                    $realLastname = $a->crypto->decrypt($realLastname);
                }
            } catch (Exception $e) {
                error_log("Error decrypting child name in revocation: " . $e->getMessage());
                // Continuar con el siguiente si hay error descifrando
                continue;
            }
        }

        // Construir nombre completo real (normalizado)
        $fullRealName = trim(strtolower($realName . ' ' . $realLastname));
        $onlyRealName = trim(strtolower($realName));

        // Input del usuario (normalizado)
        $inputName = trim(strtolower($childName));

        // Lógica de Comparación Robusta:
        // 1. Coincidencia Exacta con Nombre Completo: "alejandro martinez" == "alejandro martinez"
        // 2. Coincidencia con Nombre de Pila: "alejandro" == "alejandro"
        // 3. Inicio Parcial: "alejandro mar" coincide con arranque de "alejandro martinez"

        if (
            $fullRealName === $inputName ||
            $onlyRealName === $inputName ||
            strpos($fullRealName, $inputName) === 0
        ) {

            $foundMatch = true;
            $consentToRevoke = $consent;

            // Guardar el nombre correcto para el correo
            $childNameForEmail = $realName . ' ' . $realLastname;
            break;
        }
    }
}

if ($foundMatch && $consentToRevoke) {
    // 2. Generar Token de Revocación
    try {
        $revokeToken = bin2hex(random_bytes(32));
    } catch (Exception $e) {
        $revokeToken = bin2hex(openssl_random_pseudo_bytes(32));
    }

    $finalToken = "REVOKE-" . $revokeToken;

    // 3. Actualizar Strapi
    $updateData = ['verification_token' => $finalToken];
    $a->queryStrapi("parental-consents/" . $consentToRevoke->id, $updateData, "PUT");

    // 4. Enviar Email
    $baseUrl = Env::get('APP_URL', 'https://acuarela.app/miembros/acuarela-app-web');
    $revokeLink = "$baseUrl/set/consent/revoke.php?token=$finalToken";

    $mergeVars = [
        ['name' => 'PARENT_NAME', 'content' => $consentToRevoke->parent_name],
        ['name' => 'CHILD_NAME', 'content' => $childNameForEmail], // Nombre corregido
        ['name' => 'REVOKE_LINK', 'content' => $revokeLink]
    ];

    $subject = "Solicitud de Revocación de Consentimiento - Acuarela";
    $templateName = "coppa-consent-revoke";

    $fromEmail = "info@acuarela.app";

    $sent = $a->send_notification(
        $fromEmail,
        $parentEmail,
        $consentToRevoke->parent_name,
        $mergeVars,
        $subject,
        $templateName,
        Env::get('MANDRILL_API_KEY'), // API Key requerida
        "Acuarela" // fromName (opcional, mejora la presentación)
    );

    // Respuesta de ÉXITO Explícita
    echo json_encode([
        'success' => true,
        'message' => '¡Correcto! Hemos enviado un correo de confirmación a ' . $parentEmail . '. Por favor revise su bandeja de entrada (y spam) para completar la revocación.'
    ]);
    exit;
}

// Si llega aquí, no encontró match
echo json_encode($responseMessage);
?>