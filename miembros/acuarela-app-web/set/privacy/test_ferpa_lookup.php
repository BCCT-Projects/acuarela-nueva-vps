<?php
// set/privacy/test_ferpa_lookup.php
// Script de prueba/manual para entender cómo se relacionan:
// - parental-consents.parent_email
// - parental-consents.child_id
// - children (nombres cifrados)

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../includes/sdk.php';
require_once __DIR__ . '/../../includes/env.php';

$a = new Acuarela();
if (method_exists($a, 'initCrypto')) {
    $a->initCrypto();
}

$email = $_GET['email'] ?? '';

if (empty($email)) {
    echo json_encode([
        'success' => false,
        'message' => 'Proporciona ?email=correo@dominio.com en la URL.',
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

$output = [
    'success' => true,
    'tested_email' => $email,
];

// 1) Usuario acuarela (acuarelausers) por mail
$queryUser = http_build_query([
    'mail' => $email,
    '_limit' => 5,
]);
$users = $a->queryStrapi("acuarelausers?$queryUser", null, "GET");
$output['acuarelausers_raw'] = $users;

$userId = null;
$daycareId = null;

if (is_array($users) && count($users) > 0) {
    $user = $users[0];
    $userId = $user->id ?? null;

    // Detectar daycare igual que DSAR
    if (isset($user->daycares) && is_array($user->daycares) && count($user->daycares) > 0) {
        $daycareVal = $user->daycares[0];
        if (is_object($daycareVal)) {
            $daycareId = $daycareVal->id ?? null;
        } else {
            $daycareId = $daycareVal;
        }
    } elseif (isset($user->daycare)) {
        $daycareVal = $user->daycare;
        if (is_object($daycareVal)) {
            $daycareId = $daycareVal->id ?? null;
        } else {
            $daycareId = $daycareVal;
        }
    }
}

$output['resolved_user_id'] = $userId;
$output['resolved_daycare_id'] = $daycareId;

// 2) Consentimientos COPPA por parent_email
$queryConsentsByEmail = http_build_query([
    'parent_email' => $email,
]);
$consentsByEmail = $a->queryStrapi("parental-consents?$queryConsentsByEmail", null, "GET");
$output['parental_consents_by_email'] = $consentsByEmail;

// 3) Si tenemos daycare, listar todos los niños del daycare y sus consentimientos
$kidsSummary = [];
if ($daycareId) {
    $kids = $a->getChildren("", $daycareId);

    if (is_array($kids)) {
        foreach ($kids as $kid) {
            $kidId = null;
            if (is_object($kid) && isset($kid->id)) {
                $kidId = $kid->id;
            } elseif (is_array($kid) && isset($kid['id'])) {
                $kidId = $kid['id'];
            }
            if (!$kidId) {
                continue;
            }

            $decKid = $a->decryptChildData($kid);
            $name = trim(($decKid->name ?? '') . ' ' . ($decKid->lastname ?? ''));

            $q = http_build_query([
                'child_id' => $kidId,
                'parent_email' => $email,
            ]);
            $consents = $a->queryStrapi("parental-consents?$q", null, "GET");

            $kidsSummary[] = [
                'child_id' => $kidId,
                'name_decrypted' => $name,
                'consents_with_email' => $consents,
            ];
        }
    }
}

$output['kids_by_daycare_with_consents'] = $kidsSummary;

// 4) FERPA requests crudas para este daycare (si aplica)
if ($daycareId) {
    $ferpaRaw = $a->queryStrapi("ferpa-requests?daycare=$daycareId&_sort=created_at:DESC", null, "GET");
    $output['ferpa_requests_raw'] = $ferpaRaw;
}

echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

