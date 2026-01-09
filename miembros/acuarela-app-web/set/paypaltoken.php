<?php

$curl = curl_init();

curl_setopt_array($curl, array(
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
    'Authorization: Basic QVg2OFdpdDhRTWpiZVdFTDFwMEhYTUVKTmFEMnpCTmFoVl9rbTMzX0NNUy0wdGZENlJsWm5lTHdiYXY2cUptdzlZb3l2NmNzX05kWm1ieTY6RU9fNjRFcFdjaURmNnhST2Y5enZUelJSNjZndjdkWkkyalRENl9ObGVMM2tZRS1XLTJJRjVDb190TWxkY2hRUFJaUGJQV3NNVHBldV9oRnU=',
    'Content-Type: application/x-www-form-urlencoded',
    'Cookie: ts_c=vr%3Df7fb46f91810a475cde9ddddffff5c42%26vt%3Df7fb46f91810a475cde9ddddffff5c43'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
