
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $actual = strtolower(trim($_POST['actual_username']));
  $query = trim($_POST['search_query']);

  $curl = curl_init();
  curl_setopt_array($curl, [
    CURLOPT_URL => "https://instagram-scraper-stable-api.p.rapidapi.com/search_ig.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "search_query=" . urlencode($query),
    CURLOPT_HTTPHEADER => [
      "Content-Type: application/x-www-form-urlencoded",
      "x-rapidapi-host: instagram-scraper-stable-api.p.rapidapi.com",
      "x-rapidapi-key: a215e49e05msh5fcdb4d2a13fc9fp1cdf43jsnae562d106bb7"
    ],
  ]);

  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);

  if ($err) {
    echo json_encode(["error" => "cURL Error: $err"]);
    exit;
  }

  $data = json_decode($response, true);
  $results = [];

  foreach ($data['users'] as $entry) {
    $user = $entry['user'];
    $username = strtolower($user['username']);
    $full_name = $user['full_name'];
    $is_verified = $user['is_verified'] ? 1 : 0;
    $followers = 0;

    // Extract numeric followers if present
    if (!empty($user['search_social_context']) && preg_match('/([\d\.]+)([kKmM]?)/', $user['search_social_context'], $match)) {
      $followers = (float) $match[1];
      if (strtolower($match[2]) === 'k') $followers *= 1000;
      if (strtolower($match[2]) === 'm') $followers *= 1000000;
    }

    $profile_pic_url = $user['profile_pic_url'] ?? '';

    // Calculate similarity score
    similar_text($actual, $username, $percent);
    $score = 0;

    // 1. Username similarity (40%)
    $score += ($percent / 100) * 40;

    // 2. Not verified (20%)
    if (!$is_verified) $score += 20;

    // 3. Low followers (15%)
    if ($followers < 1000) $score += 15;

    // 4. Profile picture present (10%)
    if (!empty($profile_pic_url)) $score += 10;

    // 5. Full name similarity (15%)
    similar_text(strtolower($full_name), str_replace('.', ' ', $actual), $name_percent);
    $score += ($name_percent / 100) * 15;

    // Determine risk level
    $risk = "Low";
    if ($score >= 80) $risk = "High";
    elseif ($score >= 60) $risk = "Medium";

    if ($risk !== "Low") {
      $results[] = [
        "username" => $username,
        "full_name" => $full_name,
        "verified" => $is_verified ? "Yes" : "No",
        "followers" => (int)$followers,
        "risk_level" => $risk,
        "profile_pic_url" => $profile_pic_url
      ];
    }
  }

  header('Content-Type: application/json');
  echo json_encode($results);
}
?>
