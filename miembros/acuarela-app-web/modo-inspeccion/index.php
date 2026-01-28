<?php
/**
 * Servicio de Generación de Informes de Inspección
 * Integrado en acuarela-app-web
 * 
 * Parámetros GET:
 * - daycare: ID del daycare
 * - ninos: true/false - Fichas de niños
 * - actividades: true/false - Registro de actividades
 * - asistencia: true/false - Registro de asistencia
 * - asistentes: true/false - Fichas de asistentes
 * - from: Fecha inicio (DD-MM-YYYY)
 * - to: Fecha fin (DD-MM-YYYY)
 * - user: Nombre del usuario solicitante
 */

// Incluir SDK y configuraciones (rutas relativas desde acuarela-app-web)
require_once __DIR__ . '/../includes/sdk.php';
require_once __DIR__ . '/../includes/env.php';

// Inicializar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Crear instancia de SDK (usará sesión si existe, o funcionará sin ella)
$a = new Acuarela();

// Inicializar crypto para descifrar datos
if (method_exists($a, 'initCrypto')) {
    $a->initCrypto();
}

// Obtener parámetros GET
$tokenParam = $_GET['token'] ?? '';

// Helpers token firmado
function b64url_decode($data)
{
    $remainder = strlen($data) % 4;
    if ($remainder) {
        $padlen = 4 - $remainder;
        $data .= str_repeat('=', $padlen);
    }
    return base64_decode(strtr($data, '-_', '+/'));
}

function verify_inspection_token($token, $secret)
{
    $parts = explode('.', $token);
    if (count($parts) !== 2) {
        return null;
    }
    [$p, $sig] = $parts;
    $expected = rtrim(strtr(base64_encode(hash_hmac('sha256', $p, $secret, true)), '+/', '-_'), '=');
    if (!hash_equals($expected, $sig)) {
        return null;
    }
    $json = b64url_decode($p);
    $payload = json_decode($json);
    if (!$payload || !is_object($payload)) {
        return null;
    }
    if (!isset($payload->exp) || (int)$payload->exp < time()) {
        return null;
    }
    return $payload;
}

$hasSession = isset($_SESSION['userLogged']) || isset($_SESSION['user']);

// Si viene token, intentar validarlo y usarlo SIEMPRE (aunque haya sesión).
// Si NO hay sesión, el token es obligatorio.
$payload = null;
$secret = Env::get('INSPECTION_LINK_SECRET', '');

if (!empty($tokenParam) && !empty($secret)) {
    $payload = verify_inspection_token($tokenParam, $secret);
    if (!$payload && !$hasSession) {
        http_response_code(403);
        die('Acceso denegado (token inválido o expirado).');
    }
} elseif (!$hasSession) {
    // Sin sesión y sin token/secret: denegar
    http_response_code(403);
    die('Acceso denegado (token requerido).');
}

// Parámetros efectivos (del token si no hay sesión; si hay sesión permitimos query params por compatibilidad)
$daycareId = $payload ? ($payload->daycare ?? '') : ($_GET['daycare'] ?? '');
$includeNinos = $payload ? ((int)($payload->ninos ?? 0) === 1) : (isset($_GET['ninos']) && ($_GET['ninos'] === 'true' || $_GET['ninos'] === '1'));
$includeActividades = $payload ? ((int)($payload->actividades ?? 0) === 1) : (isset($_GET['actividades']) && ($_GET['actividades'] === 'true' || $_GET['actividades'] === '1'));
$includeAsistencia = $payload ? ((int)($payload->asistencia ?? 0) === 1) : (isset($_GET['asistencia']) && ($_GET['asistencia'] === 'true' || $_GET['asistencia'] === '1'));
$includeAsistentes = $payload ? ((int)($payload->asistentes ?? 0) === 1) : (isset($_GET['asistentes']) && ($_GET['asistentes'] === 'true' || $_GET['asistentes'] === '1'));
$fromDate = $payload ? ($payload->from ?? '') : ($_GET['from'] ?? '');
$toDate = $payload ? ($payload->to ?? '') : ($_GET['to'] ?? '');
$userName = $payload ? ($payload->user ?? 'Usuario') : ($_GET['user'] ?? 'Usuario');

// Validar daycare
if (empty($daycareId)) {
    die('Error: Se requiere el parámetro daycare');
}

// Obtener información del daycare
$a->setDaycare($daycareId);
$daycareInfo = $a->getDaycareInfo($daycareId);
$daycareName = $daycareInfo->name ?? 'Daycare';

// Función para convertir fecha DD-MM-YYYY a timestamp
function parseDate($dateStr) {
    if (empty($dateStr)) return null;
    $parts = explode('-', $dateStr);
    if (count($parts) === 3) {
        return mktime(0, 0, 0, (int)$parts[1], (int)$parts[0], (int)$parts[2]);
    }
    return null;
}

