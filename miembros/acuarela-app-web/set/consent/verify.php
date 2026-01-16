<?php
// set/consent/verify.php
ini_set('display_errors', 0);
session_start();
include "../../includes/sdk.php";
include "get_coppa_version.php";
$a = new Acuarela();

$token = $_GET['token'] ?? '';
$statusTitle = "";
$statusMessage = "";
$statusType = "error"; // success | error | warning

if (empty($token)) {
    $statusTitle = "Enlace inválido";
    $statusMessage = "El enlace que has utilizado no es válido.";
} else {
    // 1. Buscar el consentimiento por token en Strapi
    $queryParams = http_build_query([
        'verification_token' => $token,
        'consent_status' => 'pending'
    ]);

    $consents = $a->queryStrapi("parental-consents?$queryParams", null, "GET");

    if (empty($consents) || !is_array($consents)) {
        // Chequear si ya fue aprobado
        $checkGranted = http_build_query([
            'verification_token' => $token,
            'consent_status' => 'granted'
        ]);
        $grantedConsents = $a->queryStrapi("parental-consents?$checkGranted", null, "GET");

        if (!empty($grantedConsents) && is_array($grantedConsents)) {
            $statusTitle = "Ya verificado";
            $statusMessage = "Este consentimiento ya ha sido verificado anteriormente. No es necesaria ninguna acción adicional.";
            $statusType = "info";
        } else {
            $statusTitle = "Enlace expirado";
            $statusMessage = "Este enlace de verificación ha expirado o no es válido. Si necesitas ayuda, contacta con la administración.";
        }
    } else {
        // PROCESO DE APROBACIÓN
        $consent = $consents[0];
        $consentId = $consent->id;

        // Obtener el ID del niño asociado
        $childIdInConsent = $consent->child_id;
        $realChildId = is_object($childIdInConsent) ? $childIdInConsent->id : $childIdInConsent;

        if (empty($realChildId)) {
            $statusTitle = "Error de datos";
            $statusMessage = "No se encontró la información del niño asociada a este consentimiento.";
        } else {
            // 2. Actualizar estado del Consentimiento a 'granted'
            // Strapi prefiere formato UTC estricto ("Zulu time")
            $dateNow = gmdate('Y-m-d\TH:i:s.000\Z');
            
            // Obtener la versión actual del aviso COPPA
            $coppaVersion = getCurrentCoppaVersion();
            
            $updateConsentData = [
                'consent_status' => 'granted',
                'granted_at' => $dateNow,
                'Granted_at' => $dateNow,
                'Granted_At' => $dateNow,
                'GRANTED_AT' => $dateNow,
                'policy_version' => $coppaVersion,
                'Policy_version' => $coppaVersion,
                'Policy_Version' => $coppaVersion,
                'POLICY_VERSION' => $coppaVersion
            ];

            $updateResp = $a->queryStrapi("parental-consents/$consentId", $updateConsentData, "PUT");

            if (!$updateResp || (isset($updateResp->statusCode) && $updateResp->statusCode >= 400)) {
                $statusTitle = "Error técnico";
                $statusMessage = "Hubo un problema al registrar tu consentimiento en nuestra base de datos. Por favor intenta nuevamente.";
            } else {
                // 3. Activar Inscripción del niño
                // Buscar inscripción
                $inscripcionId = null;
                $childData = $a->queryStrapi("children/$realChildId?populate=inscripcion", null, "GET");

                if ($childData && isset($childData->inscripcion)) {
                    $inscripcionId = is_object($childData->inscripcion) ? $childData->inscripcion->id : $childData->inscripcion;
                } else {
                    // Búsqueda alternativa
                    $inscripcionesResp = $a->queryStrapi("inscripciones?child=$realChildId", null, "GET");
                    if ($inscripcionesResp && is_array($inscripcionesResp) && count($inscripcionesResp) > 0) {
                        $inscripcionId = $inscripcionesResp[0]->id;
                    }
                }

                if ($inscripcionId) {
                    $updateInscripcionData = ['status' => 'Finalizado'];
                    $inscripcionResp = $a->queryStrapi("inscripciones/$inscripcionId", $updateInscripcionData, "PUT");

                    if ($inscripcionResp && (!isset($inscripcionResp->statusCode) || $inscripcionResp->statusCode < 400)) {
                        $statusTitle = "¡Consentimiento Verificado!";
                        $statusMessage = "Gracias por confirmar tu consentimiento. El proceso de inscripción de tu hijo(a) ha sido completado exitosamente.";
                        $statusType = "success";
                    } else {
                        $statusTitle = "Verificado con advertencia";
                        $statusMessage = "Tu consentimiento se registró, pero hubo un error al activar la inscripción automática. El personal administrativo lo resolverá manualmente.";
                        $statusType = "warning";
                    }
                } else {
                    // No se encontró inscripción, pero el consent está OK
                    $statusTitle = "¡Consentimiento Guardado!";
                    $statusMessage = "Gracias. Hemos registrado tu aprobación correctamente.";
                    $statusType = "success";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificación de Consentimiento - Acuarela</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap">
    <style>
        :root {
            --primary: #7155A4;
            /* Morado Acuarela */
            --secondary: #0CB5C3;
            /* Cielo */
            --accent: #FA6F5C;
            /* Sandia */
            --text-dark: #140A4C;
            --bg-light: #f8fafc;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-light);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: var(--text-dark);
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(113, 85, 164, 0.1);
            max-width: 500px;
            width: 90%;
            text-align: center;
            border-top: 6px solid var(--primary);
        }

        .icon-container {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
        }

        .success .icon-container {
            background-color: #e0f2f1;
            color: #3fb072;
        }

        .error .icon-container {
            background-color: #ffebee;
            color: #e53935;
        }

        .warning .icon-container {
            background-color: #fff3e0;
            color: #fb8c00;
        }

        .info .icon-container {
            background-color: #e3f2fd;
            color: #1e88e5;
        }

        .icon-svg {
            width: 40px;
            height: 40px;
            fill: currentColor;
        }

        h1 {
            margin: 0 0 15px;
            color: var(--text-dark);
            font-size: 24px;
            font-weight: 600;
        }

        p {
            color: #5B6B79;
            line-height: 1.6;
            font-size: 16px;
            margin-bottom: 30px;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: var(--secondary);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 500;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(12, 181, 195, 0.3);
        }

        .logo-container {
            margin-bottom: 30px;
        }

        .logo-container img {
            height: 40px;
        }
    </style>
</head>

<body class="<?= $statusType ?>">
    <div class="card">
        <div class="logo-container">
            <img src="https://acuarela.app/miembros/acuarela-app-web/img/logo.png" alt="Acuarela Logo"
                onerror="this.style.display='none'">
        </div>

        <div class="icon-container">
            <?php if ($statusType === 'success'): ?>
                <!-- Check Icon -->
                <svg class="icon-svg" viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                </svg>
            <?php elseif ($statusType === 'error'): ?>
                <!-- Error Icon -->
                <svg class="icon-svg" viewBox="0 0 24 24">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" />
                </svg>
            <?php else: ?>
                <!-- Info/Warning Icon -->
                <svg class="icon-svg" viewBox="0 0 24 24">
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z" />
                </svg>
            <?php endif; ?>
        </div>

        <h1><?= $statusTitle ?></h1>
        <p><?= $statusMessage ?></p>

        <?php if ($statusType === 'success' || $statusType === 'info'): ?>
            <a href="https://acuarela.app" class="btn">Ir al Inicio</a>
        <?php else: ?>
            <a href="mailto:info@acuarela.app" class="btn" style="background-color: var(--primary);">Contactar Soporte</a>
        <?php endif; ?>
    </div>
</body>

</html>