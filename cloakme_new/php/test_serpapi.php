<?php
$api_key = 'b6a4ac0f90023068ed26eb2aadd915c82e64bfd23708401166860246f35f2e6f';
$query = 'mithila palkar';

$url = "https://serpapi.com/search.json?engine=reddit&q=" . urlencode($query) . "&api_key=" . $api_key;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 20);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // in case your server lacks updated CA certs

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'cURL Error: ' . curl_error($ch);
} else {
    $data = json_decode($response, true);
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

curl_close($ch);
?>