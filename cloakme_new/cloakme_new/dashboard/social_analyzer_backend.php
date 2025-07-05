<?php
header("Content-Type: application/json");

$username = $_GET['username'] ?? '';

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://instagram-scraper-stable-api.p.rapidapi.com/get_user_profile.php?user=$username",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "x-rapidapi-host: instagram-scraper-stable-api.p.rapidapi.com",
        "x-rapidapi-key: a215e49e05msh5fcdb4d2a13fc9fp1cdf43jsnae562d106bb7"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo json_encode(["success" => false, "error" => $err]);
    exit;
}

$raw_data = json_decode($response, true);

// Debug print
echo json_encode([
    "success" => true,
    "raw_response" => $raw_data,
    "score" => 0,
    "posts" => []
]);
?>
