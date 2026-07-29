<?php
require_once __DIR__ . '/../includes/db-config.php';
$link = mysqli_connect($mysqlserver, $mysqluser, $mysqlpw);
if (!$link) die("Database connection failed.");
mysqli_set_charset($link, 'utf8mb4');
function coverageBadge($ot, $nt, $ad) {
    if ($ot >= 39 && $nt >= 27)          return '<span class="badge-full">Full Bible</span>';
    if ($nt >= 27 && $ot == 0)           return '<span class="badge-nt">NT</span>';
    if ($nt > 0  && $ot > 0)             return '<span class="badge-part">NT+</span>';
    if ($nt > 0  || $ot > 0 || $ad > 0) return '<span class="badge-part">Portions</span>';
    return '';
}

// Pacific country codes
$pacificCodes = "'PG','AU','SB','VU','FM','TO','FJ','WS','KI','MH','PW','TV','NR','CK','NU','WF','TK','PF','NC','GU','AS','MP'";

$cntQ = "SELECT COUNT(*) FROM sofia.bible_list
          WHERE redistributable=1 AND countryCode IN ($pacificCodes)";
$cntR = mysqli_query($link, $cntQ);
[$numTrans] = mysqli_fetch_row($cntR);

$listQ = "SELECT translationId, languageName, languageNameInEnglish, dialect,
                 vernacularTitle, shortTitle, country, copyrightYears,
                 otBookCount, ntBookCount, adBookCount
          FROM sofia.bible_list
          WHERE redistributable=1 AND countryCode IN ($pacificCodes)
          ORDER BY country, languageName, dialect, copyrightYears";
