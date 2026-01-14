<?php
require_once 'src/Mandrill.php';
class acuarela
{
	public $domain = "https://acuarelaadmin.acuarela.app/wp-json/wp/v2/";
	public $url = "https://acuarelaadmin.acuarela.app/";
	public $generalInfo = array();
	public $politics = array();
	public $about = array();

	public $client_id = "1000.4CBCGSPLAUZ10CRM6XQYU2Z5JQBT9L";
	public $client_secret = "7c28db40807ee2e2459a9629f084d037ee7edc0c95";
	public $refresh_token = "1000.ecf5734d91ad7ba8474aaac5e019ec8f.6148872828accaaf6896a2d98af189f0";
	public $token;

	function __construct()
	{
		$this->generalInfo = $this->getInfoGeneral();
		$this->politics = $this->gPolitics();
		$this->about = $this->gAbout();
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
			$result = $mandrill->messages->sendTemplate($template_name, $template_content, $message, $async, $ip_pool, $send_at);
			$answer = true;
		} catch (Mandrill_Error $e) {
			$result = 'Error de envío: ' . get_class($e) . ' - ' . $e->getMessage();
			$answer = false;
			throw $e;
		}
		return $result;
	}

	function sendDemoEmail($name, $mail, $phone, $daycare, $country, $city, $subject = 'Hemos recibido tus datos')
	{
		$mergeVars = [
			'NOMBRE' => $name
		];
		$mergevariables = [
			'ADMIN' => 'Administrador',
			'NAME' => $name,
			'EMAIL' => $mail,
			'PHONE' => $phone,
			'DAYCARE' => $daycare,
			'COUNTRY' => $country,
			'CITY' => $city
		];
		$this->send_notification('info@acuarela.app', $mail, $name, $this->transformMergeVars($mergeVars), $subject, 'obtener-demo', 'maRkSStgpCapJoSmwHOZDg', "Acuarela");
		$this->send_notification('info@acuarela.app', 'empleo@acuarela.app', 'Admin', $this->transformMergeVars($mergevariables), 'Nuevo contacto desde página web', 'obtener-demo-admin', 'maRkSStgpCapJoSmwHOZDg', "Acuarela");
	}
	function sendEmailDeleteRequest($mail, $requestType, $reason, $subject = 'Confirmación de recepción de tu solicitud sobre datos personales')
	{
		try {
			// Definir los destinatarios y sus plantillas
			$emailsToSend = [
				[
					'to' => $mail,
					'subject' => $subject,
					'template' => 'data-request-received',
					'mergeVars' => [
						'REQUESTTYPE' => $requestType
					]
				],
				// [
				// 	'to' => 'nicolas@bilingualchildcaretraining.com',
				// 	'subject' => 'Nueva solicitud de gestión de datos personales recibida',
				// 	'template' => 'data-request-received-admin',
				// 	'mergeVars' => [
				// 		'EMAIL' => $mail,
				// 		'REQUESTTYPE' => $requestType,
				// 		'REASON' => $reason,

				// 	]
				// ],
				[
					'to' => 'empleo@acuarela.app',
					'subject' => 'Nueva solicitud de gestión de datos personales recibida',
					'template' => 'data-request-received-admin',
					'mergeVars' => [
						'EMAIL' => $mail,
						'REQUESTTYPE' => $requestType,
						'REASON' => $reason,

					]
				],
				[
					'to' => 'nestor@bilingualchildcaretraining.com',
					'subject' => 'Nueva solicitud de gestión de datos personales recibida',
					'template' => 'data-request-received-admin',
					'mergeVars' => [
						'EMAIL' => $mail,
						'REQUESTTYPE' => $requestType,
						'REASON' => $reason,

					]
				],
			];

			$responses = [];
			$allSuccess = true;
			$errorMessages = [];

			foreach ($emailsToSend as $emailData) {
				$response = $this->send_notification(
					'info@acuarela.app',
					$emailData['to'],
					$name = "",
					$this->transformMergeVars($emailData['mergeVars']),
					$emailData['subject'],
					$emailData['template'],
					'maRkSStgpCapJoSmwHOZDg',
					"Acuarela"
				);

				$responses[$emailData['to']] = $response;

				// Verificar si el envío fue exitoso
				if (empty($response) || !isset($response[0]['status']) || !in_array($response[0]['status'], ['sent', 'queued'])) {
					$allSuccess = false;
					$errorMessages[$emailData['to']] = 'Error en el envío: ' . json_encode($response);
				}
			}

			if ($allSuccess) {
				return [
					'success' => true,
					'message' => 'Todos los correos fueron enviados correctamente',
					'responses' => $responses
				];
			} else {
				return [
					'success' => false,
					'message' => 'Algunos correos no se enviaron correctamente',
					'errors' => $errorMessages,
					'responses' => $responses
				];
			}
		} catch (Exception $e) {
			return [
				'success' => false,
				'message' => 'Excepción al enviar email: ' . $e->getMessage()
			];
		}
	}
	function sendEndRegisterDaycare($name, $pass, $email, $subject = 'Registro finalizado')
	{
		$mergeVars = [
			'NOMBRE' => $name,
			'PASS' => $pass
		];
		$a = $this->send_notification('info@acuarela.app', $email, '', $this->transformMergeVars($mergeVars), $subject, 'registro-finalizado-de-daycare', 'maRkSStgpCapJoSmwHOZDg', "Acuarela");
		$b = $this->send_notification('info@acuarela.app', 'daniela@bilingualchildcaretraining.com', '', $this->transformMergeVars($mergeVars), $subject, 'registro-finalizado-de-daycare', 'maRkSStgpCapJoSmwHOZDg', "Acuarela");
		$c = $this->send_notification('info@acuarela.app', 'karen@bilingualchildcaretraining.com', '', $this->transformMergeVars($mergeVars), $subject, 'registro-finalizado-de-daycare', 'maRkSStgpCapJoSmwHOZDg', "Acuarela");
		// $d = $this->send_notification('info@acuarela.app','dreinovcorp@gmail.com','',$this->transformMergeVars($mergeVars),$subject,'registro-finalizado-de-daycare','maRkSStgpCapJoSmwHOZDg',"Acuarela");
		$resp['a'] = $a;
		$resp['b'] = $b;
		$resp['c'] = $c;

		return $resp;
	}
	function sendEndRegisterDaycareCheckout($name, $pass, $email, $subject = 'Registro finalizado')
	{
		$mergeVars = [
			'NOMBRE' => $name,
			'PASS' => $pass,
			'CHECKOUT' => 1
		];
		$a = $this->send_notification('info@acuarela.app', $email, '', $this->transformMergeVars($mergeVars), $subject, 'registro-finalizado-de-daycare', 'maRkSStgpCapJoSmwHOZDg', "Acuarela");
		// $c = $this->send_notification('info@acuarela.app','karen@bilingualchildcaretraining.com','',$this->transformMergeVars($mergeVars),$subject,'registro-finalizado-de-daycare','maRkSStgpCapJoSmwHOZDg',"Acuarela");
		// $d = $this->send_notification('info@acuarela.app','dreinovcorp@gmail.com','',$this->transformMergeVars($mergeVars),$subject,'registro-finalizado-de-daycare','maRkSStgpCapJoSmwHOZDg',"Acuarela");
		$resp['a'] = $a;
		// $resp['c'] = $c;
		// $resp['d'] = $d;
		return $resp;
	}
	function sendEndRegisterAsistente($name, $pass, $email, $subject = 'Registro finalizado')
	{
		$mergeVars = [
			'NOMBRE' => $name,
			'PASS' => $pass
		];
		$a = $this->send_notification('info@acuarela.app', $email, '', $this->transformMergeVars($mergeVars), $subject, 'registro-finalizado-asistentes', 'maRkSStgpCapJoSmwHOZDg', "Acuarela");
		$resp['a'] = $a;
		return $resp;
	}

	function sendDemoActiveEmail($name, $mail, $pass, $subject = '¡Tu Demo está listo!')
	{
		$mergeVars = [
			'FNAME' => $name,
			'EMAIL' => $mail,
			'THEPASS' => $pass,
		];
		$this->send_notification('info@acuarela.app', $mail, $name, $this->transformMergeVars($mergeVars), $subject, 'activaci-n-demo', 'maRkSStgpCapJoSmwHOZDg', "Acuarela");
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
		return $this->send_notification('info@acuarela.app', $mail, $nameParent, $this->transformMergeVars($mergeVars), $subject, 'check-in', 'maRkSStgpCapJoSmwHOZDg', "Acuarela");
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
		return $this->send_notification('info@acuarela.app', $mail, $nameParent, $this->transformMergeVars($mergeVars), $subject, 'check-out', 'maRkSStgpCapJoSmwHOZDg', "Acuarela");
	}
	function sendInvitationAdmin(
		$name,
		$daycare,
		$licencia,
		$condado,
		$email,
		$phone,
		$subject = 'Nueva invitación recibida'
	) {
		$mergeVars = [
			'NAME' => $name,
			'DAYCARE' => $daycare,
			'LICENCIA' => $licencia,
			'CONDADO' => $condado,
			'EMAIL' => $email,
			'PHONE' => $phone
		];
		$resp = array();
		$a = $this->send_notification('info@acuarela.app', 'info@bilingualchildcaretraining.com', $name, $this->transformMergeVars($mergeVars), $subject, 'invitation-admin', 'maRkSStgpCapJoSmwHOZDg', "Acuarela");
		$b = $this->send_notification('info@acuarela.app', 'marcela@bilingualchildcaretraining.com', $name, $this->transformMergeVars($mergeVars), $subject, 'invitation-admin', 'maRkSStgpCapJoSmwHOZDg', "Acuarela");
		$d = $this->send_notification('info@acuarela.app', 'dreinovcorp@gmail.com', $name, $this->transformMergeVars($mergeVars), $subject, 'invitation-admin', 'maRkSStgpCapJoSmwHOZDg', "Acuarela");
		$resp['a'] = $a;
		$resp['b'] = $b;

		$resp['d'] = $d;
		return $resp;
	}
	function setLeadInvitation($name, $daycare, $licencia, $condado, $email, $phone)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://acuarelaadmin.acuarela.app/wp-json/acf/v2/leads-invitation',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => '{
            "title":"' . $name . '"

        }',
			CURLOPT_HTTPHEADER => array(
				'Authorization: Basic ZGV2ZWxvcGVyOm95RUMgdkRtbCBxT3NLIDVxU0sgR2NZQyAyTXo0',
				'Content-Type: application/json',
				'Cookie: PHPSESSID=d94a3c004cf26f50e1c2266bec0f6525'
			),
		));

		$response = curl_exec($curl);
		$response = json_decode($response);
		$theID = $response->id;
		curl_close($curl);
		$curl2 = curl_init();
		curl_setopt_array($curl2, array(
			CURLOPT_URL => 'https://elmuseodelatesta.com/admin/wp-json/acf/v3/leads-invitation/' . $theID,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'PUT',
			CURLOPT_POSTFIELDS => '{
			"fields":{
				"daycare_name":"' . $daycare . '",
				"licence":"' . $licencia . '",
				"condado":"' . $condado . '",
				"email":"' . $email . '",
				"phone":"' . $phone . '",
				}
			}',
			CURLOPT_HTTPHEADER => array(
				'Authorization: Basic ZGV2ZWxvcGVyOm95RUMgdkRtbCBxT3NLIDVxU0sgR2NZQyAyTXo0',
				'Content-Type: application/json',
				'Cookie: PHPSESSID=d94a3c004cf26f50e1c2266bec0f6525'
			),
		));
		$response2 = curl_exec($curl2);
		//$response2 = json_decode($response2);

		curl_close($curl2);

		return $response2;
	}
	function query($url, $body = "")
	{
		$endpoint = $this->domain . $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($ch);
		$request = json_decode($output);
		curl_close($ch);
		return $request;
	}
	function getInfoGeneral()
	{
		if (isset($_SESSION['ginfo'])) {
			$gnrl = $_SESSION['ginfo'];
		} else {
			$result = $this->query("pages/14");
			$gnrl = $result;
			$_SESSION['ginfo'] = $gnrl;
		}
		return $gnrl;
	}
	function gPolitics()
	{
		if (isset($_SESSION['gpolitics'])) {
			$gnrl = $_SESSION['gpolitics'];
		} else {
			$result = $this->query("pages/196");
			$gnrl = $result;
			$_SESSION['gpolitics'] = $gnrl;
		}
		return $gnrl;
	}
	function gAbout()
	{
		if (isset($_SESSION['gAbout'])) {
			$gnrl = $_SESSION['gAbout'];
		} else {
			$result = $this->query("pages/54");
			$gnrl = $result;
			$_SESSION['gAbout'] = $gnrl;
		}
		return $gnrl;
	}
	function getHome()
	{
	}
	function getHomeSections()
	{
		$result = $this->query("promo-home");
		return $result;
	}
	function getFaq()
	{
		$result = $this->query("preguntas-frecuentes");
		return $result;
	}
	function getPrices()
	{
		$result = $this->query("plan-precio");
		return $result;
	}
	function getTestimonios()
	{
		$result = $this->query("testimonio");
		return $result;
	}

	function getParent($id)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://acuarelacore.com/api/acuarelausers/' . $id,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'token: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJtYWlsIjoib2VqYXJhbWlsbG9AZ21haWwuY29tIiwiaWQiOiI2MmNjMTRhMjljMWU0MGRiZmNjZTYzY2YiLCJuYW1lIjoiT3NjYXIgSmFyYW1pbGxvIiwicGhvbmUiOiI1NTU1NTU1IiwiaWF0IjoxNjU3OTIyNTI5LCJleHAiOjE2NTgxODE3Mjl9.BA7Dmtb7HrPHLm8kjYR_z7wsoobuPPLIEobo-n4KuMc'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return json_decode($response);
	}

	function getMovement($id)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://acuarelacore.com/api/movements/' . $id,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'token: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJtYWlsIjoib2VqYXJhbWlsbG9AZ21haWwuY29tIiwiaWQiOiI2MmNjMTRhMjljMWU0MGRiZmNjZTYzY2YiLCJuYW1lIjoiT3NjYXIgSmFyYW1pbGxvIiwicGhvbmUiOiI1NTU1NTU1IiwiaWF0IjoxNjU3OTIyNTI5LCJleHAiOjE2NTgxODE3Mjl9.BA7Dmtb7HrPHLm8kjYR_z7wsoobuPPLIEobo-n4KuMc'
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return json_decode($response);
	}
	function updateMovement($id)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://acuarelacore.com/api/movements/' . $id,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'PUT',
			CURLOPT_POSTFIELDS => '{
			"type": 2
		}',
			CURLOPT_HTTPHEADER => array(
				'token: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJtYWlsIjoib2VqYXJhbWlsbG9AZ21haWwuY29tIiwiaWQiOiI2MmNjMTRhMjljMWU0MGRiZmNjZTYzY2YiLCJuYW1lIjoiT3NjYXIgSmFyYW1pbGxvIiwicGhvbmUiOiI1NTU1NTU1IiwiaWF0IjoxNjU3OTIyNTI5LCJleHAiOjE2NTgxODE3Mjl9.BA7Dmtb7HrPHLm8kjYR_z7wsoobuPPLIEobo-n4KuMc',
				'Content-Type: application/json'
			),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	// Token Zoho para cosultas
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

	public function createLead($name, $lastName, $email, $phone, $servicioInteres, $fuenteComunicacion, $daycareName)
	{
		$new_token = $this->getTokenZoho();
		if ($new_token) {
			$fechaActual = date('Y-m-d');

			// // Asignar un valor predeterminado si $Name es null o está vacío
			// if (is_null($name) || trim($name) === '') {
			//     $name = 'No Name Provided'; // Valor predeterminado
			// }

			// if (is_null($lastName) || trim($lastName) === '') {
			//     $lastName = 'No LastName Provided'; // Valor predeterminado
			// }

			// if (is_null($phone) || trim($phone) === '') {
			//     $phone = '0000000000'; // Valor predeterminado
			// }
			// if (is_null($fuenteComunicacion) | trim($fuenteComunicacion) === '') {
			//     $fuenteComunicacion = 'Website';
			// }

			// Definir valores predeterminados en un array asociativo
			$defaults = [
				'name' => 'No Name Provided',
				'lastName' => 'No LastName Provided',
				'phone' => '0000000000',
				'fuenteComunicacion' => 'Website',
				'servicioInteres' => 'Other',
				'daycareName' => 'Daycare',
			];

			// Recorrer cada variable y asignar el valor predeterminado si está vacía o es null
			foreach ($defaults as $key => $default) {
				if (!isset($$key) || trim($$key) === '') {
					$$key = $default;
				}
			}


			$payload = [
				'data' => [
					[
						'First_Name' => $name,
						'Last_Name' => $lastName,
						'Email' => $email,
						'Phone' => $phone,
						'Fuente_de_comunicaci_n' => $fuenteComunicacion,
						'Date_of_first_communication' => $fechaActual,
						'Service_interest' => $servicioInteres,
						'Daycare_Name' => $daycareName,
						'Owner' => [
							'id' => '873108290',
						],
					]
				]
			];

			$curl = curl_init();

			curl_setopt_array($curl, [
				CURLOPT_URL => 'https://www.zohoapis.com/crm/v2/Leads',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => json_encode($payload),
				CURLOPT_HTTPHEADER => [
					'Content-Type: application/json',
					"Authorization: Zoho-oauthtoken $new_token",
				],
			]);

			$response = curl_exec($curl);

			if (curl_errno($curl)) {
				error_log("Error en la solicitud cURL: " . curl_error($curl));
				curl_close($curl);
				return false;
			}

			$http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			curl_close($curl);

			if ($http_status !== 201) {
				error_log("Error HTTP: $http_status, Respuesta: $response");
				return false;
			}

			$data = json_decode($response, true);

			if (isset($data['data'][0]['code']) && $data['data'][0]['code'] === "SUCCESS") {
				// if ($data['data'][0]['code'] === "SUCCESS") {
				return true;
			} else {
				error_log("Error en la respuesta de Zoho: " . print_r($data, true));
				return false;
			}
		}
		return false;
	}
}
