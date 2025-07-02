
<?php
header('Content-Type: application/json');

$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$source = isset($_GET['source']) ? trim($_GET['source']) : 'all';
$api_key = 'b6a4ac0f90023068ed26eb2aadd915c82e64bfd23708401166860246f35f2e6f';

$sources = [
  'pastebin' => 'site:pastebin.com',
  'hastebin' => 'site:hastebin.com',
  'anonpaste' => 'site:anonpaste.org',
  'duckduckgo' => 'site:darkweb'
];

$keywords = " leaked password dump database compromised paste credentials login breach exposed";
$results = [];
$debug = [];

$search_sources = ($source === 'all') ? array_keys($sources) : explode(',', $source);

foreach ($search_sources as $src) {
  if (!isset($sources[$src])) continue;

  $full_query = $sources[$src] . ' ' . $query . $keywords;

  // Try Google engine first
  $google_url = "https://serpapi.com/search.json?q=" . urlencode($full_query) . "&engine=google&api_key={$api_key}";
  $response = @file_get_contents($google_url);
  $http_code = $http_response_header[0] ?? 'No Header';

  $entry = ['source' => $src, 'url' => $google_url];

  if (strpos($http_code, '200') !== false && strpos($response, 'Google hasn\'t returned any results') === false) {
    $results[$src] = json_decode($response, true);
    $entry['http_code'] = 200;
  } else {
    // Fall back to DuckDuckGo
    $duck_url = "https://serpapi.com/search.json?q=" . urlencode($full_query) . "&engine=duckduckgo&api_key={$api_key}";
    $response = @file_get_contents($duck_url);
    $http_code = $http_response_header[0] ?? 'No Header';
    $entry['url'] = $duck_url;

    if (strpos($http_code, '200') !== false) {
      $results[$src] = json_decode($response, true);
      $entry['http_code'] = 200;
    } else {
      $entry['http_code'] = explode(' ', $http_code)[1] ?? 'error';
      $entry['error_msg'] = "No results from both Google and DuckDuckGo.";
    }
  }

  $debug[] = $entry;
}

echo json_encode([
  'query' => $query . $keywords,
  'sources' => $source,
  'results' => $results,
  'debug' => $debug
], JSON_UNESCAPED_SLASHES);
?>
