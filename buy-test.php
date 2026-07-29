<?php
// ── Product data ─────────────────────────────────────────────────────────────
// edition:  classic | updated | british
// subset:   66 | ecumenical | nt | ntpp | apocrypha
// cover:    paperback | hardcover | leather
$products = [
  [
    'title'   => 'World English Bible',
    'detail'  => 'Color, Red Letter Edition',
    'edition' => 'classic',
    'subset'  => '66',
    'cover'   => 'paperback',
    'isbn'    => '978-1-63656-003-8',
    'image'   => '978-1-63656-003-8covertn.jpg',
    'links'   => [['label'=>'Amazon','url'=>'https://www.amazon.com/dp/1636560032']],
  ],
  [
    'title'   => 'World English Bible',
    'detail'  => 'Color, Red Letter Edition',
    'edition' => 'classic',
    'subset'  => '66',
    'cover'   => 'hardcover',
    'isbn'    => '978-1-63656-015-1',
    'image'   => '978-1-63656-015-1covertn.jpg',
    'links'   => [['label'=>'Amazon','url'=>'https://www.amazon.com/dp/1636560156']],
  ],
  [
    'title'   => 'World English Bible',
    'detail'  => 'U.S.A. Spelling',
    'edition' => 'updated',
    'subset'  => '66',
    'cover'   => 'paperback',
    'isbn'    => '978-1-63656-020-5',
    'image'   => '978-1-63656-020-5covertn.jpg',
    'links'   => [['label'=>'Amazon','url'=>'https://www.amazon.com/dp/1636560202']],
  ],
  [
    'title'   => 'World English Bible',
    'detail'  => 'U.S.A. Spelling, Flexible recycled leather cover',
    'edition' => 'updated',
    'subset'  => '66',
    'cover'   => 'leather',
    'isbn'    => '978-1-63656-001-4',
    'image'   => '978-1-63656-000-7covertn.jpg',
    'links'   => [['label'=>'Broken Yoke Publishing','url'=>'https://brokenyokepublishing.com/']],
  ],
  [
    'title'   => 'World English Bible',
    'detail'  => 'British/International Spelling',
    'edition' => 'british',
    'subset'  => '66',
    'cover'   => 'paperback',
    'isbn'    => '978-1-63656-021-2',
    'image'   => '978-1-63656-021-2covertn.jpg',
    'links'   => [['label'=>'Amazon','url'=>'https://www.amazon.com/dp/1636560210']],
  ],
  [
    'title'   => 'World English Bible Ecumenical Edition',
    'detail'  => 'U.S.A. Spelling, Flexible recycled leather cover',
    'edition' => 'updated',
    'subset'  => 'ecumenical',
    'cover'   => 'leather',
    'isbn'    => '978-1-63656-022-9',
    'image'   => '978-1-63656-022-9covertn.jpg',
    'links'   => [
      ['label'=>'Broken Yoke Publishing','url'=>'https://brokenyokepublishing.com/'],
      ['label'=>'shop.eBible.org','url'=>'https://shop.ebible.org/'],
    ],
  ],
  [
    'title'   => 'World English Bible Ecumenical Edition',
    'detail'  => 'U.S.A. Spelling',
    'edition' => 'updated',
    'subset'  => 'ecumenical',
    'cover'   => 'hardcover',
    'isbn'    => '978-1-63656-028-1',
    'image'   => '978-1-63656-011-3covertn.jpg',
    'links'   => [['label'=>'shop.eBible.org','url'=>'https://shop.ebible.org/']],
  ],
  [
    'title'   => 'World English Bible Ecumenical Edition',
    'detail'  => 'U.S.A. Spelling',
    'edition' => 'updated',
    'subset'  => 'ecumenical',
    'cover'   => 'paperback',
    'isbn'    => '978-1-63656-029-8',
    'image'   => '029-8.jpg',
    'links'   => [['label'=>'shop.eBible.org','url'=>'https://shop.ebible.org/']],
  ],
  [
    'title'   => 'World English Bible Ecumenical Edition',
    'detail'  => 'U.S.A. Spelling',
    'edition' => 'updated',
    'subset'  => 'ecumenical',
    'cover'   => 'hardcover',
    'isbn'    => '978-1-63656-011-3',
    'image'   => '978-1-63656-011-3covertn.jpg',
    'links'   => [['label'=>'Amazon','url'=>'https://www.amazon.com/dp/1636560113']],
  ],
  [
    'title'   => 'World English Bible Ecumenical Edition',
    'detail'  => 'U.S.A. Spelling',
    'edition' => 'updated',
    'subset'  => 'ecumenical',
    'cover'   => 'paperback',
    'isbn'    => '978-1-63656-012-0',
    'image'   => '978-1-63656-012-0covertn.jpg',
    'links'   => [['label'=>'Amazon','url'=>'https://www.amazon.com/dp/1636560121']],
  ],
  [
    'title'   => 'World English Bible Ecumenical Edition',
    'detail'  => 'British/International Spelling',
    'edition' => 'british',
    'subset'  => 'ecumenical',
    'cover'   => 'hardcover',
    'isbn'    => '978-1-63656-013-7',
    'image'   => '978-1-63656-013-7covertn.jpg',
    'links'   => [['label'=>'Amazon','url'=>'https://www.amazon.com/dp/1636560130']],
  ],
  [
    'title'   => 'World English Bible Ecumenical Edition',
    'detail'  => 'British/International Spelling',
    'edition' => 'british',
    'subset'  => 'ecumenical',
    'cover'   => 'paperback',
    'isbn'    => '978-1-63656-014-4',
    'image'   => '978-1-63656-014-4covertn.jpg',
    'links'   => [['label'=>'Amazon','url'=>'https://www.amazon.com/dp/1636560148']],
  ],
  [
    'title'   => 'New Testament + Psalms &amp; Proverbs',
    'detail'  => 'U.S.A. Spelling',
    'edition' => 'updated',
    'subset'  => 'ntpp',
    'cover'   => 'hardcover',
    'isbn'    => '978-1-63656-007-6',
    'image'   => '978-1-63656-007-6covertn.jpg',
    'links'   => [['label'=>'Amazon','url'=>'https://www.amazon.com/dp/1636560075']],
  ],
  [
    'title'   => 'New Testament + Psalms &amp; Proverbs',
    'detail'  => 'U.S.A. Spelling',
    'edition' => 'updated',
    'subset'  => 'ntpp',
    'cover'   => 'paperback',
    'isbn'    => '978-1-63656-008-3',
    'image'   => '978-1-63656-008-3covertn.jpg',
    'links'   => [['label'=>'Amazon','url'=>'https://www.amazon.com/dp/1636560083']],
  ],
  [
    'title'   => 'New Testament + Psalms &amp; Proverbs',
    'detail'  => 'British/International Spelling',
    'edition' => 'british',
    'subset'  => 'ntpp',
    'cover'   => 'hardcover',
    'isbn'    => '978-1-63656-009-0',
    'image'   => '978-1-63656-009-0covertn.jpg',
    'links'   => [['label'=>'Amazon','url'=>'https://www.amazon.com/dp/1636560091']],
  ],
  [
    'title'   => 'New Testament + Psalms &amp; Proverbs',
    'detail'  => 'British/International Spelling',
    'edition' => 'british',
    'subset'  => 'ntpp',
    'cover'   => 'paperback',
    'isbn'    => '978-1-63656-010-6',
    'image'   => '978-1-63656-010-6covertn.jpg',
    'links'   => [['label'=>'Amazon','url'=>'https://www.amazon.com/dp/1636560105']],
  ],
  [
    'title'   => 'New Testament',
    'detail'  => 'Large Print, U.S.A. Spelling',
    'edition' => 'updated',
    'subset'  => 'nt',
    'cover'   => 'paperback',
    'isbn'    => '978-1-63656-017-5',
    'image'   => '978-1-63656-017-5covertn.jpg',
    'links'   => [['label'=>'Amazon','url'=>'https://www.amazon.com/dp/1636560172']],
  ],
  [
    'title'   => 'Deuterocanon &amp; Apocrypha',
    'detail'  => 'U.S.A. Spelling',
    'edition' => 'updated',
    'subset'  => 'apocrypha',
    'cover'   => 'hardcover',
    'isbn'    => '978-1-63656-004-5',
    'image'   => 'dc+acover100.png',
    'links'   => [['label'=>'Amazon','url'=>'https://www.amazon.com/dp/1636560040']],
  ],
  [
    'title'   => 'Deuterocanon &amp; Apocrypha',
    'detail'  => 'U.S.A. Spelling',
    'edition' => 'updated',
    'subset'  => 'apocrypha',
    'cover'   => 'paperback',
    'isbn'    => '978-1-63656-005-2',
    'image'   => '978-1-63656-005-2covertn.jpg',
    'links'   => [['label'=>'Amazon','url'=>'https://www.amazon.com/dp/1636560059']],
  ],
];

