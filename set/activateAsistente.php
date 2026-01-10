<?php
header('Access-Control-Allow-Origin: https://acuarelacore.com');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
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

    function registerUser($name, $lastname, $email, $phone,$password, $daycare, $acuarelaUser){
        $data = '{"name":"'.$name.'","lastname":"'.$lastname.'","email":"'.$email.'","password":"'.$password.'","state":"","daycares":["'.$daycare.'"],"phone":"'.$phone.'","acuarelauser":"'.$acuarelaUser.'"}';
        $userCreatedResponse = queryPost("/bilingual-users", $data);
        return $userCreatedResponse;
    }

    $array = array();
    extract($_POST);

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://acuarelacore.com/api/acuarelausers/'.$id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_POSTFIELDS =>'{
        "pass": "'.$password.'",
        "password": "'.$password.'",
        "name": "'.$name.'",
        "lastname": "'.$lastname.'",
        "mail": "'.$email.'",
        "phone": "'.$phone.'",
        "status": true,
        "rols":["5ff78fd55d6f2e272cfd7392"]
    }',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $acuarelaUser = json_decode($response);
    $registerBilingualUser = registerUser($name, $lastname, $email, $phone,$password, $acuarelaUser->daycare->id, $id);
    $emailSended = $a->sendEndRegisterAsistente($name,$password,$email);
    $array['message'] = 1;
    $array['IdUser'] = $id;
    $array['user'] = json_decode($response);
    $array['emailSended'] = $emailSended;
    $array['registerBilingualUser'] = $registerBilingualUser;
    echo json_encode($array);
