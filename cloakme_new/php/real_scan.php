<?php
session_start();
if (isset($breachList)) {
    $_SESSION['breach_count'] = count($breachList);
    $_SESSION['breach_data'] = $breachList;
}
$email = $_POST['email'];

function checkBreaches($email) {
    $url = "https://haveibeenpwned.com/api/v3/breachedaccount/" . urlencode($email) . "?truncateResponse=false";
    $headers = [
        "hibp-api-key: 3ad7f0c4b35446b0a4ee942f78679bf5", // Replace with your actual API key
        "User-Agent: CloakMeScanner/1.0"
    ];

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    $response = curl_exec($curl);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Scan Results</title>
        <link rel='stylesheet' href='../css/styles.css'>
    </head>
    <body>
        <header>
            <div class='logo'>🛡️ CloakMe</div>
            <nav>
                <a href='../dashboard/dashboard.html'>Dashboard</a>
                <a href='logout.php'>Logout</a>
            </nav>
        </header>
        <section class='hero'>
            <h1>Scan Results for: " . htmlspecialchars($email) . "</h1>";

    if ($http_status == 200) {
        $breaches = json_decode($response, true);
        echo "<ul>";
        foreach ($breaches as $breach) {
            $name = htmlspecialchars($breach['Name']);
            $date = htmlspecialchars($breach['BreachDate']);
            $domain = htmlspecialchars($breach['Domain']);
            $description = htmlspecialchars($breach['Description']);
            $url = "https://haveibeenpwned.com/PwnedWebsites#" . urlencode($name);

            echo "<li><strong><a href='$url' target='_blank'>$name</a></strong> 
                    <br><strong>Date:</strong> $date 
                    <br><strong>Domain:</strong> $domain
                    <br><strong>Description:</strong> <em>$description</em>
                  </li><br>";
        }
        echo "</ul>";
    } elseif ($http_status == 404) {
        echo "<p>No breaches found for this email.</p>";
    } else {
        echo "<p>Error retrieving data. Status code: $http_status</p>";
    }

    echo "<br><a href='../dashboard/scan.html'><button style='padding: 0.5rem 1rem; background-color: #3f83f8; color: white; border: none; border-radius: 4px;'>Back to Scan</button></a>
        </section>
    </body>
    </html>";
}

checkBreaches($email);
?>
