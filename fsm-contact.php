<?php
/*
 * contact.php — Smart contact form for eBible.us
 * Multilingual: auto-detects browser language, supports 20 languages.
 */

define('SITE_CODE', 'fsm');
define('SITE_NAME', 'FSM.Bible');
define('SITE_URL',  'https://fsm.bible/');

// ---- Language detection ----
$accept = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
$uiLang = 'en';
foreach (explode(',', $accept) as $part) {
    $tag = strtolower(trim(explode(';', $part)[0]));
    if      (str_starts_with($tag,'zh'))   { $uiLang='zh'; break; }
    elseif  (str_starts_with($tag,'es'))   { $uiLang='es'; break; }
    elseif  (str_starts_with($tag,'hi'))   { $uiLang='hi'; break; }
    elseif  (str_starts_with($tag,'ar'))   { $uiLang='ar'; break; }
    elseif  (str_starts_with($tag,'pt'))   { $uiLang='pt'; break; }
    elseif  (str_starts_with($tag,'bn'))   { $uiLang='bn'; break; }
    elseif  (str_starts_with($tag,'ru'))   { $uiLang='ru'; break; }
    elseif  (str_starts_with($tag,'ja'))   { $uiLang='ja'; break; }
    elseif  (str_starts_with($tag,'fr'))   { $uiLang='fr'; break; }
    elseif  (str_starts_with($tag,'de'))   { $uiLang='de'; break; }
    elseif  (str_starts_with($tag,'ko'))   { $uiLang='ko'; break; }
    elseif  (str_starts_with($tag,'id'))   { $uiLang='id'; break; }
    elseif  (str_starts_with($tag,'tr'))   { $uiLang='tr'; break; }
    elseif  (str_starts_with($tag,'it'))   { $uiLang='it'; break; }
    elseif  (str_starts_with($tag,'vi'))   { $uiLang='vi'; break; }
    elseif  (str_starts_with($tag,'th'))   { $uiLang='th'; break; }
    elseif  (str_starts_with($tag,'nl'))   { $uiLang='nl'; break; }
    elseif  (str_starts_with($tag,'pl'))   { $uiLang='pl'; break; }
    elseif  (str_starts_with($tag,'uk'))   { $uiLang='uk'; break; }
    elseif  ($tag==='ur' || str_starts_with($tag,'ur-')) { $uiLang='ur'; break; }
    elseif  (str_starts_with($tag,'mr'))   { $uiLang='mr'; break; }
    elseif  (str_starts_with($tag,'te'))   { $uiLang='te'; break; }
    elseif  (str_starts_with($tag,'ta'))   { $uiLang='ta'; break; }
    elseif  (str_starts_with($tag,'sw'))   { $uiLang='sw'; break; }
    elseif  ($tag==='tet')                 { $uiLang='tet'; break; }
    elseif  ($tag==='tpi')                 { $uiLang='tpi'; break; }
    elseif  (str_starts_with($tag,'ilo'))  { $uiLang='ilo'; break; }
    elseif  (str_starts_with($tag,'ceb'))  { $uiLang='ceb'; break; }
    elseif  (str_starts_with($tag,'km'))   { $uiLang='km'; break; }
    elseif  (str_starts_with($tag,'ha'))   { $uiLang='ha'; break; }
    elseif  (str_starts_with($tag,'yo'))   { $uiLang='yo'; break; }
    elseif  (str_starts_with($tag,'ig'))   { $uiLang='ig'; break; }
    elseif  (str_starts_with($tag,'am'))   { $uiLang='am'; break; }
    elseif  (str_starts_with($tag,'om'))   { $uiLang='om'; break; }
    elseif  (str_starts_with($tag,'so'))   { $uiLang='so'; break; }
    elseif  (str_starts_with($tag,'mg'))   { $uiLang='mg'; break; }
    elseif  (str_starts_with($tag,'en'))   { $uiLang='en'; break; }
}
// Allow explicit override via ?lang= or POST ui_lang
$allLangs = ['en','es','fr','de','pt','ru','zh','ar','hi','ja','ko','id','tr','it','vi','th','nl','pl','uk','bn',
             'ur','mr','te','ta','sw','tet','tpi','ilo','ceb','km','ha','yo','ig','am','om','so','mg'];
if (isset($_GET['lang']) && in_array($_GET['lang'], $allLangs))   $uiLang = $_GET['lang'];
if (isset($_POST['ui_lang']) && in_array($_POST['ui_lang'], $allLangs)) $uiLang = $_POST['ui_lang'];

$rtl = ($uiLang === 'ar' || $uiLang === 'ur');

$langNames = [
  'en'=>'English','es'=>'Español','fr'=>'Français','de'=>'Deutsch','pt'=>'Português',
  'ru'=>'Русский','zh'=>'中文','ar'=>'العربية',
  'hi'=>'हिन्दी','ja'=>'日本語','ko'=>'한국어','id'=>'Bahasa Indonesia',
  'tr'=>'Türkçe','it'=>'Italiano','vi'=>'Tiếng Việt','th'=>'ภาษาไทย',
  'nl'=>'Nederlands','pl'=>'Polski','uk'=>'Українська','bn'=>'বাংলা',
];

// ---- Translations ----
$T = [];

$T['en'] = [
  'title'=>'Contact','subtitle'=>'Send a message to the FSM.Bible team',
  'step1'=>'Step 1 — Why are you contacting us?',
  'reason_label'=>'Reason for contacting us',
  'reason_placeholder'=>'— Choose a reason —',
  'reason_B'=>'Bible translation suggestion',
  'reason_P'=>'Publishing or copyright question',
  'reason_R'=>'Request to join mailing list',
  'reason_O'=>'Other',
  'step2_bible'=>'Step 2 — Bible passage details',
  'trans_label'=>'Bible translation or the URL where you found it','trans_hint'=>'e.g. <code>engwebp</code> for English WEB, <code>porbrbsl</code> for Portuguese, <code>tet</code> for Tetun',
  'book_label'=>'Book','book_hint'=>'SIL/UBS 3-letter code or book name (e.g. Mat, Mark, John)',
  'chapter_label'=>'Chapter','verse_label'=>'Verse',
  'step3'=>'Step 3 — Your contact details',
  'name_label'=>'Your name','email_label'=>'Your email address',
  'submit'=>'Continue →',
  'success_heading'=>'Your message is ready to send',
  'success1'=>'Click <strong>Open email program</strong> — opens a new email with subject and message prompts pre-filled.',
  'success2'=>'<strong>Finish typing your message</strong> where indicated in the email body.',
  'success3'=>'Click <strong>Send</strong> in your email program.',
  'open_email'=>'Open email program →','open_gmail'=>'Open in Gmail →',
  'no_email'=>'Either button opens a pre-addressed email. Finish typing your message in the email body, then send.',
  'to_label'=>'To:','subject_display'=>'Subject:',
  'copy_btn'=>'Copy message body','copied'=>'Copied!',
  'send_another'=>'← Send another message',
  'err_reason'=>'Please choose a reason for contacting us.',
  'err_trans'=>'Please enter the translation code.',
  'err_book_empty'=>'Please enter the book name or abbreviation.',
  'err_book_invalid'=>'',
  'err_chapter'=>'Please enter a valid chapter number.',
  'err_verse'=>'Please enter a valid verse number.',
  'err_current'=>'Please enter what the text currently says.',
  'err_correct'=>'Please enter what it should say.',
  'err_name'=>'Please enter your name.',
  'err_email'=>'Please enter a valid email address.',
  'err_subject'=>'Please enter a subject.',
  'err_message'=>'Please enter a message (at least 10 characters).',
  'err_type'=>'Please choose a contact type.',
  'reason_label'=>'Reason for contacting us','reason_placeholder'=>'— Choose a reason —',
  'reason_B'=>'Bible translation suggestion','reason_P'=>'Publishing or copyright question',
  'reason_R'=>'Request to join mailing list','reason_O'=>'Other',
  'body_prompt'=>'Please type your message here then send your email.',
  'body_reads_now'=>'How it reads now:',
  'body_better'=>'How it might be better:',
];

$T['es'] = [
  'title'=>'Contacto','subtitle'=>'Envía un mensaje al equipo de eBible.us',
  'step1'=>'Paso 1 — ¿Qué tipo de mensaje es este?',
  'typo_title'=>'Error tipográfico o de traducción',
  'typo_desc'=>'Encontré un error en un texto bíblico — una palabra incorrecta, error ortográfico o versículo que parece equivocado.',
  'general_title'=>'Pregunta o comentario general',
  'general_desc'=>'Tengo una pregunta, sugerencia u otro mensaje para el equipo.',
  'step2_typo'=>'Paso 2 — Cuéntanos sobre el error',
  'trans_label'=>'Código de traducción','trans_hint'=>'p.ej. <code>tl</code> para Tetum, <code>engwebp</code> para inglés WEB, <code>porbrbsl</code> para portugués',
  'book_label'=>'Libro','book_hint'=>'abreviatura',
  'chapter_label'=>'Capítulo','verse_label'=>'Versículo',
  'current_label'=>'Lo que dice el texto actualmente','current_hint'=>'copia y pega el texto exacto que ves',
  'correct_label'=>'Lo que debería decir','correct_hint'=>'ingresa el texto correcto',
  'step3'=>'Paso 3 — Tus datos de contacto',
  'name_label'=>'Tu nombre','email_label'=>'Tu dirección de correo electrónico',
  'submit'=>'Preparar mi mensaje →',
  'step2_general'=>'Paso 2 — Tu mensaje',
  'subject_label'=>'Asunto','message_label'=>'Tu mensaje',
  'success_heading'=>'Tu mensaje está listo para enviar',
  'success1'=>'Haz clic en <strong>Abrir programa de correo</strong> — abre un nuevo correo con el asunto prellenado.',
  'success2'=>'Haz clic en <strong>Copiar cuerpo del mensaje</strong> y pégalo en ese correo.',
  'success3'=>'Haz clic en <strong>Enviar</strong> en tu programa de correo.',
  'open_email'=>'Abrir programa de correo →','open_gmail'=>'Abrir en Gmail →',
  'no_email'=>'Cualquier botón abre un correo con el asunto prellenado. Copia y pega el cuerpo antes de enviar.',
  'to_label'=>'Para:','subject_display'=>'Asunto:',
  'copy_btn'=>'Copiar cuerpo del mensaje','copied'=>'¡Copiado!',
  'send_another'=>'← Enviar otro mensaje',
  'err_trans'=>'Por favor ingresa el código de traducción.',
  'err_book_empty'=>'Por favor ingresa la abreviatura del libro.',
  'err_book_invalid'=>'Abreviatura "%s" no reconocida. Usa abreviaturas estándar como mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Por favor ingresa un número de capítulo válido.',
  'err_verse'=>'Por favor ingresa un número de versículo válido.',
  'err_current'=>'Por favor ingresa lo que dice actualmente el texto.',
  'err_correct'=>'Por favor ingresa lo que debería decir.',
  'err_name'=>'Por favor ingresa tu nombre.',
  'err_email'=>'Por favor ingresa una dirección de correo electrónico válida.',
  'err_subject'=>'Por favor ingresa un asunto.',
  'err_message'=>'Por favor ingresa un mensaje (mínimo 10 caracteres).',
  'err_type'=>'Por favor elige un tipo de mensaje.',
  'reason_label'=>'Razón para contactarnos','reason_placeholder'=>'— Elige una razón —',
  'reason_B'=>'Sugerencia de traducción bíblica','reason_P'=>'Pregunta sobre publicación o derechos de autor',
  'reason_R'=>'Solicitud para unirse a la lista de correo','reason_O'=>'Otro',
  'body_prompt'=>'Por favor, escribe tu mensaje aquí y luego envía tu correo.',
  'body_reads_now'=>'Cómo aparece ahora:',
  'body_better'=>'Cómo podría mejorar:',
];

$T['fr'] = [
  'title'=>'Contact','subtitle'=>"Envoyer un message à l'équipe eBible.us",
  'step1'=>'Étape 1 — Quel type de message est-ce ?',
  'typo_title'=>'Faute de frappe ou erreur de traduction',
  'typo_desc'=>"J'ai trouvé une erreur dans un texte biblique — un mot incorrect, une faute d'orthographe ou un verset qui semble inexact.",
  'general_title'=>'Question ou commentaire général',
  'general_desc'=>"J'ai une question, une suggestion ou un autre message pour l'équipe.",
  'step2_typo'=>"Étape 2 — Parlez-nous de l'erreur",
  'trans_label'=>'Code de traduction','trans_hint'=>'ex. <code>tl</code> pour le Tetum, <code>engwebp</code> pour l\'anglais WEB, <code>porbrbsl</code> pour le portugais',
  'book_label'=>'Livre','book_hint'=>'abréviation',
  'chapter_label'=>'Chapitre','verse_label'=>'Verset',
  'current_label'=>'Ce que dit actuellement le texte','current_hint'=>'copiez et collez le texte exact que vous voyez',
  'correct_label'=>'Ce qu\'il devrait dire','correct_hint'=>'entrez le texte correct',
  'step3'=>'Étape 3 — Vos coordonnées',
  'name_label'=>'Votre nom','email_label'=>'Votre adresse e-mail',
  'submit'=>'Préparer mon message →',
  'step2_general'=>'Étape 2 — Votre message',
  'subject_label'=>'Sujet','message_label'=>'Votre message',
  'success_heading'=>'Votre message est prêt à être envoyé',
  'success1'=>'Cliquez sur <strong>Ouvrir le programme de messagerie</strong> — ouvre un nouvel e-mail avec le sujet pré-rempli.',
  'success2'=>'Cliquez sur <strong>Copier le corps du message</strong> ci-dessous, puis collez-le dans cet e-mail.',
  'success3'=>'Cliquez sur <strong>Envoyer</strong> dans votre programme de messagerie.',
  'open_email'=>'Ouvrir le programme de messagerie →','open_gmail'=>'Ouvrir dans Gmail →',
  'no_email'=>'Chaque bouton ouvre un e-mail avec le sujet pré-rempli. Copiez et collez le corps avant d\'envoyer.',
  'to_label'=>'À :','subject_display'=>'Sujet :',
  'copy_btn'=>'Copier le corps du message','copied'=>'Copié !',
  'send_another'=>'← Envoyer un autre message',
  'err_trans'=>'Veuillez entrer le code de traduction.',
  'err_book_empty'=>'Veuillez entrer l\'abréviation du livre.',
  'err_book_invalid'=>'Abréviation « %s » non reconnue. Utilisez des abréviations standard comme mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Veuillez entrer un numéro de chapitre valide.',
  'err_verse'=>'Veuillez entrer un numéro de verset valide.',
  'err_current'=>'Veuillez entrer ce que dit actuellement le texte.',
  'err_correct'=>'Veuillez entrer ce qu\'il devrait dire.',
  'err_name'=>'Veuillez entrer votre nom.',
  'err_email'=>'Veuillez entrer une adresse e-mail valide.',
  'err_subject'=>'Veuillez entrer un sujet.',
  'err_message'=>'Veuillez entrer un message (minimum 10 caractères).',
  'err_type'=>'Veuillez choisir un type de message.',
  'reason_label'=>'Raison du contact','reason_placeholder'=>'— Choisissez une raison —',
  'reason_B'=>'Suggestion de traduction biblique','reason_P'=>'Question sur l\'édition ou les droits d\'auteur',
  'reason_R'=>'Demande d\'inscription à la liste de diffusion','reason_O'=>'Autre',
  'body_prompt'=>'Veuillez taper votre message ici, puis envoyer votre e-mail.',
  'body_reads_now'=>'Comment cela se lit actuellement :',
  'body_better'=>'Comment cela pourrait être amélioré :',
];

$T['de'] = [
  'title'=>'Kontakt','subtitle'=>'Senden Sie eine Nachricht an das eBible.us-Team',
  'step1'=>'Schritt 1 — Um welche Art von Nachricht handelt es sich?',
  'typo_title'=>'Tippfehler oder Übersetzungsfehler',
  'typo_desc'=>'Ich habe einen Fehler in einem Bibeltext gefunden — ein falsches Wort, einen Rechtschreibfehler oder einen Vers, der falsch erscheint.',
  'general_title'=>'Allgemeine Frage oder Kommentar',
  'general_desc'=>'Ich habe eine Frage, einen Vorschlag oder eine andere Nachricht für das Team.',
  'step2_typo'=>'Schritt 2 — Erzählen Sie uns vom Fehler',
  'trans_label'=>'Übersetzungscode','trans_hint'=>'z.B. <code>tl</code> für Tetum, <code>engwebp</code> für Englisch WEB, <code>porbrbsl</code> für Portugiesisch',
  'book_label'=>'Buch','book_hint'=>'Abkürzung',
  'chapter_label'=>'Kapitel','verse_label'=>'Vers',
  'current_label'=>'Was der Text derzeit sagt','current_hint'=>'Kopieren Sie den genauen Text, den Sie sehen',
  'correct_label'=>'Was er sagen sollte','correct_hint'=>'Geben Sie den korrekten Text ein',
  'step3'=>'Schritt 3 — Ihre Kontaktdaten',
  'name_label'=>'Ihr Name','email_label'=>'Ihre E-Mail-Adresse',
  'submit'=>'Meine Nachricht vorbereiten →',
  'step2_general'=>'Schritt 2 — Ihre Nachricht',
  'subject_label'=>'Betreff','message_label'=>'Ihre Nachricht',
  'success_heading'=>'Ihre Nachricht ist versandfertig',
  'success1'=>'Klicken Sie auf <strong>E-Mail-Programm öffnen</strong> — öffnet eine neue E-Mail mit vorausgefülltem Betreff.',
  'success2'=>'Klicken Sie auf <strong>Nachrichtentext kopieren</strong> und fügen Sie ihn in die E-Mail ein.',
  'success3'=>'Klicken Sie in Ihrem E-Mail-Programm auf <strong>Senden</strong>.',
  'open_email'=>'E-Mail-Programm öffnen →','open_gmail'=>'In Gmail öffnen →',
  'no_email'=>'Jede Schaltfläche öffnet eine E-Mail mit vorausgefülltem Betreff. Kopieren Sie den Text vor dem Senden.',
  'to_label'=>'An:','subject_display'=>'Betreff:',
  'copy_btn'=>'Nachrichtentext kopieren','copied'=>'Kopiert!',
  'send_another'=>'← Weitere Nachricht senden',
  'err_trans'=>'Bitte geben Sie den Übersetzungscode ein.',
  'err_book_empty'=>'Bitte geben Sie die Buchabkürzung ein.',
  'err_book_invalid'=>'Abkürzung „%s" nicht erkannt. Verwenden Sie Standardabkürzungen wie mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Bitte geben Sie eine gültige Kapitelnummer ein.',
  'err_verse'=>'Bitte geben Sie eine gültige Versnummer ein.',
  'err_current'=>'Bitte geben Sie an, was der Text derzeit sagt.',
  'err_correct'=>'Bitte geben Sie an, was er sagen sollte.',
  'err_name'=>'Bitte geben Sie Ihren Namen ein.',
  'err_email'=>'Bitte geben Sie eine gültige E-Mail-Adresse ein.',
  'err_subject'=>'Bitte geben Sie einen Betreff ein.',
  'err_message'=>'Bitte geben Sie eine Nachricht ein (mindestens 10 Zeichen).',
  'err_type'=>'Bitte wählen Sie einen Nachrichtentyp.',
  'reason_label'=>'Grund der Kontaktaufnahme','reason_placeholder'=>'— Grund auswählen —',
  'reason_B'=>'Vorschlag zur Bibelübersetzung','reason_P'=>'Frage zu Veröffentlichung oder Urheberrecht',
  'reason_R'=>'Anfrage zur Aufnahme in die Mailingliste','reason_O'=>'Sonstiges',
  'body_prompt'=>'Bitte tippen Sie hier Ihre Nachricht und senden Sie dann die E-Mail.',
  'body_reads_now'=>'Wie es derzeit lautet:',
  'body_better'=>'Wie es besser lauten könnte:',
];

$T['pt'] = [
  'title'=>'Contato','subtitle'=>'Envie uma mensagem para a equipe do FSM.Bible',
  'step1'=>'Passo 1 — Que tipo de mensagem é esta?',
  'typo_title'=>'Erro de digitação ou tradução',
  'typo_desc'=>'Encontrei um erro em um texto bíblico — uma palavra incorreta, erro ortográfico ou versículo que parece incorreto.',
  'general_title'=>'Pergunta ou comentário geral',
  'general_desc'=>'Tenho uma pergunta, sugestão ou outra mensagem para a equipe.',
  'step2_typo'=>'Passo 2 — Conte-nos sobre o erro',
  'trans_label'=>'Código de tradução','trans_hint'=>'ex. <code>tl</code> para Tetum, <code>engwebp</code> para inglês WEB, <code>porbrbsl</code> para português',
  'book_label'=>'Livro','book_hint'=>'abreviatura',
  'chapter_label'=>'Capítulo','verse_label'=>'Versículo',
  'current_label'=>'O que o texto diz atualmente','current_hint'=>'copie e cole o texto exato que você vê',
  'correct_label'=>'O que deveria dizer','correct_hint'=>'insira o texto correto',
  'step3'=>'Passo 3 — Seus dados de contato',
  'name_label'=>'Seu nome','email_label'=>'Seu endereço de e-mail',
  'submit'=>'Preparar minha mensagem →',
  'step2_general'=>'Passo 2 — Sua mensagem',
  'subject_label'=>'Assunto','message_label'=>'Sua mensagem',
  'success_heading'=>'Sua mensagem está pronta para enviar',
  'success1'=>'Clique em <strong>Abrir programa de e-mail</strong> — abre um novo e-mail com o assunto pré-preenchido.',
  'success2'=>'Clique em <strong>Copiar corpo da mensagem</strong> abaixo e cole-o nesse e-mail.',
  'success3'=>'Clique em <strong>Enviar</strong> no seu programa de e-mail.',
  'open_email'=>'Abrir programa de e-mail →','open_gmail'=>'Abrir no Gmail →',
  'no_email'=>'Qualquer botão abre um e-mail com o assunto pré-preenchido. Copie e cole o corpo antes de enviar.',
  'to_label'=>'Para:','subject_display'=>'Assunto:',
  'copy_btn'=>'Copiar corpo da mensagem','copied'=>'Copiado!',
  'send_another'=>'← Enviar outra mensagem',
  'err_trans'=>'Por favor insira o código de tradução.',
  'err_book_empty'=>'Por favor insira a abreviatura do livro.',
  'err_book_invalid'=>'Abreviatura "%s" não reconhecida. Use abreviaturas padrão como mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Por favor insira um número de capítulo válido.',
  'err_verse'=>'Por favor insira um número de versículo válido.',
  'err_current'=>'Por favor insira o que o texto diz atualmente.',
  'err_correct'=>'Por favor insira o que deveria dizer.',
  'err_name'=>'Por favor insira seu nome.',
  'err_email'=>'Por favor insira um endereço de e-mail válido.',
  'err_subject'=>'Por favor insira um assunto.',
  'err_message'=>'Por favor insira uma mensagem (mínimo 10 caracteres).',
  'err_type'=>'Por favor escolha um tipo de mensagem.',
  'reason_label'=>'Motivo do contato','reason_placeholder'=>'— Escolha um motivo —',
  'reason_B'=>'Sugestão de tradução bíblica','reason_P'=>'Pergunta sobre publicação ou direitos autorais',
  'reason_R'=>'Solicitação para entrar na lista de e-mails','reason_O'=>'Outro',
  'body_prompt'=>'Por favor, escreva sua mensagem aqui e envie o e-mail.',
  'body_reads_now'=>'Como está atualmente:',
  'body_better'=>'Como poderia ser melhorado:',
];

