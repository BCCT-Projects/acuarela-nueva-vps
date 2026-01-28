<?php
// set/privacy/send_ferpa_reports.php
// Envía al padre un enlace de modo inspección con los reportes seleccionados

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../includes/sdk.php";
require_once __DIR__ . '/../../../cron/AuditLogger.php';
require_once __DIR__ . '/../../includes/env.php';

$a = new Acuarela();
$logger = new AuditLogger();

// Prevenir errores HTML en la respuesta JSON
ini_set('display_errors', 0);
ini_set('log_errors', 1);

header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$from = $_POST['from'] ?? null; // formato YYYY-MM-DD
$to = $_POST['to'] ?? null;

// IMPORTANTE: los checkboxes llegan como '1'/'0' (string). No usar cast directo a bool.
$ninos = isset($_POST['ninos']) && $_POST['ninos'] === '1';
$actividades = isset($_POST['actividades']) && $_POST['actividades'] === '1';
$asistencia = isset($_POST['asistencia']) && $_POST['asistencia'] === '1';
$asistentes = isset($_POST['asistentes']) && $_POST['asistentes'] === '1';

$replyMessage = trim($_POST['reply_message'] ?? '');

if (!$id || !$from || !$to) {
    echo json_encode(['success' => false, 'message' => 'Faltan parámetros requeridos (id, desde, hasta).']);
    exit;
}

// Helper para convertir YYYY-MM-DD -> DD-MM-YYYY (igual que generateReport en JS)
function ferpa_convert_date($dateString)
{
    $parts = explode('-', $dateString);
    if (count($parts) !== 3) {
        return $dateString;
    }
    return $parts[2] . '-' . $parts[1] . '-' . $parts[0];
}

// Helpers para token firmado de modo-inspección
function b64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function create_inspection_token($payload, $secret)
{
    $json = json_encode($payload, JSON_UNESCAPED_UNICODE);
    $p = b64url_encode($json);
    $sig = b64url_encode(hash_hmac('sha256', $p, $secret, true));
    return $p . '.' . $sig;
}

