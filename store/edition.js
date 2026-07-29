/**
 * eBible.org Store — edition detail page. Reads ?sku=<sku_id> from the
 * URL, finds the matching edition, and renders it with the large cover
 * image. Shares data/formatting/offer logic with the listing page via
 * common.js (loaded first).
 */

function yesNo(b) {
  return b ? 'Yes' : 'No';
}

function renderNotFound(sku) {
  document.getElementById('content').innerHTML = `
    <div class="not-found">
      <p>${sku ? `No edition found for "${sku}".` : 'No edition specified.'}</p>
      <p><a href="./">Back to the store</a></p>
    </div>`;
}

function renderEdition(edition) {
  document.title = `${edition.title} — eBible.org Store`;

  const imgHtml = edition.cover_image_large_url
    ? `<img src="${edition.cover_image_large_url}" alt="${edition.title} cover" onerror="this.closest('.detail-img').innerHTML='<div class=\\'no-cover\\'>Cover image<br>not available</div>'">`
    : `<div class="no-cover">Cover image<br>not available</div>`;

  const dims = mmToImperial(edition.trim_height_mm, edition.trim_width_mm, edition.thickness_mm);
  const dimsMm = edition.trim_height_mm != null
    ? `${edition.trim_height_mm} × ${edition.trim_width_mm}${edition.thickness_mm != null ? ' × ' + edition.thickness_mm : ''} mm`
    : null;

  const rows = [
    ['Translation', edition.translation_name + (edition.translation_abbrev ? ` (${edition.translation_abbrev})` : '')],
    ["What's included", EXTENT_LABELS[edition.extent] || edition.extent],
    ['Includes Deuterocanon', yesNo(edition.includes_dc)],
    ['Cover material', edition.cover_material],
    ['Binding', edition.binding_type],
    ['Print size', edition.print_size_category || '—'],
    ['Font size', edition.font_size_pt ? `${edition.font_size_pt}pt` : '—'],
    ['Trim size', dims ? `${dims} <span class="mm">(${dimsMm})</span>` : '—'],
    ['Weight', edition.weight_g != null ? `${gToOz(edition.weight_g)} oz <span class="mm">(${edition.weight_g} g)</span>` : '—'],
    ['Pages', edition.page_count || '—'],
    ['Interior', edition.color_interior],
    ['Illustrated', yesNo(edition.illustrated)],
    ['Edition year', edition.edition_year || '—'],
    ['ISBN-13', edition.isbn13 || 'No ISBN (digital-only)'],
  ];

  const offers = sellableOffers(edition.sku_id);
  const hasHiddenOnly = offers.length === 0 && (OFFERS_BY_EDITION[edition.sku_id] || []).length > 0;
  const emptyMessage = hasHiddenOnly
    ? 'Not yet linked for purchase here — check back soon.'
    : 'No retailer currently listed for this edition.';

  document.getElementById('content').innerHTML = `
    <div class="detail-wrap">
      <div class="detail-img">${imgHtml}</div>
      <div class="detail-body">
        <h1 class="detail-title">${edition.title}</h1>
        <p class="detail-family">${edition.edition_family}</p>
        <div class="badges">${badgesFor(edition).join('')}</div>
        <table class="spec-table">
          ${rows.map(([label, value]) => `<tr><td>${label}</td><td>${value}</td></tr>`).join('')}
        </table>
        ${edition.notes ? `
          <div class="detail-notes">
            <h2>Details</h2>
            <p>${edition.notes}</p>
          </div>` : ''}
        <div class="buy-section">
          <h2>Where to buy</h2>
          <div class="buy-list">${buyButtonsHtml(offers, emptyMessage)}</div>
        </div>
      </div>
    </div>`;
}

(async function init() {
  const sku = new URLSearchParams(window.location.search).get('sku');
  await loadData();
  const edition = sku ? EDITIONS.find(e => e.sku_id === sku) : null;
  if (!edition) {
    renderNotFound(sku);
    return;
  }
  renderEdition(edition);
})();
