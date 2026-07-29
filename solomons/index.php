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

// Count translations and languages for the intro blurb
$cntQ = "SELECT COUNT(*), COUNT(DISTINCT languageId)
          FROM sofia.bible_list
          WHERE redistributable=1 AND countryCode='SB'";
$cntR = mysqli_query($link, $cntQ);
[$numTrans, $numLangs] = mysqli_fetch_row($cntR);

// Fetch the full list ordered by language then year
$listQ = "SELECT translationId, languageName, languageNameInEnglish, dialect,
                 vernacularTitle, shortTitle, copyrightYears,
                 otBookCount, ntBookCount, adBookCount
          FROM sofia.bible_list
          WHERE redistributable=1 AND countryCode='SB'
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
<meta name="description" content="Bible translations in the languages of the Solomon Islands">
<meta property="og:title" content="The Holy Bible for the Solomon Islands">
<meta property="og:description" content="Bible translations in the languages of the Solomon Islands">
<meta property="og:image" content="/images/main-logo.jpg">
<title>The Holy Bible for the Solomon Islands</title>
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="/css/font-icons.min.css">
<link rel="stylesheet" type="text/css" href="/css/theme-vendors.min.css">
<link rel="stylesheet" type="text/css" href="/css/style.css" />
<link rel="stylesheet" type="text/css" href="/css/custom.css" />
<link rel="stylesheet" type="text/css" href="/css/responsive.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
/* Translation table */
.translation-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
.translation-table th { background: #111; color: #fff; padding: 10px 14px; text-align: left; font-family: sans-serif; font-size: 0.85em; letter-spacing: 0.05em; text-transform: uppercase; }
.translation-table td { padding: 10px 14px; border-bottom: 1px solid #eee; font-size: 0.95em; vertical-align: middle; }
.translation-table tr:hover td { background: #f8f8f8; }
.translation-table a { color: #1a6bbf; text-decoration: none; font-weight: 600; }
.translation-table a:hover { color: #0d47a1; }
.translation-table th:nth-child(1), .translation-table td:nth-child(1) { width: 22%; }
.translation-table th:nth-child(2), .translation-table td:nth-child(2) { width: 45%; }
.translation-table th:nth-child(3), .translation-table td:nth-child(3) { width: 18%; font-size: 0.82em; }
.translation-table th:nth-child(4), .translation-table td:nth-child(4) { width: 15%; text-align: center; }
.lang-name { color: #aaa; font-size: 0.78em; font-family: sans-serif; display: block; margin-top: 2px; }
.badge-full { display: inline-block; padding: 2px 8px; background: #e8f5e9; color: #2e7d32; border-radius: 10px; font-size: 0.8em; font-family: sans-serif; font-weight: 600; white-space: nowrap; }
.badge-nt   { display: inline-block; padding: 2px 8px; background: #e3f2fd; color: #1565c0; border-radius: 10px; font-size: 0.8em; font-family: sans-serif; font-weight: 600; white-space: nowrap; }
.badge-part { display: inline-block; padding: 2px 8px; background: #fdf5e0; color: #8a6000; border-radius: 10px; font-size: 0.8em; font-family: sans-serif; font-weight: 600; white-space: nowrap; }

/* Audio section */
.audio-section { margin-top: 40px; }
.audio-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 10px;
  margin-top: 14px;
}
.audio-card {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 14px;
  background: #f8f8f8;
  border-radius: 6px;
  border: 1px solid #eee;
  text-decoration: none !important;
  color: #222 !important;
  font-family: sans-serif;
  font-size: 0.88em;
  transition: background 0.12s;
}
.audio-card:hover { background: #eef2ff; border-color: #b8cff5; }
.audio-card .fa { color: #1a6bbf; font-size: 1.1em; flex-shrink: 0; }

/* Partner logos */
.partner-logos { display: flex; flex-wrap: wrap; align-items: center; gap: 28px; margin-top: 20px; }
.partner-logos img { max-height: 50px; max-width: 130px; object-fit: contain; filter: grayscale(30%); }
</style>
</head>

<body data-mobile-nav-style="classic">

<!-- NAVBAR -->
<header class="header-with-topbar">
  <nav class="navbar navbar-expand-lg top-space navbar-light bg-black header-light fixed-top navbar-boxed" style="top: 48.8px;">
    <div class="container-fluid nav-header-container">
      <div class="ps-lg-0 d-flex align-items-center" style="flex:1; min-width:0;">
        <a class="navbar-brand" href="/solomons/">
          <img src="/images/SolomonsBibleLogo_300.png" data-at2x="/images/SolomonsBibleLogo_300.png" class="default-logo" alt="Solomons Bible" height="60">
          <img src="/images/SolomonsBibleLogo_300.png" data-at2x="/images/SolomonsBibleLogo_300.png" class="alt-logo"    alt="Solomons Bible" width="0" height="0">
          <img src="/images/SolomonsBibleLogo_120.png" data-at2x="/images/SolomonsBibleLogo_120.png" class="mobile-logo" alt="Solomons Bible" width="0" height="0">
        </a>
      </div>
      <div class="col-auto bg-black menu-order px-lg-0">
        <button class="navbar-toggler float-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
          <span class="navbar-toggler-line"></span><span class="navbar-toggler-line"></span>
          <span class="navbar-toggler-line"></span><span class="navbar-toggler-line"></span>
        </button>
        <div class="bg-black collapse navbar-collapse justify-content-center" id="navbarNav">
          <ul class="navbar-nav alt-font">
            <li class="nav-item"><a href="/solomons/" class="nav-link">Welcome</a></li>
            <li class="nav-item"><a href="https://solomons.bible/about.php" class="nav-link">About Us</a></li>
            <li class="nav-item"><a href="https://solomons.bible/reading-offline.php" class="nav-link">Reading Offline</a></li>
            <li class="nav-item"><a href="/contact-sb.php" class="nav-link">Contact</a></li>
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

      <h1 class="h1-main-title alt-font font-weight-600 text-extra-dark-gray w-95">Solomon Islands Bibles</h1>
      <p>Find the Holy Bible to read or download in the languages of the Solomon Islands. We offer downloadable epub files, PDF files, and Bible study application file formats for each Bible translation.</p>
      <p>We offer <strong><?= $numTrans ?> Bible translations</strong> in <strong><?= $numLangs ?> languages</strong>, plus Christmas stories in audio for <strong>19 languages</strong>.</p>

      <h2 class="alt-font font-weight-600 text-extra-dark-gray" style="font-size:1.4em; margin-top:32px;">Bible Translations</h2>

      <table class="translation-table">
        <thead>
          <tr>
            <th>Language</th>
            <th>Title</th>
            <th>Year</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
<?php while ($row = mysqli_fetch_assoc($listR)):
    $id      = $row['translationId'];
    $lang    = $row['languageName'] ?: $row['languageNameInEnglish'];
    if ($row['dialect'] && $row['dialect'] !== $lang) $lang = $row['dialect'];
    $title   = htmlspecialchars($row['vernacularTitle']);
    $short   = htmlspecialchars($row['shortTitle']);
    $year    = htmlspecialchars($row['copyrightYears']);
    $badge   = coverageBadge((int)$row['otBookCount'], (int)$row['ntBookCount'], (int)$row['adBookCount']);
    $url     = "https://solomons.bible/details.php?id=" . urlencode($id);
?>
          <tr>
            <td><a href="<?= $url ?>" target="_blank"><?= htmlspecialchars($lang) ?></a></td>
            <td>
              <a href="<?= $url ?>" target="_blank"><?= $title ?></a>
              <?php if ($short && $short !== $row['vernacularTitle']): ?>
                <span class="lang-name"><?= $short ?></span>
              <?php endif; ?>
            </td>
            <td><?= $year ?></td>
            <td><?= $badge ?></td>
          </tr>
<?php endwhile; ?>
        </tbody>
      </table>

      <hr style="margin: 44px 0; border-color: #ddd;">

      <!-- Christmas stories -->
      <div class="audio-section">
        <h2 class="alt-font font-weight-600 text-extra-dark-gray" style="font-size:1.4em;">Christmas Story Recordings</h2>
        <p style="font-family:sans-serif; font-size:0.9em; color:#555;">Luke chapters 1 and 2 — the story of the birth of Jesus — recorded in 19 Solomon Islands languages.</p>
        <div class="audio-grid">
          <a href="https://solomons.bible/alu/Are'are Christmas Story.mp3" class="audio-card"><i class="fa fa-volume-up"></i> Are'are</a>
          <a href="https://solomons.bible/bvd/Baegu Christmas Story.mp3"   class="audio-card"><i class="fa fa-volume-up"></i> Baegu</a>
          <a href="https://solomons.bible/bgt/Bughotu Christmas Story.mp3" class="audio-card"><i class="fa fa-volume-up"></i> Bughotu</a>
          <a href="https://solomons.bible/mrn/Cheke Holo.mp3"              class="audio-card"><i class="fa fa-volume-up"></i> Cheke Holo</a>
          <a href="https://solomons.bible/far/Fataleka Christmas Story.mp3" class="audio-card"><i class="fa fa-volume-up"></i> Fataleka</a>
          <a href="https://solomons.bible/gga/Gao Christmas Story.mp3"     class="audio-card"><i class="fa fa-volume-up"></i> Gao</a>
          <a href="https://solomons.bible/nlg/Gela Christmas Story.mp3"    class="audio-card"><i class="fa fa-volume-up"></i> Gela</a>
          <a href="https://solomons.bible/gri/Ghari Christmas Story.mp3"   class="audio-card"><i class="fa fa-volume-up"></i> Ghari</a>
          <a href="https://solomons.bible/kwd/Kwaio Christmas Story.mp3"   class="audio-card"><i class="fa fa-volume-up"></i> Kwaio</a>
          <a href="https://solomons.bible/kwf/Kwara_ae Christmas Story.mp3" class="audio-card"><i class="fa fa-volume-up"></i> Kwara'ae</a>
          <a href="https://solomons.bible/mln/Malango Christmas Story.mp3" class="audio-card"><i class="fa fa-volume-up"></i> Malango</a>
          <a href="https://solomons.bible/ojv/Ontong Java Christmas Story.mp3" class="audio-card"><i class="fa fa-volume-up"></i> Ontong Java</a>
          <a href="https://solomons.bible/stn/Owa Christmas Story.mp3"     class="audio-card"><i class="fa fa-volume-up"></i> Owa</a>
          <a href="https://solomons.bible/pis/Pijin Christmas Story.mp3"   class="audio-card"><i class="fa fa-volume-up"></i> Pijin</a>
          <a href="https://solomons.bible/mnv/Rennell-Bellona Christmas Story.mp3" class="audio-card"><i class="fa fa-volume-up"></i> Rennell-Bellona</a>
          <a href="https://solomons.bible/rug/Roviana Christmas Story.mp3" class="audio-card"><i class="fa fa-volume-up"></i> Roviana</a>
          <a href="https://solomons.bible/apb/Sa_a Christmas Story.mp3"    class="audio-card"><i class="fa fa-volume-up"></i> Sa'a</a>
          <a href="https://solomons.bible/tkp/Tikopia Christmas Story.mp3" class="audio-card"><i class="fa fa-volume-up"></i> Tikopia</a>
          <a href="https://solomons.bible/lgl/Wala Christmas Story.mp3"    class="audio-card"><i class="fa fa-volume-up"></i> Wala</a>
        </div>
      </div>

      <hr style="margin: 44px 0; border-color: #ddd;">

      <h2 class="alt-font font-weight-600 text-extra-dark-gray" style="font-size:1.4em;">Partners</h2>
      <div class="partner-logos">
        <a href="https://eBible.org/"><img src="https://solomons.bible/eBibleorg.png" alt="eBible.org"></a>
        <a href="https://crosswire.org/"><img src="https://solomons.bible/crosswire.jpg" alt="Crosswire Bible Society"></a>
        <a href="https://www.unitedbiblesocieties.org/"><img src="https://solomons.bible/biblesociety.png" alt="United Bible Societies"></a>
        <a href="http://isles-of-the-sea.org/"><img src="https://solomons.bible/islesofthesea.png" alt="Isles of the Sea"></a>
        <a href="https://www.wycliffe.net/en/"><img src="https://solomons.bible/WBT_logo.gif" alt="Wycliffe Global Alliance"></a>
        <a href="https://islandsbibleministries.org/"><img src="/images/IslandsBibleMinistries.jpg" alt="Islands Bible Ministries"></a>
      </div>

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
          <img class="circle-black-bg" src="/images/Flag_of_the_Solomon_Islands.jpg" alt="Solomon Islands flag">
        </div>
        <div class="col-12 col-md-6 text-center sm-margin-20px-bottom">
          <span class="alt-font font-weight-500 d-inline-block align-middle margin-5px-right text-white">
            <p>This site is posted for the people of the Solomon Islands by <a href="https://eBible.org/">eBible.org</a>.<br>
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
</body>
</html>
