<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["linkedinUrl"])) {
    $linkedinUrl = urlencode($_POST["linkedinUrl"]);
    $url = "https://fresh-linkedin-profile-data.p.rapidapi.com/get-linkedin-profile?linkedin_url=" . $linkedinUrl .
           "&include_skills=false&include_certifications=false&include_publications=false&include_honors=false" .
           "&include_volunteers=false&include_projects=false&include_patents=false&include_courses=false" .
           "&include_organizations=false&include_profile_status=false&include_company_public_url=false";

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "x-rapidapi-host: fresh-linkedin-profile-data.p.rapidapi.com",
            "x-rapidapi-key: a215e49e05msh5fcdb4d2a13fc9fp1cdf43jsnae562d106bb7"
        ],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($response, true);
    $data = $result["data"];

    $score = 0;

    if (!empty($data["profile_image_url"])) $score += 15;
    if (!empty($data["headline"])) $score += 10;
    if (!empty($data["location"])) $score += 10;
    if (!empty($data["company"])) $score += 10;
    if (!empty($data["job_title"])) $score += 10;
    if (!empty($data["about"])) $score += 10;
    if (!empty($data["follower_count"]) && $data["follower_count"] > 5000) $score += 15;
    if (!empty($data["is_influencer"]) && $data["is_influencer"]) $score += 10;
    if (!empty($data["educations"]) && count($data["educations"]) > 0) $score += 10;
    if (!empty($data["experiences"]) && count($data["experiences"]) > 2) $score += 10;

    $level = "low";
    $message = "Minimal exposure detected.";
    if ($score > 40) {
        $level = "medium";
        $message = "Moderate exposure. Consider limiting visible details.";
    }
    if ($score > 70) {
        $level = "high";
        $message = "High exposure! Profile is highly visible.";
    }

    echo json_encode(["score" => $score, "level" => $level, "message" => $message]);
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
