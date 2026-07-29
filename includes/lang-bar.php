<?php
/*
 * includes/lang-bar.php
 * Small UI-language selector shared across all ebible.us pages.
 * Reads $uiLang (set by the including page) and outputs the dropdown.
 * Outputs nothing if $uiLang is not defined — define it before including.
 */
if (!isset($uiLang)) $uiLang = 'en';

$langBarNames = [
  'en'=>'English','es'=>'Español','fr'=>'Français','de'=>'Deutsch',
  'pt'=>'Português','ru'=>'Русский','zh'=>'中文','ar'=>'العربية',
  'hi'=>'हिन्दी','ja'=>'日本語','ko'=>'한국어','id'=>'Bahasa Indonesia',
  'tr'=>'Türkçe','it'=>'Italiano','vi'=>'Tiếng Việt','th'=>'ภาษาไทย',
  'nl'=>'Nederlands','pl'=>'Polski','uk'=>'Українська','bn'=>'বাংলা',
  'ur'=>'اردو','mr'=>'मराठी','te'=>'తెలుగు','ta'=>'தமிழ்',
  'sw'=>'Kiswahili','tet'=>'Tetun','tpi'=>'Tok Pisin','ilo'=>'Ilocano',
  'ceb'=>'Cebuano','km'=>'ខ្មែរ','ha'=>'Hausa','yo'=>'Yorùbá',
  'ig'=>'Igbo','am'=>'አማርኛ','om'=>'Afaan Oromoo','so'=>'Soomaali','mg'=>'Malagasy',
];
?>
<div class="ui-lang-bar">
  <select onchange="location.href=updateLangParam(location.href, this.value)" aria-label="Interface language">
    <?php foreach ($langBarNames as $code => $name): ?>
      <option value="<?= $code ?>" <?= $code===$uiLang?'selected':'' ?>><?= htmlspecialchars($name) ?></option>
    <?php endforeach; ?>
  </select>
</div>
<script>
function updateLangParam(url, lang) {
  var u = new URL(url);
  u.searchParams.set('lang', lang);
  return u.toString();
}
</script>
