<!-- Navbar -->
<nav class="navbar">
    <div class="nav-left">
        <a href="#top" class="nav-logo">
            <img src="images/logo.png" alt="QTABLE">
        </a>
    </div>

    <button class="nav-burger" aria-label="<?= htmlspecialchars(t('nav_menu_open')) ?>" onclick="toggleNav()">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <div class="nav-overlay" onclick="closeNav()" aria-hidden="true"></div>

    <div class="nav-links" id="navLinks">
        <div class="lang-switcher" role="group" aria-label="<?= htmlspecialchars(t('lang_switch_aria')) ?>">
            <?php
            $labels = ['nl' => 'NL', 'es' => 'ES', 'en' => 'EN', 'fr' => 'FR', 'pt' => 'PT', 'tr' => 'TR'];
            foreach ($labels as $code => $label):
                $active = qtable_lang() === $code ? ' is-active' : '';
            ?>
            <a href="index.php?lang=<?= htmlspecialchars($code) ?>" class="lang-link<?= $active ?>" data-lang="<?= htmlspecialchars($code) ?>"><?= htmlspecialchars($label) ?></a>
            <?php endforeach;
            unset($code, $label, $active, $labels);
            ?>
        </div>
        <a href="#verhaal" onclick="closeNav()"><?= htmlspecialchars(t('nav_story')) ?></a>
        <a href="#plannen" onclick="closeNav()"><?= htmlspecialchars(t('nav_plans')) ?></a>
        <a href="#roi-calculator" onclick="closeNav()"><?= htmlspecialchars(t('nav_roi')) ?></a>
        <a href="#contact" onclick="closeNav()"><?= htmlspecialchars(t('nav_contact')) ?></a>
        <a href="https://demo.qtable.cloud/" target="_blank" rel="noopener noreferrer" class="nav-btn nav-demo nav-cta-mobile" onclick="closeNav()"><?= htmlspecialchars(t('nav_demo')) ?></a>
        <a href="<?= htmlspecialchars(qtable_register_url()) ?>" target="_blank" rel="noopener noreferrer" class="nav-btn nav-cta-mobile" onclick="closeNav()"><?= htmlspecialchars(t('nav_start')) ?></a>
    </div>

    <div class="nav-right">
        <a href="https://demo.qtable.cloud/" target="_blank" rel="noopener noreferrer" class="nav-btn nav-demo">
            <span><?= htmlspecialchars(t('nav_demo')) ?></span>
        </a>
        <a href="<?= htmlspecialchars(qtable_register_url()) ?>" target="_blank" rel="noopener noreferrer" class="nav-btn">
            <span><?= htmlspecialchars(t('nav_start')) ?></span>
        </a>
    </div>
</nav>