$T['ru'] = [
  'title'=>'Контакт','subtitle'=>'Отправьте сообщение команде eBible.us',
  'step1'=>'Шаг 1 — Какой тип сообщения?',
  'typo_title'=>'Опечатка или ошибка перевода',
  'typo_desc'=>'Я нашёл ошибку в библейском тексте — неправильное слово, орфографическую ошибку или стих, который кажется неточным.',
  'general_title'=>'Общий вопрос или комментарий',
  'general_desc'=>'У меня есть вопрос, предложение или другое сообщение для команды.',
  'step2_typo'=>'Шаг 2 — Расскажите нам об ошибке',
  'trans_label'=>'Код перевода','trans_hint'=>'напр. <code>tl</code> для Тетум, <code>engwebp</code> для английского WEB, <code>porbrbsl</code> для португальского',
  'book_label'=>'Книга','book_hint'=>'сокращение',
  'chapter_label'=>'Глава','verse_label'=>'Стих',
  'current_label'=>'Что в тексте написано сейчас','current_hint'=>'скопируйте и вставьте точный текст, который вы видите',
  'correct_label'=>'Что должно быть написано','correct_hint'=>'введите правильный текст',
  'step3'=>'Шаг 3 — Ваши контактные данные',
  'name_label'=>'Ваше имя','email_label'=>'Ваш адрес электронной почты',
  'submit'=>'Подготовить моё сообщение →',
  'step2_general'=>'Шаг 2 — Ваше сообщение',
  'subject_label'=>'Тема','message_label'=>'Ваше сообщение',
  'success_heading'=>'Ваше сообщение готово к отправке',
  'success1'=>'Нажмите <strong>Открыть почтовую программу</strong> — откроется новое письмо с предзаполненной темой.',
  'success2'=>'Нажмите <strong>Скопировать текст сообщения</strong> ниже и вставьте его в письмо.',
  'success3'=>'Нажмите <strong>Отправить</strong> в своей почтовой программе.',
  'open_email'=>'Открыть почтовую программу →','open_gmail'=>'Открыть в Gmail →',
  'no_email'=>'Любая кнопка откроет письмо с предзаполненной темой. Скопируйте и вставьте текст перед отправкой.',
  'to_label'=>'Кому:','subject_display'=>'Тема:',
  'copy_btn'=>'Скопировать текст сообщения','copied'=>'Скопировано!',
  'send_another'=>'← Отправить ещё одно сообщение',
  'err_trans'=>'Пожалуйста, введите код перевода.',
  'err_book_empty'=>'Пожалуйста, введите сокращение книги.',
  'err_book_invalid'=>'Сокращение «%s» не распознано. Используйте стандартные сокращения: mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Пожалуйста, введите действительный номер главы.',
  'err_verse'=>'Пожалуйста, введите действительный номер стиха.',
  'err_current'=>'Пожалуйста, введите то, что сейчас написано в тексте.',
  'err_correct'=>'Пожалуйста, введите то, что должно быть написано.',
  'err_name'=>'Пожалуйста, введите ваше имя.',
  'err_email'=>'Пожалуйста, введите действительный адрес электронной почты.',
  'err_subject'=>'Пожалуйста, введите тему.',
  'err_message'=>'Пожалуйста, введите сообщение (минимум 10 символов).',
  'err_type'=>'Пожалуйста, выберите тип сообщения.',
  'reason_label'=>'Причина обращения','reason_placeholder'=>'— Выберите причину —',
  'reason_B'=>'Предложение по переводу Библии','reason_P'=>'Вопрос об издании или авторском праве',
  'reason_R'=>'Запрос на подписку на рассылку','reason_O'=>'Другое',
  'body_prompt'=>'Пожалуйста, напишите ваше сообщение здесь, затем отправьте письмо.',
  'body_reads_now'=>'Как это звучит сейчас:',
  'body_better'=>'Как это могло бы звучать лучше:',
];

$T['zh'] = [
  'title'=>'联系我们','subtitle'=>'向 eBible.us 团队发送消息',
  'step1'=>'第1步 — 这是什么类型的消息？',
  'typo_title'=>'错别字或翻译错误',
  'typo_desc'=>'我在圣经文本中发现了一个错误——一个错误的词、拼写错误或看似不正确的节。',
  'general_title'=>'一般问题或评论',
  'general_desc'=>'我有问题、建议或其他消息要发送给团队。',
  'step2_typo'=>'第2步 — 告诉我们有关错误的信息',
  'trans_label'=>'译本代码','trans_hint'=>'例如 <code>tl</code> 代表帝汶语，<code>engwebp</code> 代表英语 WEB，<code>porbrbsl</code> 代表葡萄牙语',
  'book_label'=>'书卷','book_hint'=>'缩写',
  'chapter_label'=>'章','verse_label'=>'节',
  'current_label'=>'文本目前的内容','current_hint'=>'复制并粘贴您看到的确切文本',
  'correct_label'=>'应该是什么内容','correct_hint'=>'输入正确的文本',
  'step3'=>'第3步 — 您的联系信息',
  'name_label'=>'您的姓名','email_label'=>'您的电子邮件地址',
  'submit'=>'准备我的消息 →',
  'step2_general'=>'第2步 — 您的消息',
  'subject_label'=>'主题','message_label'=>'您的消息',
  'success_heading'=>'您的消息已准备好发送',
  'success1'=>'点击<strong>打开电子邮件程序</strong>——打开预填了主题的新邮件。',
  'success2'=>'点击下方<strong>复制消息正文</strong>，然后粘贴到邮件正文中。',
  'success3'=>'在您的电子邮件程序中点击<strong>发送</strong>。',
  'open_email'=>'打开电子邮件程序 →','open_gmail'=>'在 Gmail 中打开 →',
  'no_email'=>'任一按钮均可打开预填主题的新邮件。发送前请复制并粘贴消息正文。',
  'to_label'=>'收件人：','subject_display'=>'主题：',
  'copy_btn'=>'复制消息正文','copied'=>'已复制！',
  'send_another'=>'← 发送另一条消息',
  'err_trans'=>'请输入译本代码。',
  'err_book_empty'=>'请输入书卷缩写。',
  'err_book_invalid'=>'缩写"%s"未被识别。请使用标准缩写，如 mt、mk、lk、jn、ac、ro。',
  'err_chapter'=>'请输入有效的章编号。',
  'err_verse'=>'请输入有效的节编号。',
  'err_current'=>'请输入文本目前的内容。',
  'err_correct'=>'请输入应该是什么内容。',
  'err_name'=>'请输入您的姓名。',
  'err_email'=>'请输入有效的电子邮件地址。',
  'err_subject'=>'请输入主题。',
  'err_message'=>'请输入消息（至少10个字符）。',
  'err_type'=>'请选择消息类型。',
  'reason_label'=>'联系原因','reason_placeholder'=>'— 请选择原因 —',
  'reason_B'=>'圣经翻译建议','reason_P'=>'出版或版权问题',
  'reason_R'=>'申请加入邮件列表','reason_O'=>'其他',
  'body_prompt'=>'请在此处输入您的消息，然后发送电子邮件。',
  'body_reads_now'=>'当前内容：',
  'body_better'=>'建议修改为：',
];

$T['ar'] = [
  'title'=>'اتصل بنا','subtitle'=>'أرسل رسالة إلى فريق eBible.us',
  'step1'=>'الخطوة 1 — ما نوع هذه الرسالة؟',
  'typo_title'=>'خطأ إملائي أو خطأ في الترجمة',
  'typo_desc'=>'وجدت خطأً في نص كتابي — كلمة خاطئة أو خطأ إملائي أو آية تبدو غير صحيحة.',
  'general_title'=>'سؤال أو تعليق عام',
  'general_desc'=>'لدي سؤال أو اقتراح أو رسالة أخرى للفريق.',
  'step2_typo'=>'الخطوة 2 — أخبرنا عن الخطأ',
  'trans_label'=>'رمز الترجمة','trans_hint'=>'مثال: <code>tl</code> للتيتوم، <code>engwebp</code> للإنجليزية WEB، <code>porbrbsl</code> للبرتغالية',
  'book_label'=>'السفر','book_hint'=>'اختصار',
  'chapter_label'=>'الإصحاح','verse_label'=>'الآية',
  'current_label'=>'ما يقوله النص حالياً','current_hint'=>'انسخ والصق النص الدقيق الذي تراه',
  'correct_label'=>'ما يجب أن يقوله','correct_hint'=>'أدخل النص الصحيح',
  'step3'=>'الخطوة 3 — بيانات الاتصال الخاصة بك',
  'name_label'=>'اسمك','email_label'=>'عنوان بريدك الإلكتروني',
  'submit'=>'تحضير رسالتي →',
  'step2_general'=>'الخطوة 2 — رسالتك',
  'subject_label'=>'الموضوع','message_label'=>'رسالتك',
  'success_heading'=>'رسالتك جاهزة للإرسال',
  'success1'=>'انقر على <strong>فتح برنامج البريد الإلكتروني</strong> — يفتح بريداً جديداً مع تعبئة الموضوع مسبقاً.',
  'success2'=>'انقر على <strong>نسخ نص الرسالة</strong> أدناه والصقه في البريد.',
  'success3'=>'انقر على <strong>إرسال</strong> في برنامج البريد الإلكتروني.',
  'open_email'=>'فتح برنامج البريد الإلكتروني →','open_gmail'=>'فتح في Gmail →',
  'no_email'=>'أي زر يفتح بريداً مع تعبئة الموضوع. انسخ والصق نص الرسالة قبل الإرسال.',
  'to_label'=>'إلى:','subject_display'=>'الموضوع:',
  'copy_btn'=>'نسخ نص الرسالة','copied'=>'تم النسخ!',
  'send_another'=>'← إرسال رسالة أخرى',
  'err_trans'=>'الرجاء إدخال رمز الترجمة.',
  'err_book_empty'=>'الرجاء إدخال اختصار السفر.',
  'err_book_invalid'=>'الاختصار "%s" غير معروف. استخدم اختصارات قياسية مثل mt، mk، lk، jn، ac، ro.',
  'err_chapter'=>'الرجاء إدخال رقم إصحاح صحيح.',
  'err_verse'=>'الرجاء إدخال رقم آية صحيح.',
  'err_current'=>'الرجاء إدخال ما يقوله النص حالياً.',
  'err_correct'=>'الرجاء إدخال ما يجب أن يقوله.',
  'err_name'=>'الرجاء إدخال اسمك.',
  'err_email'=>'الرجاء إدخال عنوان بريد إلكتروني صحيح.',
  'err_subject'=>'الرجاء إدخال الموضوع.',
  'err_message'=>'الرجاء إدخال رسالة (10 أحرف على الأقل).',
  'err_type'=>'الرجاء اختيار نوع الرسالة.',
  'reason_label'=>'سبب التواصل','reason_placeholder'=>'— اختر سبباً —',
  'reason_B'=>'اقتراح ترجمة الكتاب المقدس','reason_P'=>'سؤال حول النشر أو حقوق النشر',
  'reason_R'=>'طلب الانضمام إلى القائمة البريدية','reason_O'=>'أخرى',
  'body_prompt'=>'يرجى كتابة رسالتك هنا ثم إرسال البريد الإلكتروني.',
  'body_reads_now'=>'ما يقوله النص حالياً:',
  'body_better'=>'كيف يمكن تحسينه:',
];

$T['hi'] = [
  'title'=>'संपर्क करें','subtitle'=>'eBible.us टीम को संदेश भेजें',
  'step1'=>'चरण 1 — यह किस प्रकार का संदेश है?',
  'typo_title'=>'टाइपो या अनुवाद त्रुटि',
  'typo_desc'=>'मुझे एक बाइबिल पाठ में गलती मिली — एक गलत शब्द, वर्तनी की गलती, या एक पद जो गलत लगता है।',
  'general_title'=>'सामान्य प्रश्न या टिप्पणी',
  'general_desc'=>'मेरे पास टीम के लिए एक प्रश्न, सुझाव या अन्य संदेश है।',
  'step2_typo'=>'चरण 2 — हमें त्रुटि के बारे में बताएं',
  'trans_label'=>'अनुवाद कोड','trans_hint'=>'उदा. <code>tl</code> टेटम के लिए, <code>engwebp</code> अंग्रेजी WEB के लिए, <code>porbrbsl</code> पुर्तगाली के लिए',
  'book_label'=>'पुस्तक','book_hint'=>'संक्षिप्त नाम',
  'chapter_label'=>'अध्याय','verse_label'=>'पद',
  'current_label'=>'पाठ में अभी क्या लिखा है','current_hint'=>'आप जो सटीक पाठ देखते हैं उसे कॉपी और पेस्ट करें',
  'correct_label'=>'क्या होना चाहिए','correct_hint'=>'सही पाठ दर्ज करें',
  'step3'=>'चरण 3 — आपकी संपर्क जानकारी',
  'name_label'=>'आपका नाम','email_label'=>'आपका ईमेल पता',
  'submit'=>'मेरा संदेश तैयार करें →',
  'step2_general'=>'चरण 2 — आपका संदेश',
  'subject_label'=>'विषय','message_label'=>'आपका संदेश',
  'success_heading'=>'आपका संदेश भेजने के लिए तैयार है',
  'success1'=>'<strong>ईमेल प्रोग्राम खोलें</strong> पर क्लिक करें — विषय पूर्व-भरे के साथ नया ईमेल खुलता है।',
  'success2'=>'नीचे <strong>संदेश मुख्य भाग कॉपी करें</strong> पर क्लिक करें और उसे ईमेल में पेस्ट करें।',
  'success3'=>'अपने ईमेल प्रोग्राम में <strong>भेजें</strong> पर क्लिक करें।',
  'open_email'=>'ईमेल प्रोग्राम खोलें →','open_gmail'=>'Gmail में खोलें →',
  'no_email'=>'कोई भी बटन विषय पूर्व-भरे ईमेल खोलता है। भेजने से पहले संदेश का मुख्य भाग कॉपी और पेस्ट करें।',
  'to_label'=>'प्रति:','subject_display'=>'विषय:',
  'copy_btn'=>'संदेश मुख्य भाग कॉपी करें','copied'=>'कॉपी हो गया!',
  'send_another'=>'← एक और संदेश भेजें',
  'err_trans'=>'कृपया अनुवाद कोड दर्ज करें।',
  'err_book_empty'=>'कृपया पुस्तक का संक्षिप्त नाम दर्ज करें।',
  'err_book_invalid'=>'संक्षिप्त नाम "%s" मान्यता प्राप्त नहीं है। mt, mk, lk, jn, ac, ro जैसे मानक संक्षिप्त नामों का उपयोग करें।',
  'err_chapter'=>'कृपया एक वैध अध्याय संख्या दर्ज करें।',
  'err_verse'=>'कृपया एक वैध पद संख्या दर्ज करें।',
  'err_current'=>'कृपया दर्ज करें कि पाठ में अभी क्या लिखा है।',
  'err_correct'=>'कृपया दर्ज करें कि क्या होना चाहिए।',
  'err_name'=>'कृपया अपना नाम दर्ज करें।',
  'err_email'=>'कृपया एक वैध ईमेल पता दर्ज करें।',
  'err_subject'=>'कृपया विषय दर्ज करें।',
  'err_message'=>'कृपया एक संदेश दर्ज करें (कम से कम 10 अक्षर)।',
  'err_type'=>'कृपया संदेश का प्रकार चुनें।',
  'reason_label'=>'संपर्क का कारण','reason_placeholder'=>'— कारण चुनें —',
  'reason_B'=>'बाइबल अनुवाद सुझाव','reason_P'=>'प्रकाशन या कॉपीराइट प्रश्न',
  'reason_R'=>'मेलिंग सूची में शामिल होने का अनुरोध','reason_O'=>'अन्य',
  'body_prompt'=>'कृपया यहाँ अपना संदेश लिखें और फिर ईमेल भेजें।',
  'body_reads_now'=>'अभी पाठ में क्या लिखा है:',
  'body_better'=>'यह कैसे बेहतर हो सकता है:',
];

$T['ja'] = [
  'title'=>'お問い合わせ','subtitle'=>'eBible.us チームにメッセージを送る',
  'step1'=>'ステップ 1 — このメッセージの種類は何ですか？',
  'typo_title'=>'タイプミスまたは翻訳エラー',
  'typo_desc'=>'聖書のテキストに誤りを見つけました — 間違った単語、スペルミス、または不正確に見える節。',
  'general_title'=>'一般的な質問またはコメント',
  'general_desc'=>'チームへの質問、提案、またはその他のメッセージがあります。',
  'step2_typo'=>'ステップ 2 — エラーについて教えてください',
  'trans_label'=>'翻訳コード','trans_hint'=>'例：<code>tl</code>（テトゥム語）、<code>engwebp</code>（英語 WEB）、<code>porbrbsl</code>（ポルトガル語）',
  'book_label'=>'書','book_hint'=>'略語',
  'chapter_label'=>'章','verse_label'=>'節',
  'current_label'=>'テキストに現在書かれていること','current_hint'=>'表示されているテキストをそのままコピーして貼り付けてください',
  'correct_label'=>'正しく書かれるべきこと','correct_hint'=>'正しいテキストを入力してください',
  'step3'=>'ステップ 3 — 連絡先情報',
  'name_label'=>'お名前','email_label'=>'メールアドレス',
  'submit'=>'メッセージを準備する →',
  'step2_general'=>'ステップ 2 — メッセージ',
  'subject_label'=>'件名','message_label'=>'メッセージ',
  'success_heading'=>'メッセージの送信準備ができました',
  'success1'=>'<strong>メールプログラムを開く</strong>をクリック — 件名が事前入力された新しいメールが開きます。',
  'success2'=>'下の<strong>メッセージ本文をコピー</strong>をクリックして、メールの本文に貼り付けてください。',
  'success3'=>'メールプログラムで<strong>送信</strong>をクリックしてください。',
  'open_email'=>'メールプログラムを開く →','open_gmail'=>'Gmail で開く →',
  'no_email'=>'どちらのボタンも件名が事前入力されたメールを開きます。送信前に本文をコピーして貼り付けてください。',
  'to_label'=>'宛先：','subject_display'=>'件名：',
  'copy_btn'=>'メッセージ本文をコピー','copied'=>'コピーしました！',
  'send_another'=>'← 別のメッセージを送る',
  'err_trans'=>'翻訳コードを入力してください。',
  'err_book_empty'=>'書の略語を入力してください。',
  'err_book_invalid'=>'略語「%s」は認識されません。mt、mk、lk、jn、ac、ro などの標準略語を使用してください。',
  'err_chapter'=>'有効な章番号を入力してください。',
  'err_verse'=>'有効な節番号を入力してください。',
  'err_current'=>'現在のテキストの内容を入力してください。',
  'err_correct'=>'正しい内容を入力してください。',
  'err_name'=>'お名前を入力してください。',
  'err_email'=>'有効なメールアドレスを入力してください。',
  'err_subject'=>'件名を入力してください。',
  'err_message'=>'メッセージを入力してください（10文字以上）。',
  'err_type'=>'メッセージの種類を選択してください。',
  'reason_label'=>'お問い合わせの理由','reason_placeholder'=>'— 理由を選んでください —',
  'reason_B'=>'聖書翻訳の提案','reason_P'=>'出版または著作権に関するご質問',
  'reason_R'=>'メーリングリストへの参加申請','reason_O'=>'その他',
  'body_prompt'=>'こちらにメッセージを入力してから、メールを送信してください。',
  'body_reads_now'=>'現在の本文:',
  'body_better'=>'改善案:',
];

$T['ko'] = [
  'title'=>'문의하기','subtitle'=>'eBible.us 팀에 메시지 보내기',
  'step1'=>'1단계 — 어떤 종류의 메시지입니까?',
  'typo_title'=>'오타 또는 번역 오류',
  'typo_desc'=>'성경 텍스트에서 오류를 발견했습니다 — 잘못된 단어, 맞춤법 오류 또는 부정확해 보이는 구절.',
  'general_title'=>'일반 질문 또는 의견',
  'general_desc'=>'팀에 질문, 제안 또는 기타 메시지가 있습니다.',
  'step2_typo'=>'2단계 — 오류에 대해 알려주세요',
  'trans_label'=>'번역 코드','trans_hint'=>'예: <code>tl</code>(테툼어), <code>engwebp</code>(영어 WEB), <code>porbrbsl</code>(포르투갈어)',
  'book_label'=>'성경','book_hint'=>'약어',
  'chapter_label'=>'장','verse_label'=>'절',
  'current_label'=>'텍스트에 현재 쓰여 있는 내용','current_hint'=>'보이는 텍스트를 정확히 복사하여 붙여넣기',
  'correct_label'=>'올바르게 쓰여야 하는 내용','correct_hint'=>'올바른 텍스트를 입력하세요',
  'step3'=>'3단계 — 연락처 정보',
  'name_label'=>'이름','email_label'=>'이메일 주소',
  'submit'=>'메시지 준비하기 →',
  'step2_general'=>'2단계 — 메시지',
  'subject_label'=>'제목','message_label'=>'메시지',
  'success_heading'=>'메시지가 전송 준비되었습니다',
  'success1'=>'<strong>이메일 프로그램 열기</strong>를 클릭하세요 — 제목이 미리 입력된 새 이메일이 열립니다.',
  'success2'=>'아래의 <strong>메시지 본문 복사</strong>를 클릭한 다음 이메일 본문에 붙여넣으세요.',
  'success3'=>'이메일 프로그램에서 <strong>보내기</strong>를 클릭하세요.',
  'open_email'=>'이메일 프로그램 열기 →','open_gmail'=>'Gmail에서 열기 →',
  'no_email'=>'어느 버튼이든 제목이 미리 입력된 이메일을 엽니다. 보내기 전에 본문을 복사하여 붙여넣으세요.',
  'to_label'=>'받는 사람:','subject_display'=>'제목:',
  'copy_btn'=>'메시지 본문 복사','copied'=>'복사됨!',
  'send_another'=>'← 다른 메시지 보내기',
  'err_trans'=>'번역 코드를 입력하세요.',
  'err_book_empty'=>'성경 약어를 입력하세요.',
  'err_book_invalid'=>'약어 "%s"을(를) 인식할 수 없습니다. mt, mk, lk, jn, ac, ro 등의 표준 약어를 사용하세요.',
  'err_chapter'=>'유효한 장 번호를 입력하세요.',
  'err_verse'=>'유효한 절 번호를 입력하세요.',
  'err_current'=>'텍스트에 현재 쓰여 있는 내용을 입력하세요.',
  'err_correct'=>'올바르게 쓰여야 하는 내용을 입력하세요.',
  'err_name'=>'이름을 입력하세요.',
  'err_email'=>'유효한 이메일 주소를 입력하세요.',
  'err_subject'=>'제목을 입력하세요.',
  'err_message'=>'메시지를 입력하세요 (최소 10자).',
  'err_type'=>'메시지 유형을 선택하세요.',
  'reason_label'=>'문의 이유','reason_placeholder'=>'— 이유를 선택하세요 —',
  'reason_B'=>'성경 번역 제안','reason_P'=>'출판 또는 저작권 질문',
  'reason_R'=>'메일링 리스트 가입 요청','reason_O'=>'기타',
  'body_prompt'=>'여기에 메시지를 입력한 후 이메일을 보내세요.',
  'body_reads_now'=>'현재 내용:',
  'body_better'=>'개선 제안:',
];

