<?php
// set/privacy/apply_ferpa_correction.php
// Aplica (si es posible) una corrección FERPA sobre un registro específico y registra evidencia before/after.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../includes/sdk.php";
require_once __DIR__ . "/../../includes/env.php";
require_once __DIR__ . '/../../../cron/AuditLogger.php';

header('Content-Type: application/json');
ini_set('display_errors', 0);
ini_set('log_errors', 1);

$a = new Acuarela();
$logger = new AuditLogger();

// Requiere sesión (endpoints admin). El control por rol lo vemos después (requisito 1).
if (!isset($_SESSION['user']) || !isset($_SESSION['user']->acuarelauser) || !isset($_SESSION['user']->acuarelauser->id)) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit;
}

$adminId = $_SESSION['user']->acuarelauser->id;

$id = $_POST['id'] ?? null;
$action = $_POST['action'] ?? null; // approve|deny
$note = trim($_POST['reply_message'] ?? '');
$manualBefore = trim($_POST['correction_before'] ?? '');
$manualAfter = trim($_POST['correction_after'] ?? '');

if (!$id || !$action) {
    echo json_encode(['success' => false, 'message' => 'Faltan parámetros (id, action)']);
    exit;
}

if (!in_array($action, ['approve', 'deny'], true)) {
    echo json_encode(['success' => false, 'message' => 'Acción inválida']);
    exit;
}

try {
    // 1) Leer solicitud
    $req = $a->queryStrapi("ferpa-requests/$id");
    if (!$req) {
        echo json_encode(['success' => false, 'message' => 'Solicitud FERPA no encontrada']);
        exit;
    }
    if (isset($req->response) && is_array($req->response) && !empty($req->response)) {
        $req = $req->response[0];
    }

    if (($req->request_type ?? '') !== 'correction') {
        echo json_encode(['success' => false, 'message' => 'Esta acción aplica solo para solicitudes de corrección']);
        exit;
    }

    $recordType = $req->record_type ?? null;
    $recordRef = $req->record_ref ?? null;

    // 2) Denegar (solo cierre con nota)
    if ($action === 'deny') {
        $updateData = [
            'status' => 'denied',
            'completed_at' => date('c'),
        ];
        if (!empty($note)) $updateData['resolution_notes'] = $note;

        $a->updateFerpaRequest($id, $updateData);

        $logger->log('ferpa_correction_denied', [
            'request_id' => $id,
            'admin_id' => $adminId,
            'record_type' => $recordType,
            'record_ref' => $recordRef,
        ]);

        echo json_encode(['success' => true, 'message' => 'Solicitud de corrección rechazada']);
        exit;
    }

    // 3) Aprobar: solo evidencia manual (antes/después) sin tocar el registro en Strapi
    if (empty($manualAfter)) {
        echo json_encode(['success' => false, 'message' => 'Debes describir cómo quedó corregida la información.']);
        exit;
    }

    // 4) Evidencia before/after (manual) se guarda en resolution_notes
    $evidence = [
        'v' => 2,
        'record_type' => $recordType,
        'record_ref' => $recordRef,
        'approved_by' => $adminId,
        'approved_at' => date('c'),
        'manual_before' => $manualBefore,
        'manual_after' => $manualAfter,
    ];

    $resolution = trim($note);
    $resolution .= ($resolution ? "\n\n" : "");
    $resolution .= "---FERPA_CORRECTION_EVIDENCE---\n" . json_encode($evidence, JSON_UNESCAPED_UNICODE);

    // 5) Cerrar solicitud
    $updated = $a->updateFerpaRequest($id, [
        'status' => 'approved',
        'completed_at' => date('c'),
        'resolution_notes' => $resolution,
    ]);

    // 6) Auditoría
    $logger->log('ferpa_correction_approved', [
        'request_id' => $id,
        'admin_id' => $adminId,
        'record_type' => $recordType,
        'record_ref' => $recordRef,
    ]);

    // 7) Notificación al padre (igual filosofía que update_ferpa_status)
    $requesterEmail = null;
    $requesterName = "Usuario";

    // Intentar sacar el email desde la respuesta actualizada (puede venir más completa)
    if ($updated) {
        if (isset($updated->requester_details) && is_object($updated->requester_details)) {
            $requesterEmail = $updated->requester_details->mail ?? null;
            $requesterName = trim(($updated->requester_details->name ?? '') . ' ' . ($updated->requester_details->lastname ?? '')) ?: "Usuario";
        } elseif (isset($updated->requester) && is_object($updated->requester)) {
            $requesterEmail = $updated->requester->mail ?? null;
            $requesterName = $updated->requester->name ?? "Usuario";
        } elseif (isset($updated->requester_email)) {
            $requesterEmail = $updated->requester_email;
        }
    }

    // Fallback: usar los datos originales si en el update no vino nada
    if (!$requesterEmail) {
        if (isset($req->requester_details) && is_object($req->requester_details)) {
            $requesterEmail = $req->requester_details->mail ?? null;
            $requesterName = trim(($req->requester_details->name ?? '') . ' ' . ($req->requester_details->lastname ?? '')) ?: "Usuario";
        } elseif (isset($req->requester_email)) {
            $requesterEmail = $req->requester_email;
        }
    }

    if ($requesterEmail && !empty($note)) {
        $statusTitle = "Corrección de datos aprobada";
        $emailSubject = "Actualización de su Solicitud Educativa (Corrección aprobada)";
        $statusColor = "#28a745"; // Verde para aprobado

        // Variables para el template dsar-status-update (mismo que usa privacidad)
        $mergeVars = [
            ['name' => 'USER_NAME', 'content' => $requesterName],
            ['name' => 'DSAR_ID', 'content' => substr($id, -6)], // El template espera DSAR_ID
            ['name' => 'STATUS_TITLE', 'content' => $statusTitle],
            ['name' => 'STATUS_COLOR', 'content' => $statusColor],
            ['name' => 'UPDATE_MESSAGE', 'content' => nl2br(htmlspecialchars($note))],
            ['name' => 'CURRENT_YEAR', 'content' => date('Y')],
        ];

        try {
            // Usar el mismo template que DSAR (dsar-status-update) que ya existe en Mandrill
            $a->send_notification(
                "info@acuarela.app",
                $requesterEmail,
                $requesterName,
                $mergeVars,
                $emailSubject,
                "dsar-status-update",
                Env::get('MANDRILL_API_KEY'),
                "Acuarela Administration"
            );
        } catch (Exception $e) {
            error_log("FERPA correction notification error: " . $e->getMessage());
        }
    } else {
        // Log para diagnosticar por qué no se envió correo
        if (empty($requesterEmail)) {
            error_log("FERPA correction: no requester email found for request $id");
        }
        if (empty($note)) {
            error_log("FERPA correction: reply_message empty, skipping email for request $id");
        }
    }

    echo json_encode(['success' => true, 'message' => 'Corrección registrada y padre notificado.']);
} catch (Exception $e) {
    error_log("FERPA apply correction error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error interno al aplicar la corrección']);
}

