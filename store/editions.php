<?php
// Database-backed replacement for the old static data/editions.json --
// same JSON shape, so common.js needs no changes beyond the fetch URL.
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../includes/db-config-store.php';

$link = @mysqli_connect($storeHost, $storeUser, $storePw, 'ebible_store');
if (!$link) {
    http_response_code(503);
    echo json_encode(['error' => 'unavailable']);
    exit;
}
mysqli_set_charset($link, 'utf8mb4');

$result = mysqli_query($link, 'SELECT * FROM editions ORDER BY sku_id');

$intCols   = ['font_size_pt', 'page_count', 'weight_g', 'edition_year'];
$floatCols = ['trim_height_mm', 'trim_width_mm', 'thickness_mm'];
$boolCols  = ['includes_dc', 'illustrated'];

$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    foreach ($intCols as $c)   { if ($row[$c] !== null) $row[$c] = (int) $row[$c]; }
    foreach ($floatCols as $c) { if ($row[$c] !== null) $row[$c] = (float) $row[$c]; }
    foreach ($boolCols as $c)  { $row[$c] = (bool) $row[$c]; }
    $rows[] = $row;
}

echo json_encode($rows);
