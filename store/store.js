/**
 * eBible.org Store — client-side data load, filter, and render.
 * Static JSON (editions.json + offers.json), no backend. See
 * eBible_Store_Rebuild_Plan.md Section 0/3 for why: this deploys
 * unchanged to GitHub Pages and any other static host.
 */

const EXTENT_LABELS = {
  'OT+NT+DC': 'Old & New Testaments + Deuterocanon',
  'OT+NT': 'Old & New Testaments',
  'NT': 'New Testament only',
  'NT+Partial-OT': 'New Testament + partial Old Testament',
  'DC-Only': 'Deuterocanon / Apocrypha only',
  'Selections (Words of Jesus only)': "Selections — words of Jesus only",
  'Gospels only (Harmony)': 'Gospels only (harmony)',
};

function mmToImperial(heightMm, widthMm, thicknessMm) {
  if (heightMm == null || widthMm == null) return null;
  const hIn = (heightMm / 25.4).toFixed(1);
  const wIn = (widthMm / 25.4).toFixed(1);
  let out = `${hIn} × ${wIn} in`;
  if (thicknessMm != null) {
    out += ` × ${(thicknessMm / 25.4).toFixed(2)} in`;
  }
  return out;
}

function gToOz(g) {
  if (g == null) return null;
  return (g / 28.3495).toFixed(1);
}

let EDITIONS = [];
let OFFERS = [];
let OFFERS_BY_EDITION = {};

async function loadData() {
  const [editionsRes, offersRes] = await Promise.all([
    fetch('data/editions.json'),
    fetch('data/offers.json'),
  ]);
  EDITIONS = await editionsRes.json();
  OFFERS = await offersRes.json();
  OFFERS_BY_EDITION = {};
  for (const o of OFFERS) {
    (OFFERS_BY_EDITION[o.edition_id] ??= []).push(o);
  }
}

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
  populateSelect('f-retailer',
    [...new Set(OFFERS.map(o => o.retailer))].sort());
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

function editionOffers(edition, f) {
  let offers = OFFERS_BY_EDITION[edition.sku_id] || [];
  if (f.retailer) offers = offers.filter(o => o.retailer === f.retailer);
  if (f.inStockOnly) offers = offers.filter(o => o.in_stock);
  if (f.priceMin != null) offers = offers.filter(o => o.price_usd == null || o.price_usd >= f.priceMin);
  if (f.priceMax != null) offers = offers.filter(o => o.price_usd == null || o.price_usd <= f.priceMax);
  return offers;
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
  const offers = editionOffers(edition, f);
  if ((f.retailer || f.inStockOnly || f.priceMin != null || f.priceMax != null) && offers.length === 0) return false;
  return true;
}

function renderCard(edition, offers) {
  const specs = [];
  const dims = mmToImperial(edition.trim_height_mm, edition.trim_width_mm, edition.thickness_mm);
  if (dims) {
    const mmDims = `${edition.trim_height_mm} × ${edition.trim_width_mm}${edition.thickness_mm != null ? ' × ' + edition.thickness_mm : ''} mm`;
    specs.push(`${dims} <span class="mm">(${mmDims})</span>`);
  }
  if (edition.weight_g != null) {
    specs.push(`${gToOz(edition.weight_g)} oz <span class="mm">(${edition.weight_g} g)</span>`);
  }
  if (edition.page_count) specs.push(`${edition.page_count} pages`);
  if (edition.font_size_pt) specs.push(`${edition.font_size_pt}pt type`);

  const badges = [];
  badges.push(`<span class="badge badge-extent">${EXTENT_LABELS[edition.extent] || edition.extent}</span>`);
  if (edition.print_size_category) badges.push(`<span class="badge badge-print">${edition.print_size_category}</span>`);
  if (edition.binding_type && edition.binding_type !== 'Unknown') {
    badges.push(`<span class="badge badge-binding">${edition.binding_type}</span>`);
  }

  const imgHtml = edition.cover_image_thumb_url
    ? `<img src="${edition.cover_image_thumb_url}" alt="${edition.title} cover" onerror="this.closest('.card-img').innerHTML='<div class=\\'no-cover\\'>Cover image<br>not available</div>'">`
    : `<div class="no-cover">Cover image<br>not available</div>`;

  const offersHtml = offers.length
    ? offers.map(o => `
        <a class="btn-buy${o.in_stock ? '' : ' out-of-stock'}" href="${o.purchase_url}" target="_blank" rel="noopener">
          <span>Buy at ${o.retailer}</span>
          ${o.price_usd != null ? `<span class="price">$${o.price_usd.toFixed(2)}</span>` : ''}
        </a>`).join('')
    : `<span style="font-size:.78rem;color:#999;">No retailer matches your filters</span>`;

  return `
    <div class="card">
      <div class="card-img">${imgHtml}</div>
      <div class="card-body">
        <div class="card-title">${edition.title}</div>
        <div class="card-family">${edition.edition_family}</div>
        <div class="badges">${badges.join('')}</div>
        <div class="card-specs">${specs.join('<br>')}</div>
        ${edition.isbn13 ? `<div class="card-isbn">ISBN ${edition.isbn13}</div>` : `<div class="card-isbn">No ISBN (digital-only)</div>`}
        <div class="card-links">${offersHtml}</div>
      </div>
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
  grid.innerHTML = filtered.map(e => renderCard(e, editionOffers(e, f))).join('');
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
