
<?php
$realUsername = $_POST['realUsername'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];

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

echo "<pre>Raw JSON Response:\n" . htmlspecialchars($response) . "</pre>";

preg_match_all('/"screen_name":"(.*?)"/', $response, $matches);
$usernames = array_unique($matches[1]);

$impersonators = [];
foreach ($usernames as $username) {
    if (stripos($username, $realUsername) !== false || similar_text($username, $realUsername) >= strlen($realUsername) * 0.7) {
        $impersonators[] = $username;
    }
}

if (!empty($impersonators)) {
    echo "<p>Possible impersonators found:</p><ul>";
    foreach ($impersonators as $imp) {
        echo "<li>" . htmlspecialchars($imp) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No impersonators found.</p>";
}
?>
