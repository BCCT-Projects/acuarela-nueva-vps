<?php

$curl = curl_init();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$merchantIdInPayPal = filter_input(INPUT_GET, 'merchantIdInPayPal', FILTER_SANITIZE_STRING);
$merchantId = filter_input(INPUT_GET, 'merchantId', FILTER_SANITIZE_STRING);

if (!$id || !$merchantIdInPayPal || !$merchantId) {
   die("Missing required parameters");
}

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://acuarelacore.com/api/daycares/'.$id,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'PUT',
  CURLOPT_POSTFIELDS => json_encode([
    "paypal" => [
        "merchantIdInPayPal" => $merchantIdInPayPal,
        "merchantId" => $merchantId,
        "isset" => true
    ]
  ]),
  CURLOPT_HTTPHEADER => array(
    'token: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJtYWlsIjoiZGFuaXpxdWkyM0BnbWFpbC5jb20iLCJpZCI6IjYyNWY0MDMxNzE2MzE2ZDgxZGI4ZDkyMCIsIm5hbWUiOiJEYW5pZWxhIiwicGhvbmUiOiIzMTI0NTcyNzc3IiwiaWF0IjoxNjUxMDI2OTI3LCJleHAiOjE2NTEyODYxMjd9.hXH9Hx4ctmY4RfRqNn8zAbUIaSl2mIrqbSjV_lRpWLo',
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="img/favicon.ico" />
    <title>Acuarela | Home</title>
    <base href="/" />
    <meta
      name="facebook-domain-verification"
      content="lth8med3qtj6lk9akuvgnovn4u6ysj"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css"
    />
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/fonts.css" />
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body class="autoPays">
    <div
      class="left"
      style="
        background-image: url(https://images.pexels.com/photos/4482900/pexels-photo-4482900.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940);
      "
    ></div>
    <div class="right">
      <div class="content">
        <h2>Pagos habilitados</h2>
        <p>
          Has habilitado correctamente los pagos electrónicos para padres.
          Puedes volver a la aplicación
        </p>
        <a href="javascript:;">Continuar</a>
      </div>
    </div>
  </body>
</html>
