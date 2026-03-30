/**
 * QTABLE — rekentool potentieel (no-shows), landingspagina
 */
(function () {
    function parseNum(id) {
        var el = document.getElementById(id);
        if (!el) return 0;
        var v = parseFloat(String(el.value).replace(',', '.'), 10);
        return isNaN(v) ? 0 : Math.max(0, v);
    }

    function isDigital() {
        var y = document.getElementById('roi_dig_yes');
        return !!(y && y.checked);
    }

    function fmtEUR(n, locale) {
        try {
            return new Intl.NumberFormat(locale, {
                style: 'currency',
                currency: 'EUR',
                maximumFractionDigits: 0,
                minimumFractionDigits: 0
            }).format(n);
        } catch (e) {
            return '€' + Math.round(n).toLocaleString();
        }
    }

    function localeFromHtml() {
        var lang = (document.documentElement.lang || 'nl').split('-')[0];
        if (lang === 'en') return 'en-GB';
        if (lang === 'es') return 'es-ES';
        if (lang === 'fr') return 'fr-BE';
        return 'nl-BE';
    }

    function initRoiReveal() {
        var showBtn = document.getElementById('roiShowCalculator');
        var modal = document.getElementById('roiModal');
        var backdrop = document.getElementById('roiModalBackdrop');
        var closeBtn = document.getElementById('roiModalClose');
        if (!showBtn || !modal) return;

        function openModal() {
            modal.removeAttribute('hidden');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('roi-modal-open');
            showBtn.setAttribute('aria-expanded', 'true');
            var focusEl = document.getElementById('roi_dig_no');
            if (focusEl) {
                window.setTimeout(function () {
                    try {
                        focusEl.focus({ preventScroll: true });
                    } catch (e) {
                        focusEl.focus();
                    }
                }, 100);
            }
        }

        function closeModal() {
            if (modal.hasAttribute('hidden')) return;
            modal.setAttribute('hidden', '');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('roi-modal-open');
            showBtn.setAttribute('aria-expanded', 'false');
            try {
                showBtn.focus();
            } catch (e) {
                /* ignore */
            }
        }

        showBtn.addEventListener('click', function () {
            openModal();
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', function (e) {
                e.preventDefault();
                closeModal();
            });
        }
        if (backdrop) {
            backdrop.addEventListener('click', function () {
                closeModal();
            });
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modal && !modal.hasAttribute('hidden')) {
                closeModal();
            }
        });
    }

    function init() {
        initRoiReveal();
        var btn = document.getElementById('roiBtn');
        var results = document.getElementById('roiResults');
        var section = document.getElementById('roi-calculator');
        if (!btn || !results || !section) return;

        var ratingTipTemplate = section.getAttribute('data-rating-tip') || '';

        btn.addEventListener('click', function () {
            var nsL = parseNum('roi_ns_lunch');
            var nsD = parseNum('roi_ns_dinner');
            var avgL = parseNum('roi_avg_lunch');
            var avgD = parseNum('roi_avg_dinner');
            var weeklyLoss = nsL * avgL + nsD * avgD;
            var annualLoss = weeklyLoss * 52;
            var dig = isDigital();
            var recoveryRate = dig ? 0.26 : 0.42;
            var recover = annualLoss * recoveryRate;
            var loc = localeFromHtml();

            var lossEl = document.getElementById('roiValLoss');
            var recEl = document.getElementById('roiValRecover');
            if (lossEl) lossEl.textContent = fmtEUR(annualLoss, loc);
            if (recEl) recEl.textContent = fmtEUR(recover, loc);

            var google = parseNum('roi_google');
            var tipEl = document.getElementById('roiRatingTip');
            if (tipEl && ratingTipTemplate) {
                if (google > 0 && google < 4.2) {
                    tipEl.textContent = ratingTipTemplate;
                    tipEl.hidden = false;
                } else {
                    tipEl.hidden = true;
                }
            }

            results.hidden = false;
            results.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