$T['id'] = [
  'title'=>'Hubungi Kami','subtitle'=>'Kirim pesan ke tim eBible.us',
  'step1'=>'Langkah 1 — Pesan jenis apa ini?',
  'typo_title'=>'Kesalahan ketik atau terjemahan',
  'typo_desc'=>'Saya menemukan kesalahan dalam teks Alkitab — kata yang salah, kesalahan ejaan, atau ayat yang tampak tidak tepat.',
  'general_title'=>'Pertanyaan atau komentar umum',
  'general_desc'=>'Saya memiliki pertanyaan, saran, atau pesan lain untuk tim.',
  'step2_typo'=>'Langkah 2 — Ceritakan tentang kesalahannya',
  'trans_label'=>'Kode terjemahan','trans_hint'=>'mis. <code>tl</code> untuk Tetum, <code>engwebp</code> untuk Inggris WEB, <code>porbrbsl</code> untuk Portugis',
  'book_label'=>'Kitab','book_hint'=>'singkatan',
  'chapter_label'=>'Pasal','verse_label'=>'Ayat',
  'current_label'=>'Apa yang saat ini tertulis dalam teks','current_hint'=>'salin dan tempel teks persis yang Anda lihat',
  'correct_label'=>'Apa yang seharusnya tertulis','correct_hint'=>'masukkan teks yang benar',
  'step3'=>'Langkah 3 — Informasi kontak Anda',
  'name_label'=>'Nama Anda','email_label'=>'Alamat email Anda',
  'submit'=>'Siapkan pesan saya →',
  'step2_general'=>'Langkah 2 — Pesan Anda',
  'subject_label'=>'Subjek','message_label'=>'Pesan Anda',
  'success_heading'=>'Pesan Anda siap dikirim',
  'success1'=>'Klik <strong>Buka program email</strong> — membuka email baru dengan subjek yang sudah terisi.',
  'success2'=>'Klik <strong>Salin isi pesan</strong> di bawah, lalu tempelkan ke badan email.',
  'success3'=>'Klik <strong>Kirim</strong> di program email Anda.',
  'open_email'=>'Buka program email →','open_gmail'=>'Buka di Gmail →',
  'no_email'=>'Tombol mana pun membuka email dengan subjek terisi. Salin dan tempel isi pesan sebelum mengirim.',
  'to_label'=>'Kepada:','subject_display'=>'Subjek:',
  'copy_btn'=>'Salin isi pesan','copied'=>'Disalin!',
  'send_another'=>'← Kirim pesan lain',
  'err_trans'=>'Harap masukkan kode terjemahan.',
  'err_book_empty'=>'Harap masukkan singkatan kitab.',
  'err_book_invalid'=>'Singkatan "%s" tidak dikenali. Gunakan singkatan standar seperti mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Harap masukkan nomor pasal yang valid.',
  'err_verse'=>'Harap masukkan nomor ayat yang valid.',
  'err_current'=>'Harap masukkan apa yang saat ini tertulis dalam teks.',
  'err_correct'=>'Harap masukkan apa yang seharusnya tertulis.',
  'err_name'=>'Harap masukkan nama Anda.',
  'err_email'=>'Harap masukkan alamat email yang valid.',
  'err_subject'=>'Harap masukkan subjek.',
  'err_message'=>'Harap masukkan pesan (minimal 10 karakter).',
  'err_type'=>'Harap pilih jenis pesan.',
  'reason_label'=>'Alasan menghubungi','reason_placeholder'=>'— Pilih alasan —',
  'reason_B'=>'Saran terjemahan Alkitab','reason_P'=>'Pertanyaan tentang penerbitan atau hak cipta',
  'reason_R'=>'Permintaan untuk bergabung ke daftar surat','reason_O'=>'Lainnya',
  'body_prompt'=>'Silakan ketik pesan Anda di sini lalu kirim email.',
  'body_reads_now'=>'Isi teks saat ini:',
  'body_better'=>'Bagaimana sebaiknya:',
];

$T['tr'] = [
  'title'=>'İletişim','subtitle'=>'eBible.us ekibine mesaj gönderin',
  'step1'=>'Adım 1 — Bu nasıl bir mesaj?',
  'typo_title'=>'Yazım hatası veya çeviri hatası',
  'typo_desc'=>'Kutsal Kitap metninde hata buldum — yanlış kelime, yazım hatası veya yanlış görünen ayet.',
  'general_title'=>'Genel soru veya yorum',
  'general_desc'=>'Ekibe bir sorum, önerim veya başka bir mesajım var.',
  'step2_typo'=>'Adım 2 — Hata hakkında bize bilgi verin',
  'trans_label'=>'Çeviri kodu','trans_hint'=>'örn. <code>tl</code> Tetum için, <code>engwebp</code> İngilizce WEB için, <code>porbrbsl</code> Portekizce için',
  'book_label'=>'Kitap','book_hint'=>'kısaltma',
  'chapter_label'=>'Bölüm','verse_label'=>'Ayet',
  'current_label'=>'Metnin şu anda ne yazdığı','current_hint'=>'gördüğünüz tam metni kopyalayıp yapıştırın',
  'correct_label'=>'Ne yazması gerektiği','correct_hint'=>'doğru metni girin',
  'step3'=>'Adım 3 — İletişim bilgileriniz',
  'name_label'=>'Adınız','email_label'=>'E-posta adresiniz',
  'submit'=>'Mesajımı hazırla →',
  'step2_general'=>'Adım 2 — Mesajınız',
  'subject_label'=>'Konu','message_label'=>'Mesajınız',
  'success_heading'=>'Mesajınız gönderilmeye hazır',
  'success1'=>'<strong>E-posta programını aç</strong>\'a tıklayın — konu önceden doldurulmuş yeni bir e-posta açar.',
  'success2'=>'Aşağıdaki <strong>Mesaj gövdesini kopyala</strong>\'ya tıklayın ve e-postaya yapıştırın.',
  'success3'=>'E-posta programınızda <strong>Gönder</strong>\'e tıklayın.',
  'open_email'=>'E-posta programını aç →','open_gmail'=>'Gmail\'de aç →',
  'no_email'=>'Her iki düğme de konusu doldurulmuş e-posta açar. Göndermeden önce mesaj gövdesini kopyalayıp yapıştırın.',
  'to_label'=>'Kime:','subject_display'=>'Konu:',
  'copy_btn'=>'Mesaj gövdesini kopyala','copied'=>'Kopyalandı!',
  'send_another'=>'← Başka bir mesaj gönder',
  'err_trans'=>'Lütfen çeviri kodunu girin.',
  'err_book_empty'=>'Lütfen kitap kısaltmasını girin.',
  'err_book_invalid'=>'Kısaltma "%s" tanınmadı. mt, mk, lk, jn, ac, ro gibi standart kısaltmalar kullanın.',
  'err_chapter'=>'Lütfen geçerli bir bölüm numarası girin.',
  'err_verse'=>'Lütfen geçerli bir ayet numarası girin.',
  'err_current'=>'Lütfen metnin şu anda ne yazdığını girin.',
  'err_correct'=>'Lütfen ne yazması gerektiğini girin.',
  'err_name'=>'Lütfen adınızı girin.',
  'err_email'=>'Lütfen geçerli bir e-posta adresi girin.',
  'err_subject'=>'Lütfen bir konu girin.',
  'err_message'=>'Lütfen bir mesaj girin (en az 10 karakter).',
  'err_type'=>'Lütfen bir mesaj türü seçin.',
  'reason_label'=>'İletişim nedeni','reason_placeholder'=>'— Bir neden seçin —',
  'reason_B'=>'İncil çevirisi önerisi','reason_P'=>'Yayıncılık veya telif hakkı sorusu',
  'reason_R'=>'Posta listesine katılma isteği','reason_O'=>'Diğer',
  'body_prompt'=>'Lütfen mesajınızı buraya yazın ve ardından e-postayı gönderin.',
  'body_reads_now'=>'Metin şu an nasıl okuyor:',
  'body_better'=>'Nasıl daha iyi olabilir:',
];

$T['it'] = [
  'title'=>'Contattaci','subtitle'=>'Invia un messaggio al team di eBible.us',
  'step1'=>'Passaggio 1 — Che tipo di messaggio è questo?',
  'typo_title'=>'Refuso o errore di traduzione',
  'typo_desc'=>'Ho trovato un errore in un testo biblico — una parola sbagliata, un errore ortografico o un versetto che sembra errato.',
  'general_title'=>'Domanda o commento generale',
  'general_desc'=>'Ho una domanda, un suggerimento o un altro messaggio per il team.',
  'step2_typo'=>"Passaggio 2 — Raccontaci dell'errore",
  'trans_label'=>'Codice di traduzione','trans_hint'=>'es. <code>tl</code> per il Tetum, <code>engwebp</code> per l\'inglese WEB, <code>porbrbsl</code> per il portoghese',
  'book_label'=>'Libro','book_hint'=>'abbreviazione',
  'chapter_label'=>'Capitolo','verse_label'=>'Versetto',
  'current_label'=>'Quello che il testo dice attualmente','current_hint'=>'copia e incolla il testo esatto che vedi',
  'correct_label'=>'Quello che dovrebbe dire','correct_hint'=>'inserisci il testo corretto',
  'step3'=>'Passaggio 3 — I tuoi dati di contatto',
  'name_label'=>'Il tuo nome','email_label'=>'Il tuo indirizzo email',
  'submit'=>'Prepara il mio messaggio →',
  'step2_general'=>'Passaggio 2 — Il tuo messaggio',
  'subject_label'=>'Oggetto','message_label'=>'Il tuo messaggio',
  'success_heading'=>'Il tuo messaggio è pronto per essere inviato',
  'success1'=>'Clicca su <strong>Apri programma email</strong> — apre una nuova email con l\'oggetto precompilato.',
  'success2'=>'Clicca su <strong>Copia corpo del messaggio</strong> qui sotto e incollalo nell\'email.',
  'success3'=>'Clicca su <strong>Invia</strong> nel tuo programma email.',
  'open_email'=>'Apri programma email →','open_gmail'=>'Apri in Gmail →',
  'no_email'=>'Entrambi i pulsanti aprono un\'email con l\'oggetto precompilato. Copia e incolla il corpo prima di inviare.',
  'to_label'=>'A:','subject_display'=>'Oggetto:',
  'copy_btn'=>'Copia corpo del messaggio','copied'=>'Copiato!',
  'send_another'=>'← Invia un altro messaggio',
  'err_trans'=>'Inserisci il codice di traduzione.',
  'err_book_empty'=>'Inserisci l\'abbreviazione del libro.',
  'err_book_invalid'=>'Abbreviazione "%s" non riconosciuta. Usa abbreviazioni standard come mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Inserisci un numero di capitolo valido.',
  'err_verse'=>'Inserisci un numero di versetto valido.',
  'err_current'=>'Inserisci quello che il testo dice attualmente.',
  'err_correct'=>'Inserisci quello che dovrebbe dire.',
  'err_name'=>'Inserisci il tuo nome.',
  'err_email'=>'Inserisci un indirizzo email valido.',
  'err_subject'=>'Inserisci un oggetto.',
  'err_message'=>'Inserisci un messaggio (almeno 10 caratteri).',
  'err_type'=>'Scegli un tipo di messaggio.',
  'reason_label'=>'Motivo del contatto','reason_placeholder'=>'— Scegli un motivo —',
  'reason_B'=>'Suggerimento di traduzione biblica','reason_P'=>'Domanda su pubblicazione o diritti d\'autore',
  'reason_R'=>'Richiesta di iscrizione alla mailing list','reason_O'=>'Altro',
  'body_prompt'=>'Per favore scrivi il tuo messaggio qui e poi invia l\'email.',
  'body_reads_now'=>'Come appare attualmente:',
  'body_better'=>'Come potrebbe essere migliorato:',
];

$T['vi'] = [
  'title'=>'Liên hệ','subtitle'=>'Gửi tin nhắn cho đội ngũ eBible.us',
  'step1'=>'Bước 1 — Đây là loại tin nhắn gì?',
  'typo_title'=>'Lỗi đánh máy hoặc lỗi dịch thuật',
  'typo_desc'=>'Tôi tìm thấy lỗi trong văn bản Kinh Thánh — từ sai, lỗi chính tả hoặc câu có vẻ không chính xác.',
  'general_title'=>'Câu hỏi hoặc nhận xét chung',
  'general_desc'=>'Tôi có câu hỏi, đề xuất hoặc tin nhắn khác gửi cho đội ngũ.',
  'step2_typo'=>'Bước 2 — Cho chúng tôi biết về lỗi',
  'trans_label'=>'Mã bản dịch','trans_hint'=>'vd. <code>tl</code> cho Tetum, <code>engwebp</code> cho tiếng Anh WEB, <code>porbrbsl</code> cho tiếng Bồ Đào Nha',
  'book_label'=>'Sách','book_hint'=>'viết tắt',
  'chapter_label'=>'Chương','verse_label'=>'Câu',
  'current_label'=>'Những gì văn bản hiện đang nói','current_hint'=>'sao chép và dán văn bản chính xác bạn thấy',
  'correct_label'=>'Những gì nó nên nói','correct_hint'=>'nhập văn bản đúng',
  'step3'=>'Bước 3 — Thông tin liên hệ của bạn',
  'name_label'=>'Tên của bạn','email_label'=>'Địa chỉ email của bạn',
  'submit'=>'Chuẩn bị tin nhắn của tôi →',
  'step2_general'=>'Bước 2 — Tin nhắn của bạn',
  'subject_label'=>'Chủ đề','message_label'=>'Tin nhắn của bạn',
  'success_heading'=>'Tin nhắn của bạn đã sẵn sàng gửi',
  'success1'=>'Nhấp vào <strong>Mở chương trình email</strong> — mở email mới với chủ đề được điền sẵn.',
  'success2'=>'Nhấp vào <strong>Sao chép nội dung tin nhắn</strong> bên dưới và dán vào email.',
  'success3'=>'Nhấp vào <strong>Gửi</strong> trong chương trình email của bạn.',
  'open_email'=>'Mở chương trình email →','open_gmail'=>'Mở trong Gmail →',
  'no_email'=>'Nút nào cũng mở email với chủ đề điền sẵn. Sao chép và dán nội dung trước khi gửi.',
  'to_label'=>'Đến:','subject_display'=>'Chủ đề:',
  'copy_btn'=>'Sao chép nội dung tin nhắn','copied'=>'Đã sao chép!',
  'send_another'=>'← Gửi tin nhắn khác',
  'err_trans'=>'Vui lòng nhập mã bản dịch.',
  'err_book_empty'=>'Vui lòng nhập tên viết tắt của sách.',
  'err_book_invalid'=>'Tên viết tắt "%s" không được nhận dạng. Sử dụng tên viết tắt chuẩn như mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Vui lòng nhập số chương hợp lệ.',
  'err_verse'=>'Vui lòng nhập số câu hợp lệ.',
  'err_current'=>'Vui lòng nhập những gì văn bản hiện đang nói.',
  'err_correct'=>'Vui lòng nhập những gì nó nên nói.',
  'err_name'=>'Vui lòng nhập tên của bạn.',
  'err_email'=>'Vui lòng nhập địa chỉ email hợp lệ.',
  'err_subject'=>'Vui lòng nhập chủ đề.',
  'err_message'=>'Vui lòng nhập tin nhắn (ít nhất 10 ký tự).',
  'err_type'=>'Vui lòng chọn loại tin nhắn.',
  'reason_label'=>'Lý do liên hệ','reason_placeholder'=>'— Chọn lý do —',
  'reason_B'=>'Đề xuất dịch thuật Kinh Thánh','reason_P'=>'Câu hỏi về xuất bản hoặc bản quyền',
  'reason_R'=>'Yêu cầu tham gia danh sách gửi thư','reason_O'=>'Khác',
  'body_prompt'=>'Vui lòng nhập tin nhắn của bạn ở đây rồi gửi email.',
  'body_reads_now'=>'Văn bản hiện tại:',
  'body_better'=>'Cách cải thiện:',
];

$T['th'] = [
  'title'=>'ติดต่อเรา','subtitle'=>'ส่งข้อความถึงทีม eBible.us',
  'step1'=>'ขั้นตอนที่ 1 — ข้อความประเภทใด?',
  'typo_title'=>'ข้อผิดพลาดการพิมพ์หรือการแปล',
  'typo_desc'=>'ฉันพบข้อผิดพลาดในข้อความพระคัมภีร์ — คำผิด ข้อผิดพลาดการสะกด หรือข้อที่ดูไม่ถูกต้อง',
  'general_title'=>'คำถามหรือความคิดเห็นทั่วไป',
  'general_desc'=>'ฉันมีคำถาม ข้อเสนอแนะ หรือข้อความอื่นสำหรับทีม',
  'step2_typo'=>'ขั้นตอนที่ 2 — บอกเราเกี่ยวกับข้อผิดพลาด',
  'trans_label'=>'รหัสการแปล','trans_hint'=>'เช่น <code>tl</code> สำหรับภาษาเตตุม, <code>engwebp</code> สำหรับภาษาอังกฤษ WEB, <code>porbrbsl</code> สำหรับภาษาโปรตุเกส',
  'book_label'=>'หนังสือ','book_hint'=>'ตัวย่อ',
  'chapter_label'=>'บท','verse_label'=>'ข้อ',
  'current_label'=>'สิ่งที่ข้อความระบุในปัจจุบัน','current_hint'=>'คัดลอกและวางข้อความที่คุณเห็น',
  'correct_label'=>'สิ่งที่ควรระบุ','correct_hint'=>'ป้อนข้อความที่ถูกต้อง',
  'step3'=>'ขั้นตอนที่ 3 — ข้อมูลการติดต่อของคุณ',
  'name_label'=>'ชื่อของคุณ','email_label'=>'ที่อยู่อีเมลของคุณ',
  'submit'=>'เตรียมข้อความของฉัน →',
  'step2_general'=>'ขั้นตอนที่ 2 — ข้อความของคุณ',
  'subject_label'=>'หัวเรื่อง','message_label'=>'ข้อความของคุณ',
  'success_heading'=>'ข้อความของคุณพร้อมส่งแล้ว',
  'success1'=>'คลิก<strong>เปิดโปรแกรมอีเมล</strong> — เปิดอีเมลใหม่พร้อมหัวเรื่องที่กรอกไว้ล่วงหน้า',
  'success2'=>'คลิก<strong>คัดลอกเนื้อหาข้อความ</strong>ด้านล่างแล้ววางลงในอีเมล',
  'success3'=>'คลิก<strong>ส่ง</strong>ในโปรแกรมอีเมลของคุณ',
  'open_email'=>'เปิดโปรแกรมอีเมล →','open_gmail'=>'เปิดใน Gmail →',
  'no_email'=>'ปุ่มใดก็ตามจะเปิดอีเมลพร้อมหัวเรื่อง คัดลอกและวางเนื้อหาก่อนส่ง',
  'to_label'=>'ถึง:','subject_display'=>'หัวเรื่อง:',
  'copy_btn'=>'คัดลอกเนื้อหาข้อความ','copied'=>'คัดลอกแล้ว!',
  'send_another'=>'← ส่งข้อความอื่น',
  'err_trans'=>'กรุณาป้อนรหัสการแปล',
  'err_book_empty'=>'กรุณาป้อนตัวย่อหนังสือ',
  'err_book_invalid'=>'ตัวย่อ "%s" ไม่ได้รับการรู้จัก ใช้ตัวย่อมาตรฐาน เช่น mt, mk, lk, jn, ac, ro',
  'err_chapter'=>'กรุณาป้อนหมายเลขบทที่ถูกต้อง',
  'err_verse'=>'กรุณาป้อนหมายเลขข้อที่ถูกต้อง',
  'err_current'=>'กรุณาป้อนสิ่งที่ข้อความระบุในปัจจุบัน',
  'err_correct'=>'กรุณาป้อนสิ่งที่ควรระบุ',
  'err_name'=>'กรุณาป้อนชื่อของคุณ',
  'err_email'=>'กรุณาป้อนที่อยู่อีเมลที่ถูกต้อง',
  'err_subject'=>'กรุณาป้อนหัวเรื่อง',
  'err_message'=>'กรุณาป้อนข้อความ (อย่างน้อย 10 ตัวอักษร)',
  'err_type'=>'กรุณาเลือกประเภทข้อความ',
  'reason_label'=>'เหตุผลในการติดต่อ','reason_placeholder'=>'— เลือกเหตุผล —',
  'reason_B'=>'ข้อเสนอแนะการแปลพระคัมภีร์','reason_P'=>'คำถามเกี่ยวกับการพิมพ์หรือลิขสิทธิ์',
  'reason_R'=>'ขอเข้าร่วมรายชื่อผู้รับจดหมาย','reason_O'=>'อื่นๆ',
  'body_prompt'=>'กรุณาพิมพ์ข้อความของคุณที่นี่แล้วส่งอีเมล',
  'body_reads_now'=>'ข้อความปัจจุบัน:',
  'body_better'=>'ควรเป็นอย่างไร:',
];

