<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://acuarelacore.com/api/movements/'. $_GET['id'],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PUT',
  CURLOPT_POSTFIELDS =>'{
    "estado": "1"
}',
  CURLOPT_HTTPHEADER => array(
    'token: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJtYWlsIjoiZGFuaXpxdWkyM0BnbWFpbC5jb20iLCJpZCI6IjYyNWY0MDMxNzE2MzE2ZDgxZGI4ZDkyMCIsIm5hbWUiOiJEYW5pZWxhIiwicGhvbmUiOiIzMTI0NTcyNzc3IiwiaWF0IjoxNjUxMDI2OTI3LCJleHAiOjE2NTEyODYxMjd9.hXH9Hx4ctmY4RfRqNn8zAbUIaSl2mIrqbSjV_lRpWLo',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo json_encode($response);