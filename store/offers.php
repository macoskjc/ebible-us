<?php
// Database-backed replacement for the old static data/offers.json --
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

$result = mysqli_query($link, 'SELECT edition_id, retailer, purchase_url, price_usd, in_stock, type FROM offers ORDER BY id');

$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['price_usd'] = $row['price_usd'] !== null ? (float) $row['price_usd'] : null;
    $row['in_stock']  = (bool) $row['in_stock'];
    $rows[] = $row;
}

echo json_encode($rows);