$T['nl'] = [
  'title'=>'Contact','subtitle'=>'Stuur een bericht naar het eBible.us-team',
  'step1'=>'Stap 1 — Wat voor soort bericht is dit?',
  'typo_title'=>'Typefout of vertaalfout',
  'typo_desc'=>'Ik heb een fout gevonden in een Bijbeltekst — een verkeerd woord, spellingsfout of vers dat onjuist lijkt.',
  'general_title'=>'Algemene vraag of opmerking',
  'general_desc'=>'Ik heb een vraag, suggestie of ander bericht voor het team.',
  'step2_typo'=>'Stap 2 — Vertel ons over de fout',
  'trans_label'=>'Vertaalcode','trans_hint'=>'bijv. <code>tl</code> voor Tetum, <code>engwebp</code> voor Engels WEB, <code>porbrbsl</code> voor Portugees',
  'book_label'=>'Boek','book_hint'=>'afkorting',
  'chapter_label'=>'Hoofdstuk','verse_label'=>'Vers',
  'current_label'=>'Wat de tekst momenteel zegt','current_hint'=>'kopieer en plak de exacte tekst die u ziet',
  'correct_label'=>'Wat het zou moeten zeggen','correct_hint'=>'voer de juiste tekst in',
  'step3'=>'Stap 3 — Uw contactgegevens',
  'name_label'=>'Uw naam','email_label'=>'Uw e-mailadres',
  'submit'=>'Mijn bericht voorbereiden →',
  'step2_general'=>'Stap 2 — Uw bericht',
  'subject_label'=>'Onderwerp','message_label'=>'Uw bericht',
  'success_heading'=>'Uw bericht is klaar om te verzenden',
  'success1'=>'Klik op <strong>E-mailprogramma openen</strong> — opent een nieuw e-mailbericht met het onderwerp vooringevuld.',
  'success2'=>'Klik op <strong>Berichttekst kopiëren</strong> hieronder en plak het in de e-mail.',
  'success3'=>'Klik op <strong>Verzenden</strong> in uw e-mailprogramma.',
  'open_email'=>'E-mailprogramma openen →','open_gmail'=>'Openen in Gmail →',
  'no_email'=>'Elke knop opent een e-mail met het onderwerp vooringevuld. Kopieer en plak de tekst voor het verzenden.',
  'to_label'=>'Aan:','subject_display'=>'Onderwerp:',
  'copy_btn'=>'Berichttekst kopiëren','copied'=>'Gekopieerd!',
  'send_another'=>'← Nog een bericht sturen',
  'err_trans'=>'Voer de vertaalcode in.',
  'err_book_empty'=>'Voer de boekafkorting in.',
  'err_book_invalid'=>'Afkorting "%s" niet herkend. Gebruik standaard afkortingen zoals mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Voer een geldig hoofdstuknummer in.',
  'err_verse'=>'Voer een geldig versnummer in.',
  'err_current'=>'Voer in wat de tekst momenteel zegt.',
  'err_correct'=>'Voer in wat het zou moeten zeggen.',
  'err_name'=>'Voer uw naam in.',
  'err_email'=>'Voer een geldig e-mailadres in.',
  'err_subject'=>'Voer een onderwerp in.',
  'err_message'=>'Voer een bericht in (minimaal 10 tekens).',
  'err_type'=>'Kies een berichttype.',
  'reason_label'=>'Reden van contact','reason_placeholder'=>'— Kies een reden —',
  'reason_B'=>'Bijbelvertaling suggestie','reason_P'=>'Vraag over publicatie of auteursrecht',
  'reason_R'=>'Verzoek om inschrijving op de mailinglijst','reason_O'=>'Anders',
  'body_prompt'=>'Typ hier uw bericht en stuur dan de e-mail.',
  'body_reads_now'=>'Hoe de tekst er nu uitziet:',
  'body_better'=>'Hoe het verbeterd kan worden:',
];

$T['pl'] = [
  'title'=>'Kontakt','subtitle'=>'Wyślij wiadomość do zespołu eBible.us',
  'step1'=>'Krok 1 — Jaki to rodzaj wiadomości?',
  'typo_title'=>'Literówka lub błąd tłumaczenia',
  'typo_desc'=>'Znalazłem błąd w tekście biblijnym — nieprawidłowe słowo, błąd ortograficzny lub werset, który wydaje się niepoprawny.',
  'general_title'=>'Ogólne pytanie lub komentarz',
  'general_desc'=>'Mam pytanie, sugestię lub inną wiadomość dla zespołu.',
  'step2_typo'=>'Krok 2 — Powiedz nam o błędzie',
  'trans_label'=>'Kod tłumaczenia','trans_hint'=>'np. <code>tl</code> dla Tetum, <code>engwebp</code> dla angielskiego WEB, <code>porbrbsl</code> dla portugalskiego',
  'book_label'=>'Księga','book_hint'=>'skrót',
  'chapter_label'=>'Rozdział','verse_label'=>'Werset',
  'current_label'=>'Co aktualnie mówi tekst','current_hint'=>'skopiuj i wklej dokładny tekst, który widzisz',
  'correct_label'=>'Co powinien mówić','correct_hint'=>'wprowadź poprawny tekst',
  'step3'=>'Krok 3 — Twoje dane kontaktowe',
  'name_label'=>'Twoje imię i nazwisko','email_label'=>'Twój adres e-mail',
  'submit'=>'Przygotuj moją wiadomość →',
  'step2_general'=>'Krok 2 — Twoja wiadomość',
  'subject_label'=>'Temat','message_label'=>'Twoja wiadomość',
  'success_heading'=>'Twoja wiadomość jest gotowa do wysłania',
  'success1'=>'Kliknij <strong>Otwórz program pocztowy</strong> — otwiera nową wiadomość e-mail z wstępnie wypełnionym tematem.',
  'success2'=>'Kliknij <strong>Kopiuj treść wiadomości</strong> poniżej i wklej ją do e-maila.',
  'success3'=>'Kliknij <strong>Wyślij</strong> w swoim programie pocztowym.',
  'open_email'=>'Otwórz program pocztowy →','open_gmail'=>'Otwórz w Gmail →',
  'no_email'=>'Każdy przycisk otwiera e-mail z wstępnie wypełnionym tematem. Skopiuj i wklej treść przed wysłaniem.',
  'to_label'=>'Do:','subject_display'=>'Temat:',
  'copy_btn'=>'Kopiuj treść wiadomości','copied'=>'Skopiowano!',
  'send_another'=>'← Wyślij kolejną wiadomość',
  'err_trans'=>'Proszę podać kod tłumaczenia.',
  'err_book_empty'=>'Proszę podać skrót księgi.',
  'err_book_invalid'=>'Skrót "%s" nie został rozpoznany. Użyj standardowych skrótów takich jak mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Proszę podać prawidłowy numer rozdziału.',
  'err_verse'=>'Proszę podać prawidłowy numer wersetu.',
  'err_current'=>'Proszę podać, co aktualnie mówi tekst.',
  'err_correct'=>'Proszę podać, co powinien mówić.',
  'err_name'=>'Proszę podać swoje imię i nazwisko.',
  'err_email'=>'Proszę podać prawidłowy adres e-mail.',
  'err_subject'=>'Proszę podać temat.',
  'err_message'=>'Proszę podać wiadomość (co najmniej 10 znaków).',
  'err_type'=>'Proszę wybrać rodzaj wiadomości.',
  'reason_label'=>'Powód kontaktu','reason_placeholder'=>'— Wybierz powód —',
  'reason_B'=>'Sugestia tłumaczenia biblijnego','reason_P'=>'Pytanie dotyczące wydawnictwa lub praw autorskich',
  'reason_R'=>'Prośba o dołączenie do listy mailingowej','reason_O'=>'Inne',
  'body_prompt'=>'Proszę wpisać tutaj wiadomość, a następnie wysłać e-mail.',
  'body_reads_now'=>'Jak tekst brzmi teraz:',
  'body_better'=>'Jak mógłby brzmieć lepiej:',
];

$T['uk'] = [
  'title'=>'Зв\'язатися з нами','subtitle'=>'Надішліть повідомлення команді eBible.us',
  'step1'=>'Крок 1 — Який тип повідомлення?',
  'typo_title'=>'Друкарська помилка або помилка перекладу',
  'typo_desc'=>'Я знайшов помилку в біблійному тексті — неправильне слово, орфографічна помилка або вірш, який здається неточним.',
  'general_title'=>'Загальне запитання або коментар',
  'general_desc'=>'У мене є запитання, пропозиція або інше повідомлення для команди.',
  'step2_typo'=>'Крок 2 — Розкажіть нам про помилку',
  'trans_label'=>'Код перекладу','trans_hint'=>'напр. <code>tl</code> для Тетум, <code>engwebp</code> для англійської WEB, <code>porbrbsl</code> для португальської',
  'book_label'=>'Книга','book_hint'=>'скорочення',
  'chapter_label'=>'Глава','verse_label'=>'Вірш',
  'current_label'=>'Що зараз написано в тексті','current_hint'=>'скопіюйте та вставте точний текст, який ви бачите',
  'correct_label'=>'Що має бути написано','correct_hint'=>'введіть правильний текст',
  'step3'=>'Крок 3 — Ваші контактні дані',
  'name_label'=>'Ваше ім\'я','email_label'=>'Ваша електронна адреса',
  'submit'=>'Підготувати моє повідомлення →',
  'step2_general'=>'Крок 2 — Ваше повідомлення',
  'subject_label'=>'Тема','message_label'=>'Ваше повідомлення',
  'success_heading'=>'Ваше повідомлення готове до відправки',
  'success1'=>'Натисніть <strong>Відкрити поштову програму</strong> — відкриється новий лист з попередньо заповненою темою.',
  'success2'=>'Натисніть <strong>Скопіювати текст повідомлення</strong> нижче і вставте його в лист.',
  'success3'=>'Натисніть <strong>Надіслати</strong> у своїй поштовій програмі.',
  'open_email'=>'Відкрити поштову програму →','open_gmail'=>'Відкрити в Gmail →',
  'no_email'=>'Будь-яка кнопка відкриє лист з попередньо заповненою темою. Скопіюйте та вставте текст перед надсиланням.',
  'to_label'=>'Кому:','subject_display'=>'Тема:',
  'copy_btn'=>'Скопіювати текст повідомлення','copied'=>'Скопійовано!',
  'send_another'=>'← Надіслати ще одне повідомлення',
  'err_trans'=>'Будь ласка, введіть код перекладу.',
  'err_book_empty'=>'Будь ласка, введіть скорочення книги.',
  'err_book_invalid'=>'Скорочення "%s" не розпізнано. Використовуйте стандартні скорочення: mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Будь ласка, введіть дійсний номер глави.',
  'err_verse'=>'Будь ласка, введіть дійсний номер вірша.',
  'err_current'=>'Будь ласка, введіть те, що зараз написано в тексті.',
  'err_correct'=>'Будь ласка, введіть те, що має бути написано.',
  'err_name'=>'Будь ласка, введіть ваше ім\'я.',
  'err_email'=>'Будь ласка, введіть дійсну електронну адресу.',
  'err_subject'=>'Будь ласка, введіть тему.',
  'err_message'=>'Будь ласка, введіть повідомлення (мінімум 10 символів).',
  'err_type'=>'Будь ласка, оберіть тип повідомлення.',
  'reason_label'=>'Причина звернення','reason_placeholder'=>'— Оберіть причину —',
  'reason_B'=>'Пропозиція щодо перекладу Біблії','reason_P'=>'Питання щодо видавництва або авторського права',
  'reason_R'=>'Запит на підписку на розсилку','reason_O'=>'Інше',
  'body_prompt'=>'Будь ласка, напишіть ваше повідомлення тут, а потім надішліть листа.',
  'body_reads_now'=>'Як текст звучить зараз:',
  'body_better'=>'Як міг би звучати краще:',
];

$T['bn'] = [
  'title'=>'যোগাযোগ করুন','subtitle'=>'eBible.us টিমকে একটি বার্তা পাঠান',
  'step1'=>'ধাপ ১ — এটি কোন ধরনের বার্তা?',
  'typo_title'=>'টাইপো বা অনুবাদ ত্রুটি',
  'typo_desc'=>'আমি একটি বাইবেল পাঠে ভুল খুঁজে পেয়েছি — একটি ভুল শব্দ, বানান ত্রুটি বা একটি পদ যা ভুল মনে হচ্ছে।',
  'general_title'=>'সাধারণ প্রশ্ন বা মন্তব্য',
  'general_desc'=>'দলের জন্য আমার একটি প্রশ্ন, পরামর্শ বা অন্য বার্তা আছে।',
  'step2_typo'=>'ধাপ ২ — ত্রুটি সম্পর্কে আমাদের বলুন',
  'trans_label'=>'অনুবাদ কোড','trans_hint'=>'উদা. <code>tl</code> টেটামের জন্য, <code>engwebp</code> ইংরেজি WEB এর জন্য, <code>porbrbsl</code> পর্তুগিজের জন্য',
  'book_label'=>'বই','book_hint'=>'সংক্ষেপ',
  'chapter_label'=>'অধ্যায়','verse_label'=>'পদ',
  'current_label'=>'বর্তমানে পাঠে কী লেখা আছে','current_hint'=>'আপনি যা দেখছেন তার সঠিক পাঠ্য কপি এবং পেস্ট করুন',
  'correct_label'=>'কী লেখা থাকা উচিত','correct_hint'=>'সঠিক পাঠ্য লিখুন',
  'step3'=>'ধাপ ৩ — আপনার যোগাযোগের তথ্য',
  'name_label'=>'আপনার নাম','email_label'=>'আপনার ইমেইল ঠিকানা',
  'submit'=>'আমার বার্তা প্রস্তুত করুন →',
  'step2_general'=>'ধাপ ২ — আপনার বার্তা',
  'subject_label'=>'বিষয়','message_label'=>'আপনার বার্তা',
  'success_heading'=>'আপনার বার্তা পাঠানোর জন্য প্রস্তুত',
  'success1'=>'<strong>ইমেইল প্রোগ্রাম খুলুন</strong> ক্লিক করুন — বিষয় পূর্ব-পূরণ সহ নতুন ইমেইল খোলে।',
  'success2'=>'নিচে <strong>বার্তার মূল অংশ কপি করুন</strong> ক্লিক করুন এবং ইমেইলে পেস্ট করুন।',
  'success3'=>'আপনার ইমেইল প্রোগ্রামে <strong>পাঠান</strong> ক্লিক করুন।',
  'open_email'=>'ইমেইল প্রোগ্রাম খুলুন →','open_gmail'=>'Gmail-এ খুলুন →',
  'no_email'=>'যেকোনো বোতাম বিষয় পূর্ব-পূরণ ইমেইল খোলে। পাঠানোর আগে বার্তার মূল অংশ কপি এবং পেস্ট করুন।',
  'to_label'=>'প্রতি:','subject_display'=>'বিষয়:',
  'copy_btn'=>'বার্তার মূল অংশ কপি করুন','copied'=>'কপি হয়েছে!',
  'send_another'=>'← আরেকটি বার্তা পাঠান',
  'err_trans'=>'অনুগ্রহ করে অনুবাদ কোড দিন।',
  'err_book_empty'=>'অনুগ্রহ করে বইয়ের সংক্ষেপ দিন।',
  'err_book_invalid'=>'সংক্ষেপ "%s" চেনা যাচ্ছে না। mt, mk, lk, jn, ac, ro এর মতো মানক সংক্ষেপ ব্যবহার করুন।',
  'err_chapter'=>'অনুগ্রহ করে একটি বৈধ অধ্যায় নম্বর দিন।',
  'err_verse'=>'অনুগ্রহ করে একটি বৈধ পদ নম্বর দিন।',
  'err_current'=>'অনুগ্রহ করে বর্তমানে পাঠে কী লেখা আছে তা দিন।',
  'err_correct'=>'অনুগ্রহ করে কী লেখা থাকা উচিত তা দিন।',
  'err_name'=>'অনুগ্রহ করে আপনার নাম দিন।',
  'err_email'=>'অনুগ্রহ করে একটি বৈধ ইমেইল ঠিকানা দিন।',
  'err_subject'=>'অনুগ্রহ করে বিষয় দিন।',
  'err_message'=>'অনুগ্রহ করে একটি বার্তা দিন (কমপক্ষে ১০ অক্ষর)।',
  'err_type'=>'অনুগ্রহ করে বার্তার ধরন বেছে নিন।',
  'reason_label'=>'যোগাযোগের কারণ','reason_placeholder'=>'— একটি কারণ বেছে নিন —',
  'reason_B'=>'বাইবেল অনুবাদ পরামর্শ','reason_P'=>'প্রকাশনা বা কপিরাইট প্রশ্ন',
  'reason_R'=>'মেইলিং তালিকায় যোগ দেওয়ার অনুরোধ','reason_O'=>'অন্যান্য',
  'body_prompt'=>'অনুগ্রহ করে এখানে আপনার বার্তা টাইপ করুন তারপর ইমেইল পাঠান।',
  'body_reads_now'=>'এখন পাঠ্যটি যা বলছে:',
  'body_better'=>'এটি কীভাবে আরও ভালো হতে পারে:',
];

$T['ur'] = [
  'title'=>'رابطہ کریں','subtitle'=>'eBible.us ٹیم کو پیغام بھیجیں',
  'step1'=>'مرحلہ 1 — یہ کس قسم کا پیغام ہے؟',
  'typo_title'=>'ٹائپو یا ترجمے کی غلطی',
  'typo_desc'=>'مجھے بائبل کے متن میں غلطی ملی — غلط لفظ، ہجے کی غلطی، یا آیت جو غلط لگتی ہے۔',
  'general_title'=>'عمومی سوال یا تبصرہ',
  'general_desc'=>'میرے پاس ٹیم کے لیے ایک سوال، تجویز یا دیگر پیغام ہے۔',
  'step2_typo'=>'مرحلہ 2 — ہمیں غلطی کے بارے میں بتائیں',
  'trans_label'=>'ترجمہ کوڈ','trans_hint'=>'مثلاً <code>tl</code> تیتوم کے لیے، <code>engwebp</code> انگریزی WEB کے لیے، <code>porbrbsl</code> پرتگالی کے لیے',
  'book_label'=>'کتاب','book_hint'=>'مختصر نام',
  'chapter_label'=>'باب','verse_label'=>'آیت',
  'current_label'=>'متن میں ابھی کیا لکھا ہے','current_hint'=>'جو متن آپ دیکھتے ہیں اسے کاپی اور پیسٹ کریں',
  'correct_label'=>'کیا ہونا چاہیے','correct_hint'=>'درست متن درج کریں',
  'step3'=>'مرحلہ 3 — آپ کی رابطہ معلومات',
  'name_label'=>'آپ کا نام','email_label'=>'آپ کا ای میل پتہ',
  'submit'=>'میرا پیغام تیار کریں →',
  'step2_general'=>'مرحلہ 2 — آپ کا پیغام',
  'subject_label'=>'موضوع','message_label'=>'آپ کا پیغام',
  'success_heading'=>'آپ کا پیغام بھیجنے کے لیے تیار ہے',
  'success1'=>'<strong>ای میل پروگرام کھولیں</strong> پر کلک کریں — موضوع پہلے سے بھرے ہوئے نئے ای میل کھلتا ہے۔',
  'success2'=>'نیچے <strong>پیغام کا متن کاپی کریں</strong> پر کلک کریں اور ای میل میں پیسٹ کریں۔',
  'success3'=>'اپنے ای میل پروگرام میں <strong>بھیجیں</strong> پر کلک کریں۔',
  'open_email'=>'ای میل پروگرام کھولیں →','open_gmail'=>'Gmail میں کھولیں →',
  'no_email'=>'کوئی بھی بٹن موضوع پہلے سے بھرے ای میل کھولتا ہے۔ بھیجنے سے پہلے پیغام کا متن کاپی اور پیسٹ کریں۔',
  'to_label'=>'بمقام:','subject_display'=>'موضوع:',
  'copy_btn'=>'پیغام کا متن کاپی کریں','copied'=>'کاپی ہو گیا!',
  'send_another'=>'← ایک اور پیغام بھیجیں',
  'err_trans'=>'براہ کرم ترجمہ کوڈ درج کریں۔',
  'err_book_empty'=>'براہ کرم کتاب کا مختصر نام درج کریں۔',
  'err_book_invalid'=>'مختصر نام "%s" پہچانا نہیں گیا۔ mt, mk, lk, jn, ac, ro جیسے معیاری مختصر نام استعمال کریں۔',
  'err_chapter'=>'براہ کرم ایک درست باب نمبر درج کریں۔',
  'err_verse'=>'براہ کرم ایک درست آیت نمبر درج کریں۔',
  'err_current'=>'براہ کرم درج کریں کہ متن میں ابھی کیا لکھا ہے۔',
  'err_correct'=>'براہ کرم درج کریں کہ کیا ہونا چاہیے۔',
  'err_name'=>'براہ کرم اپنا نام درج کریں۔',
  'err_email'=>'براہ کرم ایک درست ای میل پتہ درج کریں۔',
  'err_subject'=>'براہ کرم موضوع درج کریں۔',
  'err_message'=>'براہ کرم ایک پیغام درج کریں (کم از کم 10 حروف)۔',
  'err_type'=>'براہ کرم پیغام کی قسم منتخب کریں۔',
  'reason_label'=>'رابطے کی وجہ','reason_placeholder'=>'— ایک وجہ منتخب کریں —',
  'reason_B'=>'بائبل کے ترجمے کی تجویز','reason_P'=>'اشاعت یا کاپی رائٹ کا سوال',
  'reason_R'=>'میلنگ فہرست میں شامل ہونے کی درخواست','reason_O'=>'دیگر',
  'body_prompt'=>'براہ کرم یہاں اپنا پیغام ٹائپ کریں پھر ای میل بھیجیں۔',
  'body_reads_now'=>'متن ابھی کیا کہتا ہے:',
  'body_better'=>'یہ کیسے بہتر ہو سکتا ہے:',
];

