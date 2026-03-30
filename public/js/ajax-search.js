// public/js/ajax-search.js
// Tunggu jQuery tersedia dulu (karena script ini dimuat di <head> sebelum jQuery)
(function waitForJQuery() {
    if (typeof window.jQuery === 'undefined') {
        return setTimeout(waitForJQuery, 50);
    }
    initAjaxSearch(window.jQuery);
})();

function initAjaxSearch($) {
    var searchTimeout = null;
    var isFetching = false;

    // ---- Utilitas ----
    function getTableContainer() {
        if ($('.table-responsive-custom').length) return $('.table-responsive-custom');
        if ($('.table-responsive').length) return $('.table-responsive');
        return null;
    }

    function getPaginationContainer() {
        if ($('.pagination-wrapper').length) return $('.pagination-wrapper');
        var pag = $('.pagination');
        if (pag.length) return pag.parent();
        return null;
    }

    // ---- 1. Live Search: input + keyup event pada semua search input ----
    $(document).on('input keyup', 'input[name="search"], input[name="q"], #search-input, #searchInput', function (e) {
        // Abaikan: Tab, Shift, Ctrl, Alt, CapsLock, Esc, Arrow keys, F-keys, NumLock
        var ignored = [9,16,17,18,19,20,27,33,34,35,36,37,38,39,40,44,91,92,93,
                       112,113,114,115,116,117,118,119,120,121,122,123,144,145];
        if (e.type === 'keyup' && ignored.indexOf(e.which) !== -1) return;

        clearTimeout(searchTimeout);
        var $input = $(this);
        var $form  = $input.closest('form');

        searchTimeout = setTimeout(function () {
            if (!getTableContainer()) return; // Halaman ini tidak punya tabel, skip

            if ($form.length) {
                var action = $form.attr('action') || window.location.pathname;
                var data   = $form.serialize();
                var sep    = action.indexOf('?') > -1 ? '&' : '?';
                fetchResults(action + sep + data);
            }
        }, 1500);
    });

    // ---- 2. Intersep submit form pencarian (tombol Filter / Enter) ----
    $(document).on('submit', '.search-form, form:has(input[name="search"]), form:has(input[name="q"])', function (e) {
        if (!getTableContainer()) return; // Biarkan normal jika tidak ada tabel

        e.preventDefault();
        clearTimeout(searchTimeout);

        var $form  = $(this);
        var action = $form.attr('action') || window.location.pathname;
        var data   = $form.serialize();
        var sep    = action.indexOf('?') > -1 ? '&' : '?';
        fetchResults(action + sep + data);
    });

    // ---- 3. Intersep klik pagination ----
    $(document).on('click', '.pagination-wrapper a, .pagination a', function (e) {
        if (!getTableContainer()) return;
        e.preventDefault();
        fetchResults($(this).attr('href'));
    });

    // ---- 4. Fungsi inti AJAX ----
    function fetchResults(url) {
        if (isFetching) return;

        var $table = getTableContainer();
        var $pag   = getPaginationContainer();

        if (!$table) {
            window.location.href = url;
            return;
        }

        isFetching = true;
        $table.css({ opacity: 0.5, pointerEvents: 'none', transition: 'opacity 0.2s' });
        if ($pag) $pag.css({ opacity: 0.5, pointerEvents: 'none' });

        $.ajax({
            url: url,
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function (html) {
                var $doc = $('<div>').html(html);

                // Temukan tabel baru dari respons
                var $newTable = $doc.find('.table-responsive-custom').length
                    ? $doc.find('.table-responsive-custom')
                    : $doc.find('.table-responsive');

                // Temukan pagination baru dari respons
                var $newPag = null;
                if ($doc.find('.pagination-wrapper').length) {
                    $newPag = $doc.find('.pagination-wrapper');
                } else if ($doc.find('.pagination').length) {
                    $newPag = $doc.find('.pagination').parent();
                }

                if ($newTable.length) {
                    $table.replaceWith($newTable);

                    if ($newPag && $newPag.length) {
                        if ($pag && $pag.length) {
                            $pag.replaceWith($newPag);
                        } else {
                            $('.table-responsive-custom, .table-responsive').first().after($newPag);
                        }
                    } else if ($pag && $pag.length) {
                        $pag.html(''); // Hapus pagination jika data muat 1 halaman
                    }

                    window.history.pushState(null, '', url);
                } else {
                    window.location.href = url;
                }
            },
            error: function () {
                window.location.href = url;
            },
            complete: function () {
                isFetching = false;
                $('.table-responsive-custom, .table-responsive').css({ opacity: 1, pointerEvents: 'auto' });
                var $p = getPaginationContainer();
                if ($p) $p.css({ opacity: 1, pointerEvents: 'auto' });
            }
        });
    }

    // ---- 5. Handle tombol back/forward browser ----
    $(window).on('popstate', function () {
        location.reload();
    });

    // ---- 6. Re-attach drag-scroll setelah AJAX refresh ----
    // (dipanggil dari fetchResults success callback)
    function reattachDragScroll() {
        initDragToScroll();
    }

    // Patch fetchResults agar memanggil reattachDragScroll setelah tabel berhasil diperbarui
    var _origSuccess = null; // Referenced internally, drag init handled in complete
}