try {
    // 1. Obtener la solicitud FERPA
    $req = $a->queryStrapi("ferpa-requests/$id");
    if (!$req) {
        echo json_encode(['success' => false, 'message' => 'Solicitud FERPA no encontrada.']);
        exit;
    }

    // Algunas versiones de la API devuelven { response: [...] }
    if (isset($req->response) && is_array($req->response) && !empty($req->response)) {
        $req = $req->response[0];
    }

    // 2. Sacar daycare
    $daycareId = null;
    if (isset($req->daycare)) {
        $dc = $req->daycare;
        if (is_object($dc)) {
            $daycareId = $dc->id ?? ($dc->_id ?? null);
        } else {
            $daycareId = $dc;
        }
    } elseif ($a->daycareID) {
        $daycareId = $a->daycareID;
    }

    if (!$daycareId) {
        echo json_encode(['success' => false, 'message' => 'No se pudo determinar el daycare de la solicitud.']);
        exit;
    }

    // 3. Sacar datos del padre (requester)
    $parentName = 'Padre';
    $parentEmail = null;

    if (isset($req->requester) && is_object($req->requester)) {
        $parentName = trim(($req->requester->name ?? '') . ' ' . ($req->requester->lastname ?? '')) ?: 'Padre';
        $parentEmail = $req->requester->mail ?? $req->requester->email ?? null;
    }

    if (!$parentEmail && isset($req->requester_email)) {
        $parentEmail = $req->requester_email;
    }

    if (!$parentEmail) {
        echo json_encode(['success' => false, 'message' => 'No se encontró correo electrónico del padre para esta solicitud.']);
        exit;
    }

    // 4. Sacar datos del estudiante (opcional, solo para correo)
    $childName = 'el estudiante';
    if (isset($req->child) && is_object($req->child)) {
        if (method_exists($a, 'initCrypto')) {
            $a->initCrypto();
        }
        $decChild = $a->decryptChildData($req->child);
        $childName = trim(($decChild->name ?? '') . ' ' . ($decChild->lastname ?? '')) ?: 'el estudiante';
    } elseif (isset($req->child_details)) {
        $childName = trim(
            ($req->child_details->name ?? '') . ' ' . ($req->child_details->lastname ?? '')
        ) ?: 'el estudiante';
    }

    // 5. Construir enlace de modo inspección con token firmado
    $appUrl = Env::get('APP_URL', 'https://acuarela.app/miembros/acuarela-app-web');
    $baseUrl = rtrim($appUrl, '/') . '/modo-inspeccion/';
    $fromFormatted = ferpa_convert_date($from);
    $toFormatted = ferpa_convert_date($to);

    $secret = Env::get('INSPECTION_LINK_SECRET', '');
    if (empty($secret)) {
        echo json_encode(['success' => false, 'message' => 'Falta configurar INSPECTION_LINK_SECRET en el servidor.']);
        exit;
    }

    $ttlSeconds = (int) Env::get('INSPECTION_LINK_TTL_SECONDS', '604800'); // 7 días
    if ($ttlSeconds <= 0) {
        $ttlSeconds = 604800;
    }

    $payload = [
        'v' => 1,
        'request_id' => (string) $id,
        'daycare' => (string) $daycareId,
        'ninos' => $ninos ? 1 : 0,
        'actividades' => $actividades ? 1 : 0,
        'asistencia' => $asistencia ? 1 : 0,
        'asistentes' => $asistentes ? 1 : 0,
        'from' => (string) $fromFormatted,
        'to' => (string) $toFormatted,
        'user' => (string) $parentName,
        'exp' => time() + $ttlSeconds,
    ];

    $token = create_inspection_token($payload, $secret);
    $link = $baseUrl . '?token=' . urlencode($token);

    // 6. Enviar correo al padre con Mandrill
    $mergeVars = [
        ['name' => 'PARENT_NAME', 'content' => $parentName],
        ['name' => 'CHILD_NAME', 'content' => $childName],
        ['name' => 'REPORT_LINK', 'content' => $link],
        ['name' => 'DATE_FROM', 'content' => $fromFormatted],
        ['name' => 'DATE_TO', 'content' => $toFormatted],
    ];

    if (!empty($replyMessage)) {
        $mergeVars[] = ['name' => 'ADMIN_NOTE', 'content' => $replyMessage];
    }

    // Construir HTML del correo directamente (sin depender de templates externos)
    $reportTypes = [];
    if ($ninos) $reportTypes[] = "Fichas de niños";
    if ($actividades) $reportTypes[] = "Registro de actividades";
    if ($asistencia) $reportTypes[] = "Registro de asistencia";
    if ($asistentes) $reportTypes[] = "Fichas de asistentes";
    $reportTypesList = implode(", ", $reportTypes);
    
    $emailHtml = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #0CB5C3; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
            .content { background: #f9f9f9; padding: 30px; border-radius: 0 0 8px 8px; }
            .button { display: inline-block; background: #0CB5C3; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
            .info-box { background: white; padding: 15px; border-left: 4px solid #0CB5C3; margin: 15px 0; }
            .footer { text-align: center; color: #666; font-size: 12px; margin-top: 30px; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Acceso a Registros Educativos</h1>
            </div>
            <div class="content">
                <p>Estimado/a <strong>' . htmlspecialchars($parentName) . '</strong>,</p>
                
                <p>Hemos procesado su solicitud de acceso a registros educativos para <strong>' . htmlspecialchars($childName) . '</strong>.</p>
                
                <div class="info-box">
                    <p><strong>Informes incluidos:</strong> ' . htmlspecialchars($reportTypesList) . '</p>
                    <p><strong>Período:</strong> ' . htmlspecialchars($fromFormatted) . ' al ' . htmlspecialchars($toFormatted) . '</p>
                </div>
                
                <p>Puede acceder a los informes educativos solicitados haciendo clic en el siguiente enlace:</p>
                
                <p style="text-align: center;">
                    <a href="' . htmlspecialchars($link) . '" class="button">Ver Informes Educativos</a>
                </p>
                
                <p style="font-size: 0.9em; color: #666;">
                    <strong>Nota:</strong> Este enlace es válido por tiempo limitado. Si tiene problemas para acceder, por favor contáctenos.
                </p>
                
                ' . (!empty($replyMessage) ? '<div class="info-box"><p><strong>Nota adicional:</strong> ' . nl2br(htmlspecialchars($replyMessage)) . '</p></div>' : '') . '
                
                <p>Atentamente,<br><strong>Equipo Acuarela</strong></p>
            </div>
            <div class="footer">
                <p>Este es un correo automático. Por favor no responda a este mensaje.</p>
                <p>&copy; ' . date('Y') . ' Bilingual Child Care Training (BCCT). Todos los derechos reservados.</p>
            </div>
        </div>
    </body>
    </html>';
    
    // Enviar correo directamente sin depender de templates externos
    try {
        $a->sendEmail(
            $parentEmail,
            "Acceso a Registros Educativos - Acuarela",
            $emailHtml,
            "Acuarela Privacy Team"
        );
    } catch (Exception $emailError) {
        error_log("FERPA email error: " . $emailError->getMessage());
        // Continuar aunque falle el correo - el link está generado y la solicitud se completa
    }

    // 7. Actualizar estado de la solicitud a 'completed'
    $updateData = [
        'status' => 'completed',
        'completed_at' => date('c'),
    ];

    if (!empty($replyMessage)) {
        $updateData['resolution_notes'] = $replyMessage;
    }

    $a->updateFerpaRequest($id, $updateData);

    // 8. Auditoría (evento requerido FERPA)
    $logger->log('ferpa_access_granted', [
        'request_id' => $id,
        'daycare_id' => $daycareId,
        'parent_email' => $parentEmail,
        'ninos' => $ninos,
        'actividades' => $actividades,
        'asistencia' => $asistencia,
        'asistentes' => $asistentes,
    ]);

    echo json_encode(['success' => true, 'message' => 'Enlace de informes enviado al padre.']);
} catch (Exception $e) {
    error_log("FERPA send reports error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error interno al enviar los informes.']);
}