$T['mr'] = [
  'title'=>'संपर्क करा','subtitle'=>'eBible.us टीमला संदेश पाठवा',
  'step1'=>'पायरी 1 — हा कोणत्या प्रकारचा संदेश आहे?',
  'typo_title'=>'टायपो किंवा भाषांतर त्रुटी',
  'typo_desc'=>'मला बायबलच्या मजकुरात चूक आढळली — चुकीचा शब्द, शुद्धलेखन त्रुटी, किंवा वचन जे चुकीचे वाटते.',
  'general_title'=>'सामान्य प्रश्न किंवा टिप्पणी',
  'general_desc'=>'माझ्याकडे टीमसाठी एक प्रश्न, सूचना किंवा इतर संदेश आहे.',
  'step2_typo'=>'पायरी 2 — आम्हाला त्रुटीबद्दल सांगा',
  'trans_label'=>'भाषांतर कोड','trans_hint'=>'उदा. <code>tl</code> टेटमसाठी, <code>engwebp</code> इंग्रजी WEB साठी, <code>porbrbsl</code> पोर्तुगीजसाठी',
  'book_label'=>'पुस्तक','book_hint'=>'संक्षेप',
  'chapter_label'=>'अध्याय','verse_label'=>'वचन',
  'current_label'=>'मजकुरात सध्या काय लिहिले आहे','current_hint'=>'आपण पाहत असलेला अचूक मजकूर कॉपी आणि पेस्ट करा',
  'correct_label'=>'काय असायला हवे','correct_hint'=>'योग्य मजकूर प्रविष्ट करा',
  'step3'=>'पायरी 3 — आपली संपर्क माहिती',
  'name_label'=>'आपले नाव','email_label'=>'आपला ईमेल पत्ता',
  'submit'=>'माझा संदेश तयार करा →',
  'step2_general'=>'पायरी 2 — आपला संदेश',
  'subject_label'=>'विषय','message_label'=>'आपला संदेश',
  'success_heading'=>'आपला संदेश पाठवण्यास तयार आहे',
  'success1'=>'<strong>ईमेल प्रोग्राम उघडा</strong> वर क्लिक करा — विषय पूर्व-भरलेल्या नवीन ईमेलसह उघडते.',
  'success2'=>'खाली <strong>संदेश मुख्य भाग कॉपी करा</strong> वर क्लिक करा आणि ईमेलमध्ये पेस्ट करा.',
  'success3'=>'आपल्या ईमेल प्रोग्राममध्ये <strong>पाठवा</strong> वर क्लिक करा.',
  'open_email'=>'ईमेल प्रोग्राम उघडा →','open_gmail'=>'Gmail मध्ये उघडा →',
  'no_email'=>'कोणताही बटण विषय पूर्व-भरलेला ईमेल उघडतो. पाठवण्यापूर्वी संदेशाचा मुख्य भाग कॉपी आणि पेस्ट करा.',
  'to_label'=>'प्रति:','subject_display'=>'विषय:',
  'copy_btn'=>'संदेश मुख्य भाग कॉपी करा','copied'=>'कॉपी केले!',
  'send_another'=>'← आणखी एक संदेश पाठवा',
  'err_trans'=>'कृपया भाषांतर कोड प्रविष्ट करा.',
  'err_book_empty'=>'कृपया पुस्तकाचा संक्षेप प्रविष्ट करा.',
  'err_book_invalid'=>'संक्षेप "%s" ओळखला नाही. mt, mk, lk, jn, ac, ro सारखे मानक संक्षेप वापरा.',
  'err_chapter'=>'कृपया वैध अध्याय क्रमांक प्रविष्ट करा.',
  'err_verse'=>'कृपया वैध वचन क्रमांक प्रविष्ट करा.',
  'err_current'=>'कृपया मजकुरात सध्या काय लिहिले आहे ते प्रविष्ट करा.',
  'err_correct'=>'कृपया काय असायला हवे ते प्रविष्ट करा.',
  'err_name'=>'कृपया आपले नाव प्रविष्ट करा.',
  'err_email'=>'कृपया वैध ईमेल पत्ता प्रविष्ट करा.',
  'err_subject'=>'कृपया विषय प्रविष्ट करा.',
  'err_message'=>'कृपया संदेश प्रविष्ट करा (किमान 10 वर्ण).',
  'err_type'=>'कृपया संदेशाचा प्रकार निवडा.',
  'reason_label'=>'संपर्काचे कारण','reason_placeholder'=>'— कारण निवडा —',
  'reason_B'=>'बायबल भाषांतर सूचना','reason_P'=>'प्रकाशन किंवा कॉपीराइट प्रश्न',
  'reason_R'=>'मेलिंग यादीत सामील होण्याची विनंती','reason_O'=>'इतर',
  'body_prompt'=>'कृपया येथे आपला संदेश टाइप करा आणि नंतर ईमेल पाठवा.',
  'body_reads_now'=>'मजकूर सध्या काय म्हणतो:',
  'body_better'=>'हे कसे सुधारता येईल:',
];

$T['te'] = [
  'title'=>'సంప్రదించండి','subtitle'=>'eBible.us బృందానికి సందేశం పంపండి',
  'step1'=>'దశ 1 — ఇది ఏ రకమైన సందేశం?',
  'typo_title'=>'టైపో లేదా అనువాద లోపం',
  'typo_desc'=>'నేను బైబిల్ వచనంలో లోపాన్ని కనుగొన్నాను — తప్పు పదం, స్పెల్లింగ్ లోపం, లేదా తప్పుగా అనిపించే వచనం.',
  'general_title'=>'సాధారణ ప్రశ్న లేదా వ్యాఖ్య',
  'general_desc'=>'బృందానికి నాకు ఒక ప్రశ్న, సూచన లేదా ఇతర సందేశం ఉంది.',
  'step2_typo'=>'దశ 2 — లోపం గురించి మాకు చెప్పండి',
  'trans_label'=>'అనువాద కోడ్','trans_hint'=>'ఉదా. <code>tl</code> తెతుమ్ కోసం, <code>engwebp</code> ఇంగ్లీష్ WEB కోసం, <code>porbrbsl</code> పోర్చుగీసు కోసం',
  'book_label'=>'పుస్తకం','book_hint'=>'సంక్షిప్తం',
  'chapter_label'=>'అధ్యాయం','verse_label'=>'వచనం',
  'current_label'=>'వచనంలో ప్రస్తుతం ఏముందో','current_hint'=>'మీరు చూసే ఖచ్చితమైన వచనాన్ని కాపీ చేసి పేస్ట్ చేయండి',
  'correct_label'=>'ఏమి ఉండాలో','correct_hint'=>'సరైన వచనాన్ని నమోదు చేయండి',
  'step3'=>'దశ 3 — మీ సంప్రదింపు వివరాలు',
  'name_label'=>'మీ పేరు','email_label'=>'మీ ఇమెయిల్ చిరునామా',
  'submit'=>'నా సందేశాన్ని సిద్ధం చేయండి →',
  'step2_general'=>'దశ 2 — మీ సందేశం',
  'subject_label'=>'విషయం','message_label'=>'మీ సందేశం',
  'success_heading'=>'మీ సందేశం పంపడానికి సిద్ధంగా ఉంది',
  'success1'=>'<strong>ఇమెయిల్ ప్రోగ్రామ్ తెరవండి</strong> పై క్లిక్ చేయండి — విషయం ముందే నింపిన కొత్త ఇమెయిల్ తెరుచుకుంటుంది.',
  'success2'=>'దిగువన <strong>సందేశ విషయాన్ని కాపీ చేయండి</strong> పై క్లిక్ చేసి ఇమెయిల్‌లో పేస్ట్ చేయండి.',
  'success3'=>'మీ ఇమెయిల్ ప్రోగ్రామ్‌లో <strong>పంపండి</strong> పై క్లిక్ చేయండి.',
  'open_email'=>'ఇమెయిల్ ప్రోగ్రామ్ తెరవండి →','open_gmail'=>'Gmail లో తెరవండి →',
  'no_email'=>'ఏ బటన్ అయినా విషయం ముందే నింపిన ఇమెయిల్ తెరుస్తుంది. పంపే ముందు సందేశ విషయాన్ని కాపీ చేసి పేస్ట్ చేయండి.',
  'to_label'=>'కి:','subject_display'=>'విషయం:',
  'copy_btn'=>'సందేశ విషయాన్ని కాపీ చేయండి','copied'=>'కాపీ అయింది!',
  'send_another'=>'← మరొక సందేశం పంపండి',
  'err_trans'=>'దయచేసి అనువాద కోడ్ నమోదు చేయండి.',
  'err_book_empty'=>'దయచేసి పుస్తక సంక్షిప్తం నమోదు చేయండి.',
  'err_book_invalid'=>'సంక్షిప్తం "%s" గుర్తించబడలేదు. mt, mk, lk, jn, ac, ro వంటి ప్రామాణిక సంక్షిప్తాలను వినియోగించండి.',
  'err_chapter'=>'దయచేసి చెల్లుబాటు అయ్యే అధ్యాయ సంఖ్య నమోదు చేయండి.',
  'err_verse'=>'దయచేసి చెల్లుబాటు అయ్యే వచన సంఖ్య నమోదు చేయండి.',
  'err_current'=>'దయచేసి వచనంలో ప్రస్తుతం ఏముందో నమోదు చేయండి.',
  'err_correct'=>'దయచేసి ఏమి ఉండాలో నమోదు చేయండి.',
  'err_name'=>'దయచేసి మీ పేరు నమోదు చేయండి.',
  'err_email'=>'దయచేసి చెల్లుబాటు అయ్యే ఇమెయిల్ చిరునామా నమోదు చేయండి.',
  'err_subject'=>'దయచేసి విషయం నమోదు చేయండి.',
  'err_message'=>'దయచేసి సందేశం నమోదు చేయండి (కనీసం 10 అక్షరాలు).',
  'err_type'=>'దయచేసి సందేశం రకం ఎంచుకోండి.',
  'reason_label'=>'సంప్రదింపు కారణం','reason_placeholder'=>'— ఒక కారణం ఎంచుకోండి —',
  'reason_B'=>'బైబిల్ అనువాద సూచన','reason_P'=>'ప్రచురణ లేదా కాపీరైట్ ప్రశ్న',
  'reason_R'=>'మెయిలింగ్ జాబితాలో చేరే అభ్యర్థన','reason_O'=>'ఇతర',
  'body_prompt'=>'దయచేసి ఇక్కడ మీ సందేశాన్ని టైప్ చేసి ఇమెయిల్ పంపండి.',
  'body_reads_now'=>'వచనం ప్రస్తుతం ఏమి చెప్తుందో:',
  'body_better'=>'ఇది ఎలా మెరుగుపడవచ్చు:',
];

$T['ta'] = [
  'title'=>'தொடர்பு கொள்ளுங்கள்','subtitle'=>'eBible.us குழுவிற்கு செய்தி அனுப்புங்கள்',
  'step1'=>'படி 1 — இது எந்த வகையான செய்தி?',
  'typo_title'=>'எழுத்துப் பிழை அல்லது மொழிபெயர்ப்பு பிழை',
  'typo_desc'=>'நான் பைபிள் உரையில் பிழை கண்டேன் — தவறான வார்த்தை, எழுத்துப் பிழை, அல்லது தவறாக தோன்றும் வசனம்.',
  'general_title'=>'பொதுவான கேள்வி அல்லது கருத்து',
  'general_desc'=>'குழுவிற்கு என்னிடம் ஒரு கேள்வி, பரிந்துரை அல்லது வேறு செய்தி உள்ளது.',
  'step2_typo'=>'படி 2 — பிழையைப் பற்றி எங்களுக்கு சொல்லுங்கள்',
  'trans_label'=>'மொழிபெயர்ப்பு குறியீடு','trans_hint'=>'எ.கா. <code>tl</code> டெட்டம் மொழிக்கு, <code>engwebp</code> ஆங்கில WEB க்கு, <code>porbrbsl</code> போர்த்துகீசுக்கு',
  'book_label'=>'புத்தகம்','book_hint'=>'சுருக்கம்',
  'chapter_label'=>'அதிகாரம்','verse_label'=>'வசனம்',
  'current_label'=>'உரையில் தற்போது என்ன உள்ளது','current_hint'=>'நீங்கள் காணும் சரியான உரையை நகலெடுத்து ஒட்டுங்கள்',
  'correct_label'=>'என்னவாக இருக்க வேண்டும்','correct_hint'=>'சரியான உரையை உள்ளிடுங்கள்',
  'step3'=>'படி 3 — உங்கள் தொடர்பு விவரங்கள்',
  'name_label'=>'உங்கள் பெயர்','email_label'=>'உங்கள் மின்னஞ்சல் முகவரி',
  'submit'=>'என் செய்தியை தயார் செய்யுங்கள் →',
  'step2_general'=>'படி 2 — உங்கள் செய்தி',
  'subject_label'=>'பொருள்','message_label'=>'உங்கள் செய்தி',
  'success_heading'=>'உங்கள் செய்தி அனுப்ப தயாராக உள்ளது',
  'success1'=>'<strong>மின்னஞ்சல் நிரலைத் திறக்கவும்</strong> என்பதை கிளிக் செய்யுங்கள் — பொருள் முன்பே நிரப்பப்பட்ட புதிய மின்னஞ்சல் திறக்கும்.',
  'success2'=>'கீழே <strong>செய்தி உரையை நகலெடுக்கவும்</strong> என்பதை கிளிக் செய்து மின்னஞ்சலில் ஒட்டுங்கள்.',
  'success3'=>'உங்கள் மின்னஞ்சல் நிரலில் <strong>அனுப்பு</strong> என்பதை கிளிக் செய்யுங்கள்.',
  'open_email'=>'மின்னஞ்சல் நிரலைத் திறக்கவும் →','open_gmail'=>'Gmail இல் திறக்கவும் →',
  'no_email'=>'எந்த பொத்தானும் பொருள் முன்பே நிரப்பப்பட்ட மின்னஞ்சலைத் திறக்கும். அனுப்பும் முன் செய்தி உரையை நகலெடுத்து ஒட்டுங்கள்.',
  'to_label'=>'பெறுநர்:','subject_display'=>'பொருள்:',
  'copy_btn'=>'செய்தி உரையை நகலெடுக்கவும்','copied'=>'நகலெடுக்கப்பட்டது!',
  'send_another'=>'← மற்றொரு செய்தி அனுப்புங்கள்',
  'err_trans'=>'மொழிபெயர்ப்பு குறியீட்டை உள்ளிடவும்.',
  'err_book_empty'=>'புத்தக சுருக்கத்தை உள்ளிடவும்.',
  'err_book_invalid'=>'சுருக்கம் "%s" அறியப்படவில்லை. mt, mk, lk, jn, ac, ro போன்ற நிலையான சுருக்கங்களைப் பயன்படுத்துங்கள்.',
  'err_chapter'=>'சரியான அதிகார எண்ணை உள்ளிடவும்.',
  'err_verse'=>'சரியான வசன எண்ணை உள்ளிடவும்.',
  'err_current'=>'உரையில் தற்போது என்ன உள்ளதை உள்ளிடவும்.',
  'err_correct'=>'என்னவாக இருக்க வேண்டும் என்பதை உள்ளிடவும்.',
  'err_name'=>'உங்கள் பெயரை உள்ளிடவும்.',
  'err_email'=>'சரியான மின்னஞ்சல் முகவரியை உள்ளிடவும்.',
  'err_subject'=>'பொருளை உள்ளிடவும்.',
  'err_message'=>'செய்தியை உள்ளிடவும் (குறைந்தது 10 எழுத்துக்கள்).',
  'err_type'=>'செய்தி வகையைத் தேர்ந்தெடுக்கவும்.',
  'reason_label'=>'தொடர்பு கொள்ளும் காரணம்','reason_placeholder'=>'— ஒரு காரணத்தை தேர்ந்தெடுங்கள் —',
  'reason_B'=>'பைபிள் மொழிபெயர்ப்பு பரிந்துரை','reason_P'=>'வெளியீடு அல்லது பதிப்புரிமை கேள்வி',
  'reason_R'=>'அஞ்சல் பட்டியலில் சேர கோரிக்கை','reason_O'=>'மற்றவை',
  'body_prompt'=>'இங்கே உங்கள் செய்தியை தட்டச்சு செய்து மின்னஞ்சல் அனுப்புங்கள்.',
  'body_reads_now'=>'உரை இப்போது என்ன சொல்கிறது:',
  'body_better'=>'இது எப்படி மேம்படலாம்:',
];

$T['sw'] = [
  'title'=>'Wasiliana Nasi','subtitle'=>'Tuma ujumbe kwa timu ya eBible.us',
  'step1'=>'Hatua ya 1 — Hii ni aina gani ya ujumbe?',
  'typo_title'=>'Kosa la kuandika au la tafsiri',
  'typo_desc'=>'Nimegundua kosa katika maandiko ya Biblia — neno lisilo sahihi, kosa la tahajia, au aya inayoonekana si sahihi.',
  'general_title'=>'Swali au maoni ya jumla',
  'general_desc'=>'Nina swali, pendekezo, au ujumbe mwingine kwa timu.',
  'step2_typo'=>'Hatua ya 2 — Tuambie kuhusu kosa',
  'trans_label'=>'Msimbo wa tafsiri','trans_hint'=>'mf. <code>tl</code> kwa Tetum, <code>engwebp</code> kwa Kiingereza WEB, <code>porbrbsl</code> kwa Kireno',
  'book_label'=>'Kitabu','book_hint'=>'kifupi',
  'chapter_label'=>'Sura','verse_label'=>'Aya',
  'current_label'=>'Maandishi yanayosema sasa hivi','current_hint'=>'nakili na ubandike maandishi unayoyaona',
  'correct_label'=>'Inachopaswa kusema','correct_hint'=>'ingiza maandishi sahihi',
  'step3'=>'Hatua ya 3 — Mawasiliano yako',
  'name_label'=>'Jina lako','email_label'=>'Anwani yako ya barua pepe',
  'submit'=>'Andaa ujumbe wangu →',
  'step2_general'=>'Hatua ya 2 — Ujumbe wako',
  'subject_label'=>'Mada','message_label'=>'Ujumbe wako',
  'success_heading'=>'Ujumbe wako uko tayari kutumwa',
  'success1'=>'Bonyeza <strong>Fungua programu ya barua pepe</strong> — inafungua barua pepe mpya na mada imejazwa tayari.',
  'success2'=>'Bonyeza <strong>Nakili mwili wa ujumbe</strong> hapa chini kisha ubandike kwenye barua pepe.',
  'success3'=>'Bonyeza <strong>Tuma</strong> kwenye programu yako ya barua pepe.',
  'open_email'=>'Fungua programu ya barua pepe →','open_gmail'=>'Fungua kwenye Gmail →',
  'no_email'=>'Kitufe chochote kinafungua barua pepe na mada imejazwa. Nakili na ubandike mwili wa ujumbe kabla ya kutuma.',
  'to_label'=>'Kwa:','subject_display'=>'Mada:',
  'copy_btn'=>'Nakili mwili wa ujumbe','copied'=>'Imenakiliwa!',
  'send_another'=>'← Tuma ujumbe mwingine',
  'err_trans'=>'Tafadhali ingiza msimbo wa tafsiri.',
  'err_book_empty'=>'Tafadhali ingiza kifupi cha kitabu.',
  'err_book_invalid'=>'Kifupi "%s" hakikujulikana. Tumia vifupi vya kawaida kama mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Tafadhali ingiza nambari sahihi ya sura.',
  'err_verse'=>'Tafadhali ingiza nambari sahihi ya aya.',
  'err_current'=>'Tafadhali ingiza maandishi yanayosema sasa hivi.',
  'err_correct'=>'Tafadhali ingiza inachopaswa kusema.',
  'err_name'=>'Tafadhali ingiza jina lako.',
  'err_email'=>'Tafadhali ingiza anwani sahihi ya barua pepe.',
  'err_subject'=>'Tafadhali ingiza mada.',
  'err_message'=>'Tafadhali ingiza ujumbe (angalau herufi 10).',
  'err_type'=>'Tafadhali chagua aina ya ujumbe.',
  'reason_label'=>'Sababu ya kuwasiliana','reason_placeholder'=>'— Chagua sababu —',
  'reason_B'=>'Pendekezo la tafsiri ya Biblia','reason_P'=>'Swali kuhusu uchapishaji au hakimiliki',
  'reason_R'=>'Ombi la kujiunga na orodha ya barua pepe','reason_O'=>'Nyingine',
  'body_prompt'=>'Tafadhali andika ujumbe wako hapa kisha utume barua pepe.',
  'body_reads_now'=>'Maandishi yanasema nini sasa:',
  'body_better'=>'Jinsi inavyoweza kuboreshwa:',
];

$T['tet'] = [
  'title'=>'Kontaktu','subtitle'=>'Haruka mensajen ba ekipa eBible.us',
  'step1'=>'Pasu 1 — Mensajen ne\'e mak saida?',
  'typo_title'=>'Erru iha escrita ka tradusaun',
  'typo_desc'=>'Hau hetan erru iha textu Bíblia nian — liafuan sala, erru ortografia, ka versikulu ne\'ebé la los.',
  'general_title'=>'Pergunta ka komentáriu jerál',
  'general_desc'=>'Hau iha pergunta, sujesaun, ka mensajen seluk ba ekipa.',
  'step2_typo'=>'Pasu 2 — Koalia ba ami kona-ba erru',
  'trans_label'=>'Kódigu tradusaun','trans_hint'=>'hanesan <code>tl</code> ba Tetum, <code>engwebp</code> ba Inglés WEB, <code>porbrbsl</code> ba Portugés',
  'book_label'=>'Livru','book_hint'=>'abreviasaun',
  'chapter_label'=>'Kapítulu','verse_label'=>'Versikulu',
  'current_label'=>'Saida mak textu dehan agora','current_hint'=>'kopia no kolla textu ne\'ebé ita haree',
  'correct_label'=>'Saida mak tenke dehan','correct_hint'=>'hatama textu ne\'ebé los',
  'step3'=>'Pasu 3 — Ita-nia informasaun kontaktu',
  'name_label'=>'Ita-nia naran','email_label'=>'Ita-nia enderesu email',
  'submit'=>'Prepara ha\'u-nia mensajen →',
  'step2_general'=>'Pasu 2 — Ita-nia mensajen',
  'subject_label'=>'Asuntu','message_label'=>'Ita-nia mensajen',
  'success_heading'=>'Ita-nia mensajen mak pronto atu haruka',
  'success1'=>'Klik <strong>Loke programa email</strong> — loke email foun ho asuntu ne\'ebé iha tiha ona.',
  'success2'=>'Klik <strong>Kopia korpu mensajen</strong> iha kraik, depois kolla ba email nian.',
  'success3'=>'Klik <strong>Haruka</strong> iha ita-nia programa email.',
  'open_email'=>'Loke programa email →','open_gmail'=>'Loke iha Gmail →',
  'no_email'=>'Botaun ruma loke email ho asuntu ne\'ebé iha tiha ona. Kopia no kolla korpu antes atu haruka.',
  'to_label'=>'Ba:','subject_display'=>'Asuntu:',
  'copy_btn'=>'Kopia korpu mensajen','copied'=>'Kopiadú ona!',
  'send_another'=>'← Haruka mensajen seluk',
  'err_trans'=>'Favor hatama kódigu tradusaun.',
  'err_book_empty'=>'Favor hatama abreviasaun livru nian.',
  'err_book_invalid'=>'Abreviasaun "%s" la rekoñese. Uza abreviasaun padrãu hanesan mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Favor hatama nú-meru kapítulu ne\'ebé válidu.',
  'err_verse'=>'Favor hatama nú-meru versikulu ne\'ebé válidu.',
  'err_current'=>'Favor hatama saida mak textu dehan agora.',
  'err_correct'=>'Favor hatama saida mak tenke dehan.',
  'err_name'=>'Favor hatama ita-nia naran.',
  'err_email'=>'Favor hatama enderesu email ne\'ebé válidu.',
  'err_subject'=>'Favor hatama asuntu.',
  'err_message'=>'Favor hatama mensajen (mínimu karakter 10).',
  'err_type'=>'Favor hili tipu mensajen.',
  'reason_label'=>'Razaun atu kontaktu','reason_placeholder'=>'— Hili razaun ida —',
  'reason_B'=>'Sujesaun ba tradusaun Bíblia','reason_P'=>'Pergunta kona-ba publikasaun ka direitu autór',
  'reason_R'=>'Pedidu atu tama lista email','reason_O'=>'Seluk',
  'body_prompt'=>'Favor hakerek ita-nia mensajen iha ne\'e depois haruka email.',
  'body_reads_now'=>'Saida mak textu dehan agora:',
  'body_better'=>'Oinsá bele hadi\'a liu tan:',
];

