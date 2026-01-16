<?php
// set/consent/get_coppa_version.php
// Helper function to get current COPPA notice version

function getCurrentCoppaVersion()
{
    $domain = Env::get('ACUARELA_API_URL', 'https://acuarelacore.com/api/');
    $endpoint = $domain . 'aviso-coppas?status=active&_sort=notice_published_date:DESC&_limit=1';

    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $endpoint,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
    ));

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($httpCode === 200) {
        $data = json_decode($response, true);
        if (is_array($data) && !empty($data)) {
            $notice = $data[0];
            return $notice['version'] ?? 'v1.0';
        }
    }

    // Fallback version if API fails
    return 'v1.0';
}
?>