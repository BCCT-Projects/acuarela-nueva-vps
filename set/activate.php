<?php
    include '../includes/config.php';
    function queryPost($url, $data){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://acuarelacore.com/api/" . $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $data,
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        $output = curl_exec($curl);
        $request = json_decode($output);
        curl_close($curl);
        return $request;
        
    }
    function registerUser($name, $lastname, $email, $phone,$password, $daycare, $license, $acuarelaUser){
        $data = '{"name":"'.$name.'","lastname":"'.$lastname.'","email":"'.$email.'","password":"'.$password.'","state":"","phone":"'.$phone.'","acuarelauser":"'.$acuarelaUser.'"}';
        $userCreatedResponse = queryPost("/bilingual-users", $data);
        return $userCreatedResponse;
    }
    function createSuscription($suscription_expiration,$bilingual_user){
        $data ='{
            "suscription_expiration": "'.$suscription_expiration.'",
            "bilingual_user": ["'.$bilingual_user.'"],
            "product": ["6346e319e2d31bfeadddbd47"],
            "id_paypal": ""
        }';
        $userCreatedResponse = queryPost("/suscriptions", $data);
        return $userCreatedResponse;
    }
    $array = array();
    extract($_POST);
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://acuarelacore.com/api/daycares',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "license":"'.$license.'",
        "name": "'.$daycare.'",
        "active": true
    }',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
    ));
    $daycare = curl_exec($curl);
    $finalDaycare = json_decode($daycare);
    curl_close($curl);
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://acuarelacore.com/api/acuarelausers/register',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "pass": "'.$password.'",
        "name": "'.$name.'",
        "mail": "'.$email.'",
        "phone": "'.$phone.'",
        "daycare": ["'.$finalDaycare->id.'"],
        "status": true,
        "rols":["5ff78feb5d6f2e272cfd7393"],
        "country": "",
        "photo": ""
    }',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    $finalUser = json_decode($response);
    curl_close($curl);
    $registerBilingualUser = registerUser($name, $lastname, $email, $phone,$password, $finalDaycare->id, $license, $finalUser->entity->id);
    $Date = date();
    $expi = date('Y-m-d', strtotime($Date. ' + 14 days'));
    createSuscription($expi,$registerBilingualUser->entity->id);
    $array['message'] = 1;
    $array['user'] = json_decode($response);
    $array['daycare'] = json_decode($daycare);
    $array['registerBilingualUser'] = $registerBilingualUser;
    // $emailSended = $a->sendEndRegisterDaycare($name,$password,$email);
    // $array['emailSended'] = json_decode( $emailSended);
    echo json_encode($array);
