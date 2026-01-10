<?php
// Verificar si se recibió el parámetro esperado
if (isset($_POST['valor'])) {
    // Obtener el valor del botón enviado desde la solicitud AJAX
    $valorIdBoton = $_POST['valor'];

    // URL del endpoint
    $url = 'https://acuarelacore.com/api/threads-open-ais?id_thread=' . $valorIdBoton;

    // Realizar la solicitud GET y obtener la respuesta
    $response = file_get_contents($url);

    // Verificar si la respuesta se decodificó correctamente
    if ($response !== false) {
        // Decodificar la respuesta JSON
        $data = json_decode($response, true);

        // Verificar si se pudo decodificar la respuesta correctamente
        if ($data !== null) {
            // Acceder al primer elemento del array
            $primerElemento = $data[0];

            // Obtener el valor del parámetro id_thread y guardarlo en una variable
            $id_consulta = $primerElemento['_id'];

            // URL del endpoint para eliminar el thread específico
            $url = 'https://acuarelacore.com/api/threads-open-ais/' . $id_consulta;

            // Inicializar cURL
            $curl = curl_init($url);

            // Configurar cURL para una solicitud DELETE
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");

            // Ejecutar la solicitud
            $response = curl_exec($curl);

            // Verificar si hay errores
            if ($response === false) {
                $error = curl_error($curl);
                echo "Error en la solicitud DELETE: $error";
            } else {
                echo "Solicitud DELETE enviada correctamente.";
            }

            // Cerrar cURL
            curl_close($curl);
        } else {
            echo "Error al decodificar la respuesta JSON.";
        }
    } else {
        echo "Error en la solicitud GET.";
    }
} else {
    echo "No se recibió el parámetro esperado.";
}
?>
