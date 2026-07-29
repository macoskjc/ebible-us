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

$cntQ = "SELECT COUNT(*), COUNT(DISTINCT languageId),
                SUM(hasAudio=1 AND downloadable=1)
          FROM sofia.bible_list
          WHERE redistributable=1 AND countryCode='PG'";
$cntR = mysqli_query($link, $cntQ);
[$numTrans, $numLangs, $numAudio] = mysqli_fetch_row($cntR);

$listQ = "SELECT translationId, languageName, languageNameInEnglish, dialect,
                 vernacularTitle, shortTitle, copyrightYears,
                 otBookCount, ntBookCount, adBookCount, hasAudio
          FROM sofia.bible_list
          WHERE redistributable=1 AND countryCode='PG'
          ORDER BY languageName, dialect, copyrightYears";
$listR = mysqli_query($link, $listQ);
if (!$listR) die("Database query failed: " . mysqli_error($link));
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
<meta name="description" content="Bible translations in the languages of Papua New Guinea">
<title>Papua New Guinea Scriptures — PNG.Bible</title>
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="/css/font-icons.min.css">
<link rel="stylesheet" type="text/css" href="/css/theme-vendors.min.css">
<link rel="stylesheet" type="text/css" href="/css/style.css" />
<link rel="stylesheet" type="text/css" href="/css/custom.css" />
<link rel="stylesheet" type="text/css" href="/css/responsive.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.page-header-hero-generic, .page-header-hero-home-page {
  background-image: url("hero-collage-v2.jpg") !important;
  background-repeat: no-repeat !important;
  background-position: top center !important;
  background-size: cover !important;
}
.translation-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
.translation-table th { background: #111; color: #fff; padding: 10px 14px; text-align: left; font-family: sans-serif; font-size: 0.85em; letter-spacing: 0.05em; text-transform: uppercase; }
.translation-table td { padding: 8px 12px; border-bottom: 1px solid #eee; font-size: 0.88em; vertical-align: middle; }
.translation-table tr:hover td { background: #f8f8f8; }
.translation-table a { color: #1a6bbf; text-decoration: none; font-weight: 600; }
.translation-table a:hover { color: #0d47a1; }
.translation-table th:nth-child(1), .translation-table td:nth-child(1) { width: 18%; }
.translation-table th:nth-child(2), .translation-table td:nth-child(2) { width: 48%; }
.translation-table th:nth-child(3), .translation-table td:nth-child(3) { width: 12%; font-size: 0.82em; color: #888; }
.translation-table th:nth-child(4), .translation-table td:nth-child(4) { width: 14%; text-align: center; }
.translation-table th:nth-child(5), .translation-table td:nth-child(5) { width: 8%; text-align: center; }
.lang-name { color: #aaa; font-size: 0.78em; font-family: sans-serif; display: block; margin-top: 2px; }
.dialect    { color: #888; font-size: 0.82em; font-family: sans-serif; display: block; }
.badge-full { display: inline-block; padding: 2px 8px; background: #e8f5e9; color: #2e7d32; border-radius: 10px; font-size: 0.78em; font-family: sans-serif; font-weight: 600; white-space: nowrap; }
.badge-nt   { display: inline-block; padding: 2px 8px; background: #e3f2fd; color: #1565c0; border-radius: 10px; font-size: 0.78em; font-family: sans-serif; font-weight: 600; white-space: nowrap; }
.badge-part { display: inline-block; padding: 2px 8px; background: #fdf5e0; color: #8a6000; border-radius: 10px; font-size: 0.78em; font-family: sans-serif; font-weight: 600; white-space: nowrap; }
.mp3-link { color: #c0392b !important; font-size: 1.05em; }
.mp3-link:hover { color: #922b21 !important; }
.search-wrap { display: flex; align-items: center; gap: 10px; margin: 20px 0 6px 0; }
.search-wrap input[type="text"] { flex: 1; max-width: 380px; padding: 8px 14px; border: 1px solid #ddd; border-radius: 4px; font-size: 0.95em; font-family: sans-serif; outline: none; }
.search-wrap input[type="text"]:focus { border-color: #111; }
.result-count { font-family: sans-serif; font-size: 0.82em; color: #888; }
</style>
</head>

<body data-mobile-nav-style="classic">

<!-- NAVBAR -->
<header class="header-with-topbar">
  <nav class="navbar navbar-expand-lg top-space navbar-light bg-black header-light fixed-top navbar-boxed" style="top: 48.8px;">
    <div class="container-fluid nav-header-container">
      <div class="ps-lg-0 d-flex align-items-center" style="flex:1; min-width:0;">
        <a class="navbar-brand" href="/png/">
          <img src="https://png.bible/images/PNGBible_Logo_300.png" class="default-logo" alt="PNG Bible" height="55">
          <img src="https://png.bible/images/PNGBible_Logo_300.png" class="alt-logo"     alt="PNG Bible" width="0" height="0">
          <img src="https://png.bible/images/PNGBible_Logo_120x29.png" class="mobile-logo" alt="PNG Bible" width="0" height="0">
        </a>
      </div>
      <div class="col-auto bg-black menu-order px-lg-0">
        <button class="navbar-toggler float-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
          <span class="navbar-toggler-line"></span><span class="navbar-toggler-line"></span>
          <span class="navbar-toggler-line"></span><span class="navbar-toggler-line"></span>
        </button>
        <div class="bg-black collapse navbar-collapse justify-content-center" id="navbarNav">
          <ul class="navbar-nav alt-font">
            <li class="nav-item"><a href="/png/" class="nav-link">Welcome</a></li>
            <li class="nav-item"><a href="https://png.bible/about.php" class="nav-link">About Us</a></li>
            <li class="nav-item"><a href="https://png.bible/updates.php" class="nav-link">Updates</a></li>
            <li class="nav-item"><a href="https://png.bible/reading-offline.php" class="nav-link">Reading Offline</a></li>
            <li class="nav-item"><a href="https://png.bible/contact.php" class="nav-link">Contact</a></li>
            <li class="nav-item"><a href="https://png.bible/t/" class="nav-link">Tok Pisin</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</header>

<!-- HERO -->
<div class="hero-frame-top"></div>
<section class="p-0"><div class="page-header-hero-home-page"></div></section>
<div class="hero-frame-bottom"></div>

<!-- CONTENT -->
<section>
<div class="container slim-container">
  <div class="row">
    <div class="col-md-12">

      <h1 class="h1-main-title alt-font font-weight-600 text-extra-dark-gray w-95">Papua New Guinea Scriptures</h1>
      <p>Find the Holy Bible to read or download in the languages of Papua New Guinea — one of the most linguistically diverse countries in the world. We offer epub files, PDF files, and Bible study app formats for each translation.</p>
      <p>We offer <strong><?= $numTrans ?> Bible translations</strong> in <strong><?= $numLangs ?> languages</strong>. <strong><?= $numAudio ?></strong> of those have audio recordings. <a href="https://png.bible/t/">Tok Pisin</a> is also available.</p>

      <h2 class="alt-font font-weight-600 text-extra-dark-gray" style="font-size:1.4em; margin-top:32px;">Bible Translations</h2>

      <div class="search-wrap">
        <input type="text" id="lang-search" placeholder="Search by language or title…" oninput="filterTable()">
        <span class="result-count" id="result-count">Loading…</span>
      </div>

      <table class="translation-table" id="trans-table">
        <thead>
          <tr>
            <th>Language</th>
            <th>Title</th>
            <th>Year</th>
            <th></th>
            <th><i class="fa fa-volume-up" title="Audio"></i></th>
          </tr>
        </thead>
        <tbody id="trans-body">
<?php while ($row = mysqli_fetch_assoc($listR)):
    $id      = $row['translationId'];
    $lang    = $row['languageName'] ?: $row['languageNameInEnglish'];
    $dialect = ($row['dialect'] && $row['dialect'] !== $lang) ? $row['dialect'] : '';
    $title   = $row['vernacularTitle'];
    $short   = $row['shortTitle'];
    $year    = htmlspecialchars($row['copyrightYears']);
    $badge   = coverageBadge((int)$row['otBookCount'], (int)$row['ntBookCount'], (int)$row['adBookCount']);
    $url     = "https://png.bible/details.php?id=" . urlencode($id);
    $search  = strtolower(htmlspecialchars_decode($lang . ' ' . $dialect . ' ' . $short . ' ' . $title));
    $audio   = $row['hasAudio']
        ? "<a href=\"https://eBible.org/{$id}/mp3/\" class=\"mp3-link\" target=\"_blank\" title=\"Listen to audio\"><i class=\"fa fa-volume-up\"></i></a>"
        : '';
?>
<tr data-search="<?= htmlspecialchars($search) ?>"><td><a href="<?= $url ?>" target="_blank"><?= htmlspecialchars($lang) ?><?php if ($dialect): ?><span class="dialect"><?= htmlspecialchars($dialect) ?></span><?php endif; ?></a></td><td><a href="<?= $url ?>" target="_blank"><?= htmlspecialchars($title) ?></a><?php if ($short && $short !== $title): ?><span class="lang-name"><?= htmlspecialchars($short) ?></span><?php endif; ?></td><td><?= $year ?></td><td class="cov-cell"><?= $badge ?></td><td class="mp3-cell"><?= $audio ?></td></tr>
<?php endwhile; ?>
        </tbody>
      </table>
      <p id="no-results" style="display:none; font-family:sans-serif; color:#888; margin-top:16px;">No translations found matching your search.</p>

    </div>
  </div>
</div>
</section>

<!-- FOOTER -->
<footer class="footer-dark bg-black padding-slim-top">
  <div class="footer-top padding-40px-tb border-bottom border-color-white-transparent">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 col-md-3 text-center text-md-start sm-margin-20px-bottom">
          <img class="circle-black-bg" src="https://png.bible/images/papua-new-guinea-map-flag.png" alt="Papua New Guinea flag" width="75" height="75">
        </div>
        <div class="col-12 col-md-6 text-center sm-margin-20px-bottom">
          <span class="alt-font font-weight-500 d-inline-block align-middle margin-5px-right text-white">
            <p>This site is posted for the people of Papua New Guinea by <a href="https://eBible.org/">eBible.org</a>.<br>
            See each Bible translation's information page for copyright and permissions information.<br>
            <a href="https://eBible.org/privacy.php">Privacy Policy</a> &nbsp;&nbsp; <a href="https://eBible.org/legal.php">Legal Notices</a></p>
          </span>
        </div>
        <div class="col-12 col-md-3 text-center text-md-end"></div>
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
    var text = row.getAttribute("data-search") || "";
    var match = !q || text.indexOf(q) !== -1;
    row.style.display = match ? "" : "none";
    if (match) shown++;
  });
  var total = rows.length;
  var countEl = document.getElementById("result-count");
  countEl.textContent = !q ? "Showing all " + total + " translations" : shown + " of " + total + " translations";
  document.getElementById("no-results").style.display = (shown === 0) ? "" : "none";
}
document.addEventListener("DOMContentLoaded", function() {
  var total = document.querySelectorAll("#trans-body tr").length;
  document.getElementById("result-count").textContent = "Showing all " + total + " translations";
});
</script>
</body>
</html>
