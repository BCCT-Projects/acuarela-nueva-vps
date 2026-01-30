<?php
// set/privacy/submit_dsar.php
session_start();

// PREVENIR ERRORES HTML EN RESPUESTA JSON
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once __DIR__ . "/../../includes/sdk.php";
$a = new Acuarela();

// Inicializar servicio de cifrado para poder descifrar el teléfono
if (method_exists($a, 'initCrypto')) {
    $a->initCrypto();
} elseif (isset($a->crypto) && $a->crypto === null) {
    // Fallback si initCrypto no existe pero la propiedad sí
    // Intentar inicializar manualmente si es posible, o confiar en que el constructor lo hizo si se modificó sdk
}

header('Content-Type: application/json');

$requestType = filter_input(INPUT_POST, 'request_type', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'requester_email', FILTER_VALIDATE_EMAIL);
$phoneInput = filter_input(INPUT_POST, 'requester_phone', FILTER_SANITIZE_STRING);
$details = filter_input(INPUT_POST, 'details', FILTER_SANITIZE_STRING);

// 1. Validaciones Básicas
if (empty($email) || empty($phoneInput) || empty($requestType)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos obligatorios deben ser completados.']);
    exit;
}

// 2. Validar reCAPTCHA
require_once __DIR__ . '/../../includes/env.php';
$secretKey = Env::get('RECAPTCHA_SECRET_KEY');
$captchaResponse = filter_input(INPUT_POST, 'g-recaptcha-response', FILTER_SANITIZE_STRING);

if ($secretKey && !empty($captchaResponse)) {
    $verifyUrl = "https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$captchaResponse}";
    $verifyResponse = file_get_contents($verifyUrl);
    $responseData = json_decode($verifyResponse);

    if (!$responseData->success) {
        echo json_encode(['success' => false, 'message' => 'Validación de seguridad fallida.']);
        exit;
    }
} elseif ($secretKey) {
    echo json_encode(['success' => false, 'message' => 'Por favor complete el captcha.']);
    exit;
}

// 3. Buscar Usuario en Strapi (Por Email)
// Nota: Asumimos que el correo en acuarelausers NO está cifrado (es estándar para logins).
$queryParams = http_build_query([
    'mail' => $email,
    '_limit' => 5
]);

$users = $a->queryStrapi("acuarelausers?$queryParams", null, "GET");

// Mensaje genérico de seguridad para no revelar si el usuario existe o no
$genericSuccessMsg = ['success' => true, 'message' => 'Solicitud recibida. Si sus datos coinciden con nuestros registros, recibirá un correo de confirmación en breve.'];

if (empty($users) || !is_array($users)) {
    // Por seguridad, respondemos éxito genérico aunque no lo hayamos encontrado
    echo json_encode($genericSuccessMsg);
    exit;
}

$verifiedUser = null;

// 4. Verificar Teléfono (Descifrando)
foreach ($users as $user) {
    if (!isset($user->phone))
        continue;

    $storedPhone = $user->phone;

    // Descifrar si es necesario
    if (isset($a->crypto) && $a->crypto) {
        try {
            if ($a->crypto->isEncrypted($storedPhone)) {
                $storedPhone = $a->crypto->decrypt($storedPhone);
            }
        } catch (Exception $e) {
            error_log("DSAR Error decrypting phone for user {$user->id}: " . $e->getMessage());
            continue;
        }
    }

    // Normalizar para comparación (quitar espacios, guiones, paréntesis)
    $cleanStored = preg_replace('/[^0-9]/', '', $storedPhone);
    $cleanInput = preg_replace('/[^0-9]/', '', $phoneInput);

    // Comparación: Permitimos coincidencia exacta o últimos 6 dígitos para flexibilidad
    if ($cleanStored === $cleanInput || (strlen($cleanInput) >= 6 && substr($cleanStored, -6) === substr($cleanInput, -6))) {
        $verifiedUser = $user;

        // ESTRATEGIA ROBUSTA:
        // La búsqueda por lista (?mail=...) a veces devuelve objetos incompletos en Strapi.
        // Hacemos una llamada directa al ID para asegurar que traemos todas las relaciones (daycares).
        if (isset($verifiedUser->id)) {
            $fullUser = $a->queryStrapi("acuarelausers/" . $verifiedUser->id);
            if ($fullUser && isset($fullUser->id)) {
                $verifiedUser = $fullUser;
            }
        }
        break;
    }
}

