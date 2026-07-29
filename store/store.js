/**
 * eBible.org Store — listing page: filter UI + card grid.
 * Shared data/formatting/offer logic lives in common.js (loaded first).
 */

function populateSelect(id, values, labelFn) {
  const select = document.getElementById(id);
  const seen = new Set();
  for (const v of values) {
    if (v == null || seen.has(v)) continue;
    seen.add(v);
    const opt = document.createElement('option');
    opt.value = v;
    opt.textContent = labelFn ? labelFn(v) : v;
    select.appendChild(opt);
  }
}

function initFilterOptions() {
  populateSelect('f-translation', EDITIONS.map(e => e.translation_abbrev).sort());
  populateSelect('f-extent', [...new Set(EDITIONS.map(e => e.extent))].sort(),
    (v) => EXTENT_LABELS[v] || v);
  populateSelect('f-print-size',
    [...new Set(EDITIONS.map(e => e.print_size_category).filter(Boolean))].sort());
  populateSelect('f-binding',
    [...new Set(EDITIONS.map(e => e.binding_type).filter(Boolean))].sort());
  const sellableRetailers = OFFERS.filter(o => !HIDDEN_RETAILERS.has(o.retailer)).map(o => o.retailer);
  populateSelect('f-retailer', [...new Set(sellableRetailers)].sort());
}

function currentFilters() {
  return {
    search: document.getElementById('f-search').value.trim().toLowerCase(),
    translation: document.getElementById('f-translation').value,
    extent: document.getElementById('f-extent').value,
    printSize: document.getElementById('f-print-size').value,
    binding: document.getElementById('f-binding').value,
    retailer: document.getElementById('f-retailer').value,
    priceMin: parseFloat(document.getElementById('f-price-min').value) || null,
    priceMax: parseFloat(document.getElementById('f-price-max').value) || null,
    dcOnly: document.getElementById('f-dc').checked,
    colorOnly: document.getElementById('f-color').checked,
    inStockOnly: document.getElementById('f-instock').checked,
  };
}

function applyOfferFilters(offers, f) {
  if (f.retailer) offers = offers.filter(o => o.retailer === f.retailer);
  if (f.inStockOnly) offers = offers.filter(o => o.in_stock);
  if (f.priceMin != null) offers = offers.filter(o => o.price_usd == null || o.price_usd >= f.priceMin);
  if (f.priceMax != null) offers = offers.filter(o => o.price_usd == null || o.price_usd <= f.priceMax);
  return offers;
}

// Whether an edition qualifies under retailer/in-stock/price filters is
// checked against ALL of its offers, including the hidden ones (an
// edition that's genuinely in stock -- just only through a retailer we
// don't link to here -- shouldn't vanish from the catalog entirely).
// What's actually rendered as buy buttons is the separate, narrower
// customer-visible set (see displayOffers below).
function qualifyingOffers(edition, f) {
  return applyOfferFilters(OFFERS_BY_EDITION[edition.sku_id] || [], f);
}

function displayOffers(edition, f) {
  return applyOfferFilters(sellableOffers(edition.sku_id), f);
}

function matches(edition, f) {
  if (f.search) {
    const hay = `${edition.title} ${edition.translation_name} ${edition.isbn13 || ''}`.toLowerCase();
    if (!hay.includes(f.search)) return false;
  }
  if (f.translation && edition.translation_abbrev !== f.translation) return false;
  if (f.extent && edition.extent !== f.extent) return false;
  if (f.printSize && edition.print_size_category !== f.printSize) return false;
  if (f.binding && edition.binding_type !== f.binding) return false;
  if (f.dcOnly && !edition.includes_dc) return false;
  if (f.colorOnly && edition.color_interior !== 'Color') return false;
  const offers = qualifyingOffers(edition, f);
  if ((f.retailer || f.inStockOnly || f.priceMin != null || f.priceMax != null) && offers.length === 0) return false;
  return true;
}

function renderCard(edition, offers, qualifyingOffers) {
  const imgHtml = edition.cover_image_thumb_url
    ? `<img src="${edition.cover_image_thumb_url}" alt="${edition.title} cover" onerror="this.closest('.card-img').innerHTML='<div class=\\'no-cover\\'>Cover image<br>not available</div>'">`
    : `<div class="no-cover">Cover image<br>not available</div>`;
  const detailHref = `edition.html?sku=${encodeURIComponent(edition.sku_id)}`;
  // If it qualifies for the filters at all but has nothing to show as a
  // button, that's because its only channel right now is a retailer we
  // don't link to (see common.js HIDDEN_RETAILERS) -- say so, rather than
  // implying there's no way to buy it at all.
  const emptyMessage = qualifyingOffers.length > 0
    ? 'See edition page for purchase details'
    : 'No retailer matches your filters';

  // The buy buttons are real outbound links, so they can't sit inside the
  // card's own link to the detail page (nested <a> is invalid HTML and
  // browsers handle the click ambiguously) -- the detail link wraps only
  // the image/title/specs; the buy buttons are a separate sibling.
  return `
    <div class="card">
      <a class="card-link" href="${detailHref}">
        <div class="card-img">${imgHtml}</div>
        <div class="card-info">
          <div class="card-title">${edition.title}</div>
          <div class="card-family">${edition.edition_family}</div>
          <div class="badges">${badgesFor(edition).join('')}</div>
          <div class="card-specs">${specLines(edition).join('<br>')}</div>
          ${edition.isbn13 ? `<div class="card-isbn">ISBN ${edition.isbn13}</div>` : `<div class="card-isbn">No ISBN (digital-only)</div>`}
        </div>
      </a>
      <div class="card-links">${buyButtonsHtml(offers, emptyMessage)}</div>
    </div>`;
}

function render() {
  const f = currentFilters();
  const grid = document.getElementById('grid');
  const empty = document.getElementById('empty');
  const filtered = EDITIONS.filter(e => matches(e, f));

  document.getElementById('result-count').textContent =
    `${filtered.length} edition${filtered.length !== 1 ? 's' : ''} found`;

  if (filtered.length === 0) {
    grid.style.display = 'none';
    empty.style.display = 'block';
    return;
  }
  grid.style.display = 'grid';
  empty.style.display = 'none';
  grid.innerHTML = filtered.map(e => renderCard(e, displayOffers(e, f), qualifyingOffers(e, f))).join('');
}

function resetFilters() {
  document.getElementById('filters').reset();
  document.getElementById('f-instock').checked = true;
  render();
}

function wireUp() {
  const ids = ['f-search', 'f-translation', 'f-extent', 'f-print-size', 'f-binding',
               'f-retailer', 'f-price-min', 'f-price-max', 'f-dc', 'f-color', 'f-instock'];
  for (const id of ids) {
    const el = document.getElementById(id);
    el.addEventListener('input', render);
    el.addEventListener('change', render);
  }
  document.getElementById('btn-reset').addEventListener('click', resetFilters);
  document.getElementById('empty-reset').addEventListener('click', (e) => {
    e.preventDefault();
    resetFilters();
  });
}

(async function init() {
  await loadData();
  initFilterOptions();
  wireUp();
  render();
})();
