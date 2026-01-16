<?php
session_start();
include "../includes/sdk.php";
$a = new Acuarela();
$data = file_get_contents('php://input');

// Evitar que errores/warnings rompan el JSON
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/dev/stderr');

// Incluir el helper de consentimiento
include "consent/initiate.php";

error_log("--- Inicio createInscripcion.php ---");

// 1. Crear Inscripción en Strapi (mantener status original)
$dataObj = json_decode($data);
error_log("Payload recibido para: " . ($dataObj->name ?? 'Unknown'));

// Si es borrador, lo dejamos pasar normal sin flujo COPPA
if (isset($dataObj->status) && $dataObj->status == 'Borrador') {
    $inscripcion = $a->postInscripcion($data);
    echo json_encode($inscripcion);
    exit;
}

// Si es "Finalizado" (o cualquier otro estado), creamos el niño normalmente
// El consentimiento se registra en la tabla "parental_consents" solamente
error_log("Creando niño en Strapi con status: " . ($dataObj->status ?? 'Desconocido'));
$respInscripcion = $a->postInscripcion($data);

// Debug detallado de la respuesta
error_log("TIPO de respuesta: " . gettype($respInscripcion));
error_log("respInscripcion->id: " . ($respInscripcion->id ?? 'NO EXISTE'));
error_log("respInscripcion->data->id: " . (isset($respInscripcion->data->id) ? $respInscripcion->data->id : 'NO EXISTE'));
error_log("respInscripcion->inscripcion: " . (isset($respInscripcion->inscripcion) ? json_encode($respInscripcion->inscripcion) : 'NO EXISTE'));
error_log("Propiedades disponibles: " . implode(', ', array_keys((array) $respInscripcion)));

// postInscripcion llama a "inscripciones/complete" que retorna:
// { ok, status, code, kid: {...}, parents: [...] }
// El ID del niño está en kid->id
$childId = null;
if (isset($respInscripcion->kid->id)) {
    $childId = $respInscripcion->kid->id;
} elseif (isset($respInscripcion->kid->_id)) {
    $childId = $respInscripcion->kid->_id;
} elseif (isset($respInscripcion->id)) {
    $childId = $respInscripcion->id;
}

error_log("Child ID extraído: " . ($childId ?? 'NULL'));

if ($childId) {
    // Debug: Ver estructura completa del payload para identificar campos del padre
    error_log("Estructura del dataObj: " . json_encode($dataObj));

    // Obtener datos del padre del payload
    // Intentar múltiples formatos posibles
    $parentEmail = '';
    $parentName = 'Tutor';

    // Opción 1: Campo directo email_tutor_1
    if (isset($dataObj->email_tutor_1) && !empty($dataObj->email_tutor_1)) {
        $parentEmail = $dataObj->email_tutor_1;
        $parentName = $dataObj->nombre_tutor_1 ?? 'Tutor';
    }
    // Opción 2: Array de parents
    elseif (isset($dataObj->parents) && is_array($dataObj->parents) && count($dataObj->parents) > 0) {
        $parentEmail = $dataObj->parents[0]->email ?? '';
        $parentName = $dataObj->parents[0]->name ?? 'Tutor';
    }
    // Opción 3: Email genérico
    elseif (isset($dataObj->email) && !empty($dataObj->email)) {
        $parentEmail = $dataObj->email;
    }
    // Opción 4: email_tutor_2
    elseif (isset($dataObj->email_tutor_2) && !empty($dataObj->email_tutor_2)) {
        $parentEmail = $dataObj->email_tutor_2;
        $parentName = $dataObj->nombre_tutor_2 ?? 'Tutor';
    }

    error_log("Parent Email encontrado: '$parentEmail'");
    error_log("Parent Name encontrado: '$parentName'");

    // Datos adicionales para el template "Invitaciones"
    $childName = ($dataObj->name ?? '') . ' ' . ($dataObj->lastname ?? '');
    $childName = trim($childName);
    $daycareId = $dataObj->daycare ?? null;

    // 2. Iniciar Flujo de Consentimiento
    error_log("Iniciando flujo COPPA para ChildID: $childId, Email: $parentEmail");
    $consentResult = initiateCoppaConsent($childId, $parentEmail, $parentName, $childName, $daycareId, $a);
    error_log("Resultado flujo COPPA: " . json_encode($consentResult));

    $finalResponse = [];
    if ($consentResult['success']) {
        $finalResponse = [
            "ok" => true,  // Para que processResponse funcione
            "id" => $childId,
            "status" => "PENDING_CONSENT",
            "message" => "Inscripción creada. Se requiere verificación del consentimiento parental.",
            "email_sent_to" => $parentEmail,
            "parents" => $respInscripcion->parents ?? [],  // Para que se envíen las invitaciones
            "kid" => $respInscripcion->kid ?? null
        ];
    } else {
        error_log("Error initiating consent for Child ID $childId: " . ($consentResult['error'] ?? 'Unknown'));
        // Aún así retornamos éxito de inscripción pero con advertencia en status
        $finalResponse = [
            "ok" => true,  // Para que processResponse funcione
            "id" => $childId,
            "status" => "PENDING_CONSENT_ERROR",
            "message" => "Inscripción creada, pero falló el envío del correo. Contacte soporte.",
            "debug_error" => $consentResult['error'] ?? '',
            "parents" => $respInscripcion->parents ?? [],  // Para que se envíen las invitaciones
            "kid" => $respInscripcion->kid ?? null
        ];
    }

    $jsonOutput = json_encode($finalResponse);
    error_log("Output final JSON: " . $jsonOutput);
    echo $jsonOutput;

} else {
    // Retornar error de Strapi
    error_log("Error creating inscripcion in Strapi: " . json_encode($respInscripcion));
    echo json_encode($respInscripcion);
}
