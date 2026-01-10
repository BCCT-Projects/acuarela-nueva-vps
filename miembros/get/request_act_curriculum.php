<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos enviados desde JavaScript
    $curriculum = $_POST['curriculum'];
    $language = $_POST['language'];
    $week = $_POST['week'];
    $dia_especifico = $_POST['dia_especifico']; // Nueva variable para la fecha

    // Validar el año de la fecha
    if (!validar_anio($dia_especifico)) {
        echo "La fecha no corresponde al año 2025.";
        exit;
    }

    if (!empty($curriculum) && !empty($language) && !empty($week)) {
        request_activity($curriculum, $language, $week);
    } elseif (!empty($curriculum) && $language === "none" && !empty($week)) {
        request_activity2($curriculum, $week);
    } else {
        echo "Faltan parámetros necesarios.";
    }
}

// Función para validar que el año sea 2024
function validar_anio($fecha) {
    $date = DateTime::createFromFormat('d/m/Y', $fecha);
    if ($date) {
        $year = $date->format('Y');
        return $year == '2025';
    }
    return false;
}

function request_activity($curr, $lang, $week) {
    $curl = curl_init();

    // Construir la URL con parámetros codificados
    $params = http_build_query([
        'field' => 'curriculum,language,semanas_a_las_que_pertence',
        'value' => "$curr,$lang,$week",
        'pp' => "20"
    ]);
    $url = "https://twinkle.acuarelacore.com/wp-json/wp/v2/planessemanales?$params";

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

    // Decodificar la respuesta JSON para asegurarnos de que es válida
    $responseArray = json_decode($response, true);

    // Devolver el resultado como JSON al cliente
    header('Content-Type: application/json');
    echo json_encode($responseArray);
}

function request_activity2($curr, $week) {
    $curl = curl_init();

    // Construir la URL con parámetros codificados
    $params = http_build_query([
        'field' => 'curriculum,language,semanas_a_las_que_pertence',
        'value' => "$curr,$week"
    ]);
    $url = "https://twinkle.acuarelacore.com/wp-json/wp/v2/planessemanales?$params&pp=99";

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

    // Decodificar la respuesta JSON para asegurarnos de que es válida
    $responseArray = json_decode($response, true);

    // Devolver el resultado como JSON al cliente
    header('Content-Type: application/json');
    echo json_encode($responseArray);
}
function request_activity_ai() {
    $curl = curl_init();
    /* Construir la URL con parámetros codificados
    $params = http_build_query([
        'field' => 'curriculum,language,semanas_a_las_que_pertence',
        'value' => "$curr,$week"
    ]);*/
    
    $url = "https://twinkle.acuarelacore.com/wp-json/wp/v2/planessemanales?field=tipo_de_actividad,language&value=actividades,es&pp=99";

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

    // Decodificar la respuesta JSON para asegurarnos de que es válida
    $responseArray = json_decode($response, true);

    // Devolver el resultado como JSON al cliente
    header('Content-Type: application/json');
    return json_encode($responseArray);
}
?>
