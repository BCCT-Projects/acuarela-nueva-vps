<?php
// set/privacy/submit_ferpa.php
session_start();

// PREVENIR ERRORES HTML EN RESPUESTA JSON
ini_set('display_errors', 0);
ini_set('log_errors', 1);

require_once __DIR__ . "/../../includes/sdk.php";
// AuditLogger está en 'miembros/cron', fuera de 'acuarela-app-web'
require_once __DIR__ . '/../../../cron/AuditLogger.php';
require_once __DIR__ . '/../../../../includes/SecurityAuditLogger.php';
require_once __DIR__ . '/../../includes/env.php';

$a = new Acuarela();
$logger = new AuditLogger();

header('Content-Type: application/json');

// Modo de operación: 'validate' solo valida identidad y devuelve hijos; por defecto 'submit'
$mode = filter_input(INPUT_POST, 'mode', FILTER_SANITIZE_STRING) ?? 'submit';

// Verificar sesión si existe, sino intentar buscar usuario por email/teléfono
$currentUser = null;
$userId = null;
$userEmail = filter_input(INPUT_POST, 'requester_email', FILTER_VALIDATE_EMAIL);
$userPhone = filter_input(INPUT_POST, 'requester_phone', FILTER_SANITIZE_STRING);

// NOTA IMPORTANTE:
// Este endpoint se usa desde un formulario público. Si hay sesión activa (por ejemplo, un admin logueado),
// NO debemos ignorar el email/teléfono ingresado por el tutor.
// Por eso SOLO usamos sesión si NO se envió identidad (email/teléfono).
if ((empty($userEmail) || empty($userPhone)) && isset($_SESSION['user']) && isset($_SESSION['user']->acuarelauser->id)) {
    $currentUser = $_SESSION['user']->acuarelauser;
    $userId = $currentUser->id;
    $userEmail = $currentUser->mail; // Sobrescribir input con dato seguro de sesión
} else {
    // Lógica de Verificación de Identidad (similar a DSAR)
    if (empty($userEmail) || empty($userPhone)) {
        echo json_encode(['success' => false, 'message' => 'Email y Teléfono son requeridos para validar su identidad.']);
        exit;
    }

    // Inicializar crypto si es necesario
    if (method_exists($a, 'initCrypto')) {
        $a->initCrypto();
    }

    // Buscar usuario por email (normalizado)
    $emailNorm = strtolower(trim($userEmail));
    $queryParams = http_build_query(['mail' => $emailNorm, '_limit' => 5]);
    $users = $a->queryStrapi("acuarelausers?$queryParams", null, "GET");

    // Mensaje genérico seguro para no revelar existencia
    $genericSuccess = ['success' => true, 'message' => 'Solicitud recibida. Si sus datos coinciden, recibirá confirmación.'];

    if (empty($users) || !is_array($users)) {
        echo json_encode($mode === 'validate' ? ['success' => false, 'message' => 'No pudimos validar sus datos.'] : $genericSuccess);
        exit;
    }

    $verifiedUser = null;

    foreach ($users as $user) {
        if (!isset($user->phone)) {
            continue;
        }

        $storedPhone = $user->phone;
        // Descifrar teléfono si está cifrado
        if (isset($a->crypto) && $a->crypto) {
            try {
                if ($a->crypto->isEncrypted($storedPhone)) {
                    $storedPhone = $a->crypto->decrypt($storedPhone);
                }
            } catch (Exception $e) {
                continue;
            }
        }

        $cleanStored = preg_replace('/[^0-9]/', '', $storedPhone);
        $cleanInput = preg_replace('/[^0-9]/', '', $userPhone);

        // Match exacto o últimos 6 dígitos
        if ($cleanStored === $cleanInput || (strlen($cleanInput) >= 6 && substr($cleanStored, -6) === substr($cleanInput, -6))) {
            $verifiedUser = $user;

            // Refetch completo para asegurar datos
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
        echo json_encode($mode === 'validate' ? ['success' => false, 'message' => 'No pudimos validar sus datos.'] : $genericSuccess);
        exit;
    }

    $currentUser = $verifiedUser;
    $userId = $currentUser->id;
    // asegurar email normalizado
    $userEmail = $emailNorm;
}

// Determinar daycare asociado (similar a DSAR) para enlazar en Strapi
$daycareId = null;
if (isset($currentUser->daycares) && is_array($currentUser->daycares) && count($currentUser->daycares) > 0) {
    $daycareVal = $currentUser->daycares[0];
    if (is_object($daycareVal)) {
        $daycareId = $daycareVal->id ?? null;
    } else {
        $daycareId = $daycareVal;
    }
}
if (!$daycareId && isset($currentUser->daycare)) {
    $daycareVal = $currentUser->daycare;
    if (is_object($daycareVal)) {
        $daycareId = $daycareVal->id ?? null;
    } else {
        $daycareId = $daycareVal;
    }
}

// Si solo estamos validando, devolver lista de hijos asociados (si la hay)
if ($mode === 'validate') {
    $childrenList = [];

    try {
        // Normalizar email (Strapi suele guardar lowercase; evitar fallos por mayúsculas/espacios)
        $emailNorm = strtolower(trim($userEmail));

        // Usar directamente parental-consents filtrado por parent_email,
        // que ya incluye el objeto child_id poblado (como vimos en test_ferpa_lookup).
        $qEmail = http_build_query(['parent_email' => $emailNorm, '_limit' => 200, '_sort' => 'createdAt:DESC']);
        $consents = $a->queryStrapi("parental-consents?$qEmail", null, "GET");

        // Compatibilidad: algunos endpoints devuelven { response: [...] }
        if (!is_array($consents) && isset($consents->response) && is_array($consents->response)) {
            $consents = $consents->response;
        }

        // Fallback: si no hay match exacto, intentar contains (útil si hay espacios o variaciones)
        if ((!is_array($consents) || empty($consents)) && !empty($emailNorm)) {
            $qEmail2 = http_build_query(['parent_email_contains' => $emailNorm, '_limit' => 50, '_sort' => 'createdAt:DESC']);
            $consents2 = $a->queryStrapi("parental-consents?$qEmail2", null, "GET");
            if (!is_array($consents2) && isset($consents2->response) && is_array($consents2->response)) {
                $consents2 = $consents2->response;
            }
            if (is_array($consents2) && !empty($consents2)) {
                $consents = $consents2;
            }
        }

        if (method_exists($a, 'initCrypto')) {
            $a->initCrypto();
        }

        // Unir fuentes:
        // 1) parental-consents.child_id (fuente “legal”)
        // 2) currentUser->children (relación directa del usuario verificado; evita casos donde falta el consent)
        $seenKids = [];
        $candidateKids = [];

        if (is_array($consents) && !empty($consents)) {
            foreach ($consents as $consent) {
                if (!isset($consent->child_id)) continue;
                $candidateKids[] = $consent->child_id;
            }
        }

        if (isset($currentUser->children) && is_array($currentUser->children) && !empty($currentUser->children)) {
            foreach ($currentUser->children as $kid) {
                $candidateKids[] = $kid;
            }
        }

        foreach ($candidateKids as $kid) {
            $kidObj = $kid;
            $kidId = null;

            if (is_object($kidObj)) {
                $kidId = $kidObj->id ?? ($kidObj->_id ?? null);
            } else {
                $kidId = $kidObj;
            }

            if (!$kidId || isset($seenKids[$kidId])) continue;
            $seenKids[$kidId] = true;

            // Si solo tenemos ID, traer el niño
            if (!is_object($kidObj)) {
                $kidObj = $a->getChildren($kidId);
                if (!$kidObj) continue;
            }

            $dec = $a->decryptChildData($kidObj);
            $fullName = trim(($dec->name ?? '') . ' ' . ($dec->lastname ?? ''));

            $childrenList[] = [
                'id' => $kidId,
                'name' => $fullName ?: 'Estudiante sin nombre'
            ];
        }
    } catch (Exception $e) {
        error_log("FERPA validate children error: " . $e->getMessage());
    }

    echo json_encode([
        'success' => true,
        'children' => $childrenList
    ]);
    exit;
}

// --- Modo envío completo ---

// Validar reCAPTCHA
$secretKey = Env::get('RECAPTCHA_SECRET_KEY');
$captchaResponse = filter_input(INPUT_POST, 'g-recaptcha-response', FILTER_SANITIZE_STRING);

if ($secretKey) {
    if (empty($captchaResponse)) {
        echo json_encode(['success' => false, 'message' => 'Por favor complete el captcha.']);
        exit;
    }

    $verifyUrl = "https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$captchaResponse}";
    $verifyResponse = file_get_contents($verifyUrl);
    $responseData = json_decode($verifyResponse);

    if (!$responseData->success) {
        echo json_encode(['success' => false, 'message' => 'Validación de seguridad fallida.']);
        exit;
    }
}

$requestType = filter_input(INPUT_POST, 'request_type', FILTER_SANITIZE_STRING);
$childId = filter_input(INPUT_POST, 'child_id', FILTER_SANITIZE_STRING); // OJO: Si viene vacío, puede ser manual
$childNameManual = filter_input(INPUT_POST, 'child_name', FILTER_SANITIZE_STRING);
$details = filter_input(INPUT_POST, 'details', FILTER_SANITIZE_STRING);
$recordType = filter_input(INPUT_POST, 'record_type', FILTER_SANITIZE_STRING);
$recordRef = filter_input(INPUT_POST, 'record_ref', FILTER_SANITIZE_STRING);

// Si no hay ID de niño (porque vino de input manual), incluimos el nombre en la descripción
if (empty($childId) && !empty($childNameManual)) {
    $details = "ESTUDIANTE SOLICITADO (Manual): " . $childNameManual . "\n\n" . $details;
}

if (empty($requestType)) {
    echo json_encode(['success' => false, 'message' => 'Tipo de solicitud es obligatorio.']);
    exit;
}

// Para correcciones, exigir al menos record_type (record_ref puede ser descriptivo si no hay ID)
if ($requestType === 'correction' && empty($recordType)) {
    echo json_encode(['success' => false, 'message' => 'Para solicitudes de corrección debe indicar el tipo de registro.']);
    exit;
}

// Preparar datos FERPA
$ferpaData = [
    'request_type' => $requestType,
    'requester' => $userId,
    'child' => $childId ?: null,
    'status' => 'received',
    'daycare' => $daycareId,
    'description' => $details,
    'record_type' => $recordType ?: null,
    'record_ref' => $recordRef ?: null,
    'created_at' => date('c'), // Strapi suele poner esto solo, pero por si acaso
];

// Enviar a Strapi usando el nuevo método del SDK
$newRequest = $a->createFerpaRequest($ferpaData);

if (!$newRequest || !isset($newRequest->id)) {
    error_log("FERPA Create Error: " . json_encode($newRequest));
    echo json_encode(['success' => false, 'message' => 'Error interno al procesar la solicitud. Por favor intente más tarde.']);
    exit;
}

// 6. Auditoría Local
$event = ($requestType === 'correction') ? 'ferpa_correction_requested' : 'ferpa_access_requested';

SecurityAuditLogger::log($event, SecurityAuditLogger::SEVERITY_INFO, [
    'request_id' => $newRequest->id,
    'request_type' => $requestType,
    'child_id' => $childId ?: null,
    'record_type' => $recordType ?: null
]);

// Determinar nombre del estudiante para el correo (si aplica)
$childName = $childNameManual;
if ($childId) {
    try {
        $child = $a->queryStrapi("children/$childId");
        if ($child) {
            if (method_exists($a, 'initCrypto')) {
                $a->initCrypto();
            }
            $decChild = $a->decryptChildData($child);
            $childName = trim(
                ($decChild->name ?? '') . ' ' . ($decChild->lastname ?? '')
            );
        }
    } catch (Exception $e) {
        error_log("FERPA fetch child error: " . $e->getMessage());
    }
}

echo json_encode(['success' => true, 'message' => 'Solicitud FERPA enviada correctamente.']);
?>