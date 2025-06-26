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

if (!isset($data['user_data'])) {
    echo json_encode(["success" => false, "error" => "user_data missing"]);
    exit;
}

$user_data = $data['user_data'];

$username = isset($user_data['username']) ? $user_data['username'] : "";
$full_name = isset($user_data['full_name']) ? $user_data['full_name'] : "";
$profile_pic_url = isset($user_data['profile_pic_url']) ? $user_data['profile_pic_url'] : "";
$follower_count = isset($user_data['follower_count']) ? $user_data['follower_count'] : 0;
$media_count = isset($user_data['media_count']) ? $user_data['media_count'] : 0;
$is_private = isset($user_data['is_private']) ? $user_data['is_private'] : false;
$is_verified = isset($user_data['is_verified']) ? $user_data['is_verified'] : false;

// Score calculation from user_data
$score = 0;
if (!$is_private) $score += 20;
if ($is_verified) $score += 10;
if ($media_count > 100) $score += 10;
if ($follower_count > 1000000) $score += 10;
if (!empty($profile_pic_url)) $score += 5;

// Post traversal
$posts = isset($data['user_posts']) ? $data['user_posts'] : [];
$post_data = [];
$count = 0;

foreach ($posts as $entry) {
    if (!isset($entry['node'])) continue;

    $node = $entry['node'];
    $code = isset($node['code']) ? $node['code'] : null;
    $image_url = isset($node['image_versions2']['candidates'][0]['url']) ? $node['image_versions2']['candidates'][0]['url'] : "";

    if ($code && $image_url) {
        $post_data[] = [
            "post_url" => "https://www.instagram.com/p/{$code}/",
            "image_url" => $image_url
        ];
        $score += 5;
        $count++;
    }

    if ($count >= 5) break;
}

echo json_encode([
    "success" => true,
    "username" => $username,
    "full_name" => $full_name,
    "profile_pic_url" => $profile_pic_url,
    "follower_count" => $follower_count,
    "media_count" => $media_count,
    "score" => min($score, 100),
    "posts" => $post_data
], JSON_PRETTY_PRINT);

?>
