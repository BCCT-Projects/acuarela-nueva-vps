<?php
require_once __DIR__ . '/env.php';
require_once __DIR__ . '/src/Mandrill.php';

class Acuarela {
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
    
    function __construct(){
        // Cargar configuración desde variables de entorno
        $this->domain = Env::get('ACUARELA_API_URL', 'https://acuarelacore.com/api/');
        $this->domainWP = Env::get('WP_API_URL', 'https://application.bilingualchildcaretraining.com/wp-json/wp/v2');
        $this->domainWPA = Env::get('WP_ADMIN_API_URL', 'https://adminwebacuarela.bilingualchildcaretraining.com/wp-json/wp/v2');
        $this->mandrillApiKey = Env::get('MANDRILL_API_KEY');
        
        $this->userID = $_SESSION["user"]->acuarelauser->id;
        $this->token = $_SESSION["userLogged"]->user->token;
        
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

    public function setDaycare($id) {
        $this->daycareID = $id;
        $this->daycareInfo = $this->getDaycareInfo($id);
    }
    
    function queryStrapi($url, $body = "", $method="GET") {
        $endpoint = $this->domain . $url;
        $curl = curl_init();
        
        $curlOptions = array(
            CURLOPT_URL => $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'token: ' . $this->token
            ),
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
        
        return json_decode($response);
    }
    // Función para obtener la URL de la imagen más pequeña disponible
    function getSmallestImageUrl($image) {
        if (isset($image->formats)) {
            $formats = $image->formats;
            $sizes = ['small', 'medium', 'large'];
            foreach ($sizes as $size) {
                if (isset($formats->$size)) {
                    return 'https://acuarelacore.com/api/'.$formats->$size->url;
                }
            }
        }
        
        // Si no hay formatos, devuelve la URL principal
        return 'https://acuarelacore.com/api/'.$image->url;
    }
    function getPostsDaycares($daycare = null){
        if (is_null($daycare)) {
            $daycare = $this->daycareID;
        }
        $resp = $this->queryStrapi("posts?daycareId=$daycare");
        return $resp;
    }
    function getTasks($daycare = null){
        if (is_null($daycare)) {
            $daycare = $this->daycareID;
        }
        $resp = $this->queryStrapi("tasks?daycare=$daycare");
        return $resp;
    }
    function createTask($data){
        $resp = $this->queryStrapi("tasks", $data, "POST");
        return $resp;
    }
    function setReactionPost($data){
        $resp = $this->queryStrapi("reactions", $data, "POST");
        return $resp;
    }
    function addComment($data){
        $resp = $this->queryStrapi("comments", $data, "POST");
        return $resp;
    }
    function createAsistente($data){
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
    function editAsistente($id, $data){
        $resp = $this->queryStrapi("acuarelausers/$id", $data, "PUT");
        return $resp;
    }
    function getAgeGroups(){
        $resp = $this->queryStrapi("age-groups");
        return $resp;
    }
    function getEstadosCiudades(){
        $resp = $this->queryStrapi("estados-y-ciudades");
        return $resp;
    }
    function deleteElement($type, $id){
        $resp = $this->queryStrapi("$type/$id", $data, "DELETE");
        return $resp;
    }
    function getInscripciones($id = "", $daycare = null){
        if (is_null($daycare)) {
            $daycare = $this->daycareID;
        }
        if($id == ""){
            $resp = $this->queryStrapi("inscripciones?daycare=$daycare");
        }else{
            $resp = $this->queryStrapi("inscripciones/{$id}");
        }
        return $resp;
    }
    function postInscripcion($data){
        $data = json_decode($data);
        if($data->status == "Borrador"){
            $resp = $this->queryStrapi("inscripciones", $data, "POST");
            return $resp;
        }else{
            $respInscripcion = $this->queryStrapi("inscripciones", $data, "POST");
            $data->inscripcion = $respInscripcion->id;
            $respInscripcionComplete = $this->queryStrapi("inscripciones/complete", $data, "POST");
            return $respInscripcionComplete;
        }
    }
    function getHealthinfo($id = "", $daycare = null) {
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
    
    function postHealthinfo($data){
        $data = json_decode($data);
        $resp = $this->queryStrapi("healthinfos", $data, "POST");
        return $resp;
    }
    function putHealthinfo($data){
        $data = json_decode($data);
        if (!isset($data->inscripcion) || empty($data->inscripcion)) {
            return null; // Evitar enviar una petición sin ID de inscripción
        }
        $resp = $this->queryStrapi("healthinfos/$data->inscripcion", $data, "PUT");
        return $resp;
    }
    

    function putInscripcion($data){
        $data = json_decode($data);
        if($data->status == "Borrador"){
            $resp = $this->queryStrapi("inscripciones/$data->inscripcion", $data, "PUT");
            return $resp;
        }else{
            $resp = $this->queryStrapi("inscripciones/$data->inscripcion", $data, "PUT");
            $respInscripcionComplete = $this->queryStrapi("inscripciones/complete", $data, "POST");
            return $respInscripcionComplete;
        }
    }
    function getChildren($id = "", $daycare = null){
        if (is_null($daycare)) {
            $daycare = $this->daycareID;
        }
        if (empty($daycare)) {
            return null;
        }
        if($id == ""){
            $resp = $this->queryStrapi("children/?daycare=$daycare");
        }else{
            $resp = $this->queryStrapi("children/{$id}");
            if (isset($resp->response) && is_array($resp->response) && !empty($resp->response)) {
                $resp = $resp->response[0];
            } else {
                return null;
            }
        }
        return $resp;
    }
    function updateChildren($id, $data){
        $resp = $this->queryStrapi("children/{$id}", $data, "PUT");
        return $resp;
    }
    function getDaycareInfo($id){
        if (empty($id)) {
            return null;
        }
        $resp = $this->queryStrapi("daycares/{$id}");
        if (isset($resp->response) && is_array($resp->response) && !empty($resp->response)) {
            return $resp->response[0];
        }
        return null;
    }
    function updateDaycareInfo($data){
        $resp = $this->queryStrapi("daycares/{$this->daycareID}", $data, "PUT");
        return $resp;
    }
    function getAsistentes($id = "", $daycare = null){
        if (is_null($daycare)) {
            $daycare = $this->daycareID;
        }
        if($id == ""){
            $resp = $this->queryStrapi("acuarelausers?rols=5ff78fd55d6f2e272cfd7392&daycare=$daycare");
        }else{
            $resp = $this->queryStrapi("acuarelausers/{$id}");
        }
        return $resp;
    }
    function getGrupos($id = "", $daycare = null){
        if (is_null($daycare)) {
            $daycare = $this->daycareID;
        }
        if (empty($daycare)) {
            return [];
        }
        if($id == ""){
            $resp = $this->queryStrapi("groupsNew/$daycare");
            $resp = isset($resp->response) ? $resp->response : [];
        }else{
            $resp = $this->queryStrapi("groups/{$id}");
            if (isset($resp->response) && is_array($resp->response) && !empty($resp->response)) {
                $resp = $resp->response[0];
            } else {
                return null;
            }
        }
        return $resp;
    }
    function createGroup($data, $daycare = null){
        if (is_null($daycare)) {
            $daycare = $this->daycareID;
        }
        $data["daycare"] = $daycare;
        $resp = $this->queryStrapi("groups",$data,'POST');
        return $resp;
    }
    function editGroup($id, $data){
        $resp = $this->queryStrapi("groups/$id",$data,'PUT');
        return $resp;
    }
    function createActivity($data){
        $resp = $this->queryStrapi("groups/activity",$data,'POST');
        return $resp;
    }
    

    function checkIn($data) {
        $data->asistente = $this->userID;
        $data->token = $this->token;
        $resp = $this->queryStrapi("checkins", $data, "POST");
        return $resp;
    }
    
    function checkOut($data) {
        $data->asistente = $this->userID;
        $data->token = $this->token;
        $resp = $this->queryStrapi("checkouts", $data, "POST");
        return $resp;
    }
	function transformMergeVars($vars){
		$mergeVars = array();
		foreach ($vars as $key => $value) {
			array_push($mergeVars, ['name'=>$key,'content'=>$value]);
		}
		return $mergeVars;
	}
	

    function send_notification($from,$to,$toname,$mergevariables,$subject,$template,$mandrillApiKey,$fromName="Mandrill Message",$async=false){
		$result = '';
		try {
			if($from==""){
				$from='info@acuarela.app';
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
						'name' =>  $toname,
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
		} catch(Mandrill_Error $e) {
			$result = 'Error de envío: ' . get_class($e) . ' - ' . $e->getMessage();
			$answer = false;
			throw $e;
		}
		return $result;
	}

    function sendCheckin($nameKid,$nameParent,$nameDaycare,$nameAcudiente,$time,$date,$mail,$subject = 'Check in'){
		$mergeVars = [
			'NOMBRENINO' => $nameKid,
			'NOMBREPADRE' => $nameParent,
			'NOMBREDAYCARE' => $nameDaycare,
			'NOMBREACUDIENTE' => $nameAcudiente,
			'HORA' => $time,
			'FECHA' => $date
		];
		return $this->send_notification('info@acuarela.app',$mail,$nameParent,$this->transformMergeVars($mergeVars),$subject,'check-in',$this->mandrillApiKey,"Acuarela");
	}
	function sendCheckout($nameKid,$nameParent,$nameDaycare,$nameAcudiente,$time,$date,$mail,$subject = 'Check out'){
		$mergeVars = [
			'NOMBRENINO' => $nameKid,
			'NOMBREPADRE' => $nameParent,
			'NOMBREDAYCARE' => $nameDaycare,
			'NOMBREACUDIENTE' => $nameAcudiente,
			'HORA' => $time,
			'FECHA' => $date
		];
		return $this->send_notification('info@acuarela.app',$mail,$nameParent,$this->transformMergeVars($mergeVars),$subject,'check-out',$this->mandrillApiKey,"Acuarela");
	}

	/**
	 * Envía email de activación a un nuevo asistente para que cree su contraseña
	 */
	function sendActivacionAsistente($email, $nombreCompleto, $asistenteId, $nombreDaycare, $subject = 'Bienvenido a Acuarela - Activa tu cuenta'){
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
		return $this->send_notification('info@acuarela.app', $email, $nombreCompleto, $this->transformMergeVars($mergeVars), $subject, 'activacion-asistente', $this->mandrillApiKey, "Acuarela");
	}

	/**
	 * Actualiza la contraseña de un asistente (acuarelauser)
	 */
	function updateAsistentePassword($asistenteId, $newPassword){
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
	function getAsistenteById($id){
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

    function getMovements($initialDate = null, $finalDate = null, $type = null) {
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
    function setMovements($data){
        $movements = $this->queryStrapi("movements", $data, "POST");
        return $movements;
    }
    
    function getCategories(){
        $categories = $this->queryStrapi("categories");
        return $categories;
    }
    function setCategories($data){
        $categories = $this->queryStrapi("categories", $data, "POST");
        return $categories;
    }

    function uploadImage($file) {
        $url = "https://acuarelacore.com/api/upload";
        $headers = [
            "content-type: multipart/form-data ",
        ];
    
        $postFields = [
            "files" => new CURLFile($file['tmp_name'], $file['type'], $file['name']),
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
    function createPost($data) {
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
    
}