$listR = mysqli_query($link, $listQ);
if (!$listR) die("Database query failed: " . mysqli_error($link));
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
<meta name="description" content="Pacific Bibles — Scriptures in the languages of the Pacific nations">
<title>Pacific Bibles — PacificBibles.org</title>
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="/css/font-icons.min.css">
<link rel="stylesheet" type="text/css" href="/css/theme-vendors.min.css">
<link rel="stylesheet" type="text/css" href="/css/style.css" />
<link rel="stylesheet" type="text/css" href="/css/custom.css" />
<link rel="stylesheet" type="text/css" href="/css/responsive.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.trans-table { width:100%; border-collapse:collapse; margin-top:16px; font-family:sans-serif; font-size:0.88em; }
.trans-table thead tr { background:#111; color:#fff; }
.trans-table thead th { padding:10px 14px; text-align:left; font-weight:600; letter-spacing:0.04em; font-size:0.8em; text-transform:uppercase; }
.trans-table tbody tr { border-bottom:1px solid #eee; transition:background 0.1s; }
.trans-table tbody tr:hover { background:#f7f7f7; }
.trans-table td { padding:8px 14px; vertical-align:middle; color:#333; }
.trans-table td a { color:#333; font-weight:600; text-decoration:none; }
.trans-table td a:hover { text-decoration:underline; }
.trans-table td:nth-child(4) a { color:#555; font-weight:400; font-size:0.85em; }
.badge-full { display:inline-block; padding:2px 8px; background:#e8f5e9; color:#2e7d32; border-radius:10px; font-size:0.75em; font-weight:700; white-space:nowrap; }
.badge-nt   { display:inline-block; padding:2px 8px; background:#e3f2fd; color:#1565c0; border-radius:10px; font-size:0.75em; font-weight:700; white-space:nowrap; }
.badge-part { display:inline-block; padding:2px 8px; background:#fdf5e0; color:#8a6000; border-radius:10px; font-size:0.75em; font-weight:700; white-space:nowrap; }
.search-bar { margin:24px 0 8px; display:flex; align-items:center; gap:12px; flex-wrap:wrap; }
.search-bar input { padding:8px 14px; border:1px solid #ccc; border-radius:4px; font-size:0.95em; width:300px; font-family:sans-serif; }
.search-bar input:focus { border-color:#888; outline:none; }
.result-count { font-family:sans-serif; font-size:0.82em; color:#888; }
.region-links { font-family:sans-serif; font-size:0.88em; margin:8px 0 24px; }
.region-links a { color:#1a6bbf; margin-right:14px; text-decoration:none; font-weight:600; }
.region-links a:hover { text-decoration:underline; }
</style>
</head>

<body data-mobile-nav-style="classic">

<!-- NAVBAR -->
<header class="header-with-topbar">
  <nav class="navbar navbar-expand-lg top-space navbar-light bg-black header-light fixed-top navbar-boxed" style="top:48.8px;">
    <div class="container-fluid nav-header-container">
      <div class="ps-lg-0 d-flex align-items-center" style="flex:1;min-width:0;">
        <a class="navbar-brand" href="/pacificbibles/">
          <img src="smallglobe.gif" data-at2x="smallglobe.gif" class="default-logo" alt="Pacific Bibles" height="48">
          <img src="smallglobe.gif" data-at2x="smallglobe.gif" class="alt-logo" alt="Pacific Bibles" width="0" height="0">
          <img src="smallglobe.gif" data-at2x="smallglobe.gif" class="mobile-logo" alt="Pacific Bibles" width="0" height="0">
        </a>
      </div>
      <div class="col-auto bg-black menu-order px-lg-0">
        <button class="navbar-toggler float-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
          <span class="navbar-toggler-line"></span><span class="navbar-toggler-line"></span>
          <span class="navbar-toggler-line"></span><span class="navbar-toggler-line"></span>
        </button>
        <div class="bg-black collapse navbar-collapse justify-content-center" id="navbarNav">
          <ul class="navbar-nav alt-font">
            <li class="nav-item"><a href="/pacificbibles/" class="nav-link">Translations</a></li>
            <li class="nav-item"><a href="https://pacificbibles.org/links.php" class="nav-link">Links</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</header>

<div class="hero-frame-top"></div>
<section class="p-0"><div class="page-header-hero-generic"></div></section>
<div class="hero-frame-bottom"></div>

<section>
<div class="container slim-container">
  <h1 class="h1-main-title alt-font font-weight-600 text-extra-dark-gray w-95">Pacific Bibles</h1>
  <p style="font-family:sans-serif;font-size:0.95em;color:#555;line-height:1.7;max-width:680px;margin-bottom:8px;">
    Scriptures in the vernacular languages of the Pacific — <strong><?= number_format($numTrans) ?> translations</strong> across Papua New Guinea, Australia, Solomon Islands, Vanuatu, Micronesia, and beyond. Over 1,250 living languages are spoken in the Pacific region.
  </p>
  <p style="font-family:sans-serif;font-size:0.95em;color:#555;line-height:1.7;max-width:680px;margin-bottom:4px;">
    Ce site donne accès aux Écritures dans les langues vernaculaires du Pacifique.
  </p>
  <div class="region-links">
    <a href="https://png.bible" target="_blank">Papua New Guinea</a>
    <a href="https://solomons.bible" target="_blank">Solomon Islands</a>
    <a href="https://fsm.bible" target="_blank">Micronesia</a>
    <a href="https://baebol.org" target="_blank">Vanuatu</a>
    <a href="http://aboriginalbibles.org.au/" target="_blank">Australia</a>
    <a href="https://eBible.org/ton/" target="_blank">Tonga</a>
  </div>
  <div class="search-bar">
    <input type="text" id="lang-search" placeholder="Search language, title, or country…" oninput="filterTable()">
    <span class="result-count" id="result-count">Loading…</span>
  </div>
  <table class="trans-table">
    <thead>
      <tr>
        <th style="width:20%">Language</th>
        <th style="width:35%">Title</th>
        <th style="width:18%">Country</th>
        <th style="width:12%">ePub</th>
        <th style="width:15%">Coverage</th>
      </tr>
    </thead>
    <tbody id="trans-body">
<?php while ($row = mysqli_fetch_assoc($listR)):
    $id      = $row['translationId'];
    $lang    = $row['languageName'] ?: $row['languageNameInEnglish'];
    $dialect = ($row['dialect'] && $row['dialect'] !== $lang) ? $row['dialect'] : '';
    $title   = $row['vernacularTitle'];
    $short   = $row['shortTitle'];
    $country = $row['country'];
    $badge   = coverageBadge((int)$row['otBookCount'], (int)$row['ntBookCount'], (int)$row['adBookCount']);
    $url     = "https://pacificbibles.org/details.php?id=" . urlencode($id);
    $epub    = "https://eBible.org/epub/" . urlencode($id) . ".epub";
    $search  = strtolower(($dialect ?: $lang) . ' ' . $title . ' ' . $country);
?>
<tr data-search="<?= htmlspecialchars($search) ?>"><td><?= htmlspecialchars($lang) ?><?php if ($dialect): ?><br><span style="font-size:0.82em;color:#888;"><?= htmlspecialchars($dialect) ?></span><?php endif; ?></td><td><a href="<?= $url ?>" target="_blank"><?= htmlspecialchars($title) ?></a><?php if ($short && $short !== $title): ?><br><span style="font-size:0.82em;color:#888;"><?= htmlspecialchars($short) ?></span><?php endif; ?></td><td><?= htmlspecialchars($country) ?></td><td><a href="<?= $epub ?>" target="_blank"><i class="fa fa-download"></i> ePub</a></td><td><?= $badge ?></td></tr>
<?php endwhile; ?>
    </tbody>
  </table>
  <div id="no-results" style="display:none; font-family:sans-serif; font-size:0.9em; color:#888; padding:20px 0;">No translations matched your search.</div>
</div>
</section>

<footer class="footer-dark bg-black padding-slim-top">
  <div class="footer-top padding-40px-tb border-bottom border-color-white-transparent">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 col-md-3 text-center text-md-start sm-margin-20px-bottom">
          <img src="smallglobe.gif" alt="Pacific Globe" style="width:90px;height:90px;border-radius:50%;">
        </div>
        <div class="col-12 col-md-6 text-center sm-margin-20px-bottom">
          <span class="alt-font font-weight-500 d-inline-block align-middle margin-5px-right text-white">
            <p>Site copyright © 2009–2025 <a href="https://eBible.org/">eBible.org</a>.<br>
            <a href="https://eBible.org/privacy.php">Privacy Policy</a> &nbsp;&nbsp;
            <a href="https://eBible.org/legal.php">Legal Notices</a></p>
          </span>
        </div>
        <div class="col-12 col-md-3"></div>
      </div>
    </div>
  </div>
</footer>

<a class="scroll-top-arrow" href="javascript:void(0);"><i class="fa fa-arrow-up"></i></a>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/theme-vendors.min.js"></script>
<script type="text/javascript" src="/js/main.js"></script>
<script>
function filterTable() {
  var q = document.getElementById("lang-search").value.toLowerCase().trim();
  var rows = document.querySelectorAll("#trans-body tr");
  var shown = 0;
  rows.forEach(function(row) {
    var match = !q || (row.getAttribute("data-search") || "").indexOf(q) !== -1;
    row.style.display = match ? "" : "none";
    if (match) shown++;
  });
  var total = rows.length;
  var el = document.getElementById("result-count");
  el.textContent = q ? (shown + " of " + total + " translations") : ("Showing all " + total + " translations");
  document.getElementById("no-results").style.display = shown === 0 ? "" : "none";
}
document.addEventListener("DOMContentLoaded", function() {
  var total = document.querySelectorAll("#trans-body tr").length;
  document.getElementById("result-count").textContent = "Showing all " + total + " translations";
});
</script>
</body>
</html>
