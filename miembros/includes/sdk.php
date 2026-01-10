<?php
require_once 'src/Mandrill.php';
class acuarela
{
    public $domain = "https://acuarelacore.com/api/";
    public $domainWP = "https://twinkle.acuarelacore.com/wp-json/wp/v2";
    public $domainWPA = "https://adminwebacuarela.bilingualchildcaretraining.com/wp-json/wp/v2";
    public $domainNuevaWP = "https://lolathecow.acuarelacore.com/wp-json/wp/v2";
    public $getgruposdeedad = "";
    public $getmomentoaprendizaje = "";
    public $getformas = "";
    private $openaiApiKey = "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";
    public $client_id = "1000.4CBCGSPLAUZ10CRM6XQYU2Z5JQBT9L";
    public $client_secret = "7c28db40807ee2e2459a9629f084d037ee7edc0c95";
    public $refresh_token = "1000.ecf5734d91ad7ba8474aaac5e019ec8f.6148872828accaaf6896a2d98af189f0";
    public $token;

    function __construct()
    {
        $this->getgruposdeedad = $this->getgruposdeedad();
        $this->getmomentoaprendizaje = $this->getmomentoaprendizaje();
        $this->getformas = $this->getformas();
    }
    function performCurlRequest($url, $method, $data, $headers)
    {
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => $headers,
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
    function transformMergeVars($vars)
    {
        $mergeVars = array();
        foreach ($vars as $key => $value) {
            array_push($mergeVars, ['name' => $key, 'content' => $value]);
        }
        return $mergeVars;
    }
    function send_notification($from, $to, $toname, $mergevariables, $subject, $template, $mandrillApiKey, $fromName = "Mandrill Message", $async = false)
    {
        $result = '';
        try {
            if ($from == "") {
                $from = 'info@bilingualchildcaretraining.com';
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
            $result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool, $send_at);
            $answer = true;
        } catch (Mandrill_Error $e) {
            $result = 'Error de envío: ' . get_class($e) . ' - ' . $e->getMessage();
            $answer = false;
            throw $e;
        }
        return $result;
    }
    function getAuthToken()
    {
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://accounts.zoho.com/oauth/v2/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('client_id' => '1000.LB0PNT6MAW7ST7YGJ9XR9JEGWPVFGS', 'client_secret' => 'f4efeca5ed7818162ffc900c9c5aa292b8f42b79ca', 'code' => '1000.498ca49293740e0ab477b3e37319bd04.cba7136af5e344d34749edb9690b2942', 'grant_type' => 'authorization_code')
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        $code = json_decode($response);
        return $code;
    }
    function getTokenZoho()
    {
        $refresh_url = "https://accounts.zoho.com/oauth/v2/token";

        $data = [
            "refresh_token" => $this->refresh_token,
            "client_id" => $this->client_id,
            "client_secret" => $this->client_secret,
            "grant_type" => "refresh_token"
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $refresh_url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ["Content-Type: application/x-www-form-urlencoded"],
        ]);

        $response_token = curl_exec($curl);
        $responseDataToken = json_decode($response_token, true);
        //var_dump($responseDataToken);
        curl_close($curl);

        return $responseDataToken['access_token'] ?? null;
    }
    function createZohoContact($name, $lastname, $email, $phone, $daycare, $license, $refreshed)
    {
        $url = 'https://www.zohoapis.com/crm/v4/Contacts';

        $data = array(
            "data" => array(
                array(
                    "Owner" => array("id" => "4376238000000251013"),
                    "Account_Name" => array("id" => "Bilingual Child Care Training"),
                    "Vendor_Name" => array("id" => "4376238000000638190"),
                    "Email" => $email,
                    "Description" => "Daycare: " . $daycare . ", Licencia:" . $daycare . ",",
                    "First_Name" => $name,
                    "Phone" => $phone,
                    "Mobile" => $phone,
                    "Last_Name" => $lastname
                )
            )
        );

        $headers = array(
            'Authorization: Bearer ' . $refreshed->access_token,
            'Content-Type: application/json'
        );

        $resUserContact = $this->performCurlRequest($url, 'POST', $data, $headers);
        return $resUserContact;
    }
    function createZohoDaycare($data, $refreshed)
    {
        $url = 'https://www.zohoapis.com/crm/v4/Daycares';
        $zohoFields = array(
            "Owner" => array("id" => "4376238000000251013"),
            "Name" => $data['DaycareName'] ?? null,
            "Account_Name" => array("id" => "Bilingual Child Care Training"),
            "Vendor_Name" => array("id" => "4376238000000638190"),
            "Closing_Hour" => $data['ClosingHour'] ?? null,
            "Daycare_Apt_or_Floor" => $data['DaycareAptOrFloor'] ?? null,
            "Daycare_City" => $data['DaycareCity'] ?? null,
            "Daycare_Image" => $data['DaycareImage'] ?? null,
            "Daycare_Name" => $data['DaycareName'] ?? null,
            "Daycare_Owner" => $data['DaycareOwner'] ?? null,
            "Daycare_Phone" => $data['DaycarePhone'] ?? null,
            "Daycare_State" => $data['DaycareState'] ?? null,
            "Daycare_Street" => $data['DaycareStreet'] ?? null,
            "Daycare_Zip_Code" => strval($data['DaycareZipCode']) ?? "0",
            "Description" => $data['Description'] ?? null,
            "Email" => $data['Email'] ?? null,
            "Extended_Hour" => $data['ExtendedHour'] ?? null,
            "FacebookURL" => $data['FacebookURL'] ?? null,
            "Foundation_Date" => $data['FoundationDate'] ?? null,
            "InstagramURL" => $data['InstagramURL'] ?? null,
            "License_Capacity" => $data['LicenseCapacity'] ?? null,
            "License_Expiration_Date" => $data['LicenseExpirationDate'] ?? null,
            "License_No" => $data['LicenseNo'] ?? null,
            "On_site_Provider_Name" => $data['OnSiteProvider'] ?? null,
            "Opening_Hour" => $data['OpeningHour'] ?? null,
            "Owner1" => $data['DaycareOwner'] ?? null,
            "Philosophy" => $data['Philosophy'] ?? null,
            "Secondary_Email" => $data['SecondaryEmail'] ?? null,
            "Tik_Tok" => $data['TikTok'] ?? null,
            "Twitter" => $data['Twitter'] ?? null,
            "URL_Web_Site" => $data['URLWebsite'] ?? null
        );
        // Remove any null values from the array
        $zohoFields = array_filter($zohoFields, function ($value) {
            return $value !== null;
        });
        $data = array("data" => array($zohoFields));
        $headers = array(
            'Authorization: Bearer ' . $refreshed->access_token,
            'Content-Type: application/json'
        );
        $daycareCreated = $this->performCurlRequest($url, 'POST', $data, $headers);
        return $daycareCreated;
    }
    function createAllZoho($name, $lastname, $email, $phone, $daycare, $license, $phonedaycare, $emaildaycare, $expiration, $state, $refreshed)
    {
        $array = array();
        // Create the contact and get the response
        $contact = $this->createZohoContact($name, $lastname, $email, $phone, $daycare, $license, $refreshed);
        $contactResponse = json_decode($contact, true);
        // Check if the contact creation was successful

        if (isset($contactResponse["data"][0]["details"]["id"])) {
            $contactId = $contactResponse["data"][0]["details"]["id"];
            $dataDaycare = array(
                "DaycareName" => $daycare,
                "DaycareOwner" => $contactId,
                "LicenseNo" => $license,
                "OnSiteProvider" => $contactId,
                "DaycareState" => $state,
                "DaycarePhone" => $phonedaycare,
                "Email" => $emaildaycare,
                "LicenseExpirationDate" => $expiration
            );

            // Use the contact ID to create the daycare using the createZohoDaycare function
            $daycareResponse = $this->createZohoDaycare($dataDaycare, $refreshed);
            $array["contactResponse"] = $contactResponse;
            $array["daycareResponse"] = $daycareResponse;
            return $array;
        } else if (isset($contactResponse["data"][0]["details"]["duplicate_record"]["id"])) {
            $contactId = $contactResponse["data"][0]["details"]["duplicate_record"]["id"];
            $dataDaycare = array(
                "DaycareName" => $daycare,
                "DaycareOwner" => $contactId,
                "LicenseNo" => $license,
                "OnSiteProvider" => $contactId,
                "DaycareState" => $state,
                "DaycarePhone" => $phonedaycare,
                "Email" => $emaildaycare,
                "LicenseExpirationDate" => $expiration
            );

            // Use the contact ID to create the daycare using the createZohoDaycare function
            $daycareResponse = $this->createZohoDaycare($dataDaycare, $refreshed);
            $array["contactResponse"] = $contactResponse;
            $array["daycareResponse"] = $daycareResponse;
            return $array;
        } else {
            $contactId = $contactResponse["data"][0]["details"]["errors"][0]["details"]["duplicate_record"]["id"];
            $dataDaycare = array(
                "DaycareName" => $daycare,
                "DaycareOwner" => $contactId,
                "LicenseNo" => $license,
                "OnSiteProvider" => $contactId,
                "DaycareState" => $state,
                "DaycarePhone" => $phonedaycare,
                "Email" => $emaildaycare,
                "LicenseExpirationDate" => $expiration
            );

            // Use the contact ID to create the daycare using the createZohoDaycare function
            $daycareResponse = $this->createZohoDaycare($dataDaycare, $refreshed);
            $array["contactResponse"] = $contactResponse;
            $array["daycareResponse"] = $daycareResponse;
            return $array;
        }
    }

