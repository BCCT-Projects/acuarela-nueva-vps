<?php

$estado = $_GET["estado"];
// echo "Estado recibido: " . $estado;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://acuarelacore.com/api/regulaciones?estado=' . $estado,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json', 
  ),
));

$response = curl_exec($curl);

curl_close($curl);
header('Content-Type: application/json');
echo $response;