if (!$verifiedUser) {
    // Email existe, pero teléfono no coincide -> Fallo silencioso (Mensaje genérico)
    echo json_encode($genericSuccessMsg);
    exit;
}

// 5. Verificar si ya existe una solicitud pendiente para este usuario para evitar duplicados
$pendingParams = http_build_query([
    'linked_user' => $verifiedUser->id,
    'status_in' => ['received', 'in_review', 'in_progress'],
    'request_type' => $requestType
]);
$existingRequests = $a->queryStrapi("dsar-requests?$pendingParams");

if (!empty($existingRequests) && count($existingRequests) > 0) {
    echo json_encode(['success' => true, 'message' => 'Ya tiene una solicitud de este tipo en curso. Revise su correo para el seguimiento.']);
    exit;
}

// 6. Crear Registro DSAR
try {
    $verificationToken = bin2hex(random_bytes(32));
} catch (Exception $e) {
    $verificationToken = bin2hex(openssl_random_pseudo_bytes(32));
}

$daycareId = null;

if (isset($verifiedUser->daycares) && is_array($verifiedUser->daycares) && count($verifiedUser->daycares) > 0) {
    // Tomamos el primer daycare asociado por defecto
    $daycareVal = $verifiedUser->daycares[0];

    // En Strapi 3 a veces viene como objeto completo, a veces solo ID si no está populado profundamente
    if (is_object($daycareVal)) {
        $daycareId = $daycareVal->id ?? null;
    } else {
        $daycareId = $daycareVal; // Si es un string/ID directo
    }
}

// Fallback: Verificar relación singular 'daycare' (común en ciertos modelos de datos Strapi)
if (!$daycareId && isset($verifiedUser->daycare)) {
    $daycareVal = $verifiedUser->daycare;
    if (is_object($daycareVal)) {
        $daycareId = $daycareVal->id ?? null;
    } else {
        $daycareId = $daycareVal;
    }
}

$dsarData = [
    'request_type' => $requestType,
    'requester_email' => $email,
    'requester_phone' => $phoneInput,
    'linked_user' => $verifiedUser->id,
    'daycare' => $daycareId, // Relacionamos con el daycare para filtrado rápido
    'identity_status' => 'pending',
    'status' => 'received',
    'verification_token' => $verificationToken,
    'notes' => $details,
    'received_at' => date('c'),
    'due_at' => date('c', strtotime('+45 days')) // Plazo legal estándar (CCPA/GDPR) para control de tiempos
];

$newDsar = $a->queryStrapi("dsar-requests", $dsarData, "POST");

if (!$newDsar || !isset($newDsar->id)) {
    echo json_encode(['success' => false, 'message' => 'Error interno al procesar la solicitud.']);
    exit;
}

// 7. Enviar Correo de Verificación
$baseUrl = Env::get('APP_URL', 'https://acuarela.app/miembros/acuarela-app-web');
$verifyLink = "$baseUrl/set/privacy/verify_dsar.php?token=$verificationToken";

$mergeVars = [
    ['name' => 'USER_NAME', 'content' => $verifiedUser->name . ' ' . $verifiedUser->lastname],
    ['name' => 'REQUEST_TYPE', 'content' => strtoupper($requestType)],
    ['name' => 'VERIFY_LINK', 'content' => $verifyLink],
    ['name' => 'CURRENT_DATE', 'content' => date('d/m/Y')]
];

// Usar una plantilla existente o crear una nueva 'dsar-verification'
// Fallback a envío genérico si no existe plantilla específica aún
$templateName = "dsar-verification"; // Asegurarse de crear esta plantilla en Mandrill

// Si falla el envío de correos, al menos el registro está creado, pero el usuario no podrá verificar.
// Loguear error si ocurre.
try {
    $a->send_notification(
        "info@acuarela.app",
        $email,
        $verifiedUser->name,
        $mergeVars,
        "Confirme su Solicitud de Privacidad - Acuarela",
        $templateName,
        Env::get('MANDRILL_API_KEY'),
        "Acuarela Privacy Team"
    );
} catch (Exception $e) {
    error_log("DSAR Email Error: " . $e->getMessage());
}

echo json_encode($genericSuccessMsg);
?>