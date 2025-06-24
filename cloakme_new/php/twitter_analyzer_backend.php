
<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'];

function getTwitterUser($username, $key) {
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://twitter241.p.rapidapi.com/user?username=$username",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: twitter241.p.rapidapi.com",
            "x-rapidapi-key: $key"
        ],
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

function getUserTweets($userId, $key) {
    sleep(3);  // delay to avoid rate limiting
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://twitter241.p.rapidapi.com/user-tweets?user=$userId&count=10",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: twitter241.p.rapidapi.com",
            "x-rapidapi-key: $key"
        ],
    ]);
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

$apiKey = "a215e49e05msh5fcdb4d2a13fc9fp1cdf43jsnae562d106bb7";

$userResponse = getTwitterUser($username, $apiKey);
$userId = $userResponse['result']['data']['user']['result']['rest_id'] ?? null;

if (!$userId) {
    echo json_encode([
        'error' => 'Invalid user or user not found',
        'raw_response' => $userResponse
    ]);
    exit;
}

$tweetResponse = getUserTweets($userId, $apiKey);
$tweets = [];
if (isset($tweetResponse['result']['timeline']['instructions'])) {
    foreach ($tweetResponse['result']['timeline']['instructions'] as $inst) {
        if (isset($inst['entries'])) {
            foreach ($inst['entries'] as $entry) {
                if (strpos($entry['entryId'], 'tweet') !== false) {
                    $content = $entry['content']['itemContent']['tweet_results']['result']['legacy']['full_text'] ?? null;
                    if ($content) $tweets[] = $content;
                }
            }
        }
    }
}

$score = 0;
foreach ($tweets as $tweet) {
    if (stripos($tweet, 'location') !== false) $score += 20;
    if (stripos($tweet, 'family') !== false) $score += 20;
    if (stripos($tweet, 'email') !== false) $score += 20;
    if (preg_match('/https?:\/\//', $tweet)) $score += 10;
}
$score = min($score, 100);

echo json_encode([
    'score' => $score,
    'raw_response' => $tweetResponse
]);
?>
