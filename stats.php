<?php
// Live counts from the sofia database, used by index.html's stat bar.
// Served from jed.ebible.us and fetched cross-origin -- GitHub Pages has no PHP.
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/includes/db-config-sofia.php';

$link = @mysqli_connect($sofiaHost, $sofiaUser, $sofiaPw, 'sofia');
if (!$link) {
    http_response_code(503);
    echo json_encode(['error' => 'unavailable']);
    exit;
}

$result = mysqli_query($link, "SELECT COUNT(translationId) AS translations, COUNT(DISTINCT languageId) AS languages FROM bible_list WHERE downloadable=1");
$row = mysqli_fetch_assoc($result);

echo json_encode([
    'translations' => (int) $row['translations'],
    'languages'    => (int) $row['languages'],
]);
