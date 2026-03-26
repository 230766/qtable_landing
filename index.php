<?php
require_once __DIR__ . '/includes/i18n.php';

$form_sent = isset($_GET['sent']) && $_GET['sent'] === '1';
$err_code = isset($_GET['err']) ? (string) $_GET['err'] : '';
$form_error = '';
if ($err_code === 'required') {
    $form_error = t('err_required');
} elseif ($err_code === 'email') {
    $form_error = t('err_email');
} elseif ($err_code === 'generic') {
    $form_error = t('err_generic');
}
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars(qtable_html_lang()) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?= htmlspecialchars(t('page_title')) ?></title>
    <link rel="icon" href="images/qtable_icoon.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?v=<?= file_exists(__DIR__ . '/css/style.css') ? (int) filemtime(__DIR__ . '/css/style.css') : '1' ?>">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

    <!-- Hero Section: desktop qtable_hero.png, mobiel hero_mobiel_qtable.png -->
    <section id="top" class="hero" aria-label="QTABLE">
        <picture>
            <source media="(max-width: 768px)" srcset="images/hero_mobiel_qtable.png">
            <img class="hero-image" src="images/qtable_hero.png" alt="" width="1920" height="1080" decoding="async" fetchpriority="high">
        </picture>
    </section>

    <!-- Verhaal / Intro -->
    <section id="verhaal" class="section section-verhaal">
        <video class="verhaal-video" autoplay muted loop playsinline>
            <source src="video/q-video.mp4" type="video/mp4">
        </video>
        <div class="verhaal-overlay"></div>
        <div class="verhaal-content">
        <h2 class="section-title"><?= htmlspecialchars(t('verhaal_title')) ?></h2>
        <p class="section-subtitle"><?= htmlspecialchars(t('verhaal_subtitle')) ?></p>
        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon">📅</div>
                <h3><?= htmlspecialchars(t('benefit1_t')) ?></h3>
                <p><?= htmlspecialchars(t('benefit1_p')) ?></p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">📊</div>
                <h3><?= htmlspecialchars(t('benefit2_t')) ?></h3>
                <p><?= htmlspecialchars(t('benefit2_p')) ?></p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">⚡</div>
                <h3><?= htmlspecialchars(t('benefit3_t')) ?></h3>
                <p><?= htmlspecialchars(t('benefit3_p')) ?></p>
            </div>
        </div>
        </div>
    </section>

    <!-- Abonnementen -->
    <section id="plannen" class="section section-plannen">
        <video class="plannen-video" autoplay muted loop playsinline>
            <source src="video/q-video.mp4" type="video/mp4">
        </video>
        <div class="plannen-overlay"></div>
        <div class="plannen-content" data-yearly-hint="<?= htmlspecialchars(t('plan_yearly_hint')) ?>" data-discount-save="<?= htmlspecialchars(t('plan_discount_save')) ?>">
        <h2 class="section-title"><?= htmlspecialchars(t('plannen_title')) ?></h2>
        <p class="section-subtitle"><?= htmlspecialchars(t('plannen_subtitle')) ?></p>

        <div class="pricing-billing-wrap">
            <div class="pricing-billing-toggle" role="group" aria-label="<?= htmlspecialchars(t('plan_billing_aria')) ?>">
                <button type="button" class="billing-btn is-active" data-billing="monthly"><?= htmlspecialchars(t('plan_billing_monthly')) ?></button>
                <button type="button" class="billing-btn" data-billing="yearly"><?= htmlspecialchars(t('plan_billing_yearly')) ?></button>
            </div>
        </div>
        
        <div class="pricing-grid">
            <div class="plan-card">
                <h3 class="plan-name"><?= htmlspecialchars(t('plan_starter')) ?></h3>
                <div class="plan-price js-plan-price" data-m="45" data-y="39" data-ytotal="468">
                    <div class="plan-price-main">
                        <span class="js-plan-price-display">€45</span><span class="plan-price-asterisk">*</span><span class="plan-price-period"><?= htmlspecialchars(t('plan_per_month')) ?></span>
                    </div>
                    <div class="plan-price-yearly-line js-plan-yearly-line" hidden></div>
                </div>
                <div class="plan-discount-ticket js-plan-discount" aria-hidden="true">
                    <span class="plan-discount-title"><?= htmlspecialchars(t('plan_discount_title')) ?></span>
                    <span class="plan-discount-pct js-plan-discount-pct"></span>
                    <span class="plan-discount-save js-plan-discount-save"></span>
                </div>
                <p class="plan-desc"><?= htmlspecialchars(t('plan_starter_desc')) ?></p>
                <ul class="plan-features">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                    <li><span class="check">✔</span> <?= htmlspecialchars(t('plan_feat_s' . $i)) ?></li>
                    <?php endfor; ?>
                    <li><span class="check">✔</span> <?= htmlspecialchars(t('plan_feat_translation_option')) ?></li>
                </ul>
                <a href="https://register.qtable.cloud/#plan-starter" target="_blank" rel="noopener noreferrer" class="plan-btn outline"><?= htmlspecialchars(t('plan_starter_btn')) ?></a>
                <p class="plan-vat-note"><span class="plan-vat-asterisk" aria-hidden="true">*</span> <?= htmlspecialchars(t('plan_vat_note')) ?></p>
            </div>
            <div class="plan-card featured">
                <span class="plan-badge"><?= htmlspecialchars(t('plan_badge_popular')) ?></span>
                <h3 class="plan-name"><?= htmlspecialchars(t('plan_pro')) ?></h3>
                <div class="plan-price js-plan-price" data-m="69" data-y="59" data-ytotal="708">
                    <div class="plan-price-main">
                        <span class="js-plan-price-display">€69</span><span class="plan-price-asterisk">*</span><span class="plan-price-period"><?= htmlspecialchars(t('plan_per_month')) ?></span>
                    </div>
                    <div class="plan-price-yearly-line js-plan-yearly-line" hidden></div>
                </div>
                <div class="plan-discount-ticket js-plan-discount" aria-hidden="true">
                    <span class="plan-discount-title"><?= htmlspecialchars(t('plan_discount_title')) ?></span>
                    <span class="plan-discount-pct js-plan-discount-pct"></span>
                    <span class="plan-discount-save js-plan-discount-save"></span>
                </div>
                <p class="plan-desc"><?= htmlspecialchars(t('plan_pro_desc')) ?></p>
                <ul class="plan-features">
                    <?php for ($i = 1; $i <= 7; $i++): ?>
                    <li><span class="check">✔</span> <?= htmlspecialchars(t('plan_feat_p' . $i)) ?></li>
                    <?php endfor; ?>
                    <li><span class="check">✔</span> <?= htmlspecialchars(t('plan_feat_translation_option')) ?></li>
                </ul>
                <a href="https://register.qtable.cloud/#plan-pro" target="_blank" rel="noopener noreferrer" class="plan-btn primary"><?= htmlspecialchars(t('plan_pro_btn')) ?></a>
                <p class="plan-vat-note"><span class="plan-vat-asterisk" aria-hidden="true">*</span> <?= htmlspecialchars(t('plan_vat_note')) ?></p>
            </div>
            <div class="plan-card">
                <h3 class="plan-name"><?= htmlspecialchars(t('plan_enterprise')) ?></h3>
                <div class="plan-price js-plan-price" data-m="99" data-y="89" data-ytotal="1068">
                    <div class="plan-price-main">
                        <span class="js-plan-price-display">€99</span><span class="plan-price-asterisk">*</span><span class="plan-price-period"><?= htmlspecialchars(t('plan_per_month')) ?></span>
                    </div>
                    <div class="plan-price-yearly-line js-plan-yearly-line" hidden></div>
                </div>
                <div class="plan-discount-ticket js-plan-discount" aria-hidden="true">
                    <span class="plan-discount-title"><?= htmlspecialchars(t('plan_discount_title')) ?></span>
                    <span class="plan-discount-pct js-plan-discount-pct"></span>
                    <span class="plan-discount-save js-plan-discount-save"></span>
                </div>
                <p class="plan-desc"><?= htmlspecialchars(t('plan_enterprise_desc')) ?></p>
                <ul class="plan-features">
                    <?php for ($i = 1; $i <= 7; $i++): ?>
                    <li><span class="check">✔</span> <?= htmlspecialchars(t('plan_feat_e' . $i)) ?></li>
                    <?php endfor; ?>
                    <li><span class="check">✔</span> <?= htmlspecialchars(t('plan_feat_translation_inc')) ?></li>
                </ul>
                <a href="https://register.qtable.cloud/#plan-enterprise" target="_blank" rel="noopener noreferrer" class="plan-btn outline"><?= htmlspecialchars(t('plan_enterprise_btn')) ?></a>
                <p class="plan-vat-note"><span class="plan-vat-asterisk" aria-hidden="true">*</span> <?= htmlspecialchars(t('plan_vat_note')) ?></p>
            </div>
        </div>

        <div class="comparison-trigger-wrap">
            <button type="button" class="comparison-trigger-btn" onclick="toggleVergelijking()" data-show="<?= htmlspecialchars(t('comp_btn_show')) ?>" data-hide="<?= htmlspecialchars(t('comp_btn_hide')) ?>"><?= htmlspecialchars(t('comp_btn_show')) ?></button>
        </div>

        <div class="comparison-wrap comparison-hidden" id="comparisonTable">
            <?php qtable_render_comparison_table(); ?>
        </div>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="section bg-teal section-contact">
        <video class="contact-video" autoplay muted loop playsinline>
            <source src="video/q-video.mp4" type="video/mp4">
        </video>
        <div class="contact-overlay"></div>
        <div class="contact-content">
        <h2 class="section-title"><?= htmlspecialchars(t('contact_title')) ?></h2>
        <p class="section-subtitle"><?= htmlspecialchars(t('contact_subtitle')) ?></p>
        
        <div class="contact-grid">
            <div class="contact-info">
                <h3><?= htmlspecialchars(t('contact_company_title')) ?></h3>
                <p><?= nl2br(htmlspecialchars(t('contact_company_text'), ENT_QUOTES, 'UTF-8')) ?></p>
                <ul class="contact-details">
                    <li>📧 <?= htmlspecialchars(t('contact_email_label')) ?></li>
                    <li>📍 <?= htmlspecialchars(t('contact_location_label')) ?></li>
                </ul>
            </div>
            <div class="contact-form">
                <?php if ($form_sent): ?>
                    <div class="form-message success"><?= htmlspecialchars(t('form_success')) ?></div>
                <?php elseif ($form_error): ?>
                    <div class="form-message error"><?= htmlspecialchars($form_error) ?></div>
                <?php endif; ?>
                <?php if (!$form_sent): ?>
                <form method="post" action="send.php">
                    <input type="hidden" name="contact_submit" value="1">
                    <input type="hidden" name="lang" value="<?= htmlspecialchars(qtable_lang()) ?>">
                    <div class="form-group">
                        <label for="naam"><?= htmlspecialchars(t('form_name')) ?></label>
                        <input type="text" id="naam" name="naam" required placeholder="<?= htmlspecialchars(t('form_ph_name')) ?>" value="<?= htmlspecialchars($_POST['naam'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="email"><?= htmlspecialchars(t('form_email')) ?></label>
                        <input type="email" id="email" name="email" required placeholder="<?= htmlspecialchars(t('form_ph_email')) ?>" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="bedrijf"><?= htmlspecialchars(t('form_company')) ?></label>
                        <input type="text" id="bedrijf" name="bedrijf" placeholder="<?= htmlspecialchars(t('form_ph_company')) ?>" value="<?= htmlspecialchars($_POST['bedrijf'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="bericht"><?= htmlspecialchars(t('form_message')) ?></label>
                        <textarea id="bericht" name="bericht" required placeholder="<?= htmlspecialchars(t('form_ph_message')) ?>"><?= htmlspecialchars($_POST['bericht'] ?? '') ?></textarea>
                    </div>
                    <button type="submit" class="form-btn"><?= htmlspecialchars(t('form_submit')) ?></button>
                </form>
                <?php endif; ?>
            </div>
        </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>
    <script src="js/main.js?v=<?= file_exists(__DIR__ . '/js/main.js') ? (int) filemtime(__DIR__ . '/js/main.js') : '1' ?>"></script>
</body>
</html>
