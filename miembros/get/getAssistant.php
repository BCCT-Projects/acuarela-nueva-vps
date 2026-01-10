<?php
    /*BCCT*/
    $assistantId = "asst_RoLjBrQTVk5vwe8X9MrJq7cq";
    $apiKey = "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";

    $file_id = "file-X3kzMDq1NClOBDt6UUJvTIyT";

    /*Julie*/
    // $apiKey = "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";
    // $assistantId = "asst_ZVuscnLqs3zGNuk9mCasHHwA";

    $url = "https://api.openai.com/v1/assistants/{$assistantId}";

    $headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
        'OpenAI-Beta: assistants=v2'
    );

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode == 200) {
        $responseData = json_decode($response, true);
        //print_r($responseData);
    } else {
        // La solicitud falló, manejar el error
        echo "Error: {$httpCode}\n";
        echo "Response: {$response}\n";
    }

    curl_close($ch);
?>

<?php

/*BCCT*/ 
$apiKey = "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";

/*Julie*/
// $apiKey = "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";

$url = "https://api.openai.com/v1/threads";

$headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey,
    'OpenAI-Beta: assistants=v2'
);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '');

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($httpCode == 200) {
    // La solicitud fue exitosa, manejar la respuesta
    $responseData = json_decode($response, true);
    $threadId = $responseData['id'];

    //print_r($responseData);
    echo "<div id='threadId' data-thread-id='{$threadId}'></div>";
} else {
    // La solicitud falló, manejar el error
    echo "Error: {$httpCode}\n";
    echo "Response: {$response}\n";
}

curl_close($ch);
?>