$T['tpi'] = [
  'title'=>'Kontaktim Mipela','subtitle'=>'Salim tok long tim bilong eBible.us',
  'step1'=>'Stap 1 — Wanem kain tok dispela?',
  'typo_title'=>'Raitim rong o translesen rong',
  'typo_desc'=>'Mi painim rong long tok bilong Baibel — tok i no stret, salim rong, o vas i no stret.',
  'general_title'=>'Askim o toktok nating',
  'general_desc'=>'Mi gat wanpela askim, sajes, o narapela tok long tim.',
  'step2_typo'=>'Stap 2 — Tokim mipela long rong',
  'trans_label'=>'Kod bilong translesen','trans_hint'=>'olsem <code>tl</code> long Tetum, <code>engwebp</code> long Inglis WEB, <code>porbrbsl</code> long Portugis',
  'book_label'=>'Buk','book_hint'=>'sot nem',
  'chapter_label'=>'Seksion','verse_label'=>'Vas',
  'current_label'=>'Wanem tok i stap nau','current_hint'=>'kopi na pasim tok yu lukim',
  'correct_label'=>'Wanem tok i mas stap','correct_hint'=>'raitim tok i stret',
  'step3'=>'Stap 3 — Infomesen bilong yu',
  'name_label'=>'Nem bilong yu','email_label'=>'Adres email bilong yu',
  'submit'=>'Redim tok bilong mi →',
  'step2_general'=>'Stap 2 — Tok bilong yu',
  'subject_label'=>'Sabdek','message_label'=>'Tok bilong yu',
  'success_heading'=>'Tok bilong yu i redi long salim',
  'success1'=>'Klikim <strong>Opim email program</strong> — opim nupela email wantaim sabdek i redi pinis.',
  'success2'=>'Klikim <strong>Kopi bodi bilong tok</strong> insait, na pasim long email.',
  'success3'=>'Klikim <strong>Salim</strong> long email program bilong yu.',
  'open_email'=>'Opim email program →','open_gmail'=>'Opim long Gmail →',
  'no_email'=>'Eniwan batunan i opim email wantaim sabdek. Kopi na pasim bodi bilong tok bipo yu salim.',
  'to_label'=>'Long:','subject_display'=>'Sabdek:',
  'copy_btn'=>'Kopi bodi bilong tok','copied'=>'Kopi pinis!',
  'send_another'=>'← Salim narapela tok',
  'err_trans'=>'Putim kod bilong translesen.',
  'err_book_empty'=>'Putim sot nem bilong buk.',
  'err_book_invalid'=>'Sot nem "%s" i no save. Usim sot nem olsem mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Putim namba bilong seksion i stret.',
  'err_verse'=>'Putim namba bilong vas i stret.',
  'err_current'=>'Putim tok i stap nau.',
  'err_correct'=>'Putim tok i mas stap.',
  'err_name'=>'Putim nem bilong yu.',
  'err_email'=>'Putim adres email i stret.',
  'err_subject'=>'Putim sabdek.',
  'err_message'=>'Putim tok (10 leta o moa).',
  'err_type'=>'Makim kain tok.',
  'reason_label'=>'Wanem as bilong yu','reason_placeholder'=>'— Makim wanpela as —',
  'reason_B'=>'Sajes bilong translesen Baibel','reason_P'=>'Askim kona-ba pablisin o copyright',
  'reason_R'=>'Askim bilong joinim liston email','reason_O'=>'Narapela samting',
  'body_prompt'=>'Putim tok bilong yu hia na bihain salim email.',
  'body_reads_now'=>'Tok i stap nau:',
  'body_better'=>'Olsem wanem bai i kamap gutpela moa:',
];

$T['ilo'] = [
  'title'=>'Makiinnabuyog','subtitle'=>'Mangibaga iti mensahe iti team ti eBible.us',
  'step1'=>'Addang 1 — Ania ti kita daytoy a mensahe?',
  'typo_title'=>'Biddut iti panagsurat wenno iti patarus',
  'typo_desc'=>'Nakasarakanak iti biddut iti teksto ti Biblia — biddut a sao, biddut iti espeling, wenno bersikulo a kumukunakunayo a biddut.',
  'general_title'=>'Pangkabilangan a saludsod wenno komentaryo',
  'general_desc'=>'Adda saludsodko, mulmula, wenno sabali a mensahe para iti team.',
  'step2_typo'=>'Addang 2 — Ibagam kadakami ti maipanggep iti biddut',
  'trans_label'=>'Kodigo ti patarus','trans_hint'=>'kas <code>tl</code> para Tetum, <code>engwebp</code> para Ingles WEB, <code>porbrbsl</code> para Portuges',
  'book_label'=>'Libro','book_hint'=>'abrebiasiyon',
  'chapter_label'=>'Kapitulo','verse_label'=>'Bersikulo',
  'current_label'=>'Ania ti kunkunana ti teksto ita','current_hint'=>'kopyaen ken i-paste ti eksakto a teksto a nakitam',
  'correct_label'=>'Ania ti rumbeng a kunkunana','correct_hint'=>'ilaglag ti umiso a teksto',
  'step3'=>'Addang 3 — Dagiti impormasyon ti pannakikomunika',
  'name_label'=>'Naganmo','email_label'=>'Adres ti emailmo',
  'submit'=>'Ihanda ti mensahek →',
  'step2_general'=>'Addang 2 — Mensahem',
  'subject_label'=>'Paksa','message_label'=>'Mensahem',
  'success_heading'=>'Naganay ti mensahem a maipatulod',
  'success1'=>'I-klik ti <strong>Abulan ti programa ti email</strong> — manglukat iti baro a email nga adda ti paksa nga napno iti uneg.',
  'success2'=>'I-klik ti <strong>Kopyaen ti kuerpo ti mensahe</strong> iti baba, ket i-paste iti email.',
  'success3'=>'I-klik ti <strong>Ipatulod</strong> iti programam ti email.',
  'open_email'=>'Abulan ti programa ti email →','open_gmail'=>'Abulan iti Gmail →',
  'no_email'=>'Ania man a butones manglukat iti email nga adda ti paksa. Kopyaen ken i-paste ti kuerpo sakbay ipatulod.',
  'to_label'=>'Para:','subject_display'=>'Paksa:',
  'copy_btn'=>'Kopyaen ti kuerpo ti mensahe','copied'=>'Nakopia na!',
  'send_another'=>'← Mangibaga iti sabali a mensahe',
  'err_trans'=>'Ilaglag ti kodigo ti patarus.',
  'err_book_empty'=>'Ilaglag ti abrebiasiyon ti libro.',
  'err_book_invalid'=>'Abrebiasiyon "%s" a di maawatan. Usaren dagiti nastandar a abrebiasiyon kas mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Ilaglag ti umiso a numero ti kapitulo.',
  'err_verse'=>'Ilaglag ti umiso a numero ti bersikulo.',
  'err_current'=>'Ilaglag ti kunkunana ti teksto ita.',
  'err_correct'=>'Ilaglag ti rumbeng a kunkunana.',
  'err_name'=>'Ilaglag ti naganmo.',
  'err_email'=>'Ilaglag ti umiso a adres ti email.',
  'err_subject'=>'Ilaglag ti paksa.',
  'err_message'=>'Ilaglag ti mensahe (kaykaysa 10 a letra).',
  'err_type'=>'Pilien ti kita ti mensahe.',
  'reason_label'=>'Rason ti pannakikomunika','reason_placeholder'=>'— Pilien ti rason —',
  'reason_B'=>'Mulmula para iti patarus ti Biblia','reason_P'=>'Saludsod maipanggep iti publikasion wenno copyright',
  'reason_R'=>'Dawat nga makitipon iti listaan ti email','reason_O'=>'Sabali',
  'body_prompt'=>'Ilaglag ti mensahem ditoy ket ipatulod ti email.',
  'body_reads_now'=>'Ania ti kunkunana ti teksto ita:',
  'body_better'=>'Kasano a mapabaro:',
];

$T['ceb'] = [
  'title'=>'Kontaka Kami','subtitle'=>'Padad-a og mensahe sa team sa eBible.us',
  'step1'=>'Lakang 1 — Unsang klase nga mensahe kini?',
  'typo_title'=>'Sayop sa pagsulat o paghubad',
  'typo_desc'=>'Nakakita ko og sayop sa teksto sa Biblia — sayop nga pulong, sayop sa spelling, o bersikulo nga daw sayop.',
  'general_title'=>'Kinatibuk-ang pangutana o komentaryo',
  'general_desc'=>'Aduna akoy pangutana, sugyot, o lain nga mensahe alang sa team.',
  'step2_typo'=>'Lakang 2 — Sultihi kami bahin sa sayop',
  'trans_label'=>'Code sa paghubad','trans_hint'=>'pananglitan <code>tl</code> alang sa Tetum, <code>engwebp</code> alang sa Ingles WEB, <code>porbrbsl</code> alang sa Portuges',
  'book_label'=>'Libro','book_hint'=>'abbreviation',
  'chapter_label'=>'Kapitulo','verse_label'=>'Bersikulo',
  'current_label'=>'Unsa ang giingon sa teksto karon','current_hint'=>'kopyaha ug i-paste ang eksaktong teksto nga imong nakita',
  'correct_label'=>'Unsa ang dapat niini ingon','correct_hint'=>'isulod ang husto nga teksto',
  'step3'=>'Lakang 3 — Imong impormasyon sa kontak',
  'name_label'=>'Imong ngalan','email_label'=>'Imong email address',
  'submit'=>'Andama ang akong mensahe →',
  'step2_general'=>'Lakang 2 — Imong mensahe',
  'subject_label'=>'Subject','message_label'=>'Imong mensahe',
  'success_heading'=>'Ang imong mensahe andam na nga ipadala',
  'success1'=>'I-klik ang <strong>Ablihi ang email program</strong> — magbukas og bag-ong email nga may subject nga napuno na.',
  'success2'=>'I-klik ang <strong>Kopyaha ang lawas sa mensahe</strong> sa ubos, unya i-paste sa email.',
  'success3'=>'I-klik ang <strong>Ipadala</strong> sa imong email program.',
  'open_email'=>'Ablihi ang email program →','open_gmail'=>'Ablihi sa Gmail →',
  'no_email'=>'Bisan unsang button magbukas og email nga may subject nga napuno na. Kopyaha ug i-paste ang lawas sa mensahe sa dili pa magpadala.',
  'to_label'=>'Para:','subject_display'=>'Subject:',
  'copy_btn'=>'Kopyaha ang lawas sa mensahe','copied'=>'Nakopya na!',
  'send_another'=>'← Magpadala og laing mensahe',
  'err_trans'=>'Palihug isulod ang code sa paghubad.',
  'err_book_empty'=>'Palihug isulod ang abbreviation sa libro.',
  'err_book_invalid'=>'Abbreviation "%s" wala maila. Gamita ang naandang abbreviation sama sa mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Palihug isulod ang balid nga numero sa kapitulo.',
  'err_verse'=>'Palihug isulod ang balid nga numero sa bersikulo.',
  'err_current'=>'Palihug isulod kung unsa ang giingon sa teksto karon.',
  'err_correct'=>'Palihug isulod kung unsa ang dapat niini ingon.',
  'err_name'=>'Palihug isulod ang imong ngalan.',
  'err_email'=>'Palihug isulod ang balid nga email address.',
  'err_subject'=>'Palihug isulod ang subject.',
  'err_message'=>'Palihug isulod ang mensahe (labing menos 10 ka letra).',
  'err_type'=>'Palihug pilia ang klase sa mensahe.',
  'reason_label'=>'Rason sa pagkontak','reason_placeholder'=>'— Pilia ang rason —',
  'reason_B'=>'Sugyot sa paghubad sa Biblia','reason_P'=>'Pangutana bahin sa publikasyon o copyright',
  'reason_R'=>'Hangyo sa pagsali sa listahan sa email','reason_O'=>'Uban',
  'body_prompt'=>'Palihug i-type ang imong mensahe dinhi unya ipadala ang email.',
  'body_reads_now'=>'Unsa ang giingon sa teksto karon:',
  'body_better'=>'Unsaon kini pagpaayo:',
];

$T['km'] = [
  'title'=>'ទំនាក់ទំនង','subtitle'=>'ផ្ញើសារទៅក្រុម eBible.us',
  'step1'=>'ជំហានទី 1 — នេះជាសារប្រភេទអ្វី?',
  'typo_title'=>'កំហុសអក្ខរាវិរុទ្ធ ឬកំហុសការបកប្រែ',
  'typo_desc'=>'ខ្ញុំរកឃើញកំហុសនៅក្នុងអត្ថបទព្រះគម្ពីរ — ពាក្យខុស កំហុសអក្ខរាវិរុទ្ធ ឬខ្ចីដែលហាក់ដូចជាមិនត្រឹមត្រូវ។',
  'general_title'=>'សំណួរ ឬមតិទូទៅ',
  'general_desc'=>'ខ្ញុំមានសំណួរ ការណែនាំ ឬសារផ្សេងទៀតសម្រាប់ក្រុម។',
  'step2_typo'=>'ជំហានទី 2 — ប្រាប់ពីកំហុស',
  'trans_label'=>'លេខកូដការបកប្រែ','trans_hint'=>'ឧទាហរណ៍ <code>tl</code> សម្រាប់ Tetum, <code>engwebp</code> សម្រាប់ English WEB, <code>porbrbsl</code> សម្រាប់ Portuguese',
  'book_label'=>'សៀវភៅ','book_hint'=>'អក្សរកាត់',
  'chapter_label'=>'ជំពូក','verse_label'=>'ខ',
  'current_label'=>'អ្វីដែលអត្ថបទបច្ចុប្បន្ននិយាយ','current_hint'=>'ចម្លង និងបិទភ្ជាប់អត្ថបទដែលអ្នកឃើញ',
  'correct_label'=>'អ្វីដែលគួរតែនិយាយ','correct_hint'=>'បញ្ចូលអត្ថបទត្រឹមត្រូវ',
  'step3'=>'ជំហានទី 3 — ព័ត៌មានទំនាក់ទំនង',
  'name_label'=>'ឈ្មោះរបស់អ្នក','email_label'=>'អាសយដ្ឋានអ៊ីមែលរបស់អ្នក',
  'submit'=>'រៀបចំសារខ្ញុំ →',
  'step2_general'=>'ជំហានទី 2 — សាររបស់អ្នក',
  'subject_label'=>'ប្រធានបទ','message_label'=>'សាររបស់អ្នក',
  'success_heading'=>'សាររបស់អ្នករួចរាល់ហើយ',
  'success1'=>'ចុច <strong>បើកកម្មវិធីអ៊ីមែល</strong> — បើកអ៊ីមែលថ្មីដែលមានប្រធានបទបំពេញជាមុន។',
  'success2'=>'ចុច <strong>ចម្លងខ្លឹមសារសារ</strong> ខាងក្រោម ហើយបិទភ្ជាប់ក្នុងអ៊ីមែល។',
  'success3'=>'ចុច <strong>ផ្ញើ</strong> នៅក្នុងកម្មវិធីអ៊ីមែលរបស់អ្នក។',
  'open_email'=>'បើកកម្មវិធីអ៊ីមែល →','open_gmail'=>'បើកនៅក្នុង Gmail →',
  'no_email'=>'ប៊ូតុងណាមួយបើកអ៊ីមែលដែលមានប្រធានបទ។ ចម្លង និងបិទភ្ជាប់ខ្លឹមសារមុននឹងផ្ញើ។',
  'to_label'=>'ទៅ:','subject_display'=>'ប្រធានបទ:',
  'copy_btn'=>'ចម្លងខ្លឹមសារសារ','copied'=>'ចម្លងរួចហើយ!',
  'send_another'=>'← ផ្ញើសារផ្សេងទៀត',
  'err_trans'=>'សូមបញ្ចូលលេខកូដការបកប្រែ។',
  'err_book_empty'=>'សូមបញ្ចូលអក្សរកាត់សៀវភៅ។',
  'err_book_invalid'=>'អក្សរកាត់ "%s" មិនត្រូវបានទទួលស្គាល់។ ប្រើអក្សរកាត់ស្តង់ដារដូចជា mt, mk, lk, jn, ac, ro។',
  'err_chapter'=>'សូមបញ្ចូលលេខជំពូកត្រឹមត្រូវ។',
  'err_verse'=>'សូមបញ្ចូលលេខខត្រឹមត្រូវ។',
  'err_current'=>'សូមបញ្ចូលអ្វីដែលអត្ថបទបច្ចុប្បន្ននិយាយ។',
  'err_correct'=>'សូមបញ្ចូលអ្វីដែលគួរតែនិយាយ។',
  'err_name'=>'សូមបញ្ចូលឈ្មោះរបស់អ្នក។',
  'err_email'=>'សូមបញ្ចូលអាសយដ្ឋានអ៊ីមែលត្រឹមត្រូវ។',
  'err_subject'=>'សូមបញ្ចូលប្រធានបទ។',
  'err_message'=>'សូមបញ្ចូលសារ (យ៉ាងតិច 10 តួអក្សរ)។',
  'err_type'=>'សូមជ្រើសរើសប្រភេទសារ។',
  'reason_label'=>'មូលហេតុក្នុងការទំនាក់ទំនង','reason_placeholder'=>'— ជ្រើសរើសមូលហេតុ —',
  'reason_B'=>'សំណើការបកប្រែព្រះគម្ពីរ','reason_P'=>'សំណួរអំពីការបោះពុម្ព ឬសិទ្ធិអ្នកនិពន្ធ',
  'reason_R'=>'សំណើចូលរួមក្នុងបញ្ជីអ៊ីមែល','reason_O'=>'ផ្សេងទៀត',
  'body_prompt'=>'សូមវាយអត្ថបទសាររបស់អ្នកនៅទីនេះ ហើយបញ្ជូនអ៊ីមែល។',
  'body_reads_now'=>'អត្ថបទបច្ចុប្បន្ននិយាយថា:',
  'body_better'=>'របៀបដែលអាចប្រសើរជាង:',
];

$T['ha'] = [
  'title'=>'Tuntuɓi Mu','subtitle'=>'Aika saƙo zuwa ƙungiyar eBible.us',
  'step1'=>'Mataki na 1 — Menene irin wannan saƙo?',
  'typo_title'=>'Kuskuren rubutu ko fassara',
  'typo_desc'=>'Na sami kuskure a cikin rubutun Littafi Mai Tsarki — kalma mara daidai, kuskuren rubutu, ko aya da ta zama ba ta daidai ba.',
  'general_title'=>'Tambaya ko sharhi gabaɗaya',
  'general_desc'=>'Ina da tambaya, shawara, ko wani saƙo ga ƙungiyar.',
  'step2_typo'=>'Mataki na 2 — Sanar da mu game da kuskuren',
  'trans_label'=>'Lambar fassara','trans_hint'=>'misali <code>tl</code> don Tetum, <code>engwebp</code> don Turanci WEB, <code>porbrbsl</code> don Fotigis',
  'book_label'=>'Littafi','book_hint'=>'gajartar suna',
  'chapter_label'=>'Babi','verse_label'=>'Aya',
  'current_label'=>'Abin da rubutun ke faɗa yanzu','current_hint'=>'kwafi kuma liƙa daidai rubutun da ka gani',
  'correct_label'=>'Abin da ya kamata ya faɗa','correct_hint'=>'shigar da rubutun daidai',
  'step3'=>'Mataki na 3 — Bayanan tuntuɓarku',
  'name_label'=>'Sunanka','email_label'=>'Adireshin imel ɗinka',
  'submit'=>'Shirya saƙona →',
  'step2_general'=>'Mataki na 2 — Saƙonku',
  'subject_label'=>'Jigo','message_label'=>'Saƙonku',
  'success_heading'=>'Saƙonku yana shirye don aikawa',
  'success1'=>'Danna <strong>Buɗe shirin imel</strong> — yana buɗe sabon imel tare da jigo da aka cika a gaba.',
  'success2'=>'Danna <strong>Kwafi jikin saƙon</strong> a ƙasa, sannan liƙa shi a cikin imel.',
  'success3'=>'Danna <strong>Aika</strong> a cikin shirin imel ɗinka.',
  'open_email'=>'Buɗe shirin imel →','open_gmail'=>'Buɗe a Gmail →',
  'no_email'=>'Kowane maballin yana buɗe imel tare da jigo. Kwafi kuma liƙa jikin saƙon kafin aikawa.',
  'to_label'=>'Zuwa:','subject_display'=>'Jigo:',
  'copy_btn'=>'Kwafi jikin saƙon','copied'=>'An kwafi!',
  'send_another'=>'← Aika wani saƙo',
  'err_trans'=>'Da fatan za a shigar da lambar fassara.',
  'err_book_empty'=>'Da fatan za a shigar da gajartar sunan littafi.',
  'err_book_invalid'=>'Gajartar suna "%s" ba a gane shi ba. Yi amfani da gajartar suna na yau da kullun kamar mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Da fatan za a shigar da ingantaccen lambar babi.',
  'err_verse'=>'Da fatan za a shigar da ingantaccen lambar aya.',
  'err_current'=>'Da fatan za a shigar da abin da rubutun ke faɗa yanzu.',
  'err_correct'=>'Da fatan za a shigar da abin da ya kamata ya faɗa.',
  'err_name'=>'Da fatan za a shigar da sunanka.',
  'err_email'=>'Da fatan za a shigar da ingantaccen adireshin imel.',
  'err_subject'=>'Da fatan za a shigar da jigo.',
  'err_message'=>'Da fatan za a shigar da saƙo (haruffa 10 aƙalla).',
  'err_type'=>'Da fatan za a zaɓi irin saƙon.',
  'reason_label'=>'Dalilin tuntuɓa','reason_placeholder'=>'— Zaɓi dalilin —',
  'reason_B'=>'Shawarar fassarar Littafi Mai Tsarki','reason_P'=>'Tambaya game da wallafe-wallafe ko haƙƙin mallaka',
  'reason_R'=>'Buƙatar shiga jerin imel','reason_O'=>'Wani abu',
  'body_prompt'=>'Da fatan za a rubuta saƙon ku anan sannan ku aika imel.',
  'body_reads_now'=>'Abin da rubutun ke faɗa yanzu:',
  'body_better'=>'Yadda zai fi kyau:',
];

