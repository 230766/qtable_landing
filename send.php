<?php
/**
 * Contactformulier verwerking - verstuurt naar info@qtable.cloud (SMTP via register/.env, zie app/api/mail-helper.php)
 */
require_once __DIR__ . '/includes/i18n.php';
require_once dirname(__DIR__) . '/app/api/mail-helper.php';

$rawLang = $_POST['lang'] ?? ($_COOKIE['qtable_lang'] ?? 'nl');
if (!is_string($rawLang)) {
    $rawLang = 'nl';
}
$normalizedLang = qtable_normalize_lang($rawLang);
$lang = ($normalizedLang !== null && in_array($normalizedLang, QTABLE_LANGS, true))
    ? $normalizedLang
    : 'nl';

$GLOBALS['qtable_lang'] = $lang;

$redirect = 'index.php?lang=' . rawurlencode($lang);

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['contact_submit'])) {
    header('Location: ' . $redirect);
    exit;
}

$naam = trim($_POST['naam'] ?? '');
$email = trim($_POST['email'] ?? '');
$bedrijf = trim($_POST['bedrijf'] ?? '');
$bericht = trim($_POST['bericht'] ?? '');

if (empty($naam) || empty($email) || empty($bericht)) {
    header('Location: ' . $redirect . '&err=required');
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ' . $redirect . '&err=email');
    exit;
}

$to = 'info@qtable.cloud';
$subject = sprintf(t('contact_mail_subject'), $bedrijf !== '' ? $bedrijf : t('contact_mail_no_company'));
$body = t('contact_mail_line_name') . ' ' . $naam . "\n";
$body .= t('contact_mail_line_email') . ' ' . $email . "\n";
$body .= t('contact_mail_line_company') . ' ' . $bedrijf . "\n\n";
$body .= t('contact_mail_line_message_intro') . "\n" . $bericht;

$mail_sent = sendContactFormMail($to, $subject, $body, $email);

if ($mail_sent) {
    header('Location: ' . $redirect . '&sent=1');
} else {
    header('Location: ' . $redirect . '&err=generic');
}
exit;
