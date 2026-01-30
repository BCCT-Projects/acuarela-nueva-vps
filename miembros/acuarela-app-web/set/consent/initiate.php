<?php
// set/consent/initiate.php

// Include version helper
require_once __DIR__ . '/get_coppa_version.php';
require_once __DIR__ . '/../../../includes/SecurityAuditLogger.php';

/**
 * Función helper para iniciar el proceso de consentimiento parental.
 * Se espera que $acuarelaInstance sea una instancia ya inicializada de la clase Acuarela (SDK).
 */
function initiateCoppaConsent($childId, $parentEmail, $parentName, $childName, $daycareId, $acuarelaInstance)
{
    if (empty($childId) || empty($parentEmail)) {
        return ['success' => false, 'error' => 'Faltan datos requeridos via initiateCoppaConsent.'];
    }

    // 1. Generar Token Seguro
    try {
        $token = bin2hex(random_bytes(32));
    } catch (Exception $e) {
        $token = bin2hex(openssl_random_pseudo_bytes(32));
    }

    // 1.5 Obtener versión actual del aviso COPPA
    $coppaVersion = getCurrentCoppaVersion();

    // 2. Datos para Strapi (Colección parental_consents)
// El campo 'child_id' en Strapi es una relación, por lo que pasamos el ID del niño.
    $consentData = [
        'child_id' => $childId,
        'parent_email' => $parentEmail,
        'parent_name' => $parentName,
        'consent_status' => 'pending',
        'verification_token' => $token,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
        'granted_at' => null,
        'policy_version' => $coppaVersion,
        'Policy_version' => $coppaVersion,
        'Policy_Version' => $coppaVersion,
        'POLICY_VERSION' => $coppaVersion
    ];

    // 3. Guardar en Strapi
    error_log("Guardando consent en Strapi...");
    $response = $acuarelaInstance->queryStrapi('parental-consents', $consentData, 'POST');
    error_log("Respuesta Strapi Consent: " . json_encode($response));

    // Verificación básica de error en respuesta de Strapi
    if (!$response || (isset($response->statusCode) && $response->statusCode >= 400)) {
        $errorMsg = isset($response->message) ? json_encode($response->message) : 'Error desconocido de Strapi';
        error_log("Error creating parental consent in Strapi: " . json_encode($response));
        return ['success' => false, 'error' => 'Database error: ' . $errorMsg];
    }

    // 4. Preparar Correo (Template: Invitaciones)
// Obtener nombre del Daycare
    $daycareName = "la Guardería"; // Default
    if (!empty($daycareId)) {
        $daycareInfo = $acuarelaInstance->getDaycareInfo($daycareId);
        if ($daycareInfo && isset($daycareInfo->name)) {
            $daycareName = $daycareInfo->name;
        }
    }

    // Construir enlace de verificación
    // Usamos APP_URL definido en .env (prod o dev)
    $domainUrl = Env::get('APP_URL', 'https://acuarela.app/miembros/acuarela-app-web');

    $verifyLink = "$domainUrl/set/consent/verify.php?token=$token";
    $coppaPolicy = "$domainUrl/privacy/coppa.php";

    // Variables para Template NUEVO de Consentimiento "coppa-consent-request"
    $mergeVars = [
        ['name' => 'PARENT_NAME', 'content' => $parentName],
        ['name' => 'CHILD_NAME', 'content' => $childName],
        ['name' => 'DAYCARE_NAME', 'content' => $daycareName],
        ['name' => 'VERIFY_LINK', 'content' => $verifyLink],
        ['name' => 'COPPA_POLICY_LINK', 'content' => $coppaPolicy]
    ];

    $templateName = "coppa-consent-request"; // Template NUEVO - debe crearse en Mandrill
    $subject = "Acción Requerida: Consentimiento Parental para " . $childName;

    // Definir remitente
    $fromEmail = "info@acuarela.app";

    try {
        error_log("Enviando correo template: $templateName a $parentEmail");

        // Obtener API key desde variable de entorno usando la clase Env
        $mandrillKey = Env::get('MANDRILL_API_KEY', 'maRkSStgpCapJoSmwHOZDg');

        $emailResult = $acuarelaInstance->send_notification(
            $fromEmail, // From
            $parentEmail, // To
            $parentName, // To Name
            $mergeVars, // Merge Vars
            $subject, // Subject
            $templateName, // Template Name
            $mandrillKey, // API Key
            "Acuarela" // From Name
        );
        SecurityAuditLogger::log('parental_consent_requested', SecurityAuditLogger::SEVERITY_INFO, [
            'child_id' => $childId,
            'parent_email' => $parentEmail,
            'policy_version' => $coppaVersion
        ]);
        error_log("Correo enviado. Resultado: " . json_encode($emailResult));
    } catch (Exception $e) {
        error_log("Mandrill Error in initiateCoppaConsent: " . $e->getMessage());
        return ['success' => false, 'error' => 'Email sending failed: ' . $e->getMessage()];
    }

    return ['success' => true, 'token' => $token, 'email_result' => $emailResult];
}