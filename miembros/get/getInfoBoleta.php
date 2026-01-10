<?php

// Obtener el cuerpo del POST como JSON
$input = json_decode(file_get_contents('php://input'), true);

// Validar que venga el 'id'
$id = isset($input['id']) ? $input['id'] : null;

if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}

// Preparar el cURL con el ID recibido
$curl = curl_init();

curl_setopt_array($curl, array(
  //Child Care Expo 360
  // CURLOPT_URL => 'https://hook.us1.make.com/oa4ltvyk2f9g30f91ug0ornfxhe1vxj7',

  //Golden Care Awards
  CURLOPT_URL => 'https://hook.us1.make.com/or5b5emmgbg20upx94u9u689okxdob2i',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode([ 'id' => $id ]),
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
    // Puedes quitar el header 'Cookie' si no es necesario
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
