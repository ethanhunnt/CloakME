<?php

header("Content-Type: application/json");

if (!isset($_GET['username']) || empty($_GET['username'])) {
    echo json_encode(["success" => false, "error" => "Missing username"]);
    exit;
}

$username = urlencode($_GET['username']);
$api_url = "https://instagram-scraper-stable-api.p.rapidapi.com/ig_get_fb_profile_hover.php?username_or_url=" . $username;
$headers = [
    "x-rapidapi-host: instagram-scraper-stable-api.p.rapidapi.com",
    "x-rapidapi-key: a215e49e05msh5fcdb4d2a13fc9fp1cdf43jsnae562d106bb7"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
curl_close($ch);

if (!$response) {
    echo json_encode(["success" => false, "error" => "API call failed"]);
    exit;
}

$data = json_decode($response, true);
$user = $data['user_data'] ?? null;

if (!$user) {
    echo json_encode(["success" => true, "score" => 0, "posts" => [], "indicators" => [
        "Facial Visibility" => "Low",
        "Location Tags" => "None",
        "Luxury Display" => "Low"
    ], "risk_class" => "risk-low"]);
    exit;
}

// Simplified scoring logic
$followers = $user['follower_count'] ?? 0;
$media_count = $user['media_count'] ?? 0;

$score = min(100, intval(($followers / 1000000) * 30 + $media_count * 0.005));

$posts = [];
if (isset($data['user_posts']) && is_array($data['user_posts'])) {
    foreach (array_slice($data['user_posts'], 0, 9) as $post) {
        $posts[] = [
            "thumbnail" => $post['thumbnail_src'] ?? '',
            "caption" => $post['caption'] ?? '',
            "url" => $post['shortcode'] ? "https://www.instagram.com/p/" . $post['shortcode'] : ''
        ];
    }
}

$risk_class = $score > 70 ? "risk-high" : ($score > 40 ? "risk-medium" : "risk-low");

$indicators = [
    "Facial Visibility" => $score > 70 ? "High" : "Low",
    "Location Tags" => ($score > 40 ? "Many" : "None"),
    "Luxury Display" => $score > 50 ? "Visible" : "Low"
];

echo json_encode([
    "success" => true,
    "score" => $score,
    "posts" => $posts,
    "indicators" => $indicators,
    "risk_class" => $risk_class,
    "raw_json" => $response
]);

/*

header('Content-Type: application/json');

if (!isset($_GET['username']) || empty($_GET['username'])) {
    echo json_encode(['success' => false, 'error' => 'Missing username']);
    exit;
}

$username = urlencode($_GET['username']);

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://instagram-scraper-stable-api.p.rapidapi.com/ig_get_fb_profile_hover.php?username_or_url={$username}",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        'x-rapidapi-host: instagram-scraper-stable-api.p.rapidapi.com',
        'x-rapidapi-key: a215e49e05msh5fcdb4d2a13fc9fp1cdf43jsnae562d106bb7'
    ]
]);

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo json_encode(["success" => false, "error" => $err]);
    exit;
}

$data = json_decode($response, true);
$score = 0;
$indicators = [
    'Facial Visibility' => 'Low',
    'Location Tags' => 'None',
    'Luxury Display' => 'Low'
];

$post_images = [];

if (isset($data['user_data']['media']['nodes'])) {
    $nodes = $data['user_data']['media']['nodes'];
    foreach ($nodes as $node) {
        if (isset($node['thumbnail_src'])) {
            $post_images[] = $node['thumbnail_src'];
        }
    }

    // Adjust score based on simple heuristics (update these as needed)
    $score = count($post_images) > 5 ? 100 : (count($post_images) * 20);

    if ($score >= 80) {
        $indicators['Facial Visibility'] = 'High';
        $indicators['Location Tags'] = 'Many';
        $indicators['Luxury Display'] = 'Visible';
    }
}

$response_data = [
    'success' => true,
    'score' => $score,
    'risk_class' => $score >= 80 ? 'risk-high' : ($score >= 50 ? 'risk-medium' : 'risk-low'),
    'indicators' => $indicators,
    'posts' => $post_images,
    'raw_json' => json_encode($data)
];

echo json_encode($response_data);

*/
?>