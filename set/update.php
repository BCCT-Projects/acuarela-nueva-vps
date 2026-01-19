<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://acuarelacore.com/api/movements/'.$_GET['idMovement'],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PUT',
  CURLOPT_POSTFIELDS =>'{
    "type": 1
}',
  CURLOPT_HTTPHEADER => array(
    'token: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJtYWlsIjoib2VqYXJhbWlsbG9AZ21haWwuY29tIiwiaWQiOiI2MmNjMTRhMjljMWU0MGRiZmNjZTYzY2YiLCJuYW1lIjoiT3NjYXIgSmFyYW1pbGxvIiwicGhvbmUiOiI1NTU1NTU1IiwiaWF0IjoxNjU3OTIyNTI5LCJleHAiOjE2NTgxODE3Mjl9.BA7Dmtb7HrPHLm8kjYR_z7wsoobuPPLIEobo-n4KuMc',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo json_encode($response);
