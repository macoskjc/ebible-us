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
          WHERE redistributable=1 AND countryCode='VU'";
$cntR = mysqli_query($link, $cntQ);
[$numTrans, $numLangs] = mysqli_fetch_row($cntR);

$listQ = "SELECT translationId, languageName, languageNameInEnglish, dialect,
                 vernacularTitle, shortTitle, copyrightYears,
                 otBookCount, ntBookCount, adBookCount
          FROM sofia.bible_list
          WHERE redistributable=1 AND countryCode='VU'
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
<title>Baebol.org — Vanuatu Bibles</title>
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="/css/font-icons.min.css">
<link rel="stylesheet" type="text/css" href="/css/theme-vendors.min.css">
<link rel="stylesheet" type="text/css" href="/css/style.css" />
<link rel="stylesheet" type="text/css" href="/css/custom.css" />
<link rel="stylesheet" type="text/css" href="/css/responsive.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.page-header-hero-generic, .page-header-hero-home-page {
  background-image: url("VanuatuHero.jpg") !important;
  background-repeat: no-repeat !important;
  background-position: center center !important;
  background-size: cover !important;
}
.trans-table { width: 100%; border-collapse: collapse; margin-top: 24px; font-family: sans-serif; font-size: 0.9em; }
.trans-table thead tr { background: #111; color: #fff; }
.trans-table thead th { padding: 10px 14px; text-align: left; font-weight: 600; letter-spacing: 0.04em; font-size: 0.82em; text-transform: uppercase; }
.trans-table tbody tr { border-bottom: 1px solid #eee; transition: background 0.1s; }
.trans-table tbody tr:hover { background: #f7f7f7; }
.trans-table td { padding: 10px 14px; vertical-align: middle; color: #333; }
.trans-table td a { color: #333; text-decoration: none; font-weight: 600; }
.trans-table td a:hover { text-decoration: underline; }
.lang-cell { font-size: 0.85em; color: #555; }
.year-cell { font-size: 0.82em; color: #888; white-space: nowrap; }
.badge-full { display: inline-block; padding: 2px 8px; background: #e8f5e9; color: #2e7d32; border-radius: 10px; font-size: 0.75em; font-weight: 700; letter-spacing: 0.03em; white-space: nowrap; }
.badge-nt   { display: inline-block; padding: 2px 8px; background: #e3f2fd; color: #1565c0; border-radius: 10px; font-size: 0.75em; font-weight: 700; letter-spacing: 0.03em; white-space: nowrap; }
.badge-part { display: inline-block; padding: 2px 8px; background: #fdf5e0; color: #8a6000; border-radius: 10px; font-size: 0.75em; font-weight: 700; letter-spacing: 0.03em; white-space: nowrap; }
.section-intro { font-family: sans-serif; font-size: 0.9em; color: #555; line-height: 1.7; margin-bottom: 8px; }
.lang-bislama { font-style: italic; color: #666; }
</style>
</head>

<body data-mobile-nav-style="classic">

<!-- NAVBAR -->
<header class="header-with-topbar">
  <nav class="navbar navbar-expand-lg top-space navbar-light bg-black header-light fixed-top navbar-boxed" style="top:48.8px;">
    <div class="container-fluid nav-header-container">
      <div class="ps-lg-0 d-flex align-items-center" style="flex:1;min-width:0;">
        <a class="navbar-brand" href="/baebol/">
          <img src="https://baebol.org/images/VanuatuBibles300.png" data-at2x="https://baebol.org/images/VanuatuBibles300.png" class="default-logo" alt="Vanuatu Bibles" height="42">
          <img src="https://baebol.org/images/VanuatuBibles300.png" data-at2x="https://baebol.org/images/VanuatuBibles300.png" class="alt-logo" alt="Vanuatu Bibles" width="0" height="0">
          <img src="https://baebol.org/images/VanuatuBibles120.png" data-at2x="https://baebol.org/images/VanuatuBibles120.png" class="mobile-logo" alt="Vanuatu Bibles" width="0" height="0">
        </a>
      </div>
      <div class="col-auto bg-black menu-order px-lg-0">
        <button class="navbar-toggler float-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
          <span class="navbar-toggler-line"></span><span class="navbar-toggler-line"></span>
          <span class="navbar-toggler-line"></span><span class="navbar-toggler-line"></span>
        </button>
        <div class="bg-black collapse navbar-collapse justify-content-center" id="navbarNav">
          <ul class="navbar-nav alt-font">
            <li class="nav-item"><a href="/baebol/" class="nav-link">Bibles</a></li>
            <li class="nav-item"><a href="https://baebol.org/christmas.php" class="nav-link">Christmas / Noël</a></li>
            <li class="nav-item"><a href="https://baebol.org/about.php" class="nav-link">About / À propos</a></li>
            <li class="nav-item"><a href="https://baebol.org/reading-offline.php" class="nav-link">Offline / Hors ligne</a></li>
            <li class="nav-item"><a href="https://ebible.org/cgi-bin/contact.cgi?vu" class="nav-link">Contact</a></li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
</header>

<!-- HERO -->
<div class="hero-frame-top"></div>
<section class="p-0"><div class="page-header-hero-generic"></div></section>
<div class="hero-frame-bottom"></div>

<!-- CONTENT -->
<section>
<div class="container slim-container">

  <h1 class="h1-main-title alt-font font-weight-600 text-extra-dark-gray w-95">Vanuatu Bibles</h1>

  <p class="section-intro lang-bislama">Long Websaet ia yu save karem Baebol long olgeta defdefren langwis blong Vanuatu.</p>

  <p class="section-intro">Find the Holy Bible to read or download in the languages of Vanuatu. We offer <strong><?= $numTrans ?> translations</strong> in <strong><?= $numLangs ?> languages</strong>, including downloadable ePub, PDF, and Bible study app formats for each translation.</p>

  <p class="section-intro">Trouvez la Sainte Bible à lire ou à télécharger dans les langues du Vanuatu. Nous proposons <strong><?= $numTrans ?> traductions</strong> en <strong><?= $numLangs ?> langues</strong>.</p>

  <table class="trans-table">
    <thead>
      <tr>
        <th>Language / Langue</th>
        <th>Title / Titre</th>
        <th>Year</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
<?php while ($row = mysqli_fetch_assoc($listR)):
    $id     = $row['translationId'];
    $lang   = $row['languageName'] ?: $row['languageNameInEnglish'];
    $dialect = ($row['dialect'] && $row['dialect'] !== $lang) ? $row['dialect'] : '';
    $title  = $row['vernacularTitle'];
    $short  = $row['shortTitle'];
    $year   = htmlspecialchars($row['copyrightYears']);
    $badge  = coverageBadge((int)$row['otBookCount'], (int)$row['ntBookCount'], (int)$row['adBookCount']);
    $url    = "https://ebible.org/find/details.php?id=" . urlencode($id);
?>
      <tr>
        <td><div class="lang-cell"><?= htmlspecialchars($lang) ?><?php if ($dialect): ?><br><span style="font-size:0.82em;">(<?= htmlspecialchars($dialect) ?>)</span><?php endif; ?></div></td>
        <td>
          <a href="<?= $url ?>" target="_blank"><?= htmlspecialchars($title) ?></a>
          <?php if ($short && $short !== $title): ?><br><span style="font-size:0.82em;color:#888;"><?= htmlspecialchars($short) ?></span><?php endif; ?>
        </td>
        <td class="year-cell"><?= $year ?></td>
        <td><?= $badge ?></td>
      </tr>
<?php endwhile; ?>
    </tbody>
  </table>

</div>
</section>

<!-- FOOTER -->
<footer class="footer-dark bg-black padding-slim-top">
  <div class="footer-top padding-40px-tb border-bottom border-color-white-transparent">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-12 col-md-3 text-center text-md-start sm-margin-20px-bottom">
          <img class="circle-black-bg" src="https://baebol.org/images/vu-flagsm.gif" alt="Vanuatu flag" style="max-height:80px;">
        </div>
        <div class="col-12 col-md-6 text-center sm-margin-20px-bottom">
          <span class="alt-font font-weight-500 d-inline-block align-middle margin-5px-right text-white">
            <p>Site copyright © 2009–2025 <a href="https://eBible.org/">eBible.org</a>.<br>
            See each Bible's information page for copyright and permissions.<br>
            Consultez la page de chaque Bible pour les droits d'auteur et autorisations.<br>
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
