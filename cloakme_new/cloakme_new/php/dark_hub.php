<?php
header('Content-Type: application/json');

$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$source = isset($_GET['source']) ? strtolower($_GET['source']) : 'all';

if (!$query) {
    echo json_encode(["error" => "Missing query"]);
    exit;
}

$api_key = 'b6a4ac0f90023068ed26eb2aadd915c82e64bfd23708401166860246f35f2e6f';
$encoded_query = urlencode($query);
$fallback_keywords = ['leaked password', 'compromised', 'login dump', 'breach', 'exposed'];
$available_sources = ['duckduckgo', 'ahmia', 'onionlive', 'pastebin', 'hastebin'];
$sources = $source === 'all' ? $available_sources : array_intersect($available_sources, [$source]);
$results = [];

function serpSearch($query, $engine, $api_key) {
    $url = "https://serpapi.com/search.json?engine=$engine&q=" . urlencode($query) . "&api_key=$api_key";
    $resp = @file_get_contents($url);
    return $resp ? json_decode($resp, true) : null;
}

function parseResults($json, $label) {
    $entries = [];
    if (!isset($json['organic_results'])) return $entries;
    foreach ($json['organic_results'] as $r) {
        if (empty($r['title']) || empty($r['snippet'])) continue;
        $risk = (stripos($r['snippet'], 'password') !== false || stripos($r['snippet'], 'leak') !== false) ? 'High' : 'Medium';
        $entries[] = [
            'source' => ucfirst($label),
            'title' => $r['title'],
            'snippet' => $r['snippet'],
            'url' => $r['link'] ?? '',
            'risk' => $risk
        ];
    }
    return $entries;
}

foreach ($sources as $src) {
    switch ($src) {
        case 'duckduckgo': $engine = 'duckduckgo'; break;
        case 'ahmia': $engine = 'ahmia'; break;
        case 'onionlive': $engine = 'onion'; break;
        case 'pastebin': $engine = 'google'; break;
        case 'hastebin': $engine = 'google'; break;
        default: $engine = 'google';
    }

    $query_to_use = ($src == 'pastebin' || $src == 'hastebin') 
        ? "$query site:$src.com"
        : $query;

    $json = serpSearch($query_to_use, $engine, $api_key);
    $results[$src] = parseResults($json, $src);

    if (empty($results[$src])) {
        foreach ($fallback_keywords as $kw) {
            $fuzzy = "$query $kw";
            $json = serpSearch($fuzzy, $engine, $api_key);
            $results[$src] = parseResults($json, $src);
            if (!empty($results[$src])) break;
            sleep(1);
        }
    }

    sleep(2);
}

echo json_encode([
    "query" => $query,
    "results" => $results
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
?>