$T['yo'] = [
  'title'=>'Kan Si Wa','subtitle'=>'Fi ifiranṣẹ ranṣẹ si ẹgbẹ eBible.us',
  'step1'=>'Igbese 1 — Iru ifiranṣẹ wo ni eyi?',
  'typo_title'=>'Aṣiṣe tẹ tabi aṣiṣe itumọ',
  'typo_desc'=>'Mo ri aṣiṣe ninu ọrọ Bibeli — ọrọ ti ko tọ, aṣiṣe akọtọ, tabi ẹsẹ ti o dabi ẹni ti ko tọ.',
  'general_title'=>'Ibeere gbogbogbo tabi asọye',
  'general_desc'=>'Mo ni ibeere, imọran, tabi ifiranṣẹ miiran fun ẹgbẹ naa.',
  'step2_typo'=>'Igbese 2 — Sọ fun wa nipa aṣiṣe naa',
  'trans_label'=>'Koodu itumọ','trans_hint'=>'fun apẹẹrẹ <code>tl</code> fun Tetum, <code>engwebp</code> fun Gẹẹsi WEB, <code>porbrbsl</code> fun Pọtugali',
  'book_label'=>'Iwe','book_hint'=>'abbreviation',
  'chapter_label'=>'Ìwé orí','verse_label'=>'Ẹsẹ',
  'current_label'=>'Ohun ti ọrọ naa n sọ lọwọlọwọ','current_hint'=>'daakọ ki o fi ọrọ gangan ti o ri sori rẹ',
  'correct_label'=>'Ohun ti o yẹ ki o sọ','correct_hint'=>'tẹ ọrọ ti o tọ sii',
  'step3'=>'Igbese 3 — Alaye ibasọrọ rẹ',
  'name_label'=>'Orukọ rẹ','email_label'=>'Adirẹsi imeeli rẹ',
  'submit'=>'Mura ifiranṣẹ mi →',
  'step2_general'=>'Igbese 2 — Ifiranṣẹ rẹ',
  'subject_label'=>'Akọle','message_label'=>'Ifiranṣẹ rẹ',
  'success_heading'=>'Ifiranṣẹ rẹ ti ṣetan lati firanṣẹ',
  'success1'=>'Tẹ <strong>Ṣii eto imeeli</strong> — ṣii imeeli tuntun pẹlu akọle ti a ti kun tẹlẹ.',
  'success2'=>'Tẹ <strong>Daakọ ara ifiranṣẹ</strong> ni isalẹ, lẹhinna fi sori imeeli.',
  'success3'=>'Tẹ <strong>Fi ranṣẹ</strong> ninu eto imeeli rẹ.',
  'open_email'=>'Ṣii eto imeeli →','open_gmail'=>'Ṣii ni Gmail →',
  'no_email'=>'Bọtini eyikeyi ṣii imeeli pẹlu akọle. Daakọ ki o fi ara ifiranṣẹ sori rẹ ṣaaju fifiranṣẹ.',
  'to_label'=>'Si:','subject_display'=>'Akọle:',
  'copy_btn'=>'Daakọ ara ifiranṣẹ','copied'=>'Ti daakọ!',
  'send_another'=>'← Fi ifiranṣẹ miiran ranṣẹ',
  'err_trans'=>'Jọwọ tẹ koodu itumọ sii.',
  'err_book_empty'=>'Jọwọ tẹ abbreviation iwe sii.',
  'err_book_invalid'=>'Abbreviation "%s" ko mọ. Lo abbreviation boṣewa bii mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Jọwọ tẹ nọmba ìwé orí to tọ sii.',
  'err_verse'=>'Jọwọ tẹ nọmba ẹsẹ to tọ sii.',
  'err_current'=>'Jọwọ tẹ ohun ti ọrọ naa n sọ lọwọlọwọ sii.',
  'err_correct'=>'Jọwọ tẹ ohun ti o yẹ ki o sọ sii.',
  'err_name'=>'Jọwọ tẹ orukọ rẹ sii.',
  'err_email'=>'Jọwọ tẹ adirẹsi imeeli to tọ sii.',
  'err_subject'=>'Jọwọ tẹ akọle sii.',
  'err_message'=>'Jọwọ tẹ ifiranṣẹ sii (o kere ju awọn ohun kikọ 10).',
  'err_type'=>'Jọwọ yan iru ifiranṣẹ.',
  'reason_label'=>'Idi fun ibasọrọ','reason_placeholder'=>'— Yan idi kan —',
  'reason_B'=>'Imọran itumọ Bibeli','reason_P'=>'Ibeere nipa titẹjade tabi aṣẹ-lori-ara',
  'reason_R'=>'Ibeere lati darapọ mọ atokọ imeeli','reason_O'=>'Miiran',
  'body_prompt'=>'Jọwọ tẹ ifiranṣẹ rẹ nibi lẹhinna fi imeeli ranṣẹ.',
  'body_reads_now'=>'Ohun ti ọrọ naa n sọ lọwọlọwọ:',
  'body_better'=>'Bi o ti le dara si:',
];

$T['ig'] = [
  'title'=>'Kpọtụrụ Anyị','subtitle'=>'Zipu ozi nye ndị otu eBible.us',
  'step1'=>'Nzọụkwụ 1 — Kedu ụdị ozi nke a?',
  'typo_title'=>'Njehie ide ma ọ bụ nsụtara',
  'typo_desc'=>'Achọtara m njehie na ederede Bible — okwu na-ezighị ezi, njehie n\'ede, ma ọ bụ ụdọ nke dị ka ọ jọrọ ajọ.',
  'general_title'=>'Ajụjụ ma ọ bụ nkọwa nke ọha',
  'general_desc'=>'Nwere m ajụjụ, ntụnye, ma ọ bụ ozi ọzọ maka ndị otu.',
  'step2_typo'=>'Nzọụkwụ 2 — Gwa anyị maka njehie',
  'trans_label'=>'Koodu nsụtara','trans_hint'=>'dị ka <code>tl</code> maka Tetum, <code>engwebp</code> maka Bekee WEB, <code>porbrbsl</code> maka Portuguese',
  'book_label'=>'Akwụkwọ','book_hint'=>'mkpọnwaọ',
  'chapter_label'=>'Isi','verse_label'=>'Ụdọ',
  'current_label'=>'Ihe ederede na-ekwu ugbu a','current_hint'=>'detuo ma tinye ederede ziri ezi i hụrụ',
  'correct_label'=>'Ihe ọ kwesịrị ikwu','correct_hint'=>'tinye ederede ziri ezi',
  'step3'=>'Nzọụkwụ 3 — Ozi kpọtụrụ gị',
  'name_label'=>'Aha gị','email_label'=>'Adreesị email gị',
  'submit'=>'Kwadoo ozi m →',
  'step2_general'=>'Nzọụkwụ 2 — Ozi gị',
  'subject_label'=>'Isiokwu','message_label'=>'Ozi gị',
  'success_heading'=>'Ozi gị dị njikere iziga',
  'success1'=>'Pịa <strong>Mepee mmemme email</strong> — na-emepee email ọhụrụ nwere isiokwu edepụtara ya.',
  'success2'=>'Pịa <strong>Detuo ahịrị ozi</strong> n\'okpuru, wee tinye ya na email.',
  'success3'=>'Pịa <strong>Zipu</strong> na mmemme email gị.',
  'open_email'=>'Mepee mmemme email →','open_gmail'=>'Mepee na Gmail →',
  'no_email'=>'Bọtịnị ọ bụla na-emepee email nwere isiokwu. Detuo ma tinye ahịrị ozi tupu izi.',
  'to_label'=>'Nye:','subject_display'=>'Isiokwu:',
  'copy_btn'=>'Detuo ahịrị ozi','copied'=>'Edetụọla!',
  'send_another'=>'← Zipu ozi ọzọ',
  'err_trans'=>'Biko tinye koodu nsụtara.',
  'err_book_empty'=>'Biko tinye mkpọnwaọ akwụkwọ.',
  'err_book_invalid'=>'Mkpọnwaọ "%s" amaghị. Jiri mkpọnwaọ ọkọlọtọ dị ka mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Biko tinye nọmba isi ziri ezi.',
  'err_verse'=>'Biko tinye nọmba ụdọ ziri ezi.',
  'err_current'=>'Biko tinye ihe ederede na-ekwu ugbu a.',
  'err_correct'=>'Biko tinye ihe ọ kwesịrị ikwu.',
  'err_name'=>'Biko tinye aha gị.',
  'err_email'=>'Biko tinye adreesị email ziri ezi.',
  'err_subject'=>'Biko tinye isiokwu.',
  'err_message'=>'Biko tinye ozi (ọ dịkarịa ala mkpụrụedemede 10).',
  'err_type'=>'Biko họrọ ụdị ozi.',
  'reason_label'=>'Ihe kpatara ịkpọtụrụ','reason_placeholder'=>'— Họrọ otu ihe —',
  'reason_B'=>'Ntụnye maka nsụtara Baịbụlụ','reason_P'=>'Ajụjụ banyere nkwụpụta ma ọ bụ ikike nkwụpụta',
  'reason_R'=>'Arịrịọ ịbanye na ndepụta ozi-e','reason_O'=>'Ihe ọzọ',
  'body_prompt'=>'Biko tinye ozi gị ebe a wee zipu email.',
  'body_reads_now'=>'Ihe ederede na-ekwu ugbu a:',
  'body_better'=>'Otu esi eme ka ọ dị mma:',
];

$T['am'] = [
  'title'=>'አግኙን','subtitle'=>'ለeBible.us ቡድን መልእክት ይላኩ',
  'step1'=>'ደረጃ 1 — ይህ ምን አይነት መልእክት ነው?',
  'typo_title'=>'የጽሁፍ ስህተት ወይም የትርጉም ስህተት',
  'typo_desc'=>'በመጽሐፍ ቅዱስ ጽሁፍ ውስጥ ስህተት አገኘሁ — ስህተት ቃል፣ የፊደል አጻጻፍ ስህተት፣ ወይም ትክክለኛ ያልሆነ ቁጥር።',
  'general_title'=>'አጠቃላይ ጥያቄ ወይም አስተያየት',
  'general_desc'=>'ለቡድኑ ጥያቄ፣ ሀሳብ፣ ወይም ሌላ መልእክት አለኝ።',
  'step2_typo'=>'ደረጃ 2 — ስለ ስህተቱ ያስፈልጉናል',
  'trans_label'=>'የትርጉም ኮድ','trans_hint'=>'ለምሳሌ <code>tl</code> ለቴቱም፣ <code>engwebp</code> ለእንግሊዝኛ WEB፣ <code>porbrbsl</code> ለፖርቱጋልኛ',
  'book_label'=>'መጽሐፍ','book_hint'=>'ምህጻረ ቃል',
  'chapter_label'=>'ምዕራፍ','verse_label'=>'ቁጥር',
  'current_label'=>'ጽሁፉ አሁን የሚናገረው','current_hint'=>'የሚያዩትን ትክክለኛ ጽሁፍ ቅዱ ለጥፉ',
  'correct_label'=>'መናገር ያለበት','correct_hint'=>'ትክክለኛ ጽሁፍ ያስገቡ',
  'step3'=>'ደረጃ 3 — የእርስዎ የእውቂያ መረጃ',
  'name_label'=>'ስምዎ','email_label'=>'የኢሜይል አድራሻዎ',
  'submit'=>'መልእክቴን አዘጋጅ →',
  'step2_general'=>'ደረጃ 2 — መልእክትዎ',
  'subject_label'=>'ርዕሰ ጉዳይ','message_label'=>'መልእክትዎ',
  'success_heading'=>'መልእክትዎ ለመላክ ዝግጁ ነው',
  'success1'=>'<strong>የኢሜይል ፕሮግራም ክፈት</strong> ን ጠቅ ያድርጉ — ርዕሰ ጉዳይ አስቀድሞ የተሞላ አዲስ ኢሜይል ይከፈታል።',
  'success2'=>'ከታች <strong>የመልእክት ዋና ክፍልን ቅዱ</strong> ን ጠቅ ያድርጉ እና ኢሜይሉ ላይ ለጥፉ።',
  'success3'=>'በኢሜይል ፕሮግራምዎ <strong>ላክ</strong> ን ጠቅ ያድርጉ።',
  'open_email'=>'የኢሜይል ፕሮግራም ክፈት →','open_gmail'=>'Gmail ውስጥ ክፈት →',
  'no_email'=>'ማንኛውም ቁልፍ ርዕሰ ጉዳይ አስቀድሞ የተሞላ ኢሜይል ይከፍታል። ከመላክ በፊት የመልእክቱን ዋና ክፍል ቅዱ ለጥፉ።',
  'to_label'=>'ወደ:','subject_display'=>'ርዕሰ ጉዳይ:',
  'copy_btn'=>'የመልእክት ዋና ክፍልን ቅዱ','copied'=>'ተቀድቷል!',
  'send_another'=>'← ሌላ መልእክት ላኩ',
  'err_trans'=>'እባክዎ የትርጉም ኮዱን ያስገቡ።',
  'err_book_empty'=>'እባክዎ የመጽሐፉን ምህጻረ ቃል ያስገቡ።',
  'err_book_invalid'=>'ምህጻረ ቃሉ "%s" አልታወቀም። እንደ mt, mk, lk, jn, ac, ro ያሉ መደበኛ ምህጻረ ቃላትን ይጠቀሙ።',
  'err_chapter'=>'እባክዎ ትክክለኛ ምዕራፍ ቁጥር ያስገቡ።',
  'err_verse'=>'እባክዎ ትክክለኛ ቁጥር ያስገቡ።',
  'err_current'=>'እባክዎ ጽሁፉ አሁን የሚናገረውን ያስገቡ።',
  'err_correct'=>'እባክዎ መናገር ያለበትን ያስገቡ።',
  'err_name'=>'እባክዎ ስምዎን ያስገቡ።',
  'err_email'=>'እባክዎ ትክክለኛ የኢሜይል አድራሻ ያስገቡ።',
  'err_subject'=>'እባክዎ ርዕሰ ጉዳዩን ያስገቡ።',
  'err_message'=>'እባክዎ መልእክት ያስገቡ (ቢያንስ 10 ቁምፊዎች)።',
  'err_type'=>'እባክዎ የመልእክቱን አይነት ይምረጡ።',
  'reason_label'=>'የሚያገኙን ምክንያት','reason_placeholder'=>'— ምክንያት ይምረጡ —',
  'reason_B'=>'የመጽሐፍ ቅዱስ ትርጉም ሀሳብ','reason_P'=>'ስለ ህትመት ወይም የቅጂ መብት ጥያቄ',
  'reason_R'=>'የደብዳቤ ዝርዝር ለመቀላቀል ጥያቄ','reason_O'=>'ሌላ',
  'body_prompt'=>'እባክዎ መልእክትዎን እዚህ ይፃፉ ከዚያም ኢሜሉን ይላኩ።',
  'body_reads_now'=>'ጽሁፉ አሁን የሚናገረው:',
  'body_better'=>'እንዴት ሊሻሻል ይችላል:',
];

$T['om'] = [
  'title'=>'Nu Quunnamaa','subtitle'=>'Ergaa gara garee eBible.us ergi',
  'step1'=>'Tarkaanfii 1 — Ergaan kun gosa kamii?',
  'typo_title'=>'Dogoggora barreessuu ykn hiikkaa',
  'typo_desc'=>'Barruu Macaafa Qulqulluu keessatti dogoggora argadhe — jecha dogoggoraa, dogoggora qubee, ykn keeyyata dogoggoraa fakkaatu.',
  'general_title'=>'Gaaffii ykn yaada waliigalaa',
  'general_desc'=>'Gareen koo gaaffii, yaada, ykn ergaa biraa qaba.',
  'step2_typo'=>'Tarkaanfii 2 — Waa\'ee dogoggoraa nuuf himi',
  'trans_label'=>'Koodii hiikkaa','trans_hint'=>'fknf <code>tl</code> Tetum, <code>engwebp</code> Ingiliffaa WEB, <code>porbrbsl</code> Poorchugaalii',
  'book_label'=>'Kitaaba','book_hint'=>'gabaabinaa',
  'chapter_label'=>'Boqonnaa','verse_label'=>'Keeyyata',
  'current_label'=>'Barruu amma maal jedhu','current_hint'=>'barruu sirriitti argitu copy gochuudhaan paste godhi',
  'correct_label'=>'Maal jedhu qaba','correct_hint'=>'barruu sirrii galchi',
  'step3'=>'Tarkaanfii 3 — Odeeffannoo qunnamtii kee',
  'name_label'=>'Maqaa kee','email_label'=>'Teessoo email kee',
  'submit'=>'Ergaa koo qopheessi →',
  'step2_general'=>'Tarkaanfii 2 — Ergaa kee',
  'subject_label'=>'Mata-duree','message_label'=>'Ergaa kee',
  'success_heading'=>'Ergaan kee erguuf qophaa\'eera',
  'success1'=>'<strong>Sagantaa email bani</strong> cuqaasi — email haaraa mata-duree dura guutame banata.',
  'success2'=>'<strong>Qaamaa ergaa copy godhi</strong> jalatti cuqaasi, ergasii email keessatti paste godhi.',
  'success3'=>'Sagantaa email kee keessatti <strong>Ergi</strong> cuqaasi.',
  'open_email'=>'Sagantaa email bani →','open_gmail'=>'Gmail keessatti bani →',
  'no_email'=>'Miilataaleen kamuu mata-duree qaban email bana. Erguuf dura qaamaa ergaa copy gochuudhaan paste godhi.',
  'to_label'=>'Gara:','subject_display'=>'Mata-duree:',
  'copy_btn'=>'Qaamaa ergaa copy godhi','copied'=>'Copy godhamee!',
  'send_another'=>'← Ergaa biraa ergi',
  'err_trans'=>'Maaloo koodii hiikkaa galchi.',
  'err_book_empty'=>'Maaloo gabaabina kitaabaa galchi.',
  'err_book_invalid'=>'Gabaabinni "%s" hin beekamne. Gabaabina sadarkaa akka mt, mk, lk, jn, ac, ro fayyadami.',
  'err_chapter'=>'Maaloo lakkoofsa boqonnaa sirrii galchi.',
  'err_verse'=>'Maaloo lakkoofsa keeyyataa sirrii galchi.',
  'err_current'=>'Maaloo barruu amma maal jedhu galchi.',
  'err_correct'=>'Maaloo maal jedhu qabu galchi.',
  'err_name'=>'Maaloo maqaa kee galchi.',
  'err_email'=>'Maaloo teessoo email sirrii galchi.',
  'err_subject'=>'Maaloo mata-duree galchi.',
  'err_message'=>'Maaloo ergaa galchi (xiqqaate qubee 10).',
  'err_type'=>'Maaloo gosa ergaa filadhu.',
  'reason_label'=>'Sababaa qunnamtii','reason_placeholder'=>'— Sababaa filadhu —',
  'reason_B'=>'Yaada hiikkaa Kitaaba Qulqulluu','reason_P'=>'Gaaffii maxxansuu ykn mirga abbummaa',
  'reason_R'=>'Gaaffii galmee email keessatti hirmaachuuf','reason_O'=>'Kan biraa',
  'body_prompt'=>'Maaloo ergaa kee asitti barreessii ergasii email ergi.',
  'body_reads_now'=>'Barruu amma maal jedhu:',
  'body_better'=>'Akkamitti fooyyefamuu danda\'a:',
];

$T['so'] = [
  'title'=>'Nala Xiriir','subtitle'=>'Farriin u dir kooxda eBible.us',
  'step1'=>'Tallaabo 1 — Nooca maxay tahay fariintani?',
  'typo_title'=>'Qalad qoraal ah ama turjumaan',
  'typo_desc'=>'Waxaan ku helay qalad qoraalka Kitaabka Quduuska ah — eray qaldan, qalad higaad, ama aayad u muuqata inay qaldan tahay.',
  'general_title'=>'Su\'aal guud ama faallo',
  'general_desc'=>'Waxaan leeyahay su\'aal, talo, ama farriin kale oo loogu talagalay kooxda.',
  'step2_typo'=>'Tallaabo 2 — Noo sheeg khaladka',
  'trans_label'=>'Koodhka turjumaanka','trans_hint'=>'tusaale <code>tl</code> Tetum, <code>engwebp</code> Ingiriisi WEB, <code>porbrbsl</code> Boortaqiis',
  'book_label'=>'Buug','book_hint'=>'gaabis',
  'chapter_label'=>'Cutub','verse_label'=>'Aayad',
  'current_label'=>'Waxa qoraalku hadda leeyahay','current_hint'=>'nuqul ka samee oo ku dhejiso qoraalka saxda ah ee aad aragtay',
  'correct_label'=>'Waxa uu ahaanlahayd','correct_hint'=>'geli qoraalka saxda ah',
  'step3'=>'Tallaabo 3 — Xogta xiriirkaaga',
  'name_label'=>'Magacaaga','email_label'=>'Ciwaanka emailkaaga',
  'submit'=>'Diyaari fariintayda →',
  'step2_general'=>'Tallaabo 2 — Fariintaada',
  'subject_label'=>'Cinwaanka','message_label'=>'Fariintaada',
  'success_heading'=>'Fariintaadu diyaar ayey u tahay in la diro',
  'success1'=>'Guji <strong>Fur barnaamijka emailka</strong> — waxay furaysaa email cusub oo cinwaan horey loo buuxiyay.',
  'success2'=>'Guji <strong>Nuqul ka samee jirka fariinta</strong> hoose, kadibna ku dhejiso emailka.',
  'success3'=>'Guji <strong>Dir</strong> barnaamijkaaga emailka.',
  'open_email'=>'Fur barnaamijka emailka →','open_gmail'=>'Fur Gmail →',
  'no_email'=>'Badhanka kasta wuxuu furaa email cinwaan leh. Nuqul ka samee oo ku dhejiso jirka fariinta ka hor intaadan dirin.',
  'to_label'=>'Tii:','subject_display'=>'Cinwaanka:',
  'copy_btn'=>'Nuqul ka samee jirka fariinta','copied'=>'La nuquliyey!',
  'send_another'=>'← Dir farriin kale',
  'err_trans'=>'Fadlan geli koodhka turjumaanka.',
  'err_book_empty'=>'Fadlan geli gaabiska buugga.',
  'err_book_invalid'=>'Gaabiska "%s" lama aqoonsan. Isticmaal gaabisyo caadiga ah sida mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Fadlan geli lambarka cutubka saxda ah.',
  'err_verse'=>'Fadlan geli lambarka aayada saxda ah.',
  'err_current'=>'Fadlan geli waxa qoraalku hadda leeyahay.',
  'err_correct'=>'Fadlan geli waxa uu ahaanlahayd.',
  'err_name'=>'Fadlan geli magacaaga.',
  'err_email'=>'Fadlan geli cinwaan email saxda ah.',
  'err_subject'=>'Fadlan geli cinwaanka.',
  'err_message'=>'Fadlan geli farriin (ugu yaraan 10 xaraf).',
  'err_type'=>'Fadlan dooro nooca fariinta.',
  'reason_label'=>'Sababta xiriirka','reason_placeholder'=>'— Dooro sabab —',
  'reason_B'=>'Talo ku saabsan turjumaanka Kitaabka Quduuska','reason_P'=>'Su\'aal ku saabsan daabacaadda ama xuquuqda daabacaadda',
  'reason_R'=>'Codsiga ku biirista liiska iimaylka','reason_O'=>'Kale',
  'body_prompt'=>'Fadlan geli fariintaada halkan ka dib u dir iimaylka.',
  'body_reads_now'=>'Waxa qoraalku hadda leeyahay:',
  'body_better'=>'Sida loo wanaajiyi karo:',
];

