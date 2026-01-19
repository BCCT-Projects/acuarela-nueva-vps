<?php
    include '../includes/config.php';
    function queryStrapi($url, $body = "", $method="GET") {

        $endpoint = "https://acuarelacore.com/api/" . $url;
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => $endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => $body,
        CURLOPT_HTTPHEADER => array('Content-Type: application/json', 'token: '. $_SESSION["userLogged"]->user->token),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
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
        "state": "'.$state.'",
        "phone": "'.$phonedaycare.'",
        "mail": "'.$emaildaycare.'",
        "license_expiration_date": "'. date("Y-m-d", strtotime($expiration) ).'",
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
        "lastname": "'.$lastname.'",
        "mail": "'.$email.'",
        "phone": "'.$phone.'",
        "daycare": ["'.$finalDaycare->id.'"],
        "status": true,
        "rols":["5ff78feb5d6f2e272cfd7393"],
        "country": "",
        "photo": "",
        "state": "'.$state.'",
        "new_account": true
    }',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
    ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);

    $array['message'] = 1;
    $array['user'] = json_decode($response);
    $array['daycare'] = json_decode($daycare);
    echo json_encode($array);
