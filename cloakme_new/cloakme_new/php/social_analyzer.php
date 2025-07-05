<?php
// php/social_analyzer.php

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['username'])) {
    $username = htmlspecialchars(trim($_POST['username']));

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.instagram.com/$username/");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
        'Accept-Language: en-US,en;q=0.9',
        'Cache-Control: no-cache',
        'Pragma: no-cache',
    ]);
    $html = curl_exec($ch);
    curl_close($ch);

    if ($html && strpos($html, $username) !== false) {
        preg_match_all('/<img[^>]+src="([^"]+)"/i', $html, $matches);
        $postCount = count($matches[1]);
        $exposureScore = $postCount * 10;

        echo json_encode([
            'success' => true,
            'exposureScore' => $exposureScore,
            'posts' => array_slice($matches[1], 0, 10)
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to retrieve Instagram profile.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request'
    ]);
}
