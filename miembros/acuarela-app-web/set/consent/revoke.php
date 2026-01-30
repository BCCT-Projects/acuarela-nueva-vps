<?php
// set/consent/revoke.php
ini_set('display_errors', 0);
session_start();
include "../../includes/sdk.php";
require_once __DIR__ . "/../../../../includes/SecurityAuditLogger.php";
$a = new Acuarela();

$rawToken = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING);
// Limpiar el token: Quedarse solo con los primeros 71 caracteres (REVOKE- + 64 hex)
// Esto soluciona el problema de que el cliente de correo pegue texto basura al final.
$token = substr(trim($rawToken), 0, 71);

// Validación básica del formato del token
if (empty($token) || strpos($token, 'REVOKE-') !== 0) {
    die(" Enlace de revocación inválido (Formato incorrecto).");
}

// 1. Buscar Consentimiento por token
// Nota: En Strapi v3, para filtrar por un campo exacto, asegurarnos del nombre
$queryParams = http_build_query([
    'verification_token' => $token,
    'consent_status' => 'granted'
]);

$consents = $a->queryStrapi("parental-consents?$queryParams", null, "GET");

if (empty($consents) || !is_array($consents)) {
    // Si falla, intentar buscar sin filtrar por status, para ver si ya fue revocado
    $checkQueryParams = http_build_query(['verification_token' => $token]);
    $checkConsents = $a->queryStrapi("parental-consents?$checkQueryParams", null, "GET");

    if (!empty($checkConsents) && is_array($checkConsents)) {
        if ($checkConsents[0]->consent_status === 'revoked') {
            // Ya estaba revocado, mostrar éxito.
            // No hacemos nada, dejamos correr para mostrar el HTML de éxito.
            // Ojo: Hack rápido para no duplicar HTML.
            goto show_success;
        }
    }

    die("<h2>Solicitud inválida o el enlace ha expirado.</h2><p>Verifique que el token este completo o solicite uno nuevo.</p>");
}

$consent = $consents[0];

// Debug/Corrección ID Niño: Usar lógica probada en request_revocation
$childRef = $consent->child_id ?? $consent->Child_id ?? null;
$childId = is_object($childRef) ? $childRef->id : $childRef;

// 2. Marcar como Revocado en CONSENTIMIENTOS
// Strapi prefiere formato UTC estricto ("Zulu time")
$dateNow = gmdate('Y-m-d\TH:i:s.000\Z');
$updateConsent = [
    'consent_status' => 'revoked',
    'revoked_at' => $dateNow,
    'Revoked_at' => $dateNow,
    'Revoked_At' => $dateNow,
    'REVOKED_AT' => $dateNow
];

$respConsent = $a->queryStrapi("parental-consents/" . $consent->id, $updateConsent, "PUT");

// Validar que la actualización funcionó
if (!$respConsent || (isset($respConsent->statusCode) && $respConsent->statusCode >= 400)) {
    // Si falla, registrar error silencioso logs pero no mostrar stacktrace al usuario
    SecurityAuditLogger::log('system_error', SecurityAuditLogger::SEVERITY_ERROR, ['context' => 'consent_revocation_failure', 'consent_id' => $consent->id]);
    die("<h2>Error Técnico</h2><p>No se pudo actualizar el estado. Por favor contacte soporte.</p>");
}
SecurityAuditLogger::log('parental_consent_revoked', SecurityAuditLogger::SEVERITY_INFO, [
    'child_id' => $childId,
    'parent_email' => $consent->parent_email ?? null
]);

show_success:
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consentimiento Revocado - Acuarela</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            padding: 50px;
            background-color: #fff5f5;
            color: #333;
        }

        .container {
            background: white;
            padding: 50px 40px;
            /* Más padding vertical */
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            /* Sombra más suave */
            max-width: 600px;
            margin: 0 auto;
            border-top: 5px solid #dc3545;
        }

        h1 {
            color: #dc3545;
            margin-bottom: 20px;
            font-size: 2rem;
        }

        p {
            font-size: 16px;
            /* Texto más legible */
            line-height: 1.6;
            color: #555;
            margin-bottom: 1rem;
        }

        .icon svg {
            width: 80px;
            height: 80px;
            fill: #dc3545;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 30px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background 0.2s;
        }

        .btn:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="icon">
            <!-- Icono Shield Lock / Privacidad -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path
                    d="M12,1L3,5v6c0,5.55,3.84,10.74,9,12c5.16-1.26,9-6.45,9-12V5L12,1z M12,7c1.1,0,2,0.9,2,2s-0.9,2-2,2s-2-0.9-2-2S10.9,7,12,7z M12,17c-2.67,0-8,1.34-8,4v1h16v-1C20,18.34,14.67,17,12,17z" />
            </svg>
        </div>
        <!-- Using text for icon to avoid dependency -->

        <h1>Consentimiento Revocado</h1>
        <p>Has revocado exitosamente el consentimiento parental.</p>
        <p>El perfil del niño ha sido desactivado y ya no se podrán registrar actividades en la plataforma Acuarela.</p>
        <p>Si esto fue un error, deberás contactar a la guardería para iniciar un nuevo proceso de registro.</p>

        <a href="/" class="btn">Salir</a>
    </div>
</body>

</html>