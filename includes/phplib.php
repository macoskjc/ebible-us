<?php
require_once __DIR__ . '/db-config.php';

$link = mysqli_connect($mysqlserver, $mysqluser, $mysqlpw);
if (!$link) die("Database connection failed.");
mysqli_set_charset($link, 'utf8mb4');

function coverageBadge($ot, $nt, $ad) {
    if ($ot >= 39 && $nt >= 27)        return '<span class="badge-full">Full Bible</span>';
    if ($nt >= 27 && $ot == 0)         return '<span class="badge-nt">NT</span>';
    if ($nt > 0  && $ot > 0)           return '<span class="badge-part">NT+</span>';
    if ($nt > 0  || $ot > 0 || $ad > 0) return '<span class="badge-part">Portions</span>';
    return '';
}
?>
