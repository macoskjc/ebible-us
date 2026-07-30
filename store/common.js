/**
 * eBible.org Store — shared data loading, formatting, and offer logic
 * used by both the listing page (store.js) and the edition detail page
 * (edition.js). Static JSON, no backend -- see
 * eBible_Store_Rebuild_Plan.md Section 0/3.
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

// This catalog is going to become shop.eBible.org itself, so a "Buy at
// shop.eBible.org" link pointing at the very site you're already on
// doesn't make sense -- filtered out of every retailer-facing list
// (buy buttons, the retailer filter dropdown) everywhere, on both pages.
// The underlying offer data stays in offers.json; only display is filtered.
const HIDDEN_RETAILERS = new Set(['shop.eBible.org']);

// Amazon doesn't let a Kindle purchase deliver our EPUB, and Amazon's Kindle
// listings for these translations are never updated when the text changes,
// so unlike every other offer type, "buy the Kindle edition" isn't actually
// in a reader's interest here -- offers.json has no Amazon-Kindle rows at
// all anymore; they're replaced with free eBible.org EPUB downloads (see
// offer.type below). This is Amazon's own official upload tool, for anyone
// who still wants the file on a Kindle specifically.
const KINDLE_INSTRUCTIONS_URL = 'https://www.amazon.com/sendtokindle';

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
    fetch('editions.php'),
    fetch('offers.php'),
  ]);
  EDITIONS = await editionsRes.json();
  OFFERS = await offersRes.json();
  OFFERS_BY_EDITION = {};
  for (const o of OFFERS) {
    (OFFERS_BY_EDITION[o.edition_id] ??= []).push(o);
  }
}

/** All offers for an edition that are actually shown to customers. */
function sellableOffers(skuId) {
  return (OFFERS_BY_EDITION[skuId] || []).filter(o => !HIDDEN_RETAILERS.has(o.retailer));
}

function specLines(edition) {
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
  return specs;
}

function badgesFor(edition) {
  const badges = [];
  badges.push(`<span class="badge badge-extent">${EXTENT_LABELS[edition.extent] || edition.extent}</span>`);
  if (edition.print_size_category) badges.push(`<span class="badge badge-print">${edition.print_size_category}</span>`);
  if (edition.binding_type && edition.binding_type !== 'Unknown') {
    badges.push(`<span class="badge badge-binding">${edition.binding_type}</span>`);
  }
  return badges;
}

function buyButtonsHtml(offers, emptyMessage) {
  if (!offers.length) {
    return `<span style="font-size:.78rem;color:#999;">${emptyMessage}</span>`;
  }

  const buttons = offers.map(o => {
    if (o.type === 'free_download') {
      return `
      <a class="btn-buy btn-download" href="${o.purchase_url}" target="_blank" rel="noopener">
        <span>Download free EPUB</span>
      </a>`;
    }
    return `
      <a class="btn-buy${o.in_stock ? '' : ' out-of-stock'}" href="${o.purchase_url}" target="_blank" rel="noopener">
        <span>Buy at ${o.retailer}</span>
        ${o.price_usd != null ? `<span class="price">$${o.price_usd.toFixed(2)}</span>` : ''}
      </a>`;
  }).join('');

  // Only when EPUB is the *only* option (no paid/physical offer at all) is
  // it worth pointing someone at Amazon's Kindle-upload tool -- if a real
  // Kindle purchase link is also present, this would just be confusing.
  const epubOnly = offers.every(o => o.type === 'free_download');
  const kindleNote = epubOnly
    ? `<a class="kindle-note" href="${KINDLE_INSTRUCTIONS_URL}" target="_blank" rel="noopener">Instructions for sending to your Kindle →</a>`
    : '';

  return buttons + kindleNote;
}
