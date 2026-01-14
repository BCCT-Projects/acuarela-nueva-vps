<?php
error_reporting(0);
ob_start();
include '../includes/config.php';
require_once '../acuarela-app-web/includes/env.php';

// Normaliza los datos
$email = strtolower(trim($_POST['email']));
$password = $_POST['password'];

$_SESSION["estanoesunacontrasena"] = $password;
$userLogin = $a->loginBilingualUser($email, $password);

// Asegurar que los daycares estén disponibles en la respuesta
// Si $userLogin tiene estructura response[0], extraer el objeto
if (isset($userLogin->response) && is_array($userLogin->response) && !empty($userLogin->response)) {
    $userLogin = $userLogin->response[0];
}

if (isset($userLogin->id)) {
    // 2FA IMPLEMENTATION
    // Generar código de 6 dígitos
    $code = rand(100000, 999999);

    // Guardar datos temporales para 2FA
    $_SESSION['temp_2fa'] = [
        'session_backup' => [
            'user' => $_SESSION['user'],
            'userLogged' => $_SESSION['userLogged'],
            'userAll' => $_SESSION['userAll']
        ],
        'code' => $code,
        'timestamp' => time(),
        'email' => $email
    ];

    // SEGURIDAD CRÍTICA: Destruir sesión autenticada para evitar bypass
    // El usuario no debe tener acceso hasta que verifique el código
    unset($_SESSION['user']);
    unset($_SESSION['userLogged']);
    unset($_SESSION['userAll']);

    // Enviar correo con el código
    // Usamos el template 'portal-miembros-2fa' (deberás crearlo en Mandrill o usar uno genérico por ahora)
    $mergeVars = [
        'CODE' => $code,
        'FNAME' => $userLogin->name ?? 'Usuario'
    ];

    try {
        $a->send_notification(
            'info@acuarela.app',
            $email,
            $userLogin->name,
            $a->transformMergeVars($mergeVars),
            "Tu código de verificación",
            'portal-miembros-2fa', // NOMBRE DEL TEMPLATE A CREAR
            Env::get('MANDRILL_API_KEY', 'maRkSStgpCapJoSmwHOZDg'),
            "Bilingual Childcare Training"
        );
    } catch (Exception $e) {
        error_log("Error mandrill: " . $e->getMessage());
        // Falla silenciosa o retorno de error
        echo json_encode(['getError' => true, 'message' => 'Error al enviar email de verificación.']);
        exit;
    }

    // No iniciamos sesión completa aún, solo retornamos flag
    ob_clean(); // Limpiar cualquier output previo (warnings, espacios, etc)
    echo json_encode(['require_2fa' => true]);
    exit;
}

// Los daycares deberían estar en $_SESSION["user"] después del login
// Verificar diferentes estructuras posibles
if (!isset($userLogin->daycares) || empty($userLogin->daycares)) {
    // Intentar obtener de la sesión directamente
    if (isset($_SESSION["user"]->daycares) && !empty($_SESSION["user"]->daycares)) {
        $userLogin->daycares = $_SESSION["user"]->daycares;
    }
    // Si la sesión tiene estructura response
    elseif (isset($_SESSION["user"]->response) && is_array($_SESSION["user"]->response) && !empty($_SESSION["user"]->response)) {
        $sessionUser = $_SESSION["user"]->response[0];
        if (isset($sessionUser->daycares) && !empty($sessionUser->daycares)) {
            $userLogin->daycares = $sessionUser->daycares;
        }
    }
    // Si aún no tiene, intentar desde userInfoAll
    elseif (isset($_SESSION["userAll"]->daycares) && !empty($_SESSION["userAll"]->daycares)) {
        $userLogin->daycares = $_SESSION["userAll"]->daycares;
    }
}

echo json_encode($userLogin);

