/**
 * QTABLE - Reserveringen Landing Page
 */

document.addEventListener('DOMContentLoaded', function() {
    var params = new URLSearchParams(window.location.search);
    if (params.get('sent') === '1' || params.get('err')) {
        var contact = document.getElementById('contact');
        if (contact) {
            contact.scrollIntoView({ behavior: 'smooth' });
        }
    }

    document.querySelectorAll('.lang-link').forEach(function(a) {
        a.addEventListener('click', function(e) {
            var lang = this.getAttribute('data-lang');
            if (!lang) return;
            e.preventDefault();
            window.location.href = 'index.php?lang=' + encodeURIComponent(lang) + window.location.hash;
        });
    });

    initPlanBilling();
});

function initPlanBilling() {
    var root = document.querySelector('.plannen-content[data-yearly-hint]');
    if (!root) return;

    var hintTpl = root.getAttribute('data-yearly-hint') || '%s';
    var saveTpl = root.getAttribute('data-discount-save') || '%s';
    var buttons = document.querySelectorAll('.billing-btn');
    var lang = (document.documentElement.lang || 'nl').split('-')[0];

    function formatPctWithMinus(pct) {
        var n = Math.round(pct * 10) / 10;
        var s = (Math.abs(n - Math.round(n)) < 0.05) ? String(Math.round(n)) : n.toFixed(1);
        if (lang === 'nl' || lang === 'fr' || lang === 'es') {
            s = s.replace('.', ',');
        }
        return '-' + s + '%';
    }

    function setMode(mode) {
        buttons.forEach(function(btn) {
            btn.classList.toggle('is-active', btn.getAttribute('data-billing') === mode);
        });
        document.querySelectorAll('.js-plan-price').forEach(function(el) {
            var m = el.getAttribute('data-m');
            var y = el.getAttribute('data-y');
            var ytotal = el.getAttribute('data-ytotal');
            var display = el.querySelector('.js-plan-price-display');
            var line = el.querySelector('.js-plan-yearly-line');
            var card = el.closest('.plan-card');
            var ticket = card ? card.querySelector('.js-plan-discount') : null;
            var pctEl = ticket ? ticket.querySelector('.js-plan-discount-pct') : null;
            var saveEl = ticket ? ticket.querySelector('.js-plan-discount-save') : null;
            if (!display) return;
            if (mode === 'yearly') {
                display.textContent = '€' + y;
                if (line) {
                    line.textContent = hintTpl.replace('%s', '€' + ytotal);
                    line.hidden = false;
                }
                var mNum = parseInt(m, 10);
                var yTotalNum = parseInt(ytotal, 10);
                var yearlyAtMonthlyRate = mNum * 12;
                var saveEuro = yearlyAtMonthlyRate - yTotalNum;
                var pctOff = yearlyAtMonthlyRate > 0 ? (saveEuro / yearlyAtMonthlyRate) * 100 : 0;
                if (ticket && pctEl && saveEl) {
                    pctEl.textContent = formatPctWithMinus(pctOff);
                    saveEl.textContent = saveTpl.replace('%s', '€' + saveEuro);
                    ticket.classList.add('is-visible');
                    ticket.setAttribute('aria-hidden', 'false');
                }
            } else {
                display.textContent = '€' + m;
                if (line) {
                    line.textContent = '';
                    line.hidden = true;
                }
                if (ticket) {
                    ticket.classList.remove('is-visible');
                    ticket.setAttribute('aria-hidden', 'true');
                }
            }
        });
    }

    buttons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var mode = btn.getAttribute('data-billing');
            if (mode) setMode(mode);
        });
    });

    setMode('monthly');
}

// Navbar toggle
function toggleNav() {
    var links = document.querySelector('.nav-links');
    var burger = document.querySelector('.nav-burger');
    var overlay = document.querySelector('.nav-overlay');
    links.classList.toggle('open');
    burger.classList.toggle('active');
    overlay.classList.toggle('visible', links.classList.contains('open'));
    document.body.classList.toggle('nav-open', links.classList.contains('open'));
}

function closeNav() {
    document.querySelector('.nav-links').classList.remove('open');
    document.querySelector('.nav-burger').classList.remove('active');
    document.querySelector('.nav-overlay').classList.remove('visible');
    document.body.classList.remove('nav-open');
}

// Vergelijkingstabel - toon na vraag van klant
function toggleVergelijking() {
    var wrap = document.getElementById('comparisonTable');
    var btn = document.querySelector('.comparison-trigger-btn');
    if (!wrap || !btn) return;
    var showText = btn.getAttribute('data-show') || '';
    var hideText = btn.getAttribute('data-hide') || '';
    if (wrap.classList.contains('comparison-hidden')) {
        wrap.classList.remove('comparison-hidden');
        wrap.classList.add('comparison-visible');
        btn.textContent = hideText;
    } else {
        wrap.classList.add('comparison-hidden');
        wrap.classList.remove('comparison-visible');
        btn.textContent = showText;
    }
}
