<?php
/**
 * Taal: nl, es, en, fr, pt, tr — cookie + ?lang=  (oude code sp → es)
 * Taalcodes worden genormaliseerd (trim + lowercase) zodat bv. TR/tr hetzelfde werkt.
 */

if (!defined('QTABLE_LANGS')) {
    define('QTABLE_LANGS', ['nl', 'es', 'en', 'fr', 'pt', 'tr']);
}

require_once dirname(__DIR__, 2) . '/register/includes/locale-from-country.php';

$GLOBALS['qtable_lang'] = 'nl';

/** Cookie gedeeld over *.qtable.cloud zodat register.qtable.cloud dezelfde taal ziet. */
$qtable_lang_cookie_opts = static function (): array {
    $opts = [
        'expires' => time() + 365 * 86400,
        'path' => '/',
        'samesite' => 'Lax',
        'httponly' => false,
    ];
    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
        $opts['secure'] = true;
    }
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if ($host !== '' && preg_match('/(^|\.)qtable\.cloud$/i', $host)) {
        $opts['domain'] = '.qtable.cloud';
    }
    return $opts;
};

function qtable_normalize_lang(?string $code): ?string
{
    if ($code === null || $code === '') {
        return null;
    }
    $code = strtolower(trim($code));
    if ($code === '') {
        return null;
    }
    if ($code === 'sp') {
        return 'es';
    }
    return $code;
}

if (isset($_GET['lang'])) {
    $raw = $_GET['lang'];
    $chosen = qtable_normalize_lang(is_string($raw) ? $raw : null);
    if ($chosen !== null && in_array($chosen, QTABLE_LANGS, true)) {
        $GLOBALS['qtable_lang'] = $chosen;
        setcookie('qtable_lang', $GLOBALS['qtable_lang'], $qtable_lang_cookie_opts());
    }
} elseif (!empty($_COOKIE['qtable_lang'])) {
    $fromCookie = qtable_normalize_lang(is_string($_COOKIE['qtable_lang']) ? $_COOKIE['qtable_lang'] : null);
    if ($fromCookie !== null && in_array($fromCookie, QTABLE_LANGS, true)) {
        $GLOBALS['qtable_lang'] = $fromCookie;
        if (isset($_COOKIE['qtable_lang']) && strcasecmp((string) $_COOKIE['qtable_lang'], 'sp') === 0) {
            setcookie('qtable_lang', 'es', $qtable_lang_cookie_opts());
        }
    }
} else {
    $geoLang = qtable_locale_from_country_code(qtable_request_country_code());
    if ($geoLang !== null && in_array($geoLang, QTABLE_LANGS, true)) {
        $GLOBALS['qtable_lang'] = $geoLang;
        setcookie('qtable_lang', $geoLang, $qtable_lang_cookie_opts());
        $_COOKIE['qtable_lang'] = $geoLang;
    }
}

require_once __DIR__ . '/translations.php';

function qtable_lang(): string
{
    return $GLOBALS['qtable_lang'];
}

/** Registratie-URL met huidige taal (?lang=) + optioneel hash (plananker). */
function qtable_register_url(string $fragment = ''): string
{
    $base = 'https://register.qtable.cloud';
    $url = $base . '/?lang=' . rawurlencode($GLOBALS['qtable_lang']);
    if ($fragment !== '') {
        $url .= '#' . ltrim($fragment, '#');
    }
    return $url;
}

function qtable_html_lang(): string
{
    $map = ['nl' => 'nl', 'es' => 'es', 'en' => 'en', 'fr' => 'fr', 'pt' => 'pt', 'tr' => 'tr'];
    return $map[$GLOBALS['qtable_lang']] ?? 'nl';
}

function t(string $key): string
{
    $lang = $GLOBALS['qtable_lang'];
    $tr = $GLOBALS['qtable_translations'][$lang] ?? [];
    if (isset($tr[$key])) {
        return $tr[$key];
    }
    $fallback = $GLOBALS['qtable_translations']['nl'] ?? [];
    return $fallback[$key] ?? $key;
}

function qtable_cell_html(string $v): string
{
    if ($v === 'dash') {
        return '<span class="dash">—</span>';
    }
    if ($v === 'check') {
        return '<span class="check">✔</span>';
    }
    if (strpos($v, 't:') === 0) {
        return htmlspecialchars(t(substr($v, 2)));
    }
    return htmlspecialchars($v);
}

/** Fallback vertaalsupport voor ontbrekende sleutels in translations.php */
function qtable_t_or(string $key, string $fallback): string
{
    $lang = $GLOBALS['qtable_lang'];
    $tr = $GLOBALS['qtable_translations'][$lang] ?? [];
    if (isset($tr[$key])) {
        return $tr[$key];
    }
    $fallbackLang = $GLOBALS['qtable_translations']['nl'] ?? [];
    return $fallbackLang[$key] ?? $fallback;
}

/**
 * @return array<int, array<int|string>>
 */
