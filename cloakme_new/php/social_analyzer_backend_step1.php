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

$username = $user_data['username'] ?? "";
$full_name = $user_data['full_name'] ?? "";
$profile_pic_url = $user_data['profile_pic_url'] ?? "";
$follower_count = $user_data['follower_count'] ?? 0;
$media_count = $user_data['media_count'] ?? 0;
$is_private = $user_data['is_private'] ?? false;
$is_verified = $user_data['is_verified'] ?? false;

// Convert profile pic to base64
$profile_pic_base64 = "";
if (!empty($profile_pic_url)) {
    $img_data = @file_get_contents($profile_pic_url);
    if ($img_data !== false) {
        $profile_pic_base64 = "data:image/jpeg;base64," . base64_encode($img_data);
    }
}

// Score calculation
$score = 0;
if (!$is_private) $score += 20;
if ($is_verified) $score += 10;
if ($media_count > 100) $score += 10;
if ($follower_count > 1000000) $score += 10;
if (!empty($profile_pic_base64)) $score += 5;

// Post traversal
$posts = $data['user_posts'] ?? [];
$post_data = [];
$count = 0;
$hashtag_post_count = 0;
$geo_tagged_post_count = 0;
$all_hashtags = [];
$all_locations = [];

foreach ($posts as $entry) {
    if (!isset($entry['node'])) continue;

    $node = $entry['node'];
    $code = $node['code'] ?? null;
    $image_url = $node['image_versions2']['candidates'][0]['url'] ?? "";

    // 🔍 Caption & Hashtag Detection
    $caption = $node['edge_media_to_caption']['edges'][0]['node']['text'] ?? '';
    preg_match_all('/#(\w+)/', $caption, $matches);
    if (!empty($matches[1])) {
        $hashtag_post_count++;
        $score += 2;
        $all_hashtags = array_merge($all_hashtags, $matches[1]);
    }

    // 📍 Location/Geo-tag Detection
    $location_name = $node['location']['name'] ?? '';
    if (!empty($location_name)) {
        $geo_tagged_post_count++;
        $score += 2;
        $all_locations[] = $location_name;
    }

    // 📸 Image to Base64
    $image_base64 = "";
    if ($image_url) {
        $img = @file_get_contents($image_url);
        if ($img !== false) {
            $image_base64 = "data:image/jpeg;base64," . base64_encode($img);
        }
    }

    if ($code && $image_base64) {
        $post_data[] = [
            "post_url" => "https://www.instagram.com/p/{$code}/",
            "image_base64" => $image_base64
        ];
        $score += 5;
        $count++;
    }

    if ($count >= 5) break;
}

// Final Output
echo json_encode([
    "success" => true,
    "username" => $username,
    "full_name" => $full_name,
    "profile_pic_base64" => $profile_pic_base64,
    "follower_count" => $follower_count,
    "media_count" => $media_count,
    "score" => min($score, 100),
    "hashtag_post_count" => $hashtag_post_count,
    "geo_tagged_post_count" => $geo_tagged_post_count,
    "hashtags" => array_values(array_unique($all_hashtags)),
    "locations" => array_values(array_unique($all_locations)),
    "posts" => $post_data
], JSON_PRETTY_PRINT);

?>
