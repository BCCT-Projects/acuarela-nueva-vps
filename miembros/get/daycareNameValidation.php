<?php

// Recuperar las palabras enviadas a través de la URL como un array
$daycareNameWords = $_GET['daycareName'];
$daycareState = $_GET['daycareState']; 

// Inicializar una cadena para almacenar las variables de consulta para cada palabra
$queryVariables = "";

// Iterar sobre cada palabra del nombre del daycare
foreach ($daycareNameWords as $word) {
    // Agregar la variable de consulta para esta palabra
    $queryVariables .= "name_contains={$word}&";
}

// URL con las variables de consulta y el estado del daycare
$url = 'https://acuarelacore.com/api/daycares?' . $queryVariables . 'state=' . $_GET['daycareState'];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;