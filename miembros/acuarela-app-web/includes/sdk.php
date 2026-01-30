<?php
require_once __DIR__ . '/env.php';
require_once __DIR__ . '/src/Mandrill.php';
// Usar el servicio de cifrado compartido para evitar conflictos de declaración de clases
require_once __DIR__ . '/../../includes/CryptoService.php';

class Acuarela
{
    public $domain;
    public $domainWP;
    public $domainWPA;
    public $daycareID;
    public $daycareInfo;
    public $userID;
    public $token;
    public $defaultInitialDate;
    public $defaultFinalDate;
    private $mandrillApiKey;
    public $crypto; // CryptoService instance for encryption at rest

    function __construct()
    {
        // Cargar configuración desde variables de entorno
        $this->domain = Env::get('ACUARELA_API_URL', 'https://acuarelacore.com/api/');
        $this->domainWP = Env::get('WP_API_URL', 'https://application.bilingualchildcaretraining.com/wp-json/wp/v2');
        $this->domainWPA = Env::get(
            'WP_ADMIN_API_URL',
            'https://adminwebacuarela.bilingualchildcaretraining.com/wp-json/wp/v2'
        );
        $this->mandrillApiKey = Env::get('MANDRILL_API_KEY');

        $this->userID = isset($_SESSION["user"]->acuarelauser->id) ? $_SESSION["user"]->acuarelauser->id : null;
        $this->token = isset($_SESSION["userLogged"]->user->token) ? $_SESSION["userLogged"]->user->token : null;

        // Si no hay activeDaycare en sesión, usar el primer daycare del usuario
// EXCEPTO si estamos en la página de selección de daycare (para permitir que el usuario elija)
        if (!isset($_SESSION['activeDaycare']) || empty($_SESSION['activeDaycare'])) {
            if (isset($_SESSION["user"]->daycares) && !empty($_SESSION["user"]->daycares)) {
                // Solo establecer automáticamente si NO estamos en la página de selección
// y si solo hay un daycare (si hay múltiples, el usuario debe elegir)
                if (!isset($_SESSION['selecting_daycare']) && count($_SESSION["user"]->daycares) == 1) {
                    $_SESSION['activeDaycare'] = $_SESSION["user"]->daycares[0]->id;
                }
            }
        }

        // Validar que activeDaycare esté definido antes de usarlo
        if (isset($_SESSION['activeDaycare']) && !empty($_SESSION['activeDaycare'])) {
            $this->daycareID = $_SESSION['activeDaycare'];
            $this->daycareInfo = $this->getDaycareInfo($_SESSION['activeDaycare']);
        } else {
            $this->daycareID = null;
            $this->daycareInfo = null;
        }
        // Default initial date
        $this->defaultInitialDate = (new DateTime())
            ->sub(new DateInterval('P7D')) // subtract 7 days
            ->format('Y-m-d');

        // Default final date
        $this->defaultFinalDate = (new DateTime())
            ->add(new DateInterval('P2D')) // add 2 days
            ->format('Y-m-d');
    }

    public function setDaycare($id)
    {
        $this->daycareID = $id;
        $this->daycareInfo = $this->getDaycareInfo($id);
    }

    /** TTL del cache Strapi (solo GET) en segundos (1 hora) */
    private $strapiCacheTTL = 3600;

    function queryStrapi($url, $body = "", $method = "GET")
    {
        $method = strtoupper($method);
        $useCache = ($method === 'GET' && (empty($body) || (is_string($body) && trim($body) === '')));
        // No cachear Social (posts), Privacidad (dsar-requests, ferpa-requests) ni Inspección (checkins, checkouts): contenido muy dinámico
        if ($useCache) {
            $pathPart = (strpos($url, '?') !== false) ? substr($url, 0, strpos($url, '?')) : $url;
            $noCachePaths = ['posts', 'dsar-requests', 'ferpa-requests', 'checkins', 'checkouts'];
            foreach ($noCachePaths as $p) {
                if ($pathPart === $p || strpos($pathPart, $p . '/') === 0) {
                    $useCache = false;
                    break;
                }
            }
        }
        $cacheDir = __DIR__ . '/../cache/strapi/';
        $cacheFile = null;
        if ($useCache) {
            if (!is_dir($cacheDir)) {
                @mkdir($cacheDir, 0755, true);
            }
            $cacheKey = md5($url);
            $cacheFile = $cacheDir . $cacheKey . '.json';
            if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $this->strapiCacheTTL) {
                $cached = file_get_contents($cacheFile);
                $decoded = json_decode($cached);
                if ($decoded !== null) {
                    return $decoded;
                }
            }
        }

        $endpoint = $this->domain . $url;
        $curl = curl_init();

        // Headers: para endpoints públicos no enviar token vacío
        $headers = array('Content-Type: application/json');
        
        // Usar token de sesión si existe, sino usar token de servicio (para modo inspección, FERPA, etc.)
        $tokenToUse = $this->token;
        if (empty($tokenToUse)) {
            $tokenToUse = Env::get('STRAPI_SERVICE_TOKEN', '');
        }
        
        if (!empty($tokenToUse)) {
            $headers[] = 'token: ' . $tokenToUse;
        }

        $curlOptions = array(
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
        );

        // Verificar si $body no es un string antes de hacer json_encode
        if (!empty($body) && !is_string($body)) {
            $curlOptions[CURLOPT_POSTFIELDS] = json_encode($body);
        } elseif (is_string($body)) {
            $curlOptions[CURLOPT_POSTFIELDS] = $body;
        }

        curl_setopt_array($curl, $curlOptions);

        $response = curl_exec($curl);
        curl_close($curl);

