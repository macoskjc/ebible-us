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

$cntQ = "SELECT COUNT(*), COUNT(DISTINCT languageId)
          FROM sofia.bible_list
          WHERE redistributable=1 AND countryCode='ID'";
$cntR = mysqli_query($link, $cntQ);
[$numTrans, $numLangs] = mysqli_fetch_row($cntR);

$listQ = "SELECT translationId, languageName, languageNameInEnglish, dialect,
                 vernacularTitle, shortTitle, copyrightYears,
                 otBookCount, ntBookCount, adBookCount
          FROM sofia.bible_list
          WHERE redistributable=1 AND countryCode='ID'
          ORDER BY languageName, dialect, copyrightYears";
$listR = mysqli_query($link, $listQ);
if (!$listR) die("Database query failed: " . mysqli_error($link));
?>
<!DOCTYPE html>
<html class="no-js" lang="id">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
<meta name="description" content="Alkitab — Baca Alkitab dalam berbagai bahasa daerah Indonesia">
<title>Alkitab — e-Alkitab.org &amp; Alkitab.pw</title>
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="/css/font-icons.min.css">
<link rel="stylesheet" type="text/css" href="/css/theme-vendors.min.css">
<link rel="stylesheet" type="text/css" href="/css/style.css" />
<link rel="stylesheet" type="text/css" href="/css/custom.css" />
<link rel="stylesheet" type="text/css" href="/css/responsive.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.trans-table { width:100%; border-collapse:collapse; margin-top:16px; font-family:sans-serif; font-size:0.9em; }
.trans-table thead tr { background:#111; color:#fff; }
.trans-table thead th { padding:10px 14px; text-align:left; font-weight:600; letter-spacing:0.04em; font-size:0.82em; text-transform:uppercase; }
.trans-table tbody tr { border-bottom:1px solid #eee; transition:background 0.1s; }
.trans-table tbody tr:hover { background:#f7f7f7; }
.trans-table td { padding:9px 14px; vertical-align:middle; color:#333; }
.trans-table td a { color:#333; text-decoration:none; font-weight:600; }
.trans-table td a:hover { text-decoration:underline; }
.badge-full { display:inline-block; padding:2px 8px; background:#e8f5e9; color:#2e7d32; border-radius:10px; font-size:0.75em; font-weight:700; white-space:nowrap; }
.badge-nt   { display:inline-block; padding:2px 8px; background:#e3f2fd; color:#1565c0; border-radius:10px; font-size:0.75em; font-weight:700; white-space:nowrap; }
.badge-part { display:inline-block; padding:2px 8px; background:#fdf5e0; color:#8a6000; border-radius:10px; font-size:0.75em; font-weight:700; white-space:nowrap; }
.search-bar { margin:24px 0 8px 0; display:flex; align-items:center; gap:12px; flex-wrap:wrap; }
.search-bar input { padding:8px 14px; border:1px solid #ccc; border-radius:4px; font-size:0.95em; width:280px; font-family:sans-serif; outline:none; }
.search-bar input:focus { border-color:#888; }
.result-count { font-family:sans-serif; font-size:0.82em; color:#888; }
.intro-text { font-family:sans-serif; font-size:0.95em; color:#555; line-height:1.75; max-width:680px; margin-bottom:8px; }
</style>
</head>

<body data-mobile-nav-style="classic">

<!-- NAVBAR -->
<header class="header-with-topbar">
  <nav class="navbar navbar-expand-lg top-space navbar-light bg-black header-light fixed-top navbar-boxed" style="top:48.8px;">
    <div class="container-fluid nav-header-container">
      <div class="ps-lg-0 d-flex align-items-center" style="flex:1;min-width:0;">
        <a class="navbar-brand" href="/alkitab/">
          <span style="color:#fff; font-size:1.4em; font-family:serif; font-weight:700; letter-spacing:0.02em;">Alkitab</span>
        </a>
      </div>
      <div class="col-auto bg-black menu-order px-lg-0">
        <button class="navbar-toggler float-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
          <span class="navbar-toggler-line"></span><span class="navbar-toggler-line"></span>
          <span class="navbar-toggler-line"></span><span class="navbar-toggler-line"></span>
        </button>
        <div class="bg-black collapse navbar-collapse justify-content-center" id="navbarNav">
          <ul class="navbar-nav alt-font">
            <li class="nav-item"><a href="/alkitab/" class="nav-link">Rumah</a></li>
            <li class="nav-item"><a href="https://alkitab.pw/terms.php" class="nav-link">Syarat Penggunaan</a></li>
            <li class="nav-item"><a href="https://alkitab.pw/contact.php" class="nav-link">Hubungi Kami</a></li>
            <li class="nav-item"><a href="https://eBible.org/" class="nav-link">eBible.org</a></li>
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

  <h1 class="h1-main-title alt-font font-weight-600 text-extra-dark-gray w-95">Alkitab</h1>
  <p class="intro-text">Situs ini memungkinkan Anda membaca Alkitab dalam berbagai bahasa daerah Indonesia. Silakan pilih bahasa di bawah ini.</p>
  <p class="intro-text">This site provides access to the Holy Bible in the regional languages of Indonesia — <strong><?= $numTrans ?> translations</strong> in <strong><?= $numLangs ?> languages</strong>. "Alkitab" (الكتاب) means "The Book" — a word shared across the Indonesian archipelago.</p>

  <div class="search-bar">
    <input type="text" id="lang-search" placeholder="Cari bahasa atau judul… / Search language or title…" oninput="filterTable()">
    <span class="result-count" id="result-count">Loading…</span>
  </div>

  <table class="trans-table">
    <thead>
      <tr>
        <th style="width:22%">Bahasa / Language</th>
        <th style="width:45%">Judul / Title</th>
        <th style="width:13%">Tahun / Year</th>
        <th style="width:12%">ePub</th>
        <th style="width:8%">Coverage</th>
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
    $url     = "https://alkitab.pw/" . urlencode($id);
    $epub    = "https://eBible.org/epub/" . urlencode($id) . ".epub";
    $search  = strtolower(($dialect ?: $lang) . ' ' . $title);
?>
<tr data-search="<?= htmlspecialchars($search) ?>"><td><?= htmlspecialchars($lang) ?><?php if ($dialect): ?><br><span style="font-size:0.82em;color:#888;"><?= htmlspecialchars($dialect) ?></span><?php endif; ?></td><td><a href="<?= $url ?>" target="_blank"><?= htmlspecialchars($title) ?></a><?php if ($short && $short !== $title): ?><br><span style="font-size:0.82em;color:#888;"><?= htmlspecialchars($short) ?></span><?php endif; ?></td><td><?= $year ?></td><td><a href="<?= $epub ?>" target="_blank"><i class="fa fa-download"></i> ePub</a></td><td><?= $badge ?></td></tr>
<?php endwhile; ?>
    </tbody>
  </table>
  <div id="no-results" style="display:none; font-family:sans-serif; font-size:0.9em; color:#888; padding:20px 0;">Tidak ada terjemahan yang cocok. / No translations matched.</div>

  <h2 style="font-family:sans-serif;font-size:1.05em;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:#111;border-bottom:2px solid #111;padding-bottom:6px;margin:36px 0 10px;">Sumber Lain / Related Resources</h2>
  <p class="intro-text">
    <a href="https://eBible.org/find/" target="_blank">eBible.org — lebih banyak Alkitab dalam bahasa Indonesia dan dunia</a><br>
    <a href="http://PacificBibles.org" target="_blank">PacificBibles.org — Alkitab untuk kawasan Pasifik</a><br>
    <a href="http://www.scriptureearth.org/00i-Scripture_Index.php?sortby=country&name=all" target="_blank">ScriptureEarth.org — indeks Kitab Suci dunia</a>
  </p>

</div>
</section>

<!-- FOOTER -->
<footer class="footer-dark bg-black padding-slim-top">
  <div class="footer-top padding-40px-tb border-bottom border-color-white-transparent">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 col-md-3 text-center text-md-start sm-margin-20px-bottom">
          <span style="color:#fff; font-size:1.8em; font-family:serif; font-weight:700;">Alkitab</span>
        </div>
        <div class="col-12 col-md-6 text-center sm-margin-20px-bottom">
          <span class="alt-font font-weight-500 d-inline-block align-middle margin-5px-right text-white">
            <p>e-Alkitab.org &amp; Alkitab.pw — dikelola oleh <a href="https://eBible.org/">eBible.org</a>.<br>
            <a href="https://eBible.org/privacy.php">Privacy Policy</a> &nbsp;&nbsp;
            <a href="https://eBible.org/legal.php">Legal Notices</a></p>
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
    var match = !q || (row.getAttribute("data-search") || "").indexOf(q) !== -1;
    row.style.display = match ? "" : "none";
    if (match) shown++;
  });
  var total = rows.length;
  var el = document.getElementById("result-count");
  el.textContent = q ? (shown + " / " + total) : ("Showing all " + total + " translations");
  document.getElementById("no-results").style.display = shown === 0 ? "" : "none";
}
document.addEventListener("DOMContentLoaded", function() {
  var total = document.querySelectorAll("#trans-body tr").length;
  document.getElementById("result-count").textContent = "Showing all " + total + " translations";
});
</script>
</body>
</html>