// ============================================================
// DRAG-TO-SCROLL — Global untuk semua tabel horizontal
// Aktif otomatis setelah DOM siap (termasuk setelah AJAX)
// ============================================================
function initDragToScroll() {
    var selectors = [
        '.table-responsive-custom',
        '.table-responsive',
        '.table-container',
        '.table-wrapper'
    ];

    selectors.forEach(function(selector) {
        document.querySelectorAll(selector).forEach(function(el) {
            // Jangan inisialisasi ulang jika sudah ada listener
            if (el.dataset.dragInit === '1') return;
            el.dataset.dragInit = '1';

            var isDown    = false;
            var startX    = 0;
            var scrollLeft = 0;
            var hasDragged = false;
            var THRESHOLD  = 5; // Minimum pixel movement sebelum dianggap drag

            el.addEventListener('mousedown', function(e) {
                // Abaikan klik pada elemen interaktif
                var tag = e.target.tagName.toLowerCase();
                if (['button','a','input','select','textarea','label'].indexOf(tag) !== -1) return;

                isDown     = true;
                hasDragged = false;
                startX     = e.pageX - el.offsetLeft;
                scrollLeft = el.scrollLeft;
                el.style.cursor = 'grab';
            });

            el.addEventListener('mouseleave', function() {
                isDown = false;
                el.style.cursor = '';
            });

            el.addEventListener('mouseup', function() {
                isDown = false;
                el.style.cursor = hasDragged ? 'grab' : '';
                setTimeout(function() { el.style.cursor = ''; }, 100);
            });

            el.addEventListener('mousemove', function(e) {
                if (!isDown) return;

                var x    = e.pageX - el.offsetLeft;
                var walk = x - startX;

                // Baru aktifkan drag jika gerakan melebihi threshold
                if (Math.abs(walk) > THRESHOLD) {
                    hasDragged = true;
                    e.preventDefault();
                    el.scrollLeft = scrollLeft - walk;
                    el.style.cursor = 'grabbing';
                }
            });

            // Cegah klik normal saat sudah drag
            el.addEventListener('click', function(e) {
                if (hasDragged) {
                    e.stopPropagation();
                    e.preventDefault();
                }
            }, true);
        });
    });
}

// Jalankan saat DOM siap (baik melalui defer/DOMContentLoaded)
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initDragToScroll);
} else {
    initDragToScroll();
}

// Re-init setelah setiap AJAX yang mengganti tabel (MutationObserver)
(function() {
    var targets = [
        '.table-responsive-custom',
        '.table-responsive',
        '.card',
        '.container-fluid'
    ];

    var observerTarget = null;
    targets.forEach(function(sel) {
        if (!observerTarget) observerTarget = document.querySelector(sel);
    });
    if (!observerTarget) observerTarget = document.body;

    var observer = new MutationObserver(function(mutations) {
        var shouldReinit = mutations.some(function(m) {
            return m.type === 'childList' && m.addedNodes.length > 0;
        });
        if (shouldReinit) initDragToScroll();
    });

    observer.observe(observerTarget, { childList: true, subtree: true });
})();
