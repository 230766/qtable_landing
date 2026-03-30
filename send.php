<?php
/**
 * Contactformulier verwerking - verstuurt naar info@qtable.cloud (SMTP via register/.env, zie app/api/mail-helper.php)
 */
require_once __DIR__ . '/includes/i18n.php';
require_once dirname(__DIR__) . '/app/api/mail-helper.php';

$lang = $_POST['lang'] ?? ($_COOKIE['qtable_lang'] ?? 'nl');
if ($lang === 'sp') {
    $lang = 'es';
}
if (!in_array($lang, QTABLE_LANGS, true)) {
    $lang = 'nl';
}

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
$subject = 'Contactformulier QTABLE - ' . ($bedrijf ?: 'Geen bedrijf opgegeven');
$body = "Naam: $naam\n";
$body .= "E-mail: $email\n";
$body .= "Bedrijf: $bedrijf\n\n";
$body .= "Bericht:\n$bericht";

$mail_sent = sendContactFormMail($to, $subject, $body, $email);

if ($mail_sent) {
    header('Location: ' . $redirect . '&sent=1');
} else {
    header('Location: ' . $redirect . '&err=generic');
}
exit;
