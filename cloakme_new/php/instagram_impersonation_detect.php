<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $actual = strtolower(trim($_GET['actual_username'] ?? ''));
  $query = trim($_GET['search_query'] ?? '');

  if (empty($actual) || empty($query)) {
    echo json_encode(["error" => "Missing parameters"]);
    exit;
  }

  // Search call
  $curl = curl_init();
  curl_setopt_array($curl, [
    CURLOPT_URL => "https://instagram-scraper-stable-api.p.rapidapi.com/search_ig.php",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 10,
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
  $all_users = array_slice($data['users'], 0, 10);
  $results = [];

  foreach ($all_users as $entry) {
    $user = $entry['user'];
    $username = strtolower($user['username']);
    $full_name = $user['full_name'];
    $is_verified = $user['is_verified'] ? 1 : 0;
    $profile_pic_url = $user['profile_pic_url'] ?? '';
    $followers = 0;
    $bio = "";
    $note = "";
    $risk = "Medium";

    // Hover API to get follower count and bio
    $hover_api_url = "https://instagram-scraper-stable-api.p.rapidapi.com/ig_get_fb_profile_hover.php?username_or_url=" . urlencode($username);
    $headers = [
      "x-rapidapi-host: instagram-scraper-stable-api.p.rapidapi.com",
      "x-rapidapi-key: a215e49e05msh5fcdb4d2a13fc9fp1cdf43jsnae562d106bb7"
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $hover_api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_TIMEOUT, 3);
    $hover_response = curl_exec($ch);
    curl_close($ch);

    $hover_data = json_decode($hover_response, true);
    if (isset($hover_data['user_data'])) {
      $user_data = $hover_data['user_data'];
      $followers = $user_data['follower_count'] ?? 0;
      $bio = strtolower($user_data['biography'] ?? '');
    }

    $uname_clean = strtolower($username);
    $fname_clean = strtolower($full_name);
    $actual_clean = strtolower($actual);
    $fan_keywords = ['fan', 'fans', 'club', 'support', 'team', 'official'];

    $is_original = ($uname_clean === $actual_clean);
    $is_fan_page = false;

    foreach ($fan_keywords as $keyword) {
      if (strpos($uname_clean, $keyword) !== false || strpos($fname_clean, $keyword) !== false || strpos($bio, $keyword) !== false) {
        $is_fan_page = true;
        break;
      }
    }

    // Original Profile
    if ($is_original && $is_verified) {
      $note = "Original profile";
      $risk = "Low";
    }

    // Fan page
    elseif ($is_fan_page) {
      $note = "Likely fan page";
      $risk = "Low";
    }

    // Potential impersonator
    else {
      similar_text($actual_clean, $uname_clean, $u_sim);
      similar_text($query, $fname_clean, $f_sim);
      $risk = ($u_sim > 80 && $f_sim > 70 && !$is_verified) ? "High" : "Medium";
    }

    // Profile image
    $profile_pic_base64 = "";
    if (!empty($profile_pic_url)) {
      $img_data = @file_get_contents($profile_pic_url);
      if ($img_data !== false) {
        $profile_pic_base64 = "data:image/jpeg;base64," . base64_encode($img_data);
      }
    }

    $results[] = [
      "username" => $username,
      "full_name" => $full_name,
      "verified" => $is_verified ? "Yes" : "No",
      "followers" => $followers,
      "risk_level" => $risk,
      "note" => $note,
      "profile_pic_base64" => $profile_pic_base64
    ];
  }

  header('Content-Type: application/json');
  echo json_encode($results);
}
?>
