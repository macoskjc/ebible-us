# CLAUDE.md

This file provides guidance to Claude Code when working with the ebible.us project.

## Project overview

**ebible.us** is a prototype welcome page for eBible.org — a design concept showing what a modernized homepage for eBible.org could look like. It is a single self-contained HTML file intended for review by Michael Johnson (founder of eBible.org).

The prototype is live at: **https://macoskjc.github.io/ebible-us/**

## Branding rules (per Michael Johnson)

- Always write **eBible.org** — never "eBible", "ebible", or "e Bible"
- Always capitalize the **B** in Bible (respect for Scripture; also prevents autocorrect to "edible")
- The eBible.org logo SVG is at `https://ebible.org/icon/eBibleorglogo.svg`
- The logo must be displayed as a clipped circle showing only the cyan circle and red cross — the "eBible.org" text rendered inside the SVG must not be visible (use `background-size: 100% 145%; background-position: 50% 5%` technique)

## File structure

```
/Users/jed/ebible.us/
├── index.html          # The entire prototype — single self-contained page
├── translations.json   # Language→translation lookup scraped from eBible.org
└── CLAUDE.md           # This file
```

## Deployment

### GitHub Pages (live)
- Repo: https://github.com/macoskjc/ebible-us
- Live URL: https://macoskjc.github.io/ebible-us/
- Deploy: `git add . && git commit -m "message" && git push`
- GitHub token is stored in macOS keychain under `github.com` / `macoskjc`

### Production server (ebible.us)
- Host: a.mpj.us  Port: 123
- Username: ebible_sftp
- Auth: SSH public key (`~/.ssh/id_bibliatimorleste`)
- **Note:** As of June 2026, the SSH key has not yet been added to the ebible_sftp account by Michael. Once added, upload with paramiko SFTP as done for bibliatimorleste.org.
- Web root: TBD (to be confirmed once SSH access is working)

## How the language selector works

1. User picks a language from the dropdown (`<select id="lang-select">`)
2. Each `<option>` has a `data-lang` attribute matching a key in `translationData`
3. `goToLang()` reads `data-lang`, looks up translations from the inline `translationData` object, and calls `showResults()`
4. Results appear inline below the hero — each translation links to `https://ebible.org/details.php?id=XXX`
5. The "All languages" option navigates directly to `https://ebible.org/find/`

## Translation data

`translations.json` and the inline `translationData` JS object were scraped from `https://ebible.org/find/index.php?sort=l` in June 2026. To refresh:

```bash
curl -s "https://ebible.org/find/index.php?sort=l" > /tmp/ebible_find.html
# Then run the Python scraper used in the original session
```

The data covers 33 languages, 1,547 translations. Tok Pisin and Yoruba currently have no matches in eBible.org's database.

## Design notes

- Stack: plain HTML + Bootstrap 5 (CDN) + Google Fonts (Inter, Lora) + Bootstrap Icons
- No build step, no PHP, no database — fully static
- Hero background: Unsplash photo of open Bible (`photo-1504052434569-70ad5836ab65`)
- Mission strip background: Unsplash (`photo-1519682577862-22b62b24e493`)
- All nav links point to the live ebible.org site
- A prototype banner at the top makes clear this is a design concept
- CSS color palette: `--navy: #1a3a5c`, `--navy-dark: #0f2440`, `--gold: #b8860b`