function qtable_comparison_rows(): array
{
    return [
        ['category', 'comp_cat_prices'],
        ['data', 'comp_row_price_mnd', ['€45', '€69', '€99', '€157']],
        ['category', 'comp_cat_included'],
        ['data', 'comp_row_all_starter', ['dash', 'check', 'check', 'check']],
        ['data', 'comp_row_all_pro', ['dash', 'dash', 'check', 'check']],
        ['data', 'comp_row_included_ui_langs', ['3', '4', '5', '5']],
        ['data', 'comp_row_storage', ['10 GB', '50 GB', '100 GB', '100 GB']],
        ['data', 'comp_row_users', ['3', '10', 't:comp_unlimited', 't:comp_unlimited']],
        ['data', 'comp_row_email_support', ['check', 'dash', 'dash', 'dash']],
        ['data', 'comp_row_email_chat', ['dash', 'check', 'dash', 'dash']],
        ['data', 'comp_row_dedicated', ['dash', 'dash', 'check', 'check']],
        ['data', 'comp_row_menu', ['check', 'check', 'check', 'check']],
        ['data', 'comp_row_events', ['dash', 'dash', 'check', 'check']],
        ['data', 'comp_row_staff_perf', ['dash', 'check', 'check', 'check']],
        ['data', 'comp_row_visa_mc', ['dash', 'dash', 'check', 'check']],
        ['data', 'comp_row_white_label', ['dash', 'dash', 'check', 'check']],
        ['data', 'comp_row_backup', ['t:comp_backup_week', 't:comp_backup_day', 't:comp_backup_hour', 't:comp_backup_hour']],
        ['data', 'comp_row_translation', ['t:comp_cell_translation_fee', 't:comp_cell_translation_fee', 't:comp_cell_translation_included', 't:comp_cell_translation_included']],
        ['category', 'comp_cat_hosting'],
        ['data', 'comp_row_subdomain', ['check', 'check', 'check', 'check']],
        ['data', 'comp_row_rds', ['check', 'check', 'check', 'check']],
        ['data', 'comp_row_ssl', ['check', 'check', 'check', 'check']],
        ['data', 'comp_row_bandwidth', ['50 GB', '250 GB', 't:comp_unlimited', 't:comp_unlimited']],
        ['category', 'comp_cat_extra'],
        ['data', 'comp_row_dashboard', ['t:comp_dashboard_basic', 't:comp_dashboard_extended', 't:comp_dashboard_full', 't:comp_dashboard_full']],
        ['data', 'comp_row_reports', ['dash', 't:comp_cell_pdf_csv', 't:comp_cell_scheduler', 't:comp_cell_scheduler']],
        ['data', 'comp_row_voice_agent', ['dash', 't:comp_voice_addon', 't:comp_voice_addon', 'check']],
        ['data', 'comp_row_lightspeed', ['t:comp_lightspeed_addon', 'check', 'check', 'check']],
        ['data', 'comp_row_website', ['dash', 'dash', 'dash', 'check']],
        ['data', 'comp_row_domain_connect', ['dash', 'dash', 'dash', 'check']],
        ['category', 'comp_cat_support'],
        ['data', 'comp_row_response_time', ['t:comp_response_48', 't:comp_response_8', 't:comp_response_2_sla', 't:comp_response_2_sla']],
        ['data', 'comp_row_onboarding', ['dash', 't:comp_onboarding_video', 't:comp_onboarding_personal', 't:comp_onboarding_personal']],
    ];
}

function qtable_render_comparison_table(): void
{
    $planNames = ['Starter', 'Pro', 'Enterprise', 'Ultimate'];
    $rows = qtable_comparison_rows();
    ?>
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th></th>
                        <?php foreach ($planNames as $name): ?>
                        <th<?= $name === 'Ultimate' ? ' class="th-ultimate"' : '' ?>><?= htmlspecialchars($name) ?></th>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="category-row">
                        <th colspan="5"><?php
                        $firstCat = null;
    foreach ($rows as $r) {
        if ($r[0] === 'category') {
            $firstCat = $r[1];
            break;
        }
    }
    echo htmlspecialchars(t($firstCat));
    ?></th>
                    </tr>
                </thead>
                <tbody>
    <?php
    $skipFirstCategory = true;
    foreach ($rows as $row) {
        if ($row[0] === 'category') {
            if ($skipFirstCategory) {
                $skipFirstCategory = false;
                continue;
            }
            ?>
                    <tr class="category-row">
                        <th colspan="5"><?= htmlspecialchars(t($row[1])) ?></th>
                    </tr>
            <?php
            continue;
        }
        $labelKey = $row[1];
        $cells = $row[2];
        $isUltimateRow = in_array('check', array_slice($cells, 3, 1), true);
        echo '<tr' . ($isUltimateRow && !in_array('check', array_slice($cells, 0, 3), true) ? ' class="tr-ultimate-exclusive"' : '') . '>';
        echo '<td>' . htmlspecialchars(t($labelKey)) . '</td>';
        foreach ($cells as $idx => $c) {
            $cls = ($idx === 3) ? ' class="td-ultimate"' : '';
            echo '<td' . $cls . '>' . qtable_cell_html($c) . '</td>';
        }
        echo "</tr>\n";
    }
    ?>
                </tbody>
            </table>
    <?php
}
