<?php
// set/privacy/verify_dsar.php
session_start();

require_once __DIR__ . "/../../includes/sdk.php";
$a = new Acuarela();

$token = $_GET['token'] ?? '';

// Estilos básicos para la respuesta visual
$css = "
<style>
    body { font-family: 'Segoe UI', system-ui, sans-serif; background: #F9FAFB; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
    .card { background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); max-width: 480px; text-align: center; }
    h1 { color: #111827; margin-bottom: 0.5rem; }
    p { color: #6B7280; line-height: 1.5; }
    .btn { display: inline-block; margin-top: 1.5rem; padding: 0.75rem 1.5rem; background: #0CB5C3; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; }
    .btn:hover { background: #0aa3b0; }
    .error { color: #E65252; }
    .success { color: #065F46; }
</style>
";

if (empty($token)) {
    die("$css <div class='card'><h1 class='error'>Error</h1><p>Token de verificación inválido o faltante.</p><a href='../../privacy/dsar.php' class='btn'>Volver</a></div>");
}

// 1. Buscar la solicitud por token
$queryParams = http_build_query([
    'verification_token' => $token,
    'identity_status' => 'pending' // Solo verificar las pendientes
]);

$requests = $a->queryStrapi("dsar-requests?$queryParams");

if (empty($requests) || !is_array($requests)) {
    // Verificar si ya fue verificada (buscar solo por token)
    $allRequests = $a->queryStrapi("dsar-requests?verification_token=$token");
    if (!empty($allRequests) && $allRequests[0]->identity_status === 'verified') {
        die("$css <div class='card'><h1 class='success'>¡Ya Verificado!</h1><p>Esta solicitud ya ha sido verificada anteriormente. Nuestro equipo está procesándola.</p><a href='../../' class='btn'>Ir al Inicio</a></div>");
    }

    die("$css <div class='card'><h1 class='error'>Enlace Expirado</h1><p>No pudimos encontrar una solicitud pendiente con este enlace. Es posible que haya expirado o ya haya sido utilizada.</p><a href='../../privacy/dsar.php' class='btn'>Nueva Solicitud</a></div>");
}

$dsar = $requests[0];

// 2. Calcular Fecha Límite (45 días desde HOY, fecha de verificación)
$dueDate = date('Y-m-d', strtotime('+45 days'));

// 3. Actualizar Estado
$updateData = [
    'identity_status' => 'verified',
    'status' => 'in_review',
    'due_at' => $dueDate,
    // Invalidar token para que no se use de nuevo (opcional, o mantenerlo como referencia)
    // 'verification_token' => null 
];

$result = $a->queryStrapi("dsar-requests/{$dsar->id}", $updateData, "PUT");

if ($result && isset($result->id)) {
    // 4. Notificar Internamente (Legal/Soporte)
    // TODO: Configurar email de notificaciones internas
    // $a->send_notification( ... );

    echo "$css 
    <div class='card'>
        <h1 class='success'>¡Identidad Verificada!</h1>
        <p>Gracias por confirmar su solicitud. Hemos iniciado el proceso formal.</p>
        <p><strong>Fecha estimada de respuesta:</strong> " . date('d/m/Y', strtotime($dueDate)) . "</p>
        <p>Le mantendremos informado por correo electrónico sobre el progreso de su caso.</p>
        <a href='../../' class='btn'>Volver al Inicio</a>
    </div>";
} else {
    echo "$css <div class='card'><h1 class='error'>Error del Sistema</h1><p>Ocurrió un error al actualizar su solicitud. Por favor contacte a soporte.</p></div>";
}
?>