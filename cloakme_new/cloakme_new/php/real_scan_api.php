<?php
header('Content-Type: application/json');

// Get email from GET parameter
$email = $_GET['email'] ?? '';

if (empty($email)) {
    echo json_encode(['error' => 'Email parameter is required.']);
    exit;
}

function checkBreaches($email) {
    $url = "https://haveibeenpwned.com/api/v3/breachedaccount/" . urlencode($email) . "?truncateResponse=false";
    $headers = [
        "hibp-api-key: 3ad7f0c4b35446b0a4ee942f78679bf5", // Replace with your actual key
        "User-Agent: CloakMeScanner/1.0"
    ];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    $response = curl_exec($curl);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    if ($http_status == 200) {
        $breaches = json_decode($response, true);
        $result = [];

        foreach ($breaches as $breach) {
            $result[] = [
                'name' => $breach['Name'],
                'date' => $breach['BreachDate'],
                'domain' => $breach['Domain'],
                'description' => $breach['Description']
            ];
        }

        echo json_encode([
            'email' => $email,
            'breaches' => $result
        ]);
    } elseif ($http_status == 404) {
        echo json_encode([
            'email' => $email,
            'breaches' => []
        ]);
    } else {
        echo json_encode([
            'error' => 'Failed to retrieve data',
            'status' => $http_status
        ]);
    }
}

checkBreaches($email);
?>
