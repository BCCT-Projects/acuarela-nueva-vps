<?php
include '../includes/config.php';

// Obtener el cuerpo de la solicitud POST
$request_body = file_get_contents('php://input');
$data = json_decode($request_body, true);

function processRequest($data, $a)
{
    // Validar datos requeridos
    if (empty($data['email'])) {
        return ['success' => false, 'message' => 'Correo no proporcionado.'];
    }

    $email = $data['email'];
    $requestType = $data['requestType'] ?? '';
    $reason = $data['reason'] ?? '';

    try {
        // Webhook de Make
        $webhook_url = 'https://hook.us1.make.com/xw4rf39lpa7aw818d5ibd91sget1yaag';

        $webhook_data = array(
            'email' => $email,
            'requestType' => $requestType,
            'reason' => $reason
        );

        // Enviar a Make con cURL
        $ch = curl_init($webhook_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($webhook_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception('Error al enviar a Make: ' . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode < 200 || $httpCode >= 300) {
            throw new Exception('Make webhook responded with HTTP code: ' . $httpCode);
        }

        // Enviar email (ajusta los parámetros según lo que necesites)
        // Nota: Faltan algunos parámetros en tu ejemplo original (name, phone, etc.)
        $emailSent = $a->sendEmailDeleteRequest($email, $requestType, $reason);

        if (!$emailSent) {
            throw new Exception('Error al enviar el correo');
        }

        return ['success' => true, 'message' => 'Solicitud procesada correctamente.'];
    } catch (Exception $e) {
        return ['success' => false, 'message' => $e->getMessage()];
    }
}

$response = processRequest($data, $a);
http_response_code($response['success'] ? 200 : 400);
echo json_encode($response);
