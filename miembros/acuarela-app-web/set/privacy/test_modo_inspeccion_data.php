<?php
/**
 * Endpoint de debugging para verificar cómo llegan los datos desde Strapi
 * para el reporte de `modo-inspeccion`.
 *
 * Seguridad:
 * - Requiere sesión (admin logueado) O un header X-Debug-Key que coincida con DEBUG_ENDPOINT_KEY (.env)
 *
 * Uso (GET):
 *   /miembros/acuarela-app-web/set/privacy/test_modo_inspeccion_data.php?daycare=ID&from=YYYY-MM-DD&to=YYYY-MM-DD
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../includes/sdk.php";
require_once __DIR__ . "/../../includes/env.php";

// Evitar que errores rompan JSON
ini_set('display_errors', 0);
ini_set('log_errors', 1);
header('Content-Type: application/json');

// Seguridad: permitir solo con sesión o debug key
$hasSession = isset($_SESSION['userLogged']) || isset($_SESSION['user']);
$debugKey = Env::get('DEBUG_ENDPOINT_KEY', '');
$headerKey = $_SERVER['HTTP_X_DEBUG_KEY'] ?? '';

if (!$hasSession) {
    if (empty($debugKey) || !hash_equals($debugKey, $headerKey)) {
        http_response_code(403);
        echo json_encode(['ok' => false, 'message' => 'Forbidden']);
        exit;
    }
}

$a = new Acuarela();
if (method_exists($a, 'initCrypto')) {
    $a->initCrypto();
}

$daycareId = $_GET['daycare'] ?? '';
$from = $_GET['from'] ?? null; // YYYY-MM-DD
$to = $_GET['to'] ?? null;     // YYYY-MM-DD
$limit = (int)($_GET['limit'] ?? 10);
if ($limit <= 0 || $limit > 50) $limit = 10;

if (!$daycareId) {
    echo json_encode(['ok' => false, 'message' => 'Missing daycare']);
    exit;
}

// Helpers
function safeDate($v) {
    if (!$v) return null;
    return preg_match('/^\d{4}-\d{2}-\d{2}$/', $v) ? $v : null;
}
$from = safeDate($from);
$to = safeDate($to);

try {
    // Daycare info
    $daycare = $a->getDaycareInfo($daycareId);

    // Children
    $children = $a->getChildren("", $daycareId);
    $childrenList = [];
    if (isset($children->response) && is_array($children->response)) $childrenList = $children->response;
    elseif (is_array($children)) $childrenList = $children;

    $childrenSample = array_slice($childrenList, 0, $limit);
    $childrenDecryptedSample = [];
    foreach ($childrenSample as $c) {
        $childrenDecryptedSample[] = $a->decryptChildData($c);
    }

    // IDs de niños (para filtrar checkins/checkouts por relación child)
    $childIds = [];
    foreach ($childrenList as $c) {
        $cid = $c->id ?? ($c->_id ?? null);
        if ($cid) $childIds[] = $cid;
    }
    $childIds = array_values(array_unique($childIds));

    // Posts (probar ambas variantes)
    $postsA = $a->queryStrapi("posts?daycareId=$daycareId&_sort=createdAt:DESC&_limit=$limit");
    $postsB = $a->queryStrapi("posts?daycare=$daycareId&_sort=createdAt:DESC&_limit=$limit");

    // Asistencia
    // En este Strapi, checkins/checkouts usan relación `children[]` y `datetime`.
    // Para depurar duplicados: traemos por rango de fechas (si existe) y filtramos por los children del daycare.
    $asistenciaCdas = $a->queryStrapi("asistencia-cdas?_sort=createdAt:DESC&_limit=$limit");

    $dateQuery = '';
    if ($from) $dateQuery .= '&datetime_gte=' . urlencode($from . 'T00:00:00.000Z');
    if ($to) $dateQuery .= '&datetime_lte=' . urlencode($to . 'T23:59:59.999Z');

    // Nota: no asumimos que Strapi soporte children_in; filtramos en PHP con los childIds del daycare
    $checkinsRaw = $a->queryStrapi("checkins?_sort=datetime:DESC&_limit=50{$dateQuery}");
    $checkoutsRaw = $a->queryStrapi("checkouts?_sort=datetime:DESC&_limit=50{$dateQuery}");

    $checkinsArr = is_array($checkinsRaw) ? $checkinsRaw : (isset($checkinsRaw->response) && is_array($checkinsRaw->response) ? $checkinsRaw->response : []);
    $checkoutsArr = is_array($checkoutsRaw) ? $checkoutsRaw : (isset($checkoutsRaw->response) && is_array($checkoutsRaw->response) ? $checkoutsRaw->response : []);

    $checkinsKeys = [];
    $checkoutsKeys = [];
    if (!empty($checkinsArr)) $checkinsKeys = array_keys((array)$checkinsArr[0]);
    if (!empty($checkoutsArr)) $checkoutsKeys = array_keys((array)$checkoutsArr[0]);

    $childIdSet = array_fill_keys($childIds, true);
    $matched = [
        'checkins' => [],
        'checkouts' => [],
    ];

    $extractMatches = function ($rows, $type) use (&$matched, $childIdSet) {
        foreach ($rows as $r) {
            $rawId = $r->id ?? ($r->_id ?? null);
            $dt = $r->datetime ?? $r->createdAt ?? $r->created_at ?? null;
            $kids = $r->children ?? [];
            if (!is_array($kids)) $kids = [];

            foreach ($kids as $kid) {
                $kidId = $kid->id ?? ($kid->_id ?? null);
                if (!$kidId) continue;
                if (!isset($childIdSet[$kidId])) continue;

                $matched[$type][] = [
                    'raw_id' => $rawId,
                    'datetime' => $dt,
                    'child_id' => $kidId,
                ];
            }
        }
    };

    $extractMatches($checkinsArr, 'checkins');
    $extractMatches($checkoutsArr, 'checkouts');

    // Dedup keys
    $uniqueKeys = [];
    foreach (['checkins','checkouts'] as $t) {
        $u = [];
        foreach ($matched[$t] as $m) {
            $k = ($t . '|' . ($m['raw_id'] ?? '') . '|' . ($m['child_id'] ?? '') . '|' . ($m['datetime'] ?? ''));
            $u[$k] = $m;
        }
        $uniqueKeys[$t] = array_values($u);
    }

    // Asistentes
    $asistentes = $a->getAsistentes("", $daycareId);

    echo json_encode([
        'ok' => true,
        'daycare' => $daycare,
        'filters' => ['from' => $from, 'to' => $to, 'limit' => $limit],
        'children' => [
            'count' => is_array($childrenList) ? count($childrenList) : 0,
            'ids' => $childIds,
            'sample_raw' => $childrenSample,
            'sample_decrypted' => $childrenDecryptedSample,
        ],
        'posts' => [
            'posts_daycareId' => $postsA,
            'posts_daycare' => $postsB,
        ],
        'asistencia' => [
            'asistencia_cdas_sample' => $asistenciaCdas,
            'checkins_sample' => [
                'keys_first' => $checkinsKeys,
                'data' => $checkinsRaw,
            ],
            'checkouts_sample' => [
                'keys_first' => $checkoutsKeys,
                'data' => $checkoutsRaw,
            ],
            'matched_for_daycare_children' => [
                'counts_raw' => [
                    'checkins' => count($matched['checkins']),
                    'checkouts' => count($matched['checkouts']),
                ],
                'counts_unique' => [
                    'checkins' => count($uniqueKeys['checkins']),
                    'checkouts' => count($uniqueKeys['checkouts']),
                ],
                'unique' => $uniqueKeys,
            ],
        ],
        'asistentes' => $asistentes,
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'message' => 'Error', 'error' => $e->getMessage()]);
}