// Convertir fechas a timestamps para filtrado
$fromTimestamp = parseDate($fromDate);
$toTimestamp = parseDate($toDate);

// Función para filtrar por rango de fechas
function isInDateRange($dateStr, $fromTs, $toTs) {
    if (!$fromTs && !$toTs) return true; // Sin filtro de fecha
    
    $itemTs = strtotime($dateStr);
    if ($fromTs && $itemTs < $fromTs) return false;
    if ($toTs && $itemTs > $toTs) return false;
    return true;
}

// Función helper para formatear fecha
function formatDate($dateStr) {
    if (empty($dateStr)) return 'N/A';
    return date('d/m/Y', strtotime($dateStr));
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe FERPA - Acceso a Registros Educativos - <?= htmlspecialchars($daycareName) ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            border-bottom: 3px solid #0CB5C3;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #0CB5C3;
            font-size: 2em;
            margin-bottom: 10px;
        }
        .actions {
            margin-top: 12px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .btn {
            background: #0CB5C3;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.95em;
        }
        .btn-secondary {
            background: #334155;
        }
        .header .meta {
            color: #666;
            font-size: 0.9em;
        }
        .section {
            margin-bottom: 40px;
            page-break-inside: avoid;
        }
        .section-title {
            background: #0CB5C3;
            color: white;
            padding: 12px 20px;
            font-size: 1.3em;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-style: italic;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #eee;
            text-align: center;
            color: #666;
            font-size: 0.85em;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .container {
                box-shadow: none;
            }
            .actions {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Informe FERPA – Acceso a Registros Educativos</h1>
            <div class="meta">
                <strong>Daycare:</strong> <?= htmlspecialchars($daycareName) ?><br>
                <strong>Generado para:</strong> <?= htmlspecialchars($userName) ?><br>
                <?php if ($fromDate && $toDate): ?>
                    <strong>Período:</strong> <?= htmlspecialchars($fromDate) ?> al <?= htmlspecialchars($toDate) ?><br>
                <?php endif; ?>
                <strong>Fecha de generación:</strong> <?= date('d/m/Y H:i:s') ?>
            </div>
            <div class="actions">
                <button class="btn" onclick="window.print()">Descargar / Imprimir (PDF)</button>
                <button class="btn btn-secondary" onclick="downloadHtml()">Descargar HTML</button>
            </div>
        </div>
        <script>
            function downloadHtml() {
                const html = '<!doctype html>' + document.documentElement.outerHTML;
                const blob = new Blob([html], { type: 'text/html;charset=utf-8' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'informe-ferpa.html';
                document.body.appendChild(a);
                a.click();
                a.remove();
                URL.revokeObjectURL(url);
            }
        </script>

        <?php if ($includeNinos): ?>
        <div class="section">
            <div class="section-title">Fichas de Niños</div>
            <?php
            $children = $a->getChildren("", $daycareId);
            $childrenList = [];
            
            if (isset($children->response) && is_array($children->response)) {
                $childrenList = $children->response;
            } elseif (is_array($children)) {
                $childrenList = $children;
            }
            
            if (empty($childrenList)):
            ?>
                <div class="no-data">No hay niños registrados en este daycare.</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Género</th>
                            <th>Estado</th>
                            <th>Fecha de Inscripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($childrenList as $child): 
                            $decChild = $a->decryptChildData($child);
                            $birthday = isset($decChild->birthday) ? formatDate($decChild->birthday) : 'N/A';
                            $inscriptionDate = isset($decChild->inscription_date) ? formatDate($decChild->inscription_date) : 'N/A';
                            
                            // Filtrar por fecha de inscripción si hay rango
                            if ($fromTimestamp || $toTimestamp) {
                                if (!isInDateRange($decChild->inscription_date ?? '', $fromTimestamp, $toTimestamp)) {
                                    continue;
                                }
                            }
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($decChild->name ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($decChild->lastname ?? 'N/A') ?></td>
                                <td><?= $birthday ?></td>
                                <td><?= htmlspecialchars($decChild->gender ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($decChild->status_text ?? ($decChild->status ? 'Activo' : 'Inactivo')) ?></td>
                                <td><?= $inscriptionDate ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ($includeActividades): ?>
        <div class="section">
            <div class="section-title">Registro de Actividades</div>
            <?php
            // Algunos entornos usan posts?daycareId= y otros posts?daycare=
            // Probamos ambos para evitar reportes vacíos o inconsistentes.
            $posts = $a->getPostsDaycares($daycareId);
            if (empty($posts) || (is_array($posts) && count($posts) === 0)) {
                $posts = $a->queryStrapi("posts?daycare=$daycareId");
            }
            $postsList = [];
            
            if (is_array($posts)) {
                $postsList = $posts;
            } elseif (isset($posts->response) && is_array($posts->response)) {
                $postsList = $posts->response;
            }

            // Ordenar por fecha desc
            usort($postsList, function ($a, $b) {
                $ad = strtotime($a->createdAt ?? $a->created_at ?? '1970-01-01');
                $bd = strtotime($b->createdAt ?? $b->created_at ?? '1970-01-01');
                return $bd <=> $ad;
            });
            
            // Filtrar por fecha si hay rango
            if ($fromTimestamp || $toTimestamp) {
                $postsList = array_filter($postsList, function($post) use ($fromTimestamp, $toTimestamp) {
                    $postDate = $post->createdAt ?? $post->created_at ?? '';
                    return isInDateRange($postDate, $fromTimestamp, $toTimestamp);
                });
            }
            
            if (empty($postsList)):
            ?>
                <div class="no-data">No hay actividades registradas en el período seleccionado.</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Contenido</th>
                            <th>Autor</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($postsList as $post): ?>
                            <tr>
                                <td><?= formatDate($post->date ?? $post->createdAt ?? $post->created_at ?? '') ?></td>
                                <td><?= htmlspecialchars(substr($post->content ?? $post->description ?? '', 0, 140)) ?><?= strlen($post->content ?? $post->description ?? '') > 140 ? '...' : '' ?></td>
                                <td><?= htmlspecialchars($post->acuarelauser->name ?? $post->author->name ?? 'N/A') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ($includeAsistencia): ?>
        <div class="section">
            <div class="section-title">Registro de Asistencia</div>
            <?php
            // En este Strapi, checkins/checkouts usan relación `children` (no `child`).
            // Filtramos por los children del daycare + rango de fechas, con fallback si Strapi no soporta children_in.
            $children = $a->getChildren("", $daycareId);
            $childrenList = [];
            if (isset($children->response) && is_array($children->response)) $childrenList = $children->response;
            elseif (is_array($children)) $childrenList = $children;

            $childIds = [];
            foreach ($childrenList as $c) {
                $cid = $c->id ?? ($c->_id ?? null);
                if ($cid) $childIds[] = $cid;
            }
            $childIds = array_values(array_unique($childIds));

            $asistenciasList = [];
            $fromIso = $fromTimestamp ? gmdate('Y-m-d\T00:00:00.000\Z', $fromTimestamp) : null;
            $toIso = $toTimestamp ? gmdate('Y-m-d\T23:59:59.999\Z', $toTimestamp) : null;
            $dateQuery = '';
            if ($fromIso) $dateQuery .= '&datetime_gte=' . urlencode($fromIso);
            if ($toIso) $dateQuery .= '&datetime_lte=' . urlencode($toIso);

            $normalizeAttendance = function ($rows, $type) use (&$asistenciasList, $childIds, $a) {
                foreach ($rows as $r) {
                    $dt = $r->datetime ?? $r->date ?? $r->createdAt ?? $r->created_at ?? null;
                    $kids = $r->children ?? [];
                    if (!is_array($kids)) $kids = [];

                    foreach ($kids as $kid) {
                        $kidId = $kid->id ?? ($kid->_id ?? null);
                        if (!$kidId) continue;
                        if (!in_array($kidId, $childIds, true)) continue;

                        $decChild = $a->decryptChildData($kid);
                        $kidName = trim(($decChild->name ?? '') . ' ' . ($decChild->lastname ?? ''));
                        if ($kidName === '') $kidName = $kidId;

                        $asistenciasList[] = (object)[
                            'type' => $type,
                            'date' => $dt,
                            'child_id' => $kidId,
                            'child_name' => $kidName,
                            'raw' => $r,
                        ];
                    }
                }
            };

            if (!empty($childIds)) {
                // Intento 1 (rápido): children_in (si Strapi lo soporta)
                $idsQuery = implode('&children_in=', array_map('urlencode', $childIds));
                $checkins = $a->queryStrapi("checkins?children_in=$idsQuery{$dateQuery}&_sort=datetime:DESC");
                $checkouts = $a->queryStrapi("checkouts?children_in=$idsQuery{$dateQuery}&_sort=datetime:DESC");

                $checkinsArr = is_array($checkins) ? $checkins : (isset($checkins->response) && is_array($checkins->response) ? $checkins->response : []);
                $checkoutsArr = is_array($checkouts) ? $checkouts : (isset($checkouts->response) && is_array($checkouts->response) ? $checkouts->response : []);

                $hasError = (is_object($checkins) && isset($checkins->error)) || (is_object($checkouts) && isset($checkouts->error));

                // Fallback: si el filtro children_in falla, traemos por fecha y filtramos en PHP
                if ($hasError) {
                    $checkins = $a->queryStrapi("checkins?{$dateQuery}&_sort=datetime:DESC");
                    $checkouts = $a->queryStrapi("checkouts?{$dateQuery}&_sort=datetime:DESC");
                    $checkinsArr = is_array($checkins) ? $checkins : (isset($checkins->response) && is_array($checkins->response) ? $checkins->response : []);
                    $checkoutsArr = is_array($checkouts) ? $checkouts : (isset($checkouts->response) && is_array($checkouts->response) ? $checkouts->response : []);
                }

                $normalizeAttendance($checkinsArr, 'checkin');
                $normalizeAttendance($checkoutsArr, 'checkout');
            }

            // Deduplicar filas (pueden existir duplicados si Strapi retorna registros repetidos
            // o si hay inconsistencias en la relación children).
            $unique = [];
            foreach ($asistenciasList as $row) {
                $rawId = null;
                if (isset($row->raw) && is_object($row->raw)) {
                    $rawId = $row->raw->id ?? ($row->raw->_id ?? null);
                }
                $key = implode('|', [
                    (string)($row->type ?? ''),
                    (string)($rawId ?? ''),
                    (string)($row->child_id ?? ''),
                    (string)($row->date ?? ''),
                ]);
                $unique[$key] = $row;
            }
            $asistenciasList = array_values($unique);

            // Ordenar por fecha desc
            usort($asistenciasList, function ($a, $b) {
                $ad = strtotime($a->date ?? '1970-01-01');
                $bd = strtotime($b->date ?? '1970-01-01');
                return $bd <=> $ad;
            });
            
            if (empty($asistenciasList)):
            ?>
                <div class="no-data">No hay registros de asistencia en el período seleccionado.</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Niño</th>
                            <th>Tipo</th>
                            <th>Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($asistenciasList as $asist): ?>
                            <tr>
                                <td><?= formatDate($asist->date ?? '') ?></td>
                                <td><?= htmlspecialchars($asist->child_name ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($asist->type ?? 'N/A') ?></td>
                                <?php
                                // Hora:
                                // - Normalmente viene en `datetime` (ISO) dentro de $asist->date
                                // - Si `datetime` está a medianoche (00:00) porque se guardó solo fecha,
                                //   usamos la hora real de creación (`createdAt`) como fallback.
                                $primaryIso = $asist->date ?? '';
                                $fallbackIso = '';
                                if (isset($asist->raw) && is_object($asist->raw)) {
                                    $fallbackIso = $asist->raw->createdAt ?? $asist->raw->created_at ?? '';
                                }

                                $timeStr = 'N/A';
                                $pTs = $primaryIso ? strtotime($primaryIso) : false;
                                if ($pTs !== false) {
                                    $t = date('H:i', $pTs);
                                    if ($t !== '00:00') {
                                        $timeStr = $t;
                                    }
                                }
                                if ($timeStr === 'N/A' && !empty($fallbackIso)) {
                                    $fTs = strtotime($fallbackIso);
                                    if ($fTs !== false) {
                                        $timeStr = date('H:i', $fTs);
                                    }
                                }
                                ?>
                                <td><?= htmlspecialchars($timeStr) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <?php if ($includeAsistentes): ?>
        <div class="section">
            <div class="section-title">Fichas de Asistentes</div>
            <?php
            $asistentes = $a->getAsistentes("", $daycareId);
            $asistentesList = [];
            
            if (is_array($asistentes)) {
                $asistentesList = $asistentes;
            } elseif (isset($asistentes->response) && is_array($asistentes->response)) {
                $asistentesList = $asistentes->response;
            }
            
            if (empty($asistentesList)):
            ?>
                <div class="no-data">No hay asistentes registrados en este daycare.</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($asistentesList as $asistente): 
                            // Descifrar teléfono si está cifrado
                            $phone = $asistente->phone ?? '';
                            if ($a->crypto && $phone && $a->crypto->isEncrypted($phone)) {
                                try {
                                    $phone = $a->crypto->decrypt($phone);
                                } catch (Exception $e) {
                                    // Mantener cifrado si falla
                                }
                            }
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($asistente->name ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($asistente->lastname ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($asistente->mail ?? $asistente->email ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($phone ?: 'N/A') ?></td>
                                <td><?= $asistente->status ? 'Activo' : 'Inactivo' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <div class="footer">
            <p>Este informe fue generado automáticamente por el sistema Acuarela.</p>
            <p>&copy; <?= date('Y') ?> Bilingual Child Care Training (BCCT). Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