        $decoded = json_decode($response);
        if ($useCache && $cacheFile !== null && $decoded !== null) {
            @file_put_contents($cacheFile, $response);
        }
        return $decoded;
    }

    /**
     * Invalida la caché Strapi para una URL (p. ej. al registrar check-in/check-out en Asistencia).
     * Así la siguiente petición GET a esa URL obtiene datos frescos.
     * @param string $url Misma URL que se usa en queryStrapi (ej: "children/?daycare=123")
     */
    function invalidateStrapiCache($url)
    {
        $cacheDir = __DIR__ . '/../cache/strapi/';
        $cacheKey = md5($url);
        $cacheFile = $cacheDir . $cacheKey . '.json';
        if (file_exists($cacheFile)) {
            @unlink($cacheFile);
        }
    }

    // Función para obtener la URL de la imagen más pequeña disponible
    function getSmallestImageUrl($image)
    {
        if (isset($image->formats)) {
            $formats = $image->formats;
            $sizes = ['small', 'medium', 'large'];
            foreach ($sizes as $size) {
                if (isset($formats->$size)) {
                    return 'https://acuarelacore.com/api/' . $formats->$size->url;
                }
            }
        }

        // Si no hay formatos, devuelve la URL principal
        return 'https://acuarelacore.com/api/' . $image->url;
    }
    /**
     * Posts del daycare con paginación (15 por página).
     * @param string|null $daycare
     * @param int $page Página (1-based desde JS: page=1 es la primera).
     */
    function getPostsDaycares($daycare = null, $page = 1)
    {
        if (is_null($daycare)) {
            $daycare = $this->daycareID;
        }
        $limit = 15;
        $page = max(1, (int)$page);
        $start = ($page - 1) * $limit;
        $resp = $this->queryStrapi("posts?daycareId=$daycare&_start=$start&_limit=$limit");
        return $resp;
    }
    function getTasks($daycare = null)
    {
        if (is_null($daycare)) {
            $daycare = $this->daycareID;
        }
        $resp = $this->queryStrapi("tasks?daycare=$daycare");
        return $resp;
    }
    function createTask($data)
    {
        $resp = $this->queryStrapi("tasks", $data, "POST");
        if ($this->daycareID) {
            $this->invalidateStrapiCache("tasks?daycare=" . $this->daycareID);
        }
        return $resp;
    }
    function setReactionPost($data)
    {
        $resp = $this->queryStrapi("reactions", $data, "POST");
        return $resp;
    }
    function addComment($data)
    {
        $resp = $this->queryStrapi("comments", $data, "POST");
        return $resp;
    }
    function createAsistente($data)
    {
        $data["daycare"] = $this->daycareID;
        $data["rel_daycare"] = [
            [
                "daycare" => $this->daycareID,
                "status_invitation" => 2
            ]
        ];
        $resp = $this->queryStrapi("acuarelausers/register", $data, "POST");
        return $resp;
    }
    function editAsistente($id, $data)
    {
        $resp = $this->queryStrapi("acuarelausers/$id", $data, "PUT");
        return $resp;
    }
    function getAgeGroups()
    {
        $resp = $this->queryStrapi("age-groups");
        return $resp;
    }
    function getEstadosCiudades()
    {
        $resp = $this->queryStrapi("estados-y-ciudades");
        return $resp;
    }

    /**
     * Obtiene las solicitudes DSAR asociadas a usuarios de un daycare específico
     */
    function getDaycareDSARs($daycareID)
    {
        if (empty($daycareID))
            return [];

        // OPTIMIZACIÓN: Filtrar directamente por el campo 'daycare' en dsar-requests
        // Esto asume que el campo 'daycare' fue creado y poblado en Strapi
        $dsars = $this->queryStrapi("dsar-requests?daycare.id=$daycareID&_sort=created_at:DESC");

        // Fallback: si devuelve vacío, podría ser que el campo se llame 'daycare' directo sin .id
        if (empty($dsars)) {
            $dsars = $this->queryStrapi("dsar-requests?daycare=$daycareID&_sort=created_at:DESC");
        }

        if (empty($dsars) || !is_array($dsars))
            return [];

        // Recolectar IDs de usuarios para traer sus nombres en una sola consulta eficiente
        $userIds = [];
        foreach ($dsars as $dsar) {
            if (isset($dsar->linked_user)) {
                $uid = is_object($dsar->linked_user) ? $dsar->linked_user->id : $dsar->linked_user;
                if ($uid)
                    $userIds[] = $uid;
            }
        }

        $userIds = array_unique($userIds);
        $usersMap = [];

        if (!empty($userIds)) {
            // Traer solo los usuarios necesarios
            $idsQuery = implode('&id_in=', $userIds);
            $users = $this->queryStrapi("acuarelausers?id_in=$idsQuery");

            if ($users && is_array($users)) {
                foreach ($users as $u) {
                    $usersMap[$u->id] = $u;
                }
            }
        }

        // Asignar user_details usando el mapa
        foreach ($dsars as $dsar) {
            if (isset($dsar->linked_user)) {
                $uid = is_object($dsar->linked_user) ? $dsar->linked_user->id : $dsar->linked_user;
                if (isset($usersMap[$uid])) {
                    $dsar->user_details = $usersMap[$uid];
                }
            }
        }

        return $dsars;
    }

    /**
     * Obtiene las solicitudes FERPA asociadas a un daycare específico
     */
    function getDaycareFerpaRequests($daycareID)
    {
        if (empty($daycareID))
            return [];

        // Filtrar por daycare y ordenar por fecha
        $requests = $this->queryStrapi("ferpa-requests?daycare.id=$daycareID&_sort=created_at:DESC");

        // Fallback simple
        if (empty($requests)) {
            $requests = $this->queryStrapi("ferpa-requests?daycare=$daycareID&_sort=created_at:DESC");
        }

        if (empty($requests) || !is_array($requests))
            return [];

        // Recolectar IDs de usuarios (padres) y niños (opcional) para enriquecer datos
        $userIds = [];
        $childIds = [];

        foreach ($requests as $req) {
            if (isset($req->requester)) {
                $uid = is_object($req->requester) ? $req->requester->id : $req->requester;
                if ($uid)
                    $userIds[] = $uid;
            }
            // Compatibilidad: la relación con el niño puede llamarse 'child' o 'child_id'
            if (isset($req->child) || isset($req->child_id)) {
                $childRel = isset($req->child) ? $req->child : $req->child_id;
                $cid = is_object($childRel) ? ($childRel->id ?? ($childRel->_id ?? null)) : $childRel;
                if ($cid) {
                    $childIds[] = $cid;
                }
            }
        }

        $userIds = array_unique($userIds);
        $childIds = array_unique($childIds);

        $usersMap = [];
        $childrenMap = [];

        // Obtener usuarios
        if (!empty($userIds)) {
            $idsQuery = implode('&id_in=', $userIds);
            $users = $this->queryStrapi("acuarelausers?id_in=$idsQuery");
            if ($users && is_array($users)) {
                foreach ($users as $u) {
                    $usersMap[$u->id] = $u;
                }
            }
        }

        // Obtener niños
        if (!empty($childIds)) {
            $idsQuery = implode('&id_in=', $childIds);
            $children = $this->queryStrapi("children?id_in=$idsQuery");
            if ($children && is_array($children)) {
                foreach ($children as $c) {
                    // Decrypt name if needed (using existing helper if available, or raw)
                    // Assuming decryptChildData is in this class but maybe private or specific context
                    // We'll just store raw for now or use decrypt if public
                    $childrenMap[$c->id] = $this->decryptChildData($c);
                }
            }
        }

        // Asignar detalles
        foreach ($requests as $req) {
            // Requester Details
            if (isset($req->requester)) {
                $uid = is_object($req->requester) ? $req->requester->id : $req->requester;
                if (isset($usersMap[$uid])) {
                    $req->requester_details = $usersMap[$uid];
                } elseif (is_object($req->requester)) {
                    // Fallback: si Strapi ya populó el requester, úsalo directamente
                    $req->requester_details = $req->requester;
                }
            }
            // Child Details
            if (isset($req->child) || isset($req->child_id)) {
                $childRel = isset($req->child) ? $req->child : $req->child_id;
                $cid = is_object($childRel) ? ($childRel->id ?? ($childRel->_id ?? null)) : $childRel;

                if (isset($childrenMap[$cid])) {
                    $req->child_details = $childrenMap[$cid];
                } elseif (is_object($childRel)) {
                    // Fallback: si Strapi ya envió el objeto niño populado, descifrarlo directamente
                    $req->child_details = $this->decryptChildData($childRel);
                }
            }
        }

        return $requests;
    }

    /**
     * Crea una nueva solicitud FERPA
     */
    function createFerpaRequest($data)
    {
        $resp = $this->queryStrapi("ferpa-requests", $data, "POST");
        return $resp;
    }

    /**
     * Actualiza el estado de una solicitud FERPA
     */
    function updateFerpaRequest($id, $data)
    {
        $resp = $this->queryStrapi("ferpa-requests/$id", $data, "PUT");
        return $resp;
    }
    function deleteElement($type, $id)
    {
        // Si es una inscripción, hacer borrado en cascada
        if ($type === 'inscripciones') {
            return $this->deleteInscripcionCascade($id);
        }

        // Para otros tipos, borrado simple
        $resp = $this->queryStrapi("$type/$id", "", "DELETE");
        return $resp;
    }

    /**
     * Borra una inscripción y todos los datos relacionados del niño
     */
    function deleteInscripcionCascade($inscripcionId)
    {
        try {
            // 1. Obtener la inscripción para sacar el child_id
            $inscripcion = $this->queryStrapi("inscripciones/$inscripcionId");

            if (!$inscripcion || !isset($inscripcion->child)) {
                error_log("Inscripción no encontrada o sin child: $inscripcionId");
                return ['ok' => false, 'error' => 'Inscripción no encontrada'];
            }

            $childId = is_object($inscripcion->child) ? $inscripcion->child->id : $inscripcion->child;

            error_log("Borrando inscripción $inscripcionId y niño $childId en cascada");

            // 2. Borrar consentimientos parentales
            $consents = $this->queryStrapi("parental-consents?child_id=$childId");
            if (is_array($consents)) {
                foreach ($consents as $consent) {
                    if (isset($consent->id)) {
                        error_log("Borrando consentimiento: " . $consent->id);
                        $this->queryStrapi("parental-consents/" . $consent->id, "", "DELETE");
                    }
                }
            }

            // 3. Borrar información de salud (healthinfos)
            $healthInfos = $this->queryStrapi("healthinfos?child=$childId");
            if (is_array($healthInfos)) {
                foreach ($healthInfos as $healthInfo) {
                    if (isset($healthInfo->id)) {
                        error_log("Borrando healthinfo: " . $healthInfo->id);
                        $this->queryStrapi("healthinfos/" . $healthInfo->id, "", "DELETE");
                    }
                }
            }

            // 4. Remover de grupos (no borrar el grupo, solo quitar relación)
            $grupos = $this->queryStrapi("groups?children_contains=$childId");
            if (is_array($grupos)) {
                foreach ($grupos as $grupo) {
                    if (isset($grupo->id) && isset($grupo->children)) {
                        // Filtrar el niño del array de children
                        $newChildren = array_filter($grupo->children, function ($child) use ($childId) {
                            $id = is_object($child) ? $child->id : $child;
                            return $id != $childId;
                        });

                        // Actualizar el grupo sin este niño
                        $this->queryStrapi("groups/" . $grupo->id, [
                            'children' => array_values($newChildren)
                        ], "PUT");
                    }
                }
            }

            // 5. Borrar el niño (children)
            error_log("Borrando child: $childId");
            $this->queryStrapi("children/$childId", "", "DELETE");

            // 6. Finalmente borrar la inscripción
            error_log("Borrando inscripción: $inscripcionId");
            $resp = $this->queryStrapi("inscripciones/$inscripcionId", "", "DELETE");

            return [
                'ok' => true,
                'message' => 'Niño e inscripción borrados correctamente',
                'deleted' => [
                    'child' => $childId,
                    'inscripcion' => $inscripcionId
                ]
            ];

        } catch (Exception $e) {
            error_log("Error en deleteInscripcionCascade: " . $e->getMessage());
            return ['ok' => false, 'error' => $e->getMessage()];
        }
    }
    function getInscripciones($id = "", $daycare = null)
    {
        if (is_null($daycare)) {
            $daycare = $this->daycareID;
        }
        if ($id == "") {
            $resp = $this->queryStrapi("inscripciones?daycare=$daycare");
        } else {
            $resp = $this->queryStrapi("inscripciones/{$id}");
        }
        return $resp;
    }
    function postInscripcion($data)
    {
        $data = json_decode($data);
        if ($data->status == "Borrador") {
            $resp = $this->queryStrapi("inscripciones", $data, "POST");
            return $resp;
        } else {
            $respInscripcion = $this->queryStrapi("inscripciones", $data, "POST");
            $data->inscripcion = $respInscripcion->id;
            $respInscripcionComplete = $this->queryStrapi("inscripciones/complete", $data, "POST");
            return $respInscripcionComplete;
        }
    }
    function getHealthinfo($id = "", $daycare = null)
    {
        if (is_null($daycare)) {
            $daycare = $this->daycareID;
        }
        if ($id == "") {
            $resp = $this->queryStrapi("healthinfos?daycare=$daycare");
        } else {
            $resp = $this->queryStrapi("healthinfos/{$id}");
        }
        return $resp;
    }

    function postHealthinfo($data)
    {
        $data = json_decode($data);
        $resp = $this->queryStrapi("healthinfos", $data, "POST");
        return $resp;
    }
    function putHealthinfo($data)
    {
        $data = json_decode($data);
        if (!isset($data->inscripcion) || empty($data->inscripcion)) {
            return null; // Evitar enviar una petición sin ID de inscripción
        }
        $resp = $this->queryStrapi("healthinfos/$data->inscripcion", $data, "PUT");
        return $resp;
    }


    function putInscripcion($data)
    {
        $data = json_decode($data);
        if ($data->status == "Borrador") {
            $resp = $this->queryStrapi("inscripciones/$data->inscripcion", $data, "PUT");
            return $resp;
        } else {
            $resp = $this->queryStrapi("inscripciones/$data->inscripcion", $data, "PUT");
            $respInscripcionComplete = $this->queryStrapi("inscripciones/complete", $data, "POST");
            return $respInscripcionComplete;
        }
    }
    /**
     * Obtiene el último estado COPPA por niño en una sola petición (evita N+1).
     * Strapi v3: field_in=id1&field_in=id2 (repetir parámetro por cada valor).
     * @param array $childIds Lista de IDs de niños
     * @return array Map child_id => consent_status (granted|pending|revoked)
     */
    function getLatestParentalConsentsForChildIds($childIds)
    {
        $map = [];
        $childIds = array_unique(array_filter(array_map('strval', $childIds)));
        if (empty($childIds)) {
            return $map;
        }
        // Strapi v3: id_in=3&id_in=6&id_in=8 (doc: Find multiple restaurant with id 3, 6, 8)
        $parts = [];
        foreach (array_values($childIds) as $id) {
            $parts[] = 'child_id_in=' . urlencode($id);
        }
        $query = implode('&', $parts) . '&_sort=createdAt:desc&_limit=500';
        $consents = $this->queryStrapi("parental-consents?" . $query);
        if (!is_array($consents)) {
            return $map;
        }
        foreach ($consents as $c) {
            $cid = isset($c->child_id) ? (is_object($c->child_id) ? ($c->child_id->id ?? null) : $c->child_id) : null;
            if ($cid !== null && !isset($map[(string)$cid])) {
                $map[(string)$cid] = $c->consent_status ?? 'pending';
            }
        }
        return $map;
    }

    function getChildren($id = "", $daycare = null)
    {
        if (is_null($daycare)) {
            $daycare = $this->daycareID;
        }
        if (empty($daycare)) {
            return null;
        }
        if ($id == "") {
            $resp = $this->queryStrapi("children/?daycare=$daycare");
        } else {
            $resp = $this->queryStrapi("children/{$id}");
            if (isset($resp->response) && is_array($resp->response) && !empty($resp->response)) {
                $resp = $resp->response[0];
            } else {
                return null;
            }
        }
        return $resp;
    }
    function updateChildren($id, $data)
    {
        $resp = $this->queryStrapi("children/{$id}", $data, "PUT");
        return $resp;
    }
    function getDaycareInfo($id)
    {
        if (empty($id)) {
            return null;
        }
        $resp = $this->queryStrapi("daycares/{$id}");
        if (isset($resp->response) && is_array($resp->response) && !empty($resp->response)) {
            return $resp->response[0];
        }
        return null;
    }
    function updateDaycareInfo($data)
    {
        $resp = $this->queryStrapi("daycares/{$this->daycareID}", $data, "PUT");
        return $resp;
    }
    function getAsistentes($id = "", $daycare = null)
    {
        if (is_null($daycare)) {
            $daycare = $this->daycareID;
        }
        if ($id == "") {
            $resp = $this->queryStrapi("acuarelausers?rols=5ff78fd55d6f2e272cfd7392&daycare=$daycare");
        } else {
            $resp = $this->queryStrapi("acuarelausers/{$id}");
        }
        return $resp;
    }
    function getGrupos($id = "", $daycare = null)
    {
        if (is_null($daycare)) {
            $daycare = $this->daycareID;
        }
        if (empty($daycare)) {
            return [];
        }
        if ($id == "") {
            $resp = $this->queryStrapi("groupsNew/$daycare");
            $resp = isset($resp->response) ? $resp->response : [];
        } else {
            $resp = $this->queryStrapi("groups/{$id}");
            if (isset($resp->response) && is_array($resp->response) && !empty($resp->response)) {
                $resp = $resp->response[0];
            } else {
                return null;
            }
        }
        return $resp;
    }
    function createGroup($data, $daycare = null)
    {
        if (is_null($daycare)) {
            $daycare = $this->daycareID;
        }
        $data["daycare"] = $daycare;
        $resp = $this->queryStrapi("groups", $data, 'POST');
        $this->invalidateStrapiCache("groupsNew/$daycare");
        return $resp;
    }
    function editGroup($id, $data)
    {
        $resp = $this->queryStrapi("groups/$id", $data, 'PUT');
        if ($this->daycareID) {
            $this->invalidateStrapiCache("groupsNew/" . $this->daycareID);
        }
        return $resp;
    }
    function createActivity($data)
    {
        $resp = $this->queryStrapi("groups/activity", $data, 'POST');
        if ($this->daycareID) {
            $this->invalidateStrapiCache("groupsNew/" . $this->daycareID);
        }
        return $resp;
    }


    function checkIn($data)
    {
        $data->asistente = $this->userID;
        $data->token = $this->token;
        $resp = $this->queryStrapi("checkins", $data, "POST");
        return $resp;
    }

    function checkOut($data)
    {
        $data->asistente = $this->userID;
        $data->token = $this->token;
        $resp = $this->queryStrapi("checkouts", $data, "POST");
        return $resp;
    }
    function transformMergeVars($vars)
    {
        $mergeVars = array();
        foreach ($vars as $key => $value) {
            array_push($mergeVars, ['name' => $key, 'content' => $value]);
        }
        return $mergeVars;
    }


    function send_notification(
        $from,
        $to,
        $toname,
        $mergevariables,
        $subject,
        $template,
        $mandrillApiKey,
        $fromName =
        "Mandrill Message",
        $async = false
    ) {
        $result = '';
        try {
            if ($from == "") {
                $from = 'info@acuarela.app';
            }
            $mandrill = new Mandrill($mandrillApiKey);

            $template_name = $template;
            $template_content = array(
                array(
                    'name' => $fromName,
                    'content' => $subject
                )
            );

            $message = array(
                'html' => '<p>Example HTML content</p>',
                'text' => 'Example text content',
                'subject' => $subject,
                'from_email' => $from,
                'from_name' => $fromName,
                'to' => array(
                    array(
                        'email' => $to,
                        'name' => $toname,
                        'type' => 'to'
                    )
                ),

                'headers' => array('Reply-To' => $from),
                'important' => false,
                'track_opens' => null,
                'track_clicks' => null,
                'auto_text' => null,
                'auto_html' => null,
                'inline_css' => null,
                'url_strip_qs' => null,
                'preserve_recipients' => null,
                'view_content_link' => null,
                'tracking_domain' => null,
                'signing_domain' => null,
                'return_path_domain' => null,
                'merge' => true,
                'merge_language' => 'mailchimp',
                'global_merge_vars' => $mergevariables,
                'merge_vars' => array(
                    array(
                        'rcpt' => $to,
                        'vars' => $mergevariables
                    )
                )
            );

            $ip_pool = 'Main Pool';
            $send_at = date("Y-m-d");
            $result = $mandrill->messages->sendTemplate($template_name, $template_content, (object) $message, $async, $ip_pool, $send_at);
            $answer = true;
        } catch (Mandrill_Error $e) {
            $result = 'Error de envío: ' . get_class($e) . ' - ' . $e->getMessage();
            $answer = false;
            throw $e;
        }
        return $result;
    }

    /**
     * Envía un correo electrónico simple usando Mandrill
     */
    function sendEmail($to, $subject, $body, $title = "Acuarela Notificación")
    {
        try {
            $mandrill = new Mandrill($this->mandrillApiKey);
            $message = array(
                'html' => $body,
                'text' => strip_tags($body),
                'subject' => $subject,
                'from_email' => 'info@acuarela.app',
                'from_name' => $title,
                'to' => array(
                    array(
                        'email' => $to,
                        'type' => 'to'
                    )
                ),
                'important' => false,
                'track_opens' => true,
                'track_clicks' => true,
            );
            $async = false;
            $ip_pool = 'Main Pool';
            $send_at = null;
            return $mandrill->messages->send($message, $async, $ip_pool, $send_at);
        } catch (Mandrill_Error $e) {
            error_log('Error enviando email: ' . get_class($e) . ' - ' . $e->getMessage());
            return false;
        }
    }

    function sendCheckin($nameKid, $nameParent, $nameDaycare, $nameAcudiente, $time, $date, $mail, $subject = 'Check in')
    {
        $mergeVars = [
            'NOMBRENINO' => $nameKid,
            'NOMBREPADRE' => $nameParent,
            'NOMBREDAYCARE' => $nameDaycare,
            'NOMBREACUDIENTE' => $nameAcudiente,
            'HORA' => $time,
            'FECHA' => $date
        ];
        return $this->send_notification(
            'info@acuarela.app',
            $mail,
            $nameParent,
            $this->transformMergeVars($mergeVars),
            $subject,
            'check-in',
            $this->mandrillApiKey,
            "Acuarela"
        );
    }
    function sendCheckout($nameKid, $nameParent, $nameDaycare, $nameAcudiente, $time, $date, $mail, $subject = 'Check out')
    {
        $mergeVars = [
            'NOMBRENINO' => $nameKid,
            'NOMBREPADRE' => $nameParent,
            'NOMBREDAYCARE' => $nameDaycare,
            'NOMBREACUDIENTE' => $nameAcudiente,
            'HORA' => $time,
            'FECHA' => $date
        ];
        return $this->send_notification(
            'info@acuarela.app',
            $mail,
            $nameParent,
            $this->transformMergeVars($mergeVars),
            $subject,
            'check-out',
            $this->mandrillApiKey,
            "Acuarela"
        );
    }

    /**
     * Envía email de activación a un nuevo asistente para que cree su contraseña
     */
    function sendActivacionAsistente(
        $email,
        $nombreCompleto,
        $asistenteId,
        $nombreDaycare,
        $subject = 'Bienvenido a
Acuarela - Activa tu cuenta'
    ) {
        // Detectar si estamos en dev o producción basado en el host actual
        $host = $_SERVER['HTTP_HOST'] ?? 'bilingualchildcaretraining.com';
        $isDev = (strpos($host, 'dev.') !== false);
        $baseUrl = $isDev
            ? 'https://dev.bilingualchildcaretraining.com'
            : 'https://bilingualchildcaretraining.com';
        $linkActivacion = $baseUrl . "/miembros/acuarela-app-web/activar-cuenta?id=" . $asistenteId;

        // En producción, quitar el prefijo [TEST] si existe (viene de la plantilla de Mandrill)
        if (!$isDev) {
            $subject = str_replace('[TEST]', '', $subject);
            $subject = trim($subject);
        }

        $mergeVars = [
            'NOMBRE' => $nombreCompleto,
            'DAYCARE' => $nombreDaycare,
            'LINK' => $linkActivacion
        ];
        return $this->send_notification(
            'info@acuarela.app',
            $email,
            $nombreCompleto,
            $this->transformMergeVars($mergeVars),
            $subject,
            'activacion-asistente',
            $this->mandrillApiKey,
            "Acuarela"
        );
    }

    /**
     * Actualiza la contraseña de un asistente (acuarelauser)
     */
    function updateAsistentePassword($asistenteId, $newPassword)
    {
        $data = [
            "pass" => $newPassword,
            "password" => $newPassword
        ];
        $resp = $this->queryStrapi("acuarelausers/$asistenteId", $data, "PUT");
        return $resp;
    }

    /**
     * Obtiene información de un asistente por ID (sin requerir sesión activa)
     */
    function getAsistenteById($id)
    {
        $endpoint = $this->domain . "acuarelausers/$id";
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }

    function getMovements($initialDate = null, $finalDate = null, $type = null)
    {
        if (is_null($initialDate)) {
            $initialDate = $this->defaultInitialDate;
        }
        if (is_null($finalDate)) {
            $finalDate = $this->defaultFinalDate;
        }

        $daycare = $this->daycareID;
        $array = array();

        // Construir la URL base para la consulta
        $url = "movements?date_gte=$initialDate&date_lte=$finalDate&_sort=date:DESC&daycare=$daycare";

        // Ajustar la consulta según el tipo especificado
        if (!is_null($type)) {
            $url .= "&type=$type";
        }

        // Realizar la consulta a través de queryStrapi (asumiendo que es una función o método definido)
        $resp = $this->queryStrapi($url);

        return $resp;
    }
    function setMovements($data)
    {
        $movements = $this->queryStrapi("movements", $data, "POST");
        return $movements;
    }

    function getCategories()
    {
        $categories = $this->queryStrapi("categories");
        return $categories;
    }
    function setCategories($data)
    {
        $categories = $this->queryStrapi("categories", $data, "POST");
        return $categories;
    }

    function uploadImage($file)
    {
        $url = "https://acuarelacore.com/api/upload";
        $headers = [
            "content-type: multipart/form-data ",
        ];

        // Anonimizar nombre de archivo para proteger privacidad (evitar nombres como "Foto_Juan_Perez.jpg")
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        // Generar nombre aleatorio: timestamp + hash
        $randomName = uniqid() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;

        $postFields = [
            "files" => new CURLFile($file['tmp_name'], $file['type'], $randomName),
        ];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($status === 200) {
            return json_decode($response, true)[0];
        } else {
            return null;
        }
    }
    function createPost($data)
    {
        $data["daycare"] = $this->daycareID;
        return $this->queryStrapi("/posts", $data, "POST");
    }

    // UTILITY
    function get_alias($String)
    {
        $String = html_entity_decode($String); // Traduce codificación

        $String = str_replace("¡", "", $String); //Signo de exclamación abierta.&iexcl;
        $String = str_replace("'", "", $String); //Signo de exclamación abierta.&iexcl;
        $String = str_replace("!", "", $String); //Signo de exclamación cerrada.&iexcl;
        $String = str_replace("’", "", $String); //Signo de exclamación cerrada.&iexcl;
        $String = str_replace("¢", "-", $String); //Signo de centavo.&cent;
        $String = str_replace("£", "-", $String); //Signo de libra esterlina.&pound;
        $String = str_replace("¤", "-", $String); //Signo monetario.&curren;
        $String = str_replace("¥", "-", $String); //Signo del yen.&yen;
        $String = str_replace("¦", "-", $String); //Barra vertical partida.&brvbar;
        $String = str_replace("§", "-", $String); //Signo de sección.&sect;
        $String = str_replace("¨", "-", $String); //Diéresis.&uml;
        $String = str_replace("©", "-", $String); //Signo de derecho de copia.&copy;
        $String = str_replace("ª", "-", $String); //Indicador ordinal femenino.&ordf;
        $String = str_replace("«", "-", $String); //Signo de comillas francesas de apertura.&laquo;
        $String = str_replace("¬", "-", $String); //Signo de negación.&not;
        $String = str_replace("", "-", $String); //Guión separador de sílabas.&shy;
        $String = str_replace("®", "-", $String); //Signo de marca registrada.&reg;
        $String = str_replace("¯", "&-", $String); //Macrón.&macr;
        $String = str_replace("°", "-", $String); //Signo de grado.&deg;
        $String = str_replace("±", "-", $String); //Signo de más-menos.&plusmn;
        $String = str_replace("²", "-", $String); //Superíndice dos.&sup2;
        $String = str_replace("³", "-", $String); //Superíndice tres.&sup3;
        $String = str_replace("´", "-", $String); //Acento agudo.&acute;
        $String = str_replace("µ", "-", $String); //Signo de micro.&micro;
        $String = str_replace("¶", "-", $String); //Signo de calderón.&para;
        $String = str_replace("·", "-", $String); //Punto centrado.&middot;
        $String = str_replace("¸", "-", $String); //Cedilla.&cedil;
        $String = str_replace("¹", "-", $String); //Superíndice 1.&sup1;
        $String = str_replace("º", "-", $String); //Indicador ordinal masculino.&ordm;
        $String = str_replace("»", "-", $String); //Signo de comillas francesas de cierre.&raquo;
        $String = str_replace("¼", "-", $String); //Fracción vulgar de un cuarto.&frac14;
        $String = str_replace("½", "-", $String); //Fracción vulgar de un medio.&frac12;
        $String = str_replace("¾", "-", $String); //Fracción vulgar de tres cuartos.&frac34;
        $String = str_replace("¿", "-", $String); //Signo de interrogación abierta.&iquest;
        $String = str_replace("×", "-", $String); //Signo de multiplicación.&times;
        $String = str_replace("÷", "-", $String); //Signo de división.&divide;
        $String = str_replace("À", "a", $String); //A mayúscula con acento grave.&Agrave;
        $String = str_replace("Á", "a", $String); //A mayúscula con acento agudo.&Aacute;
        $String = str_replace("Â", "a", $String); //A mayúscula con circunflejo.&Acirc;
        $String = str_replace("Ã", "a", $String); //A mayúscula con tilde.&Atilde;
        $String = str_replace("Ä", "a", $String); //A mayúscula con diéresis.&Auml;
        $String = str_replace("Å", "a", $String); //A mayúscula con círculo encima.&Aring;
        $String = str_replace("Æ", "a", $String); //AE mayúscula.&AElig;
        $String = str_replace("Ç", "c", $String); //C mayúscula con cedilla.&Ccedil;
        $String = str_replace("È", "e", $String); //E mayúscula con acento grave.&Egrave;
        $String = str_replace("É", "e", $String); //E mayúscula con acento agudo.&Eacute;
        $String = str_replace("Ê", "e", $String); //E mayúscula con circunflejo.&Ecirc;
        $String = str_replace("Ë", "e", $String); //E mayúscula con diéresis.&Euml;
        $String = str_replace("Ì", "i", $String); //I mayúscula con acento grave.&Igrave;
        $String = str_replace("Í", "i", $String); //I mayúscula con acento agudo.&Iacute;
        $String = str_replace("Î", "i", $String); //I mayúscula con circunflejo.&Icirc;
        $String = str_replace("Ï", "i", $String); //I mayúscula con diéresis.&Iuml;
        $String = str_replace("Ð", "d", $String); //ETH mayúscula.&ETH;
        $String = str_replace("Ñ", "n", $String); //N mayúscula con tilde.&Ntilde;
        $String = str_replace("Ò", "o", $String); //O mayúscula con acento grave.&Ograve;
        $String = str_replace("Ó", "o", $String); //O mayúscula con acento agudo.&Oacute;
        $String = str_replace("Ô", "o", $String); //O mayúscula con circunflejo.&Ocirc;
        $String = str_replace("Õ", "o", $String); //O mayúscula con tilde.&Otilde;
        $String = str_replace("Ö", "o", $String); //O mayúscula con diéresis.&Ouml;
        $String = str_replace("Ø", "o", $String); //O mayúscula con barra inclinada.&Oslash;
        $String = str_replace("Ù", "u", $String); //U mayúscula con acento grave.&Ugrave;
        $String = str_replace("Ú", "u", $String); //U mayúscula con acento agudo.&Uacute;
        $String = str_replace("Û", "u", $String); //U mayúscula con circunflejo.&Ucirc;
        $String = str_replace("Ü", "u", $String); //U mayúscula con diéresis.&Uuml;
        $String = str_replace("Ý", "y", $String); //Y mayúscula con acento agudo.&Yacute;
        $String = str_replace("Þ", "b", $String); //Thorn mayúscula.&THORN;
        $String = str_replace("ß", "b", $String); //S aguda alemana.&szlig;
        $String = str_replace("à", "a", $String); //a minúscula con acento grave.&agrave;
        $String = str_replace("á", "a", $String); //a minúscula con acento agudo.&aacute;
        $String = str_replace("â", "a", $String); //a minúscula con circunflejo.&acirc;
        $String = str_replace("ã", "a", $String); //a minúscula con tilde.&atilde;
        $String = str_replace("ä", "a", $String); //a minúscula con diéresis.&auml;
        $String = str_replace("å", "a", $String); //a minúscula con círculo encima.&aring;
        $String = str_replace("æ", "a", $String); //ae minúscula.&aelig;
        $String = str_replace("ç", "a", $String); //c minúscula con cedilla.&ccedil;
        $String = str_replace("è", "e", $String); //e minúscula con acento grave.&egrave;
        $String = str_replace("é", "e", $String); //e minúscula con acento agudo.&eacute;
        $String = str_replace("ê", "e", $String); //e minúscula con circunflejo.&ecirc;
        $String = str_replace("ë", "e", $String); //e minúscula con diéresis.&euml;
        $String = str_replace("ì", "i", $String); //i minúscula con acento grave.&igrave;
        $String = str_replace("í", "i", $String); //i minúscula con acento agudo.&iacute;
        $String = str_replace("î", "i", $String); //i minúscula con circunflejo.&icirc;
        $String = str_replace("ï", "i", $String); //i minúscula con diéresis.&iuml;
        $String = str_replace("ð", "i", $String); //eth minúscula.&eth;
        $String = str_replace("ñ", "n", $String); //n minúscula con tilde.&ntilde;
        $String = str_replace("ò", "o", $String); //o minúscula con acento grave.&ograve;
        $String = str_replace("ó", "o", $String); //o minúscula con acento agudo.&oacute;
        $String = str_replace("ô", "o", $String); //o minúscula con circunflejo.&ocirc;
        $String = str_replace("õ", "o", $String); //o minúscula con tilde.&otilde;
        $String = str_replace("ö", "o", $String); //o minúscula con diéresis.&ouml;
        $String = str_replace("ø", "o", $String); //o minúscula con barra inclinada.&oslash;
        $String = str_replace("ù", "o", $String); //u minúscula con acento grave.&ugrave;
        $String = str_replace("ú", "u", $String); //u minúscula con acento agudo.&uacute;
        $String = str_replace("û", "u", $String); //u minúscula con circunflejo.&ucirc;
        $String = str_replace("ü", "u", $String); //u minúscula con diéresis.&uuml;
        $String = str_replace("ý", "y", $String); //y minúscula con acento agudo.&yacute;
        $String = str_replace("þ", "b", $String); //thorn minúscula.&thorn;
        $String = str_replace("ÿ", "y", $String); //y minúscula con diéresis.&yuml;
        $String = str_replace("Œ", "d", $String); //OE Mayúscula.&OElig;
        $String = str_replace("œ", "-", $String); //oe minúscula.&oelig;
        $String = str_replace("Ÿ", "-", $String); //Y mayúscula con diéresis.&Yuml;
        $String = str_replace("ˆ", "", $String); //Acento circunflejo.&circ;
        $String = str_replace("˜", "", $String); //Tilde.&tilde;
        $String = str_replace("%", "", $String); //Guiún corto.&ndash;
        $String = str_replace("-", "", $String); //Guiún corto.&ndash;
        $String = str_replace("–", "", $String); //Guiún corto.&ndash;
        $String = str_replace("—", "", $String); //Guiún largo.&mdash;
        $String = str_replace("'", "", $String); //Comilla simple izquierda.&lsquo;
        $String = str_replace("'", "", $String); //Comilla simple derecha.&rsquo;
        $String = str_replace("‚", "", $String); //Comilla simple inferior.&sbquo;
        $String = str_replace("\"", "", $String); //Comillas doble derecha.&rdquo;
        $String = str_replace("\"", "", $String); //Comillas doble inferior.&bdquo;
        $String = str_replace("†", "-", $String); //Daga.&dagger;
        $String = str_replace("‡", "-", $String); //Daga doble.&Dagger;
        $String = str_replace("…", "-", $String); //Elipsis horizontal.&hellip;
        $String = str_replace("‰", "-", $String); //Signo de por mil.&permil;
        $String = str_replace("‹", "-", $String); //Signo izquierdo de una cita.&lsaquo;
        $String = str_replace("›", "-", $String); //Signo derecho de una cita.&rsaquo;
        $String = str_replace("€", "-", $String); //Euro.&euro;
        $String = str_replace("™", "-", $String); //Marca registrada.&trade;
        $String = str_replace(":", "-", $String); //Marca registrada.&trade;
        $String = str_replace(" & ", "-", $String); //Marca registrada.&trade;
        $String = str_replace("(", "-", $String);
        $String = str_replace(")", "-", $String);
        $String = str_replace("?", "-", $String);
        $String = str_replace("¿", "-", $String);
        $String = str_replace(",", "-", $String);
        $String = str_replace(";", "-", $String);
        $String = str_replace("�", "-", $String);
        $String = str_replace("/", "-", $String);
        $String = str_replace(" ", "-", $String); //Espacios
        $String = str_replace(".", "", $String); //Punto
        $String = str_replace("&", "-", $String);

        //Mayusculas
        $String = strtolower($String);

        return ($String);
    }

    /**
     * Obtener aviso COPPA activo
     * @return object|null
     */
    function getCoppaNotice()
    {
        // Usar el endpoint correcto: aviso-coppas (plural)
        $resp = $this->queryStrapi("aviso-coppas?status=active&_sort=notice_published_date:DESC&_limit=1");
        // Si no encuentra con status=active, buscar cualquier publicado
        if (!$resp || !isset($resp->response) || empty($resp->response)) {
            $resp = $this->queryStrapi("aviso-coppas?_sort=notice_published_date:DESC&_limit=1");
        }
        return $resp;
    }

    /**
     * Obtener versión específica del aviso COPPA
     * @param string $version Versión a obtener (ej: "v1.0")
     * @return object|null
     */
    function getCoppaNoticeByVersion($version)
    {
        // Usar el endpoint correcto: aviso-coppas (plural)
        $resp = $this->queryStrapi("aviso-coppas?version=" . urlencode($version) . "&_limit=1");
        return $resp;
    }

    /**
     * Obtener todas las versiones del aviso COPPA (para historial)
     * @return object|null
     */
    function getAllCoppaNotices()
    {
        // Usar el endpoint correcto: aviso-coppas (plural)
        $resp = $this->queryStrapi("aviso-coppas?_sort=notice_published_date:DESC");
        return $resp;
    }

    /**
     * ═══════════════════════════════════════════════════════════════
     * ENCRYPTION AT REST - Methods for Data Protection
     * ═══════════════════════════════════════════════════════════════
     */

    /**
     * Inicializa el servicio de cifrado
     */
    function initCrypto()
    {
        try {
            // Obtener clave de cifrado de variable de entorno
            $encryptionKey = Env::get('DATA_ENCRYPTION_KEY');

            if (!$encryptionKey) {
                // En desarrollo, mostrar warning
                error_log('WARNING: DATA_ENCRYPTION_KEY not set. Encryption disabled.');
                $this->crypto = null;
                return;
            }

            require_once __DIR__ . '/../../includes/CryptoService.php';
            $this->crypto = new CryptoService($encryptionKey);
        } catch (Exception $e) {
            error_log('CryptoService initialization error: ' . $e->getMessage());
            $this->crypto = null;
        }
    }

    /**
     * Cifra campos sensibles de un niño antes de enviar a Strapi
     */
    function encryptChildData($data)
    {
        if (!isset($this->crypto)) {
            $this->initCrypto();
        }

        if (!$this->crypto) {
            return $data;
        }

        $fieldsToEncrypt = ['name', 'lastname', 'birthday'];

        foreach ($fieldsToEncrypt as $field) {
            if (isset($data[$field]) && !empty($data[$field])) {
                if (!$this->crypto->isEncrypted($data[$field])) {
                    $data[$field] = $this->crypto->encrypt($data[$field]);
                }
            }
        }

        return $data;
    }

    /**
     * Descifra campos sensibles de un niño después de recibir de Strapi
     */
    function decryptChildData($child)
    {
        if (!isset($this->crypto)) {
            $this->initCrypto();
        }

        if (!$this->crypto || !$child) {
            return $child;
        }

        $isArray = is_array($child);
        if ($isArray) {
            $child = (object) $child;
        }

        $fieldsToDecrypt = ['name', 'lastname', 'birthday'];

        foreach ($fieldsToDecrypt as $field) {
            if (isset($child->$field)) {
                if ($this->crypto->isEncrypted($child->$field)) {
                    try {
                        $child->$field = $this->crypto->decrypt($child->$field);
                    } catch (Exception $e) {
                        error_log("Error decrypting child.$field: " . $e->getMessage());
                    }
                }
            }
        }

        return $isArray ? (array) $child : $child;
    }

    /**
     * Cifra campos sensibles de padres antes de enviar
     */
    function encryptParentData($data)
    {
        if (!isset($this->crypto)) {
            $this->initCrypto();
        }

        if (!$this->crypto) {
            return $data;
        }

        $fieldsToEncrypt = ['phone'];

        foreach ($fieldsToEncrypt as $field) {
            if (isset($data[$field]) && !empty($data[$field])) {
                if (!$this->crypto->isEncrypted($data[$field])) {
                    $data[$field] = $this->crypto->encrypt($data[$field]);
                }
            }
        }

        return $data;
    }

    /**
     * Descifra campos sensibles de padres después de recibir
     */
    function decryptParentData($parent)
    {
        if (!isset($this->crypto)) {
            $this->initCrypto();
        }

        if (!$this->crypto || !$parent) {
            return $parent;
        }

        $isArray = is_array($parent);
        if ($isArray) {
            $parent = (object) $parent;
        }

        $fieldsToDecrypt = ['phone'];

        foreach ($fieldsToDecrypt as $field) {
            if (isset($parent->$field) && $this->crypto->isEncrypted($parent->$field)) {
                try {
                    $parent->$field = $this->crypto->decrypt($parent->$field);
                } catch (Exception $e) {
                    error_log("Error decrypting parent.$field: " . $e->getMessage());
                }
            }
        }

        return $isArray ? (array) $parent : $parent;
    }

    /**
     * Cifra información de salud antes de enviar
     */
    function encryptHealthData($data)
    {
        if (!isset($this->crypto)) {
            $this->initCrypto();
        }

        if (!$this->crypto) {
            return $data;
        }

        $textFields = [
            'physical_health',
            'emotional_health',
            'suspected_abuse',
            'pediatrician',
            // 'pediatrician_email', // NO CIFRAR por validación de Strapi
        ];

        foreach ($textFields as $field) {
            if (isset($data[$field]) && !empty($data[$field])) {
                if (!$this->crypto->isEncrypted($data[$field])) {
                    $data[$field] = $this->crypto->encrypt($data[$field]);
                }
            }
        }

        $arrayFields = ['allergies', 'medicines', 'accidents', 'vacination', 'ointments', 'incidents'];

        foreach ($arrayFields as $field) {
            // Cifrar incluso si está vacío para devolver un string cifrado de "[]"
            // Strapi espera un string en este campo, si enviamos array [], falla con 400 Bad Request
            if (isset($data[$field]) && is_array($data[$field])) {
                $data[$field] = $this->crypto->encryptArray($data[$field]);
            }
        }

        // Cifrado granular para healthcheck (Strapi exige Array, no String cifrado)
        if (isset($data['healthcheck']) && is_array($data['healthcheck'])) {
            foreach ($data['healthcheck'] as &$check) {
                // Campos internos a cifrar
                $checkFields = ['temperature', 'report', 'bodychild'];
                foreach ($checkFields as $cf) {
                    if (isset($check[$cf]) && !$this->crypto->isEncrypted($check[$cf])) {
                        $check[$cf] = $this->crypto->encrypt($check[$cf]);
                    }
                }
            }
            // Nota: daily_fecha se mantiene en texto plano para búsquedas/índices si fuera necesario,
            // o se agrega a $checkFields si la política lo exige estricto.
        }
        return $data;
    }

    /**
     * Descifra información de salud después de recibir
     */
    function decryptHealthData($healthInfo)
    {
        if (!isset($this->crypto)) {
            $this->initCrypto();
        }

        if (!$this->crypto || !$healthInfo) {
            return $healthInfo;
        }

        $isArray = is_array($healthInfo);
        if ($isArray) {
            $healthInfo = (object) $healthInfo;
        }

        $textFields = [
            'physical_health',
            'emotional_health',
            'suspected_abuse',
            'pediatrician',
            // 'pediatrician_email', // NO CIFRAR por validación de Strapi
            // 'pediatrician_number'
        ];

        foreach ($textFields as $field) {
            if (isset($healthInfo->$field) && $this->crypto->isEncrypted($healthInfo->$field)) {
                try {
                    $healthInfo->$field = $this->crypto->decrypt($healthInfo->$field);
                } catch (Exception $e) {
                    error_log("Error decrypting healthInfo.$field: " . $e->getMessage());
                }
            }
        }

        $arrayFields = ['allergies', 'medicines', 'accidents', 'vacination', 'ointments', 'incidents'];

        foreach ($arrayFields as $field) {
            if (isset($healthInfo->$field)) {
                try {
                    $healthInfo->$field = $this->crypto->decryptArray($healthInfo->$field);

                    // Si es 'incidents', convertir cada elemento a objeto
                    // Esto es necesario porque decryptArray devuelve arrays asociativos
                    // pero las vistas esperan objetos (stdClass)
                    if ($field === 'incidents' && is_array($healthInfo->$field)) {
                        foreach ($healthInfo->$field as &$inc) {
                            if (is_array($inc)) {
                                $inc = (object) $inc;
                            }
                        }
                    }
                } catch (Exception $e) {
                    error_log("Error decrypting healthInfo.$field: " . $e->getMessage());
                    $healthInfo->$field = [];
                }
            }
        }

        // Descifrado granular para healthcheck
        if (isset($healthInfo->healthcheck) && is_array($healthInfo->healthcheck)) {
            foreach ($healthInfo->healthcheck as &$check) {
                // Convertir a objeto si es array (consistencia)
                if (is_array($check)) {
                    $check = (object) $check;
                }

                $checkFields = ['temperature', 'report', 'bodychild'];
                foreach ($checkFields as $cf) {
                    if (isset($check->$cf) && $this->crypto->isEncrypted($check->$cf)) {
                        try {
                            $check->$cf = $this->crypto->decrypt($check->$cf);
                        } catch (Exception $e) {
                            error_log("Error decrypting healthcheck.$cf: " . $e->getMessage());
                        }
                    }
                }
            }
        }

        return $isArray ? (array) $healthInfo : $healthInfo;
    }

}