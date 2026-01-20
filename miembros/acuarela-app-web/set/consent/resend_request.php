<?php
// miembros/acuarela-app-web/set/consent/resend_request.php
ini_set('display_errors', 0); // Evitar romper JSON
session_start();
header('Content-Type: application/json');

include "../../includes/sdk.php";
include "get_coppa_version.php";
$a = new Acuarela();

try {
    // 1. Validar Entrada
    $input = json_decode(file_get_contents('php://input'), true);
    $childId = $input['child_id'] ?? null;

    if (!$childId) {
        throw new Exception("Falta el ID del niño.");
    }

    // 2. Obtener datos del niño
    // Usamos el helper del SDK que ya maneja todas las relaciones (parents, healthinfo, etc.)
    $childData = $a->getChildren($childId);

    // Decrypt child data (name, lastname, etc.)
    $childData = $a->decryptChildData($childData);

    if (!$childData || isset($childData->statusCode)) {
        throw new Exception("No se encontró el niño.");
    }

    // 3. Identificar al padre principal
    $parent = null;
    if (isset($childData->acuarelausers) && is_array($childData->acuarelausers)) {
        foreach ($childData->acuarelausers as $p) {
            if (isset($p->is_principal) && $p->is_principal) {
                $parent = $p;
                break;
            }
        }
        // Fallback: primer padre
        if (!$parent && count($childData->acuarelausers) > 0) {
            $parent = $childData->acuarelausers[0];
        }
    }

    if (!$parent || empty($parent->mail)) {
        throw new Exception("No se encontró un padre con correo válido.");
    }

    // Obtener nombre del Daycare si es posible
    $daycareName = "la Guardería";
    if (!empty($childData->daycare)) {
        // Puede venir como objeto o ID
        if (is_object($childData->daycare) && isset($childData->daycare->name)) {
            $daycareName = $childData->daycare->name;
        } elseif (is_string($childData->daycare)) {
            $daycareInfo = $a->getDaycareInfo($childData->daycare);
            if ($daycareInfo && isset($daycareInfo->name)) {
                $daycareName = $daycareInfo->name;
            }
        }
    }

    // 4. Buscar Consentimiento Existente
    $existingConsent = $a->queryStrapi("parental-consents?child_id=$childId&_sort=created_at:DESC&_limit=1", null, "GET");

    $token = bin2hex(random_bytes(32)); // Nuevo token fresco
    $consentId = null;

    if (!empty($existingConsent) && is_array($existingConsent)) {
        $consent = $existingConsent[0];
        $consentId = $consent->id;

        // Obtener la versión actual del aviso COPPA para la renovación
        $coppaVersion = getCurrentCoppaVersion();

        $updateData = [
            'consent_status' => 'pending',
            'verification_token' => $token,
            'parent_email' => $parent->mail,
            'parent_name' => $parent->name,
            'policy_version' => $coppaVersion,
            'Policy_version' => $coppaVersion,
            'Policy_Version' => $coppaVersion,
            'POLICY_VERSION' => $coppaVersion
        ];

        $a->queryStrapi("parental-consents/$consentId", $updateData, "PUT");

    } else {
        // Crear nuevo si no existía (raro pero posible)
        // Obtener la versión actual del aviso COPPA
        $coppaVersion = getCurrentCoppaVersion();

        $newData = [
            'child_id' => $childId,
            'parent_name' => $parent->name,
            'parent_email' => $parent->mail,
            'consent_status' => 'pending',
            'verification_token' => $token,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Admin Resend',
            'granted_at' => null, // Reiniciar si existiera lógica futura
            'policy_version' => $coppaVersion,
            'Policy_version' => $coppaVersion,
            'Policy_Version' => $coppaVersion,
            'POLICY_VERSION' => $coppaVersion
        ];

        $created = $a->queryStrapi("parental-consents", $newData, "POST");
        if ($created && isset($created->id)) {
            $consentId = $created->id;
        } else {
            throw new Exception("Error al crear registro de consentimiento.");
        }
    }

    // 5. Enviar Correo con Mandrill
    $domainUrl = Env::get('APP_URL', 'https://acuarela.app/miembros/acuarela-app-web');

    $verifyLink = "$domainUrl/set/consent/verify.php?token=$token";
    $coppaPolicy = "$domainUrl/privacy/coppa.php";

    $mergeVars = [
        ['name' => 'PARENT_NAME', 'content' => $parent->name],
        ['name' => 'CHILD_NAME', 'content' => $childData->name . ' ' . $childData->lastname],
        ['name' => 'DAYCARE_NAME', 'content' => $daycareName],
        ['name' => 'VERIFY_LINK', 'content' => $verifyLink],
        ['name' => 'COPPA_POLICY_LINK', 'content' => $coppaPolicy]
    ];

    $templateName = "coppa-consent-request";
    $subject = "Recordatorio: Consentimiento Parental Requerido"; // Subject ligeramente diferente para reenviados?

    // API Key
    $mandrillKey = Env::get('MANDRILL_API_KEY');

    $emailResult = $a->send_notification(
        "info@acuarela.app",    // From
        $parent->mail,          // To
        $parent->name,          // Name
        $mergeVars,             // Vars
        $subject,               // Subject
        $templateName,          // Template
        $mandrillKey,           // Key
        "Acuarela"              // From Name
    );

    echo json_encode(['success' => true, 'message' => 'Correo enviado exitosamente a ' . $parent->mail]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>