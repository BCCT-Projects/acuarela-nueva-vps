<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include "../../includes/sdk.php";
$a = new Acuarela();

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

// Mapeo simple de estados permitidos
$allowedStatuses = ['received', 'in_review', 'in_progress', 'completed', 'rejected'];
if (!in_array($status, $allowedStatuses)) {
    echo json_encode(['success' => false, 'message' => 'Estado inválido']);
    exit;
}

// 2. Actualizar estado
$updateData = [
    'status' => $status
];

// Si se completa, podríamos guardar fecha de completado
if ($status == 'completed') {
    $updateData['completed_at'] = date('c');
}

$update = $a->queryStrapi("dsar-requests/$id", $updateData, 'PUT');

if ($update) {
    // Verificación: Si Strapi devolvió el objeto pero el status NO cambió, es probable que el valor no esté en la lista enumerada (Enum)
    if (isset($update->status) && $update->status !== $status) {
        // Log del problema
        error_log("DSAR Update Mismatch: Solicitado '$status', Strapi devolvió '{$update->status}'. Posible falta de opción en Enum.");
        echo json_encode(['success' => false, 'message' => "La solicitud se procesó pero Strapi no aceptó el estado '$status'. Verifique que '$status' exista en las opciones del campo 'status' en Strapi."]);
        exit;
    }

    // 3. Notificación por correo si hay mensaje de respuesta y el estado es final
    if (!empty($replyMessage)) {
        // Necesitamos el email del solicitante. 
        $requesterEmail = isset($update->requester_email) ? $update->requester_email : null;

        // Fallback: Si Strapi no devuelve el email en el response del PUT
        if (!$requesterEmail) {
            $dsarDetails = $a->queryStrapi("dsar-requests/$id");
            if ($dsarDetails && isset($dsarDetails->requester_email)) {
                $requesterEmail = $dsarDetails->requester_email;
            }
        }

        if ($requesterEmail) {
            $to = $requesterEmail;

            // Intentar obtener el nombre del usuario para personalizar el saludo
            $userName = "Usuario";
            if (isset($update->linked_user) && is_object($update->linked_user)) {
                $userName = isset($update->linked_user->name) ? $update->linked_user->name : "Usuario";
            } elseif (isset($dsarDetails) && isset($dsarDetails->linked_user) && is_object($dsarDetails->linked_user)) {
                $userName = isset($dsarDetails->linked_user->name) ? $dsarDetails->linked_user->name : "Usuario";
            }

            // Configurar variables según el estado
            $statusColor = "#0CB5C3"; // Default Teal
            $statusTitle = "Actualización";
            $emailSubject = "Actualización de Solicitud de Privacidad";

            if ($status == 'completed') {
                $statusColor = "#28a745"; // Success Green
                $statusTitle = "Solicitud Completada";
                $emailSubject = "Solicitud de Privacidad Completada - Acuarela";
            } elseif ($status == 'rejected') {
                $statusColor = "#dc3545"; // Error Red
                $statusTitle = "Solicitud Rechazada/Cancelada";
                $emailSubject = "Información sobre su Solicitud de Privacidad - Acuarela";
            } else {
                $statusColor = "#17a2b8"; // Info Blue for In Progress
                $statusTitle = "Solicitud En Progreso";
            }

            // Variables para la plantilla de Mandrill
            $mergeVars = [
                ['name' => 'USER_NAME', 'content' => $userName],
                ['name' => 'DSAR_ID', 'content' => substr($id, -6)],
                ['name' => 'STATUS_TITLE', 'content' => $statusTitle],
                ['name' => 'STATUS_COLOR', 'content' => $statusColor],
                ['name' => 'UPDATE_MESSAGE', 'content' => nl2br(htmlspecialchars($replyMessage))],
                ['name' => 'CURRENT_YEAR', 'content' => date('Y')]
            ];

            // Nombre de la plantilla en Mandrill
            $templateName = "dsar-status-update";

            try {
                // Usar send_notification que soporta plantillas
                $a->send_notification(
                    "info@acuarela.app",
                    $to,
                    $userName,
                    $mergeVars,
                    $emailSubject,
                    $templateName,
                    Env::get('MANDRILL_API_KEY'),
                    "Acuarela Privacy Team"
                );
            } catch (Exception $e) {
                error_log("Error enviando notificación de estado DSAR: " . $e->getMessage());
                // No detenemos el flujo, ya se actualizó en base de datos
            }
        }
    }

    echo json_encode(['success' => true]);
} else {
    // Loguear error para depuración
    error_log("DSAR Update Failed for ID $id. Response: " . json_encode($update));
    echo json_encode(['success' => false, 'message' => 'Error al actualizar en Strapi']);
}