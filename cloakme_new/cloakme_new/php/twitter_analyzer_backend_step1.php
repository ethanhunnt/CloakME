
<?php
header('Content-Type: application/json');

$username = $_GET['username'] ?? '';
if (!$username) {
    echo json_encode(['error' => 'Missing username']);
    exit;
}

$apiKey = "a215e49e05msh5fcdb4d2a13fc9fp1cdf43jsnae562d106bb7";

// 1. Get Twitter User Info
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://twitter241.p.rapidapi.com/user?username=" . urlencode($username),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "x-rapidapi-host: twitter241.p.rapidapi.com",
        "x-rapidapi-key: $apiKey"
    ],
]);
$user_response = curl_exec($curl);
$user_data = json_decode($user_response, true);
curl_close($curl);

// Correct user_id path
if (!isset($user_data['result']['data']['user']['result']['rest_id'])) {
    echo json_encode([
        "error" => "User ID not found",
        "raw_user_data" => $user_data
    ]);
    exit;
}
$user_id = $user_data['result']['data']['user']['result']['rest_id'];

sleep(3); // respect rate limit

// 2. Get Tweets
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://twitter241.p.rapidapi.com/user-tweets?user=$user_id&count=10",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "x-rapidapi-host: twitter241.p.rapidapi.com",
        "x-rapidapi-key: $apiKey"
    ],
]);
$tweet_response = curl_exec($curl);
$tweet_data = json_decode($tweet_response, true);
curl_close($curl);

// Extract from first valid tweet
try {
    $entry = $tweet_data['result']['timeline']['instructions'][1]['entries'][0];
    $legacy = $entry['content']['itemContent']['tweet_results']['result']['core']['user_results']['result']['legacy'];
    $tweets = [];

    foreach ($tweet_data['result']['timeline']['instructions'][1]['entries'] as $ent) {
        if (isset($ent['content']['itemContent']['tweet_results']['result']['legacy'])) {
            $tweets[] = $ent['content']['itemContent']['tweet_results']['result']['legacy'];
        }
    }

    // Scoring logic
    $score = 0;
    foreach ($tweets as $tweet) {
        $text = strtolower($tweet['full_text']);
        if (strpos($text, '#') !== false) $score += 5;
        if (strpos($text, 'instagram.com') !== false || strpos($text, 'facebook.com') !== false) $score += 10;
        if (strpos($text, 'location') !== false || strpos($text, 'mumbai') !== false) $score += 5;
        if (preg_match('/\b(birthday|party|home|wife|daughter|son)\b/', $text)) $score += 10;
    }

    // Cap the score to 100
    if ($score > 100) $score = 100;

   /* echo json_encode([
        "score" => $score,
        "account" => [
            "name" => $legacy['name'],
            "username" => $legacy['screen_name'],
            "description" => $legacy['description'],
            "location" => $legacy['location'],
            "followers" => $legacy['followers_count'],
            "profile_image" => $legacy['profile_image_url_https']
        ],
        "raw" => $tweet_data
    ]);*/
	
	
	$tweet_output = [];
	foreach ($tweets as $tweet) {
		$tweet_output[] = [
			'text' => $tweet['full_text'] ?? '',
			'created_at' => $tweet['created_at'] ?? '',
			'url' => 'https://twitter.com/' . ($legacy['screen_name'] ?? 'user') . '/status/' . ($tweet['id_str'] ?? '')
		];
	}

	echo json_encode([
		"score" => $score,
		"account" => [
			"name" => $legacy['name'],
			"username" => $legacy['screen_name'],
			"description" => $legacy['description'],
			"location" => $legacy['location'],
			"followers" => $legacy['followers_count'],
			"profile_image" => $legacy['profile_image_url_https']
		],
		"tweets" => $tweet_output,
		"raw" => $tweet_data
	]);


} catch (Exception $e) {
    echo json_encode([
        "error" => "Failed to parse tweet data",
        "details" => $e->getMessage(),
        "raw_tweet_data" => $tweet_data
    ]);
}
?>