    function updateZohoDaycare($idZoho, $data, $refreshed)
    {
        $dataRes = json_decode($data);
        $url = 'https://www.zohoapis.com/crm/v4/Daycares/' . $idZoho;

        $zohoFields = array(
            "Account_Name" => array("id" => "Bilingual Child Care Training"),
            "Activation_Date" => $dataRes->activationdate ?? null,
            "Closing_Hour	" => $dataRes->schedule->closing_hour ?? null,
            "Daycare_Apt_or_Floor" => $dataRes->address->street ?? null,
            "Daycare_City" => $dataRes->city ?? null,
            "Daycare_Name" => $dataRes->name ?? null,
            "Daycare_Owner" => $dataRes->owner_name ?? null,
            "Daycare_Phone" => $dataRes->phone ?? null,
            "Daycare_State" => $dataRes->state ?? null,
            "Daycare_Street" => $dataRes->address->number ?? null,
            "Daycare_Zip_Code" => $dataRes->zip_code ?? 0,
            "Description" => $dataRes->description ?? null,
            "Email" => $dataRes->mail ?? null,
            "Extended_Hour" => $dataRes->schedule->horario_extendido ?? null,
            "Facebook" => $dataRes->networks_social_media->facebook ?? null,
            "Foundation_Date" => $dataRes->foundationdate ?? null,
            "Instagram" => $dataRes->networks_social_media->instagram ?? null,
            "InstagramURL" => $dataRes->networks_social_media->instagram ?? null,
            "License_Capacity" => $dataRes->name ?? null,
            "License_Expiration_Date" => $dataRes->name ?? null,
            "License_No" => $dataRes->license ?? null,
            "On-site_Provider" => $dataRes->onside_provider_name ?? null,
            "Opening_Hour" => $dataRes->schedule->opening_hour ?? null,
            "Philosophy" => $dataRes->filosofia ?? null,
            "Secondary_Email" => $dataRes->mail ?? null,
            "Tik_Tok" => $dataRes->networks_social_media->tiktok ?? null,
            "Twitter" => $dataRes->networks_social_media->twitter ?? null,
            "URL_Web_Site" => $dataRes->website ?? null,
            "Vendor_Name" => array("id" => "4376238000000638190"),
        );

        // Remove any null values from the array
        $zohoFields = array_filter($zohoFields, function ($value) {
            return $value !== null;
        });
        $data = array("data" => array($zohoFields));
        $headers = array(
            'Authorization: Bearer ' . $refreshed->access_token,
            'Content-Type: application/json',
            'Cookie: 1a99390653=0a0cd8f8f863c606ad892b381901fd90; 1ccad04dca=d12247a40ab7e0fe716c262964de2ae1; JSESSIONID=CE08EB69166EEA9FB11B4B50E4FA44EC; _zcsr_tmp=4e27bfe9-0494-477a-b0fd-494d42080b42; crmcsr=4e27bfe9-0494-477a-b0fd-494d42080b42; group_name=usergroup1'
        );

        return $this->performCurlRequest($url, 'PUT', $data, $headers);
    }
    function queryStrapi($url, $body = "", $method = "GET")
    {
        $endpoint = $this->domain . $url;
        $curl = curl_init();
        if (isset($_SESSION["userLogged"])) {

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $endpoint,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => $method,
                    CURLOPT_POSTFIELDS => $body,
                    CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'token: ' . $_SESSION["userLogged"]->user->token),
                )
            );
        } else {

            curl_setopt_array(
                $curl,
                array(
                    CURLOPT_URL => $endpoint,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => $method,
                    CURLOPT_POSTFIELDS => $body,
                    CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
                )
            );
        }

        $response = curl_exec($curl);
        $request = json_decode($response);
        curl_close($curl);
        return $request;
    }
    function gInfoDaycareStrapi($daycare)
    {
        $result = $this->queryStrapi("websites?daycare=" . $daycare);
        return $result[0];
    }
    function queryWorpress($url, $body = "", $cache = true, $cacheTTL = 3600)
    {
        // Directorio de cache
        $cacheDir = __DIR__ . '/../cache/wp/';
        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0755, true);
        }
        
        // Generar key de cache basada en la URL
        $cacheKey = md5($url . $body);
        $cacheFile = $cacheDir . $cacheKey . '.json';
        
        // Log para debug
        $this->logWP("queryWorpress llamado", substr($url, 0, 80));
        
        // Verificar si existe cache válido
        if ($cache && file_exists($cacheFile)) {
            $cacheAge = time() - filemtime($cacheFile);
            if ($cacheAge < $cacheTTL) {
                $cachedData = file_get_contents($cacheFile);
                $request = json_decode($cachedData);
                if ($request !== null) {
                    $this->logWP("CACHE HIT", "age: {$cacheAge}s, file: $cacheKey");
                    return $request;
                }
            } else {
                $this->logWP("CACHE EXPIRED", "age: {$cacheAge}s > TTL: {$cacheTTL}s");
            }
        } else {
            $this->logWP("CACHE MISS", "file not found or cache disabled");
        }
        
        // Hacer la llamada HTTP con timeout aumentado para pp=500
        $startTime = microtime(true);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://twinkle.acuarelacore.com/wp-json/wp/v2/' . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,           // Timeout aumentado a 60 segundos para evitar 524
            CURLOPT_CONNECTTIMEOUT => 15,    // Timeout de conexión de 15 segundos
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        $curlError = curl_error($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $elapsed = round((microtime(true) - $startTime) * 1000);
        curl_close($curl);
        
        // Si hay error, intentar devolver cache antiguo si existe
        if ($response === false || $curlError) {
            $this->logWP("CURL ERROR", "error: $curlError, time: {$elapsed}ms");
            if (file_exists($cacheFile)) {
                $cachedData = file_get_contents($cacheFile);
                $this->logWP("FALLBACK CACHE", "using expired cache due to error");
                return json_decode($cachedData);
            }
            return null;
        }
        
        $request = json_decode($response);
        
        // Guardar en cache si la respuesta es válida
        if ($cache && $request !== null) {
            $saved = @file_put_contents($cacheFile, $response);
            $this->logWP("API CALL OK", "HTTP: $httpCode, time: {$elapsed}ms, saved: " . ($saved ? 'yes' : 'NO'));
        } else {
            $this->logWP("API CALL", "HTTP: $httpCode, time: {$elapsed}ms, not cached (null response)");
        }
        
        return $request;
    }
    
    /**
     * Log de debug para llamadas WordPress
     */
    private function logWP($message, $data = null) {
        $logFile = __DIR__ . '/../cache/wp_debug.log';
        $timestamp = date('Y-m-d H:i:s');
        $logEntry = "[$timestamp] $message";
        if ($data !== null) {
            $logEntry .= " | Data: " . (is_string($data) ? $data : json_encode($data));
        }
        $logEntry .= PHP_EOL;
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }
    
    /**
     * Ejecuta múltiples llamadas a WordPress API en paralelo
     * @param array $urls Array asociativo ['key' => 'url', ...]
     * @param bool $cache Usar cache (default: true)
     * @param int $cacheTTL Tiempo de vida del cache en segundos (default: 600)
     * @return array Array asociativo con las respuestas ['key' => response, ...]
     */
    function queryWorpressParallel($urls, $cache = true, $cacheTTL = 3600) {
        $startTime = microtime(true);
        $this->logWP("=== INICIO queryWorpressParallel ===", count($urls) . " URLs");
        
        // Directorio de cache
        $cacheDir = __DIR__ . '/../cache/wp/';
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }
        
        $results = [];
        $urlsToFetch = [];
        $baseUrl = 'https://twinkle.acuarelacore.com/wp-json/wp/v2/';
        
        // Paso 1: Verificar cache para cada URL
        foreach ($urls as $key => $url) {
            $cacheKey = md5($url);
            $cacheFile = $cacheDir . $cacheKey . '.json';
            
            if ($cache && file_exists($cacheFile)) {
                $cacheAge = time() - filemtime($cacheFile);
                if ($cacheAge < $cacheTTL) {
                    $cachedData = file_get_contents($cacheFile);
                    $decoded = json_decode($cachedData);
                    if ($decoded !== null) {
                        // Normalizar: siempre devolver un array, incluso si el cache tiene un objeto individual
                        if (is_array($decoded)) {
                            $results[$key] = $decoded;
                        } else {
                            // Si es un objeto individual, convertirlo a array
                            $results[$key] = [$decoded];
                        }
                        $this->logWP("CACHE HIT: $key", "age: {$cacheAge}s, Items: " . count($results[$key]));
                        continue;
                    }
                }
            }
            // Necesita fetch
            $urlsToFetch[$key] = $url;
        }
        
        // Si todo estaba en cache, retornar
        if (empty($urlsToFetch)) {
            $elapsed = round((microtime(true) - $startTime) * 1000, 2);
            $this->logWP("=== FIN (todo en cache) ===", "{$elapsed}ms");
            return $results;
        }
        
        $this->logWP("URLs a buscar (sin cache)", count($urlsToFetch));
        
        // Paso 2: Preparar multi-curl
        $multiHandle = curl_multi_init();
        $curlHandles = [];
        
        foreach ($urlsToFetch as $key => $url) {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $baseUrl . $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,           // Timeout aumentado a 30 seg para evitar 524
                CURLOPT_CONNECTTIMEOUT => 10,    // Connect timeout aumentado a 10 seg
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            ]);
            curl_multi_add_handle($multiHandle, $ch);
            $curlHandles[$key] = $ch;
        }
        
        // Paso 3: Ejecutar todas las llamadas en paralelo
        $running = null;
        do {
            $status = curl_multi_exec($multiHandle, $running);
            if ($running) {
                curl_multi_select($multiHandle);
            }
        } while ($running && $status == CURLM_OK);
        
        // Paso 4: Recoger resultados
        foreach ($curlHandles as $key => $ch) {
            $response = curl_multi_getcontent($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            $totalTime = round(curl_getinfo($ch, CURLINFO_TOTAL_TIME) * 1000, 2);
            
            if ($error) {
                $this->logWP("ERROR en $key", "Error: $error");
                $results[$key] = null;
                
                // Intentar usar cache antiguo como fallback
                $cacheKey = md5($urlsToFetch[$key]);
                $cacheFile = $cacheDir . $cacheKey . '.json';
                if (file_exists($cacheFile)) {
                    $cachedData = file_get_contents($cacheFile);
                    $decoded = json_decode($cachedData);
                    // Normalizar: siempre devolver un array
                    if ($decoded !== null) {
                        if (is_array($decoded)) {
                            $results[$key] = $decoded;
                        } else {
                            $results[$key] = [$decoded];
                        }
                    } else {
                        $results[$key] = [];
                    }
                    $this->logWP("FALLBACK a cache antiguo: $key");
                } else {
                    $results[$key] = [];
                }
            } else if ($httpCode !== 200) {
                $this->logWP("HTTP ERROR en $key", "Code: $httpCode, Time: {$totalTime}ms");
                $results[$key] = null;
            } else {
                $decoded = json_decode($response);
                
                // Normalizar: siempre devolver un array, incluso si WordPress devuelve un objeto individual
                if ($decoded !== null) {
                    if (is_array($decoded)) {
                        $results[$key] = $decoded;
                    } else {
                        // Si es un objeto individual, convertirlo a array
                        $results[$key] = [$decoded];
                    }
                } else {
                    $results[$key] = [];
                }
                
                $this->logWP("OK: $key", "HTTP: $httpCode, Time: {$totalTime}ms, Items: " . (is_array($results[$key]) ? count($results[$key]) : 1));
                
                // Guardar en cache
                if ($cache && $decoded !== null) {
                    $cacheKey = md5($urlsToFetch[$key]);
                    $cacheFile = $cacheDir . $cacheKey . '.json';
                    file_put_contents($cacheFile, $response);
                }
            }
            
            curl_multi_remove_handle($multiHandle, $ch);
            curl_close($ch);
        }
        
        curl_multi_close($multiHandle);
        
        $elapsed = round((microtime(true) - $startTime) * 1000, 2);
        $this->logWP("=== FIN queryWorpressParallel ===", "Total: {$elapsed}ms, URLs: " . count($urls));
        
        return $results;
    }
    
    function queryWorpressAcuarela($url, $body = "", $method = "GET")
    {
        $endpoint = $this->domainWPA . '/' . $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $request = json_decode($output);
        curl_close($ch);
        return $request;
    }

    function queryNuevaWeb($url, $body = "", $method = "GET")
    {
        $endpoint = $this->domainNuevaWP . '/' . $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $request = json_decode($output);
        curl_close($ch);
        return $request;
    }
    function gWebinars()
    {
        $result = $this->queryNuevaWeb("webinar");
        return $result;
    }
    function gPromocionWebinar()
    {
        $result = $this->queryNuevaWeb("promotions");
        return $result;
    }
    function getInscription($id)
    {
        $result = $this->queryStrapi("inscripciones/" . $id . "?status=Finalizado");
        return $result;
    }
    function getActividades($pp = 100)
    {
        $response = $this->queryWorpress("planessemanales?pp=" . $pp . "&per_page=100");
        return $response;
    }
    function getActividad($id)
    {
        $response = $this->queryWorpress("planessemanales/" . $id);
        return $response;
    }
    function getgruposdeedad()
    {
        // if (isset($_SESSION['getgruposdeedad'])) {
        //     $gnrl = $_SESSION['getgruposdeedad'];
        // } else {
        $gnrl = $this->queryWorpress('gruposdeedad?per_page=100');
        $_SESSION['getgruposdeedad'] = $gnrl;
        // }
        return $gnrl;
    }
    function getformas()
    {
        if (isset($_SESSION['getformas'])) {
            $gnrl = $_SESSION['getformas'];
        } else {
            $gnrl = $this->queryWorpress('formas-bcct?per_page=100');
            $_SESSION['getformas'] = $gnrl;
        }
        return $gnrl;
    }
    function getGeneracionOne()
    {
        $revistas = $this->queryWorpress('one-bcct?per_page=100', "", true);
        return $revistas;
    }
    function getmomentoaprendizaje()
    {
        if (isset($_SESSION['getmomentoaprendizaje'])) {
            $gnrl = $_SESSION['momentoaprendizaje'];
        } else {
            $gnrl = $this->queryWorpress('momentoaprendizaje?per_page=100');
            $_SESSION['momentoaprendizaje'] = $gnrl;
        }
        return $gnrl;
    }
    function getDomain($id)
    {
        $gnrl = $this->queryWorpress('dominiouc/' . $id);
        return $gnrl;
    }
    function getNovedades()
    {
        $novedades = $this->queryWorpress('novedades-bilingual');
        return $novedades;
    }
    function getElof($id)
    {
        $gnrl = $this->queryWorpress('elof/' . $id);
        return $gnrl;
    }
    function getCurriCulum()
    {
        $gnrl = $this->queryWorpress('curriculum?per_page=100');
        return $gnrl;
    }
    function loginBilingualUser($email, $pass)
    {
        $user = $this->queryStrapi("bilingual-users/login", '{ "email": "' . $email . '", "password": "' . $pass . '" }', 'POST');
        if ($user->ok) {
            $userInfo = $this->queryStrapi("bilingual-users/" . $user->user->bilingual_user);
            $userInfoAll = $this->queryStrapi("bilingual-users/single/" . $user->user->bilingual_user);
            $_SESSION["userLogged"] = $user;
            $_SESSION["user"] = $userInfo;
            $_SESSION["userAll"] = $userInfoAll[0];
            return $userInfo;
        } else {
            return array("ok" => false, "message" => "No se encontro usuario");
        }
    }
    // Función para cerrar sesión
    function logout()
    {
        // Destruye la sesión actual
        session_destroy();
        // Redirige al usuario a la página de inicio o donde prefieras
        header("Location: /miembros/"); // Cambia esto a la página de inicio o a la que desees
        exit();
    }
    function getDaycare($id)
    {
        $daycare = $this->queryStrapi("daycares/" . $id);
        return $daycare->response[0];
    }
    function getSub($id)
    {
        $res = $this->queryStrapi("suscriptions/" . $id);
        return $res;
    }
    function getAgeGroups()
    {
        $res = $this->queryStrapi("age-groups");
        return $res;
    }
    function getMenus($age)
    {
        $res = $this->queryStrapi("menus/random/$age/v1");
        return $res;
    }
    function getDaycareWeb($id)
    {
        $daycare = $this->queryWorpressAcuarela("daycare-web?field=id_daycare&value=" . $id);
        return $daycare[0];
    }
    function updateDaycare($data)
    {
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://hook.us1.make.com/mb45f89zh5gxdxkpdk5fb8qmso7hnmni',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            )
        );

        $response = curl_exec($curl);

        if ($response === false) {
            // Si curl_exec() falla, se captura el error
            $error = curl_error($curl);
            curl_close($curl);
            return ['error' => 'cURL Error: ' . $error];
        }

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // if ($httpCode != 200) {
        //     return ['error' => 'HTTP Error Code: ' . $httpCode];
        // }

        return json_decode($response, true);
    }
    function registerUser($name, $email, $phone, $password, $daycare, $license, $acuarelaUser, $contact_zoho, $condado, $lastname)
    {
        $data = '{"name":"' . $name . '","lastname":"' . $lastname . '", "email":"' . $email . '","password":"' . $password . '","state":"","phone":"' . $phone . '","acuarelauser":"' . $acuarelaUser . '", "daycares": ["' . $daycare . '"], "zoho_contact_id": "' . $contact_zoho . '", "state":"' . $condado . '"}';
        $userCreatedResponse = $this->queryStrapi("/bilingual-users", $data, "POST");

        return $userCreatedResponse;
    }
    function updateUser($acuarelaid, $bilingualid, $data)
    {
        $userAcuarelaRes = $this->queryStrapi("/acuarelausers/" . $acuarelaid, $data, "PUT");
        $userBilingualRes = $this->queryStrapi("/bilingual-users/" . $bilingualid, $data, "PUT");
        $_SESSION['user'] = $userBilingualRes;
        return $userBilingualRes;
    }
    function createAcuarelaUser($name, $lastname, $email, $phone, $password, $daycare, $license, $condado, $phonedaycare, $emaildaycare, $expiration, $threadId, $estadoValue, $daycareValue, $daycareLogoUrl)
    {
        error_log("Iniciando cURL para el webhook");

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://hook.us1.make.com/88n6c8fippi86tcdqacw38fcr1bqlatq',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => http_build_query(
                    array(
                        'daycare' => $daycare,
                        'password' => $password,
                        'name' => $name,
                        'lastname' => $lastname,
                        'email' => $email,
                        'phone' => $phone,
                        'license' => $license,
                        'state' => $condado,
                        'phonedaycare' => $phonedaycare,
                        'emaildaycare' => $emaildaycare,
                        'expiration' => $expiration,
                        'threadId' => $threadId,
                        'estadoValue' => $estadoValue,
                        'daycareValue' => $daycareValue,
                        'daycareLogoUrl' => $daycareLogoUrl,
                        'method' => 'POST'
                    )
                ),
                CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded')
            )
        );

        $output = curl_exec($curl);
        if ($output === false) {
            error_log('cURL Error: ' . curl_error($curl));
            $array['error'] = 'cURL Error: ' . curl_error($curl);
        } else {
            $makeResponse = json_decode($output);
            error_log("Respuesta de Make: " . print_r($makeResponse, true));
            $array['response'] = $makeResponse;
        }
        curl_close($curl);

        // Enviar notificaciones
        $mergeVars = ['FNAME' => $name];
        $this->send_notification('info@bilingualchildcaretraining.com', $email, $name, $this->transformMergeVars($mergeVars), "Te damos la bienvenida!", 'portal-miembros-e4', 'maRkSStgpCapJoSmwHOZDg', "Bilingual Childcare Training");

        // $this->send_notification('noreplay@bilingualchildcaretraining.com',"info@bilingualchildcaretraining.com","name",$this->transformMergeVars($mergeVars),"Nuevo Usuario Registrado",'portal-miembros-new-user','maRkSStgpCapJoSmwHOZDg',"Bilingual Childcare Training");

        // Obtener usuario creado
        $usercreated = $this->loginBilingualUser($email, $password);
        $array["registerUser"] = $usercreated;
        $_SESSION["user"] = $usercreated;

        error_log("Usuario registrado exitosamente: " . print_r($usercreated, true));
        return $array;
    }
    // Escenario 3 to code 
    function getAcuarelaUser($id)
    {
        $acuarelaUser = $this->queryStrapi("/acuarelausers?bilingual_user=" . $id);
        return $acuarelaUser;
    }
    function addDaycareStrapi($daycare, $phone, $email, $state, $name, $license, $expiration, $photoID, $bilingualID, $acuarelaUserID)
    {
        $data = '{
            "name": "' . $daycare . '",
            "phone": "' . $phone . '",
            "mail": "' . $email . '",
            "state": "' . $state . '",
            "owner_name": "' . $name . '",
            "license": "' . $license . '",
            "license_expiration_date": "' . $expiration . '",
            "photo": "' . $photoID . '",
            "bilingual_users": ["' . $bilingualID . '"],
            "acuarelausers": ["' . $acuarelaUserID . '"],
            "active": true
        }';

        $daycareCreatedResponse = $this->queryStrapi("/daycares", $data, "POST");

        return $daycareCreatedResponse;
    }
    function addDaycareZoho($daycare, $contactName, $daycareOwner, $phone, $state, $email, $expiration, $license)
    {
        $new_token = $this->getTokenZoho();
        $data = [
            "data" => [
                [
                    "Owner" => ["id" => "4376238000000251013"],
                    "Account_Name" => ["id" => "Bilingual Child Care Training"],
                    "Vendor_Name" => ["id" => "4376238000000638190"],
                    "Name" => $daycare,
                    "Contact_Name" => $contactName,
                    "Daycare_Owner" => $daycareOwner,
                    "Daycare_Phone" => $phone,
                    "Daycare_State" => $state,
                    "Daycare_Zip_Code" => "023424",
                    "Email" => $email,
                    "License_Expiration_Date" => $expiration,
                    "License" => $license,
                ]
            ]
        ];

        $url = "https://www.zohoapis.com/crm/v4/Daycares";

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "Authorization: Zoho-oauthtoken $new_token",
                "Content-Type: application/json"
            ]
        ]);

        $response = curl_exec($curl);
        // Captura errores si ocurren
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            throw new Exception("Error al conectar con Zoho CRM: " . $error_msg);
        }

        curl_close($curl);

        // Decodifica la respuesta de Zoho CRM
        $decodedResponse = json_decode($response, true);

        // Verifica si hay errores en la respuesta
        if (isset($decodedResponse['data'][0]['code']) && $decodedResponse['data'][0]['code'] !== 'SUCCESS') {
            throw new Exception("Error de Zoho CRM: " . $decodedResponse['data'][0]['message']);
        }

        return $decodedResponse;
    }
    // Escenario 3 to code 
    function createContactZoho($name, $lastname, $email, $phone)
    {
        $new_token = $this->getTokenZoho();
        $data = [
            "data" => [
                [
                    "Owner" => ["id" => "4376238000000251013"],
                    "Account_Name" => ["id" => "Bilingual Child Care Training"],
                    "Vendor_Name" => ["id" => "4376238000000638190"],
                    "First_Name" => $name,
                    "Last_Name" => $lastname,
                    "Email" => $email,
                    "Phone" => $phone
                ]
            ]
        ];

        $url = "https://www.zohoapis.com/crm/v2/Contacts";

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                "Authorization: Zoho-oauthtoken $new_token",
                "Content-Type: application/json"
            ]
        ]);

        $response = curl_exec($curl);
        // Captura errores si ocurren
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            throw new Exception("Error al conectar con Zoho CRM: " . $error_msg);
        }

        curl_close($curl);

        // Decodifica la respuesta de Zoho CRM
        $decodedResponse = json_decode($response, true);

        // Verifica si hay errores en la respuesta
        if (isset($decodedResponse['data'][0]['code']) && $decodedResponse['data'][0]['code'] !== 'SUCCESS') {
            throw new Exception("Error de Zoho CRM: " . $decodedResponse['data'][0]['message']);
        }

        return $decodedResponse;
    }
    function validateZohoContact($email)
    {
        $new_token = $this->getTokenZoho();
        if ($new_token) {
            // URL de búsqueda en Zoho con el parámetro `criteria`
            $url = "https://www.zohoapis.com/crm/v2/Contacts/search?email=$email";

            $curl = curl_init();

            // Configurar opciones de cURL
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_HTTPHEADER => [
                    "Authorization: Zoho-oauthtoken $new_token",
                    "Content-Type: application/json"
                ]
            ]);

            // Ejecutar la solicitud y capturar la respuesta
            $response = curl_exec($curl);
            //var_dump($response);

            // Manejar errores en la solicitud cURL
            if (curl_errno($curl)) {
                error_log("Error en la solicitud cURL: " . curl_error($curl));
                curl_close($curl);
                return null;
            }

            curl_close($curl);

            $data = json_decode($response, true);

            // Confirmación de la respuesta de Zoho para depuración
            //var_dump($data);

            // Verificar si hay resultados en la respuesta de Zoho
            if (isset($data['data']) && count($data['data']) > 0) {
                return $data['data'][0]; // Retorna el primer contacto encontrado
            } else {
                return null; // No se encontró el contacto
            }
        }
        return null;
    }
    function addDaycare($email, $phone, $daycare, $license, $expiration, $state, $name, $lastname, $photoID, $bilingualID)
    {
        //$new_token = $this->getTokenZoho();
        /*$array = array();
        $data = '{
            "name":"'.$daycare.'",
            "phone":"'.$phone.'",
            "mail":"'.$email.'",
            "state":"'.$state.'",
            "owner_name":"'.$name.'",
            "license":"'.$license.'",
            "license_expiration_date":"'.$expiration.'",
            "bilingual_users":["'.$bilingualID.'"],
            "active":true
        }';
    
        // Realizar la solicitud a Strapi para agregar la guardería
        $daycareResponse = $this->queryStrapi("daycares", $data, "POST");
        $array["daycare"] = $daycareResponse;
    
        // Obtener el usuario bilingüe asociado
        $user = $this->getBilingualUser($bilingualID);
    
        // Almacenar el usuario en la sesión
        $_SESSION["user"] = $user;*/

        // Activar el webhook
        $webhookData = array(
            'daycare' => $daycare,
            'phone' => $phone,
            'email' => $email,
            'state' => $state,
            'name' => $name,
            'lastname' => $lastname,
            'license' => $license,
            'license_expiration_date' => $expiration,
            'logoID' => $photoID,
            'bilingualID' => $bilingualID
        );

        // Realizar la solicitud al webhook
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://hook.us1.make.com/8w0fnbgbsey4l464ikyk8n5vjd5iiiqn',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($webhookData),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                )
            )
        );

        $webhookResponse = curl_exec($curl);
        curl_close($curl);

        $array["webhook"] = json_decode($webhookResponse, true);

        return $array;
    }

    function getBilingualUser($id)
    {
        $user = $this->queryStrapi("bilingual-users/" . $id);
        return $user;
    }

    function getIdOfAThread($id_thread)
    {
        $idThread = $this->queryStrapi("threads-open-ais?id_thread=" . $id_thread);
        return $idThread;
    }
    function addThread($id_thread, $estado, $tipo)
    {
        $array = array();
        $data = '{
           "id_thread":"' . $id_thread . '",
           "bilingual_user":"' . $_SESSION["user"]->id . '",
           "estado_seleccionado":"' . $estado . '",
           "tipo_daycare_seleccionado":"' . $tipo . '"
        }';
        $threadResponse = $this->queryStrapi("threads-open-ais", $data, "POST");
        $array["thread"] = $threadResponse;
        return $array;
    }
    function deleteThread($id_thread_strapi)
    {
        $array = array();
        $url = "threads-open-ais/" . $id_thread_strapi;
        $threadResponse = $this->queryStrapi($url, "", "DELETE");
        $array["threadStrapi"] = $threadResponse;
        return $array;
    }
    function updatePassword($user, $buserId, $data, $welcome = true)
    {

        $all = array();
        $all['user'] = $user;
        $all['buserId'] = $buserId;
        $all['data'] = $data;
        $all['isRecover'] = $welcome;
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://hook.us1.make.com/3j8xrd8d1bmb4ihmakcsk8ari22bjufr',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($all),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    'Cookie: __cf_bm=GVmSWjsW4sV.ro96yGreD7AG9xM9H.wmCRNp2v9vxPs-1713288171-1.0.1.1-8lLdVI2GlhCRNps31H1qYQK1LVh8OECWEwN3hnWaLTmcCQ2tN_P2MRVCIbpGK4Esh73v.r87N6WqKEr0xoEWmg'
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        $bilingualUser = $this->queryStrapi("bilingual-users/" . $buserId, $data, "PUT");
        $acuarelaUser = $this->queryStrapi("acuarelausers/" . $user, $data, "PUT");
        $user = $this->getBilingualUser($buserId);
        $dataJson = json_decode($data);
        $loginUser = $this->loginBilingualUser($user->email, $dataJson->pass);
        $array = array();
        $array["bilingualUser"] = $bilingualUser;
        $array["acuarelaUser"] = $acuarelaUser;
        $array["user"] = $user;
        $array["loginUser"] = $loginUser;
        $array["respMake"] = $resp;
        $array["all"] = $all;
        if ($welcome) {
            $this->send_notification('info@bilingualchildcaretraining.com', $user->email, $user->name, "", "Bienvenido!", 'portal-miembros-e4', 'maRkSStgpCapJoSmwHOZDg', "Bilingual Childcare Training");
        }
        return $array;
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

    function getRandomMenu()
    {
        $arrayMenu = array();

        // Realiza las consultas a Strapi para cada tipo de contenido
        $desayuno = $this->queryStrapi("menus?type=desayuno");
        $almuerzo = $this->queryStrapi("menus?type=almuerzo");
        $cena = $this->queryStrapi("menus?type=cena");
        $snack = $this->queryStrapi("menus?type=snack");

        // Obtén un elemento aleatorio de cada arreglo
        $randomDesayuno = $desayuno[array_rand($desayuno)];
        $randomAlmuerzo = $almuerzo[array_rand($almuerzo)];
        $randomCena = $cena[array_rand($cena)];
        $randomSnack = $snack[array_rand($snack)];

        // Combina los elementos en un solo arreglo
        $arrayMenu = array($randomDesayuno, $randomAlmuerzo, $randomCena, $randomSnack);

        return $arrayMenu;
    }
    function getWelcomeMessage()
    {
        $response = $this->queryWorpress("welcomem-bcct");

        //Obtener un mensaje random
        $random_message = $response[array_rand($response)];

        $arrayMessage = array($random_message);

        return $arrayMessage;
    }

    // Solicitudes a OpenAi 
    function postRequestOpenAi($endpoint, $data)
    {
        $url = "https://api.openai.com/v1/" . $endpoint;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer " . $this->openaiApiKey,
            "OpenAI-Beta: assistants=v2"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return [
            'status' => $http_status,
            'response' => json_decode($response, true),
        ];
    }
    function getRequestOpenAi($endpoint)
    {
        $url = "https://api.openai.com/v1/" . $endpoint;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer " . $this->openaiApiKey,
            "OpenAI-Beta: assistants=v2"
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return [
            'status' => $http_status,
            'response' => json_decode($response, true),
        ];
    }
    function deleteRequestOpenAi($endpoint)
    {
        $url = "https://api.openai.com/v1/" . $endpoint;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer " . $this->openaiApiKey,
            "OpenAI-Beta: assistants=v2"
        ]);

        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return [
            'status' => $http_status,
            'response' => json_decode($response, true),
        ];
    }
    //Cancelar suscripcion PayPal
    function validateToken()
    {
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api-m.paypal.com/v1/oauth2/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Basic QWVobFNVMTRSNjZHcFRmRTY0eFZEdHdmT0hNZmJiWjNVMFNIOXhENFZNdW1xTmdWOU1jWmllaFotWGJBa0xXMGtoTkp0QkNDMUhxdU9DZWY6RUxJXzI4S1M2VEdUTGdHM3FkUzBsVWJCczFPREZ5Vk1XUjdPRGQ3NEpfdHhVWEJ2RnhUZm16U3VuOTZTNW13RV9GZjBvakNDZzA1a0VYMlU='
                ),
            )
        );
        $response = curl_exec($curl);
        curl_close($curl);
        $request = json_decode($response);
        return $request->access_token;
    }
    function postRequestPayPal($endpoint, $data, $id)
    {
        $token = $this->validateToken();

        var_dump($id);



        $url = "https://api-m.paypal.com/v1/" . $endpoint;

        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json',
                    "Authorization: Bearer " . $token,
                ),
            )
        );

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
    function getUniversityUser($email)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://bilingualchildcareuniversity.com/webservice/rest/server.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query(array(
                'wstoken' => '51599b61106ac2bf98131bb2fd9702cd',
                'wsfunction' => 'core_user_get_users_by_field',
                'moodlewsrestformat' => 'json',
                'field' => 'email',
                'values[0]' => $email
            )),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
    function getUniversityUserByUsername($username)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://bilingualchildcareuniversity.com/webservice/rest/server.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query(array(
                'wstoken' => '51599b61106ac2bf98131bb2fd9702cd',
                'wsfunction' => 'core_user_get_users_by_field',
                'moodlewsrestformat' => 'json',
                'field' => 'username',
                'values[0]' => $username
            )),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
    function createMoodleUser($username, $password, $firstname, $lastname, $email)
    {
        $curl = curl_init();

        $postData = http_build_query([
            'wstoken' => '51599b61106ac2bf98131bb2fd9702cd',
            'wsfunction' => 'core_user_create_users',
            'moodlewsrestformat' => 'json',
            'users[0][username]' => $username,
            'users[0][password]' => $password,
            'users[0][firstname]' => $firstname,
            'users[0][lastname]' => $lastname,
            'users[0][email]' => $email,
            'users[0][auth]' => 'manual'
        ]);

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://bilingualchildcareuniversity.com/webservice/rest/server.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/x-www-form-urlencoded'
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
    function updatePasswordUniversity($userId, $newPassword)
    {
        $curl = curl_init();

        $postData = http_build_query([
            'wstoken' => '51599b61106ac2bf98131bb2fd9702cd',
            'wsfunction' => 'core_user_update_users',
            'moodlewsrestformat' => 'json',
            'users[0][id]' => $userId,
            'users[0][password]' => $newPassword
        ]);

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://bilingualchildcareuniversity.com/webservice/rest/server.php',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
