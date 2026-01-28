<?php
// set/privacy/update_ferpa_status.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../../includes/sdk.php";
// AuditLogger está en 'miembros/cron', fuera de 'acuarela-app-web'
require_once __DIR__ . '/../../../cron/AuditLogger.php';

$a = new Acuarela();
$logger = new AuditLogger();

// Prevenir errores HTML en la respuesta JSON
ini_set('display_errors', 0);
ini_set('log_errors', 1);

$id = isset($_POST['id']) ? $_POST['id'] : null;
$status = isset($_POST['status']) ? $_POST['status'] : null;
$replyMessage = isset($_POST['reply_message']) ? trim($_POST['reply_message']) : '';

if (!$id || !$status) {
    echo json_encode(['success' => false, 'message' => 'Faltan parámetros']);
    exit;
}

// Mapeo simple de estados permitidos (según definición en Strapi)
$allowedStatuses = ['received', 'under_review', 'approved', 'denied', 'completed'];
if (!in_array($status, $allowedStatuses)) {
    echo json_encode(['success' => false, 'message' => 'Estado inválido']);
    exit;
}

// 2. Actualizar estado
$updateData = [
    'status' => $status
];

if (!empty($replyMessage)) {
    $updateData['resolution_notes'] = $replyMessage;
}

// Si se completa, guardar fecha
if ($status == 'completed' || $status == 'approved' || $status == 'denied') {
    $updateData['completed_at'] = date('c');
}

$update = $a->updateFerpaRequest($id, $updateData);

if ($update) {
    // Verificación
    if (isset($update->status) && $update->status !== $status) {
        error_log("FERPA Update Mismatch: Solicitado '$status', Devuelto '{$update->status}'");
        echo json_encode(['success' => false, 'message' => "Error de sincronización con Strapi. Verifique los estados permitidos."]);
        exit;
    }

    // Auditoría
    $logger->log('FERPA_STATUS_CHANGE', [
        'request_id' => $id,
        'new_status' => $status,
        'admin_id' => $_SESSION['user']->acuarelauser->id ?? 'system'
    ]);

    // 3. Notificación (Opcional, similar a DSAR)
    // Se debería investigar el email del requester (que es una relación en FERPA)
    // Como $update suele traer las relaciones populadas si se configuró así en Strapi,
    // intentamos sacar el email. 
    // NOTA: Si 'requester' es relación, Strapi v3 devuelve objeto, v4 devuelve data.

    $requesterEmail = null;
    $requesterName = "Usuario";

    if (isset($update->requester) && is_object($update->requester)) {
        $requesterEmail = $update->requester->mail ?? null;
        $requesterName = $update->requester->name ?? "Usuario";
    }

    if ($requesterEmail && !empty($replyMessage)) {
        // Configurar variables de notificación
        $statusTitle = "Actualización FERPA";
        $emailSubject = "Actualización de su Solicitud Educativa";
        $statusColor = "#0CB5C3"; // Teal por defecto

        if ($status == 'completed' || $status == 'approved') {
            $statusTitle = "Solicitud Aprobada/Completada";
            $statusColor = "#28a745"; // Verde para aprobado
        } elseif ($status == 'denied') {
            $statusTitle = "Solicitud Rechazada";
            $statusColor = "#dc3545"; // Rojo para rechazado
        }

        // Variables para el template dsar-status-update (mismo que usa privacidad)
        $mergeVars = [
            ['name' => 'USER_NAME', 'content' => $requesterName],
            ['name' => 'DSAR_ID', 'content' => substr($id, -6)], // El template espera DSAR_ID
            ['name' => 'STATUS_TITLE', 'content' => $statusTitle],
            ['name' => 'STATUS_COLOR', 'content' => $statusColor],
            ['name' => 'UPDATE_MESSAGE', 'content' => nl2br(htmlspecialchars($replyMessage))],
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
            error_log("FERPA Notification Error: " . $e->getMessage());
        }
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar en Strapi']);
}
?>