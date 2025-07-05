<?php
header('Content-Type: application/json');

// Get values from GET instead of POST
$realUsername = isset($_GET['realUsername']) ? $_GET['realUsername'] : '';
$firstName = isset($_GET['firstName']) ? $_GET['firstName'] : '';
$lastName = isset($_GET['lastName']) ? $_GET['lastName'] : '';

if (!$realUsername || !$firstName || !$lastName) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Missing required parameters.'
    ]);
    exit;
}

// Curl to Twitter API
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://twitter241.p.rapidapi.com/search?type=Top&count=20&query=" . urlencode($firstName . " " . $lastName),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "x-rapidapi-host: twitter241.p.rapidapi.com",
        "x-rapidapi-key: a215e49e05msh5fcdb4d2a13fc9fp1cdf43jsnae562d106bb7"
    ],
]);
$response = curl_exec($curl);
curl_close($curl);

// Extract usernames from raw JSON
preg_match_all('/"screen_name":"(.*?)"/', $response, $matches);
$usernames = array_unique($matches[1]);

function calculateRisk($username, $realUsername) {
    $risk = 0;
    if (stripos($username, $realUsername) !== false) $risk += 40;
    similar_text($username, $realUsername, $percent);
    if ($percent >= 70) $risk += 30;
    if (preg_match('/fan|official|real|alt|parody|news|bot/i', $username)) $risk += 20;
    if (strlen($username) < 6 || strlen($username) > 20) $risk += 10;
    return min($risk, 100);
}

function getRiskLevel($score) {
    if ($score >= 70) return "High";
    if ($score >= 40) return "Medium";
    return "Low";
}

$impersonators = [];
foreach ($usernames as $username) {
    $score = calculateRisk($username, $realUsername);
    if ($score >= 40) {
        $impersonators[] = [
            'username' => $username,
            'score' => $score,
            'risk' => getRiskLevel($score)
        ];
    }
}

// Return JSON
echo json_encode([
    'status' => 'success',
    'real_username' => $realUsername,
    'impersonators' => $impersonators
], JSON_PRETTY_PRINT);
?>