// ── Filter from GET ───────────────────────────────────────────────────────────
$valid_editions = ['','classic','updated','british'];
$valid_subsets  = ['','66','ecumenical','nt','ntpp','apocrypha'];
$valid_covers   = ['','paperback','hardcover','leather'];

$f_edition = in_array($_GET['edition'] ?? '', $valid_editions) ? ($_GET['edition'] ?? '') : '';
$f_subset  = in_array($_GET['subset']  ?? '', $valid_subsets)  ? ($_GET['subset']  ?? '') : '';
$f_cover   = in_array($_GET['cover']   ?? '', $valid_covers)   ? ($_GET['cover']   ?? '') : '';

$filtered = array_filter($products, function($p) use ($f_edition, $f_subset, $f_cover) {
  if ($f_edition && $p['edition'] !== $f_edition) return false;
  if ($f_subset  && $p['subset']  !== $f_subset)  return false;
  if ($f_cover   && $p['cover']   !== $f_cover)   return false;
  return true;
});

// ── Label maps ────────────────────────────────────────────────────────────────
$edition_labels = [
  'classic'  => 'Classic',
  'updated'  => 'Updated',
  'british'  => 'British/International',
];
$subset_labels = [
  '66'         => 'Old &amp; New Testaments (66 books)',
  'ecumenical' => 'Ecumenical Edition (with Deuterocanon)',
  'nt'         => 'New Testament only',
  'ntpp'       => 'New Testament + Psalms &amp; Proverbs',
  'apocrypha'  => 'Apocrypha / Deuterocanon only',
];
$cover_labels = [
  'paperback'  => 'Paperback',
  'hardcover'  => 'Hardcover',
  'leather'    => 'Flexible recycled leather cover',
];
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Buy a Printed Bible — eBible.us (prototype)</title>
<style>
  *, *::before, *::after { box-sizing: border-box; }
  body { font-family: Georgia, serif; background: #f8f7f4; color: #222; margin: 0; padding: 0; }
  header { background: #1a3a5c; color: #fff; padding: 1.2rem 2rem; }
  header h1 { margin: 0; font-size: 1.6rem; }
  header p  { margin: .25rem 0 0; font-size: .9rem; opacity: .8; }
  .prototype-banner {
    background: #fff3cd; border-bottom: 2px solid #ffc107;
    padding: .6rem 2rem; font-size: .85rem; color: #856404;
  }

  /* ── Filters ── */
  .filters {
    background: #fff; border-bottom: 1px solid #ddd;
    padding: 1rem 2rem; display: flex; flex-wrap: wrap; gap: 1rem; align-items: flex-end;
  }
  .filter-group { display: flex; flex-direction: column; gap: .3rem; }
  .filter-group label { font-size: .75rem; font-weight: bold; text-transform: uppercase;
    letter-spacing: .05em; color: #555; }
  .filter-group select {
    padding: .4rem .7rem; border: 1px solid #bbb; border-radius: 4px;
    font-size: .9rem; background: #fff; min-width: 200px;
  }
  .filter-group select:focus { outline: 2px solid #1a3a5c; }
  .btn-reset {
    padding: .4rem 1rem; background: #1a3a5c; color: #fff; border: none;
    border-radius: 4px; cursor: pointer; font-size: .9rem; align-self: flex-end;
  }
  .btn-reset:hover { background: #274f7a; }
  .result-count { align-self: flex-end; font-size: .85rem; color: #666; margin-left: auto; }

  /* ── Grid ── */
  .grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1.5rem;
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
  }
  .card {
    background: #fff; border: 1px solid #ddd; border-radius: 6px;
    overflow: hidden; display: flex; flex-direction: column;
    transition: box-shadow .15s;
  }
  .card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.12); }
  .card-img {
    background: #eee; text-align: center; padding: 1rem;
    border-bottom: 1px solid #eee;
  }
  .card-img img { max-height: 160px; max-width: 100%; object-fit: contain; }
  .card-body { padding: .9rem 1rem 1rem; flex: 1; display: flex; flex-direction: column; }
  .card-title { font-size: .95rem; font-weight: bold; margin: 0 0 .25rem; line-height: 1.3; }
  .card-detail { font-size: .82rem; color: #555; margin: 0 0 .6rem; }
  .badges { display: flex; flex-wrap: wrap; gap: .3rem; margin-bottom: .7rem; }
  .badge {
    font-size: .7rem; padding: .15rem .45rem; border-radius: 3px;
    font-family: sans-serif; font-weight: 600; text-transform: uppercase; letter-spacing: .03em;
  }
  .badge-edition { background: #dbeafe; color: #1e40af; }
  .badge-subset  { background: #dcfce7; color: #166534; }
  .badge-cover   { background: #fef3c7; color: #92400e; }
  .card-isbn { font-size: .75rem; color: #888; margin: 0 0 .8rem; font-family: monospace; }
  .card-links { margin-top: auto; display: flex; flex-direction: column; gap: .4rem; }
  .btn-buy {
    display: block; text-align: center; padding: .45rem .6rem;
    background: #1a3a5c; color: #fff; text-decoration: none;
    border-radius: 4px; font-size: .82rem; font-family: sans-serif;
    transition: background .15s;
  }
  .btn-buy:hover { background: #274f7a; }

  /* ── Empty state ── */
  .empty { text-align: center; padding: 4rem 2rem; color: #888; }
  .empty p { font-size: 1.1rem; }

  footer { text-align: center; padding: 2rem; font-size: .8rem; color: #999; border-top: 1px solid #ddd; }
</style>
</head>
<body>

<header>
  <h1>Buy a Printed World English Bible</h1>
  <p>Printed editions available from Amazon, Broken Yoke Publishing, and shop.eBible.org</p>
</header>

<div class="prototype-banner">
  ⚠ This is a <strong>prototype</strong> for review by Michael Johnson — not yet the live buy page.
  Product data is hard-coded here; the final version will be database-driven.
</div>

<form class="filters" method="get">
  <div class="filter-group">
    <label for="f-edition">Edition</label>
    <select id="f-edition" name="edition" onchange="this.form.submit()">
      <option value="">All editions</option>
      <option value="classic"  <?= $f_edition==='classic'  ?'selected':'' ?>>Classic</option>
      <option value="updated"  <?= $f_edition==='updated'  ?'selected':'' ?>>Updated</option>
      <option value="british"  <?= $f_edition==='british'  ?'selected':'' ?>>British / International</option>
    </select>
  </div>

  <div class="filter-group">
    <label for="f-subset">Content</label>
    <select id="f-subset" name="subset" onchange="this.form.submit()">
      <option value="">All content</option>
      <option value="66"        <?= $f_subset==='66'        ?'selected':'' ?>>Old &amp; New Testaments (66 books)</option>
      <option value="ecumenical"<?= $f_subset==='ecumenical'?'selected':'' ?>>Ecumenical Edition (with Deuterocanon)</option>
      <option value="nt"        <?= $f_subset==='nt'        ?'selected':'' ?>>New Testament only</option>
      <option value="ntpp"      <?= $f_subset==='ntpp'      ?'selected':'' ?>>New Testament + Psalms &amp; Proverbs</option>
      <option value="apocrypha" <?= $f_subset==='apocrypha' ?'selected':'' ?>>Apocrypha / Deuterocanon only</option>
    </select>
  </div>

  <div class="filter-group">
    <label for="f-cover">Cover</label>
    <select id="f-cover" name="cover" onchange="this.form.submit()">
      <option value="">All cover types</option>
      <option value="paperback" <?= $f_cover==='paperback' ?'selected':'' ?>>Paperback</option>
      <option value="hardcover" <?= $f_cover==='hardcover' ?'selected':'' ?>>Hardcover</option>
      <option value="leather"   <?= $f_cover==='leather'   ?'selected':'' ?>>Flexible recycled leather cover</option>
    </select>
  </div>

  <?php if ($f_edition || $f_subset || $f_cover): ?>
    <a href="buy-test.php" class="btn-reset">Clear filters</a>
  <?php endif; ?>

  <span class="result-count"><?= count($filtered) ?> edition<?= count($filtered)!==1?'s':'' ?> found</span>
</form>

<?php if (count($filtered) === 0): ?>
  <div class="empty">
    <p>No editions match those filters.</p>
    <p><a href="buy-test.php">Clear all filters</a></p>
  </div>
<?php else: ?>
<div class="grid">
  <?php foreach ($filtered as $p): ?>
  <div class="card">
    <div class="card-img">
      <img src="/<?= htmlspecialchars($p['image']) ?>"
           alt="<?= $p['title'] ?> cover"
           onerror="this.style.display='none'">
    </div>
    <div class="card-body">
      <div class="card-title"><?= $p['title'] ?></div>
      <div class="card-detail"><?= $p['detail'] ?></div>
      <div class="badges">
        <span class="badge badge-edition"><?= $edition_labels[$p['edition']] ?></span>
        <span class="badge badge-subset"><?= strip_tags($subset_labels[$p['subset']]) ?></span>
        <span class="badge badge-cover"><?= $cover_labels[$p['cover']] ?></span>
      </div>
      <div class="card-isbn">ISBN <?= htmlspecialchars($p['isbn']) ?></div>
      <div class="card-links">
        <?php foreach ($p['links'] as $lnk): ?>
          <a class="btn-buy" href="<?= htmlspecialchars($lnk['url']) ?>" target="_blank" rel="noopener">
            Buy at <?= htmlspecialchars($lnk['label']) ?> →
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>

<footer>
  Site copyright &copy; 2009–2026 eBible.org &nbsp;|&nbsp;
  <a href="https://ebible.org/privacy.php">Privacy Policy</a>
</footer>

</body>
</html>