$T['mg'] = [
  'title'=>'Mifandraisa Aminay','subtitle'=>'Mandefa hafatra any amin\'ny ekipa eBible.us',
  'step1'=>'Dingana 1 — Inona karazana hafatra ity?',
  'typo_title'=>'Fahadisoana amin\'ny soratra na fandikana',
  'typo_desc'=>'Hitako fahadisoana ao amin\'ny lahatsoratra Baiboly — teny diso, fahadisoana amin\'ny fanoratsora, na andininy toa diso.',
  'general_title'=>'Fanontaniana na hevitra ankapobeny',
  'general_desc'=>'Manana fanontaniana, soso-kevitra, na hafatra hafa ho an\'ny ekipa aho.',
  'step2_typo'=>'Dingana 2 — Lazao aminay ny fahadisoana',
  'trans_label'=>'Kaody fandikana','trans_hint'=>'ohatra <code>tl</code> ho an\'ny Tetum, <code>engwebp</code> ho an\'ny Anglisy WEB, <code>porbrbsl</code> ho an\'ny Portiogey',
  'book_label'=>'Boky','book_hint'=>'fanafohezana',
  'chapter_label'=>'Toko','verse_label'=>'Andininy',
  'current_label'=>'Izay lazain\'ny lahatsoratra ankehitriny','current_hint'=>'adikao sy apetaho ny lahatsoratra marina hitanao',
  'correct_label'=>'Izay tokony holazainy','correct_hint'=>'ampidiro ny lahatsoratra marina',
  'step3'=>'Dingana 3 — Ny mombamomba anao',
  'name_label'=>'Ny anaranao','email_label'=>'Ny adiresin\'ny mailainao',
  'submit'=>'Omano ny hafatrao →',
  'step2_general'=>'Dingana 2 — Ny hafatrao',
  'subject_label'=>'Lohahevitra','message_label'=>'Ny hafatrao',
  'success_heading'=>'Ny hafatrao dia vonona ho alefa',
  'success1'=>'Tsindrio ny <strong>Hamaha ny programa mailaka</strong> — mamaha mailaka vaovao miaraka amin\'ny lohahevitra efa feno.',
  'success2'=>'Tsindrio ny <strong>Adikao ny vatan\'ny hafatra</strong> etsy ambany, dia apetaho ao amin\'ny mailaka.',
  'success3'=>'Tsindrio ny <strong>Alefa</strong> ao amin\'ny programa mailainao.',
  'open_email'=>'Hamaha ny programa mailaka →','open_gmail'=>'Hamaha ao Gmail →',
  'no_email'=>'Ny bokotra rehetra dia mamaha mailaka miaraka amin\'ny lohahevitra. Adikao sy apetaho ny vatana alohan\'ny alefa.',
  'to_label'=>'Ho an\':','subject_display'=>'Lohahevitra:',
  'copy_btn'=>'Adikao ny vatan\'ny hafatra','copied'=>'Voadika!',
  'send_another'=>'← Mandefa hafatra hafa',
  'err_trans'=>'Azafady ampidiro ny kaody fandikana.',
  'err_book_empty'=>'Azafady ampidiro ny fanafohezana boky.',
  'err_book_invalid'=>'Fanafohezana "%s" tsy fantatra. Ampiasao fanafohezana mahazatra toy ny mt, mk, lk, jn, ac, ro.',
  'err_chapter'=>'Azafady ampidiro ny laharana toko mety.',
  'err_verse'=>'Azafady ampidiro ny laharana andininy mety.',
  'err_current'=>'Azafady ampidiro izay lazain\'ny lahatsoratra ankehitriny.',
  'err_correct'=>'Azafady ampidiro izay tokony holazainy.',
  'err_name'=>'Azafady ampidiro ny anaranao.',
  'err_email'=>'Azafady ampidiro adiresy mailaka mety.',
  'err_subject'=>'Azafady ampidiro ny lohahevitra.',
  'err_message'=>'Azafady ampidiro hafatra (fara-fahakeliny endri-tsoratra 10).',
  'err_type'=>'Azafady safidio ny karazana hafatra.',
  'reason_label'=>'Antony an\'ny fifandraisana','reason_placeholder'=>'— Safidio ny antony —',
  'reason_B'=>'Soso-kevitra amin\'ny fandikana ny Baiboly','reason_P'=>'Fanontaniana momba ny famoahana na ny zo an-tsoratra',
  'reason_R'=>'Fangatahana hiditra ao amin\'ny lisitry ny mailaka','reason_O'=>'Hafa',
  'body_prompt'=>'Azafady soratana ny hafatrao eto ary alefa ny mailaka.',
  'body_reads_now'=>'Izay lazain\'ny lahatsoratra ankehitriny:',
  'body_better'=>'Ahoana no ahafahana hanatsarana:',
];

$t = array_merge($T['en'], $T[$uiLang] ?? []);

// ---- Process submitted form ----
$submitted   = ($_SERVER['REQUEST_METHOD'] === 'POST');
$reason      = '';
$errors      = [];
$mailto_url  = '';
$gmail_url   = '';
$recipient   = '';
$subject     = '';
$body        = '';

$reason_labels_en = [
  'B' => 'Bible translation suggestion',
  'P' => 'Publishing or copyright question',
  'R' => 'Request to join mailing list',
  'O' => 'Other',
];

if ($submitted) {
    $reason       = trim($_POST['reason']     ?? '');
    $trans        = trim($_POST['trans']      ?? '');
    $book         = trim($_POST['book']       ?? '');
    $chapter      = trim($_POST['chapter']    ?? '');
    $verse        = trim($_POST['verse']      ?? '');
    $sender_name  = trim($_POST['name']       ?? '');
    $sender_email = trim($_POST['email_addr'] ?? '');

    if (!array_key_exists($reason, $reason_labels_en)) $errors[] = $t['err_reason'];
    if ($sender_name  === '') $errors[] = $t['err_name'];
    if ($sender_email === '' || !filter_var($sender_email, FILTER_VALIDATE_EMAIL)) $errors[] = $t['err_email'];

    if ($reason === 'B') {
        if ($trans   === '') $errors[] = $t['err_trans'];
        if ($book    === '') $errors[] = $t['err_book_empty'];
        if (!ctype_digit($chapter) || (int)$chapter < 1) $errors[] = $t['err_chapter'];
        if (!ctype_digit($verse)   || (int)$verse   < 1) $errors[] = $t['err_verse'];
    }

    if (empty($errors)) {
        $recipient    = 'ebible.org+' . SITE_CODE . '.' . strtolower($reason) . '@gmail.com';
        $reason_text  = $t['reason_' . $reason];

        if ($reason === 'B') {
            $subject = "[Bible suggestion] $trans $book $chapter:$verse";
            $body    = "Translation: $trans\nBook: $book  Chapter: $chapter  Verse: $verse\n\n"
                     . $t['body_reads_now'] . "\n\n\n"
                     . $t['body_better'] . "\n\n\n"
                     . $t['body_prompt'] . "\n\n"
                     . "---\nFrom: $sender_name <$sender_email>";
        } else {
            $subject = "[$reason_text]";
            $body    = $reason_text . "\n\n"
                     . $t['body_prompt'] . "\n\n"
                     . "---\nFrom: $sender_name <$sender_email>";
        }

        $mailto_url = 'mailto:' . $recipient
                    . '?subject=' . rawurlencode($subject)
                    . '&body='    . rawurlencode($body);
        $gmail_url  = 'https://mail.google.com/mail/?view=cm&fs=1'
                    . '&to='  . rawurlencode($recipient)
                    . '&su='  . rawurlencode($subject)
                    . '&body=' . rawurlencode($body);
    }
}

function h($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
function val($key, $default = '') { return h(trim($_POST[$key] ?? $default)); }
?>
<!DOCTYPE html>
<html class="no-js" lang="<?= $uiLang ?>" <?= $rtl ? 'dir="rtl"' : '' ?>>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
<meta name="robots" content="noindex, follow" />
<title><?= h($t['title']) ?> — FSM.Bible</title>
<link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
<link rel="icon" href="/images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="/css/font-icons.min.css">
<link rel="stylesheet" type="text/css" href="/css/theme-vendors.min.css">
<link rel="stylesheet" type="text/css" href="/css/style.css" />
<link rel="stylesheet" type="text/css" href="/css/custom.css" />
<link rel="stylesheet" type="text/css" href="/css/responsive.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.fsm-title-bar { margin-top: 117px; }
@media (max-width: 767px) {
  .fsm-title-bar { margin-top: 60px; }
  .navbar-brand img.default-logo { height: 40px !important; max-width: 160px; }
}
.cform-wrap { max-width: 680px; }
.lang-bar { text-align: right; margin-bottom: 20px; font-family: sans-serif; font-size: 0.88em; }
.lang-bar select { font-family: sans-serif; font-size: 0.9em; padding: 4px 8px; border: 1px solid #bbb; border-radius: 4px; background: #fff; cursor: pointer; }
.step-label { font-family: sans-serif; font-size: 0.75em; font-weight: bold; letter-spacing: 0.1em; text-transform: uppercase; color: #888; margin-bottom: 6px; }
.fields-section { display: none; }
.fields-section.active { display: block; }
.field-group { margin-bottom: 18px; }
.field-group label { display: block; font-family: sans-serif; font-size: 0.88em; font-weight: bold; margin-bottom: 5px; color: #333; }
.field-group label .hint { font-weight: normal; color: #777; font-size: 0.92em; }
.row-fields { display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end; padding-bottom: 1.4em; }
.row-fields .field-group { flex: 1; min-width: 80px; position: relative; }
.row-fields .field-group .hint { position: absolute; top: 100%; left: 0; margin-top: 3px; font-size: 0.78em; color: #777; white-space: nowrap; }
.cform-wrap input[type="text"], .cform-wrap input[type="email"], .cform-wrap textarea {
  width: 100%; font-size: 1em; padding: 8px 10px; border: 1px solid #bbb; border-radius: 4px; background: #fff; box-sizing: border-box;
}
.cform-wrap select.reason-sel { width: 100%; font-size: 1em; padding: 8px 10px; border: 1px solid #bbb; border-radius: 4px; background: #fff; box-sizing: border-box; }
.code-input { font-family: monospace; }
.required { color: #b00; margin-left: 2px; }
.contact-submit { background: #000; color: #fff; border: none; padding: 11px 28px; font-size: 1em; border-radius: 4px; cursor: pointer; margin-top: 6px; }
.contact-submit:hover { background: #333; }
.errors { background: #fff3f3; border: 1px solid #f5b8b8; border-radius: 6px; padding: 12px 16px; margin-bottom: 22px; }
.errors p { margin: 0 0 4px; font-size: 0.92em; color: #b00; }
.errors p:last-child { margin-bottom: 0; }
.success-panel { background: #f0f7f0; border: 1px solid #a8d5a8; border-radius: 8px; padding: 24px 28px; margin-bottom: 28px; }
.success-panel h3 { margin: 0 0 12px; font-size: 1.1em; color: #1a4a1a; }
.success-panel p { margin: 0 0 16px; font-size: 0.95em; line-height: 1.6; }
.mailto-btn { display: inline-block; background: #2a7a2a; color: #fff !important; text-decoration: none; padding: 12px 28px; border-radius: 4px; font-size: 1em; font-weight: bold; }
.mailto-btn:hover { background: #1f5f1f; }
.gmail-btn { background: #c0392b; }
.gmail-btn:hover { background: #96281b; }
.mailto-note { font-size: 0.82em; color: #666; margin-top: 12px !important; }
.message-preview { margin-top: 16px; background: #fff; border: 1px solid #c8e0c8; border-radius: 6px; padding: 16px 20px; font-family: sans-serif; font-size: 0.88em; }
.message-preview-row { margin-bottom: 6px; color: #444; }
.mp-label { font-weight: bold; color: #222; min-width: 60px; display: inline-block; }
.copy-btn { background: #555; color: #fff; border: none; border-radius: 4px; padding: 6px 14px; font-size: 0.85em; cursor: pointer; }
.copy-btn:hover { background: #333; }
.mp-body { margin: 12px 0 0; white-space: pre-wrap; font-family: monospace; font-size: 0.95em; background: #f5f5f5; border: 1px solid #ddd; border-radius: 4px; padding: 12px; color: #222; user-select: all; }
hr.cform-hr { border: none; border-top: 1px solid #ddd; margin: 28px 0; }
</style>
</head>

<body data-mobile-nav-style="classic">

<header class="header-with-topbar">
    <nav class="navbar navbar-expand-lg top-space navbar-light bg-black header-light fixed-top navbar-boxed" style="top: 48.8px;">
        <div class="container-fluid nav-header-container">
            <div class="ps-lg-0 d-flex align-items-center" style="flex:1; min-width:0;">
                <a class="navbar-brand" href="/fsm.php">
                    <img src="/images/Flag_of_FSM.png" data-at2x="/images/Flag_of_FSM.png" class="default-logo" alt="FSM Bible" height="42">
                    <img src="/images/Flag_of_FSM.png" data-at2x="/images/Flag_of_FSM.png" class="alt-logo" alt="FSM Bible" width="0" height="0">
                    <img src="/images/Flag_of_FSM.png" data-at2x="/images/Flag_of_FSM.png" class="mobile-logo" alt="FSM Bible" width="0" height="0">
                </a>
            </div>
            <div class="col-auto bg-black menu-order px-lg-0">
                <button class="navbar-toggler float-end" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
                    <span class="navbar-toggler-line"></span>
                    <span class="navbar-toggler-line"></span>
                    <span class="navbar-toggler-line"></span>
                    <span class="navbar-toggler-line"></span>
                </button>
                <div class="bg-black collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav alt-font">
                        <li class="nav-item"><a href="/fsm.php" class="nav-link">Welcome</a></li>
                        <li class="nav-item"><a href="https://fsm.bible/" class="nav-link">FSM.Bible</a></li>
                        <li class="nav-item"><a href="https://eBible.org/" class="nav-link">eBible.org</a></li>
                        <li class="nav-item"><a href="/fsm-contact.php" class="nav-link">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
<div class="fsm-title-bar" style="background:#d4700a; padding: 18px 30px; text-align:center;">
  <a href="/fsm.php" style="color:#fff; font-size:clamp(1.4em, 4vw, 2.4em); font-family: Georgia, serif; text-decoration:none; line-height:1.2;">The Holy Bible for the Federated States of Micronesia</a>
</div>

<div style="background:#000;"><img src="/images/fsm-hero.png" alt="FSM Digital and Technology Gospel" style="width:100%; max-height:220px; object-fit:cover; display:block;"></div>

<section>
<div class="container slim-container">
  <div class="row">
    <div class="col-md-12">
      <h1 class="h1-main-title alt-font font-weight-600 text-extra-dark-gray w-95"><?= h($t['title']) ?></h1>
      <p style="color:#555;margin-bottom:1.5em"><?= h($t['subtitle']) ?></p>

      <div class="cform-wrap">
      <div class="lang-bar">
        <form method="get" action="" style="display:inline">
          <select name="lang" onchange="this.form.submit()">
            <?php foreach ($langNames as $code => $name): ?>
              <option value="<?= h($code) ?>" <?= $uiLang===$code?'selected':'' ?>><?= h($name) ?></option>
            <?php endforeach; ?>
          </select>
        </form>
      </div>

<?php if ($mailto_url): ?>
  <div class="success-panel">
    <h3><?= h($t['success_heading']) ?></h3>
    <ol style="margin:0 0 16px;padding-left:1.4em;font-size:0.95em;line-height:1.8">
      <li><?= $t['success1'] ?></li>
      <li><?= $t['success2'] ?></li>
      <li><?= $t['success3'] ?></li>
    </ol>
    <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:4px">
      <a class="mailto-btn" href="<?= h($mailto_url) ?>"><?= h($t['open_email']) ?></a>
      <a class="mailto-btn gmail-btn" href="<?= h($gmail_url) ?>" target="_blank" rel="noopener"><?= h($t['open_gmail']) ?></a>
    </div>
    <p class="mailto-note"><?= h($t['no_email']) ?></p>
    <div class="message-preview">
      <div class="message-preview-row"><span class="mp-label"><?= h($t['to_label']) ?></span> <?= h($recipient) ?></div>
      <div class="message-preview-row"><span class="mp-label"><?= h($t['subject_display']) ?></span> <?= h($subject) ?></div>
      <div style="display:flex;justify-content:flex-end;margin-top:12px">
        <button class="copy-btn" onclick="copyBody()"><?= h($t['copy_btn']) ?></button>
      </div>
      <pre class="mp-body" id="mp-body"><?= h($body) ?></pre>
    </div>
  </div>
  <p><a href="fsm-contact.php?lang=<?= h($uiLang) ?>"><?= h($t['send_another']) ?></a></p>

<?php else: ?>

  <?php if (!empty($errors)): ?>
  <div class="errors">
    <?php foreach ($errors as $e): ?>
      <p>⚠ <?= h($e) ?></p>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <form method="post" action="fsm-contact.php?lang=<?= h($uiLang) ?>" id="contact-form">

    <div class="step-label"><?= h($t['step1']) ?></div>
    <div class="field-group">
      <label><?= h($t['reason_label']) ?> <span class="required">*</span></label>
      <select name="reason" id="reason-select" class="reason-sel" onchange="updateBibleFields()">
        <option value=""><?= h($t['reason_placeholder']) ?></option>
        <?php foreach (['B','P','R','O'] as $rc): ?>
          <option value="<?= $rc ?>" <?= ($reason??'')===$rc?'selected':'' ?>><?= h($t['reason_'.$rc]) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Bible passage fields (shown only for reason B) -->
    <div id="bible-fields" class="fields-section <?= $reason==='B'?'active':'' ?>">
      <div class="step-label"><?= h($t['step2_bible']) ?></div>

      <div class="field-group">
        <label><?= h($t['trans_label']) ?> <span class="required">*</span>
          <span class="hint">— <?= $t['trans_hint'] ?></span>
        </label>
        <input type="text" name="trans" class="code-input" value="<?= val('trans') ?>" placeholder="e.g. engwebp" autocomplete="off" spellcheck="false">
      </div>

      <div class="row-fields">
        <div class="field-group">
          <label><?= h($t['book_label']) ?> <span class="required">*</span></label>
          <input type="text" name="book" class="code-input" value="<?= val('book') ?>" placeholder="e.g. Mat, Mark, John" autocomplete="off" spellcheck="false">
          <span class="hint"><?= h($t['book_hint']) ?></span>
        </div>
        <div class="field-group">
          <label><?= h($t['chapter_label']) ?> <span class="required">*</span></label>
          <input type="text" name="chapter" class="code-input" value="<?= val('chapter') ?>" placeholder="e.g. 3" autocomplete="off">
        </div>
        <div class="field-group">
          <label><?= h($t['verse_label']) ?> <span class="required">*</span></label>
          <input type="text" name="verse" class="code-input" value="<?= val('verse') ?>" placeholder="e.g. 16" autocomplete="off">
        </div>
      </div>
    </div>

    <hr class="cform-hr">
    <div class="step-label"><?= h($t['step3']) ?></div>

    <div class="row-fields">
      <div class="field-group">
        <label><?= h($t['name_label']) ?> <span class="required">*</span></label>
        <input type="text" name="name" value="<?= val('name') ?>" autocomplete="name">
      </div>
      <div class="field-group">
        <label><?= h($t['email_label']) ?> <span class="required">*</span></label>
        <input type="email" name="email_addr" value="<?= val('email_addr') ?>" autocomplete="email">
      </div>
    </div>

    <button type="submit" class="contact-submit"><?= h($t['submit']) ?></button>

  </form>

<?php endif; ?>

      </div><!-- /.cform-wrap -->
    </div><!-- /.col-md-12 -->
  </div><!-- /.row -->
</div><!-- /.container -->
</section>

<footer class="footer-dark bg-black padding-slim-top">
    <div class="footer-top padding-40px-tb border-bottom border-color-white-transparent">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-3 text-center text-md-start sm-margin-20px-bottom">
                    <img class="circle-black-bg" src="/images/Flag_of_FSM.png" alt="FSM flag">
                </div>
                <div class="col-12 col-md-6 text-center sm-margin-20px-bottom">
                    <span class="alt-font font-weight-500 d-inline-block align-middle margin-5px-right text-uppercase text-white">
                        <p>This site is posted for the people of the Federated States of Micronesia by the FSM Digital and Technology Gospel and by <a href="https://eBible.org/">eBible.org</a>.<br/>
                        See each Bible translation's information page for copyright and permissions information for that translation.<br/>
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

<script>
var copiedLabel = <?= json_encode($t['copied']) ?>;
var copyLabel   = <?= json_encode($t['copy_btn']) ?>;
function copyBody() {
  var text = document.getElementById('mp-body');
  if (text) {
    navigator.clipboard.writeText(text.innerText).then(function() {
      var btn = document.querySelector('.copy-btn');
      btn.textContent = copiedLabel;
      setTimeout(function() { btn.textContent = copyLabel; }, 2000);
    });
  }
}
function updateBibleFields() {
  var reason = document.getElementById('reason-select').value;
  var bf = document.getElementById('bible-fields');
  if (bf) bf.classList.toggle('active', reason === 'B');
}
document.addEventListener('DOMContentLoaded', updateBibleFields);
</script>

</body>
</html>
