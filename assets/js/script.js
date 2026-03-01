const parentSwiperEl = document.querySelector('.new-products__slider');
const collectionSwiperEl = document.querySelector('.collection-products__slider');
const promoSwiperEl = document.querySelector('.promo__slider');

const productItems = document.querySelectorAll('.product-item');

try {
    productItems.forEach(item => {
        const swiperEl = item.querySelector('.product-item__images-slider');
        const btnNext = item.querySelector('.inner-next');
        const btnPrev = item.querySelector('.inner-prev');

        if (swiperEl && btnNext && btnPrev) {
            // При клике на кастомную кнопку - просим Swiper переключить слайд
            btnNext.addEventListener('click', (e) => {
                e.preventDefault(); // Чтобы не сработала ссылка на товар
                swiperEl.swiper.slideNext();
            });

            btnPrev.addEventListener('click', (e) => {
                e.preventDefault();
                swiperEl.swiper.slidePrev();
            });
        }
    });
} catch(err) {
    console.log(err)
}

if (parentSwiperEl) {
    const swiperParams = {
        init: false, 
        navigation: {
            nextEl: '.new-products__heading .next-btn',
            prevEl: '.new-products__heading .prev-btn',
        },
        slidesPerView: 4,
        // spaceBetween: 20,
        injectStyles: [
          `
          :host .swiper-button-next,
          :host .swiper-button-prev {
            display: none;
          }
          `,
        ],
        breakpoints: {
            320: { slidesPerView: 1.8, spaceBetween: 10 },
            480: { slidesPerView: 2.1, spaceBetween: 10 },
            640: { slidesPerView: 2.7, spaceBetween: 10 },
            768: { slidesPerView: 3.2, spaceBetween: 10 },
            1024: { slidesPerView: 4, spaceBetween: 10 },
            1280: { spaceBetween: 20 }
        }
    };

    Object.assign(parentSwiperEl, swiperParams);
    parentSwiperEl.initialize();
}

if (collectionSwiperEl) {
    const swiperCollectionParams = {
        init: false, 
        navigation: {
            nextEl: '.collection__controls .next-btn',
            prevEl: '.collection__controls .prev-btn',
        },
        slidesPerView: 4,
        spaceBetween: 20,
        injectStyles: [
          `
          :host .swiper-button-next,
          :host .swiper-button-prev {
            display: none;
          }
          `,
        ],
        breakpoints: {
            320: { slidesPerView: 1.8, spaceBetween: 10 },
            480: { slidesPerView: 2.1, spaceBetween: 10 },
            640: { slidesPerView: 2.7, spaceBetween: 10 },
            768: { slidesPerView: 3.2, spaceBetween: 10 },
            1024: { slidesPerView: 4, spaceBetween: 10 },
            1280: { spaceBetween: 20 }
        }
    };

    Object.assign(collectionSwiperEl, swiperCollectionParams);
    collectionSwiperEl.initialize();
}

if (promoSwiperEl) {
    const swiperPromoParams = {
        init: false, 
        navigation: {
            nextEl: '.promo__controls .next-btn',
            prevEl: '.promo__controls .prev-btn',
        },
        slidesPerView: 3,
        spaceBetween: 20,
        injectStyles: [
          `
          :host .swiper-button-next,
          :host .swiper-button-prev {
            display: none;
          }
          `,
        ],
        breakpoints: {
            320: { slidesPerView: 1.8, spaceBetween: 10 },
            480: { slidesPerView: 2.1, spaceBetween: 10 },
            640: { slidesPerView: 2.7, spaceBetween: 10 },
            768: { slidesPerView: 2.2, spaceBetween: 10 },
            1024: { slidesPerView: 3, spaceBetween: 10 },
            1280: { spaceBetween: 20 }
        }
    };

    Object.assign(promoSwiperEl, swiperPromoParams);
    promoSwiperEl.initialize();
}

if (window.innerWidth < 992) {
    // const gallery = document.querySelector('.woocommerce-product-gallery__wrapper');
    // gallery.classList.add('swiper-wrapper');

    // document.querySelectorAll('.woocommerce-product-gallery__image')
    //     .forEach(el => el.classList.add('swiper-slide'));

    // new Swiper('.woocommerce-product-gallery', {
    //     slidesPerView: 1,
    //     spaceBetween: 10,
    // });
}

// Аккордеон FAQ
document.addEventListener('click', function (e) {
    const head = e.target.closest(
        '.product-page__faq-head, .size-accordion__head'
    );

    if (!head) return;

    const item = head.parentElement;
    const container = head.closest(
        '.product-page__faq, .size-accordion'
    );
    container.querySelectorAll(
        '.product-page__faq-item, .size-accordion__item'
    ).forEach(el => {
        if (el !== item) el.classList.remove('is-open');
    });
    item.classList.toggle('is-open');
});


document.querySelectorAll('.faq-head').forEach(head => {
    head.addEventListener('click', () => {
        const item = head.parentElement;

        document.querySelectorAll('.faq-item')
        .forEach(el => {
            if (el !== item) el.classList.remove('is-open');
        });
        item.classList.toggle('is-open');
    });
});
// Аккордеон FAQ

// Поиск в хедере
const searchToggle = document.querySelector('.header-search__toggle');
const searchClose = document.querySelector('.header-search__close');
const searchOverlay = document.querySelector('.header-search__overlay');
const searchInput = document.querySelector('.header-search__input');
const headerMain = document.querySelector('.header__main');

if (searchToggle && headerMain) {
    searchToggle.addEventListener('click', () => {
        headerMain.classList.add('is-search-open');
        document.body.style.overflow = 'hidden';
        setTimeout(() => searchInput.focus(), 400);
    });

    searchClose.addEventListener('click', () => {
        headerMain.classList.remove('is-search-open');
        document.body.style.overflow = '';
        searchInput.value = '';
    });
}

// Мобильное бургер-меню
const burger = document.querySelector('.header__burger');
const mobileNav = document.querySelector('.header__mobile-nav');
const mobileOverlay = document.querySelector('.header__mobile-overlay');
const mobileClose = document.querySelector('.header__mobile-close');
const header = document.querySelector('.header');
const catalogToggle = document.querySelector('.header__mobile-catalog-toggle');
const catalogItem = document.querySelector('.header__mobile-menu-item--catalog');

function openMobileMenu() {
    header.classList.add('is-menu-open');
    document.body.classList.add('is-menu-open');
}

function closeMobileMenu() {
    header.classList.remove('is-menu-open');
    document.body.classList.remove('is-menu-open');
}

if (burger) {
    burger.addEventListener('click', () => {
        if (header.classList.contains('is-menu-open')) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    });
}

if (mobileClose) {
    mobileClose.addEventListener('click', closeMobileMenu);
}

if (mobileOverlay) {
    mobileOverlay.addEventListener('click', closeMobileMenu);
}

if (catalogToggle && catalogItem) {
    catalogToggle.addEventListener('click', () => {
        catalogItem.classList.toggle('is-open');
    });
}

// Popups (dialogs)
const dialogs = document.querySelector('.dialogs');
const closeBg = document.querySelector('.close-bg');
let closeBtn = null;
let closeModal = null;
   
function openPopup(id) {
    const popup = document.getElementById(id);
    if (!dialogs || !popup) return;
    dialogs.style.display = 'block';
    popup.style.display = 'block';
    document.body.style.overflow = 'hidden';
    popup.offsetHeight; // reflow for animation
    dialogs.style.opacity = '1';
    popup.classList.add('active');
}

function closePopup() {
    if (!dialogs) return;

    const activePopup = dialogs.querySelector('.popup.active');
    if (activePopup) {
        activePopup.classList.remove('active');
        dialogs.style.opacity = '0';
        setTimeout(() => {
            activePopup.style.display = 'none';
            dialogs.style.display = 'none';
            document.body.style.overflow = '';
        }, 300);
    }
}

if (dialogs) {
    closeBtn = dialogs.querySelector('.close-popup');
    closeModal = dialogs.querySelector('.close');
    dialogs.addEventListener('click', (e) => {
        if (e.target.closest('.close') || e.target.closest('.close-popup')) {
            closePopup();
        }
    });
    if (closeBg) {
        closeBg.addEventListener('click', closePopup);
    }
    if (closeBtn) {
        closeBtn.addEventListener('click', closePopup);
    }
    if (closeModal) {
        closeModal.addEventListener('click', closePopup);
    }
}

// Gift popup — показываем 1 раз при первом посещении
if (!localStorage.getItem('giftPopupShown')) {
    setTimeout(() => {
        openPopup('gift');
        localStorage.setItem('giftPopupShown', 'true');
    }, 5000);
}

// Табы с адресами магазинов
// const items = document.querySelectorAll('.maps-contact-item');
// const mapFrame = document.getElementById('map-frame');

// items.forEach(item => {
//     item.addEventListener('click', () => {
//         // убрать активный у всех
//         items.forEach(el => el.classList.remove('is-active'));
//         // добавить текущему
//         item.classList.add('is-active');
//         // поменять карту
//         const newMap = item.dataset.map;
//         mapFrame.src = newMap;
//     });
// });
// Табы с адресами магазинов

document.querySelectorAll('.preset-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const price = this.dataset.price;
        const input = document.querySelector('input[name="custom_price"]');
        if(input){
            input.value = price;
        }
    });
});


document.addEventListener('click', function(e) {
    // Ищем ближайшую кнопку с классом notice-close от места клика
    const closeBtn = e.target.closest('.notice-close');
    
    if (closeBtn) {
        const notice = closeBtn.closest('.cart-notice');
        if (notice) {
            notice.remove();
        }
    }
});

function autoHideNotice(notice) {
    if (notice.dataset.processed) return;
    notice.dataset.processed = "true";

    // Убедимся, что стили для анимации применены
    setTimeout(function () {
        notice.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
        notice.style.opacity = '0';
        notice.style.transform = 'translateY(-10px)';

        setTimeout(function () {
            if (notice.parentNode) {
                notice.remove();
            }
        }, 400);
    }, 4000);
}

// Наблюдатель (MutationObserver)
const observer = new MutationObserver(function (mutations) {
    mutations.forEach(function (mutation) {
        mutation.addedNodes.forEach(function (node) {
            // Проверка: является ли узел элементом и имеет ли нужный класс
            if (node.nodeType === 1) { 
                if (node.classList.contains('cart-notice')) {
                    autoHideNotice(node);
                }
                // На случай, если прилетела пачка уведомлений в одном контейнере
                node.querySelectorAll('.cart-notice').forEach(autoHideNotice);
            }
        });
    });
});

observer.observe(document.body, {
    childList: true,
    subtree: true
});

// Первичный запуск
document.querySelectorAll('.cart-notice').forEach(autoHideNotice);

// Фильтры каталога (AJAX-дропдауны)
(function () {
    var dropdowns   = document.querySelectorAll('.filter-dropdown');
    var $catalog    = document.querySelector('.catalog__items');
    if (!dropdowns.length || !$catalog) return;

    var perPage  = parseInt($catalog.dataset.perPage, 10) || 12;
    var catId    = parseInt($catalog.dataset.cat, 10)     || 0;
    var $loadBtn = document.querySelector('.load-more');
    var $counter = document.querySelector('.pagination__quantity');

    // ── Открыть/закрыть ──────────────────────────────────
    function openDropdown(dd) {
        dd.querySelector('.filter-dropdown__panel').classList.add('is-open');
    }
    function closeDropdown(dd) {
        dd.querySelector('.filter-dropdown__panel').classList.remove('is-open');
    }
    function closeAll(except) {
        dropdowns.forEach(function (dd) { if (dd !== except) closeDropdown(dd); });
    }

    dropdowns.forEach(function (dd) {
        dd.querySelector('.filter-dropdown__toggle').addEventListener('click', function (e) {
            e.stopPropagation();
            var panel  = dd.querySelector('.filter-dropdown__panel');
            var isOpen = panel.classList.contains('is-open');
            closeAll(dd);
            isOpen ? closeDropdown(dd) : openDropdown(dd);
        });
    });

    document.addEventListener('click', function () { closeAll(null); });

    // ── Собрать все активные значения фильтров ────────────
    function collectFilters() {
        var filters = {};
        dropdowns.forEach(function (dd) {
            var param  = dd.dataset.param;
            var panel  = dd.querySelector('.filter-dropdown__panel');
            var radios = panel.querySelectorAll('input[type="radio"]:checked');
            var checks = panel.querySelectorAll('input[type="checkbox"]:checked');

            if (radios.length) {
                filters[param] = radios[0].value;
            } else if (checks.length) {
                filters[param] = Array.from(checks).map(function (i) { return i.value; }).join(',');
            }
        });
        return filters;
    }

    // ── Обновить состояние кнопок-тоглов ─────────────────
    function updateToggles(filters) {
        dropdowns.forEach(function (dd) {
            var param  = dd.dataset.param;
            var toggle = dd.querySelector('.filter-dropdown__toggle');
            var panel  = dd.querySelector('.filter-dropdown__panel');
            var checks = panel.querySelectorAll('input[type="checkbox"]:checked');
            var isRadio = panel.querySelector('input[type="radio"]');

            toggle.classList.toggle('is-active', !isRadio && checks.length > 0);

            if (!isRadio) {
                var base = toggle.dataset.label || toggle.textContent.replace(/\s*\(\d+\)|\s*↓/g, '').trim();
                if (!toggle.dataset.label) toggle.dataset.label = base;
                toggle.textContent = checks.length ? base + ' (' + checks.length + ')' : base + ' ↓';
            }
        });
    }

    // ── AJAX-запрос ───────────────────────────────────────
    function applyFilters(filters, page) {
        page = page || 1;

        $catalog.style.opacity = '0.5';
        $catalog.style.pointerEvents = 'none';

        var postData = Object.assign({
            action:   'unico_filter_products',
            nonce:    (typeof unico_ajax !== 'undefined') ? unico_ajax.nonce : '',
            page:     page,
            per_page: perPage,
            cat:      catId,
        }, filters);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', (typeof unico_ajax !== 'undefined') ? unico_ajax.ajax_url : '/wp-admin/admin-ajax.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function () {
            $catalog.style.opacity = '';
            $catalog.style.pointerEvents = '';

            var res;
            try { res = JSON.parse(xhr.responseText); } catch (e) { return; }

            // Заменяем товары
            $catalog.innerHTML = res.products || '';

            // Обновляем счётчик
            if ($counter) {
                $counter.textContent = 'Показано ' + res.shown + ' из ' + res.total;
            }

            // Обновляем кнопку "Показать больше"
            if ($loadBtn) {
                if (res.max_pages > 1) {
                    $loadBtn.style.display = '';
                    $loadBtn.dataset.currentPage = page;
                    $loadBtn.dataset.maxPages    = res.max_pages;
                    $loadBtn.dataset.total       = res.total;
                    $loadBtn.dataset.perPage     = perPage;
                    // Сохраняем активные фильтры для следующих страниц
                    $($loadBtn).data('filters', filters);
                    $($loadBtn).data('orderby', filters.orderby || 'menu_order');
                } else {
                    $loadBtn.style.display = 'none';
                }
            }

            // Обновляем URL (без перезагрузки)
            var url = new URL(window.location.href);
            url.search = '';
            Object.keys(filters).forEach(function (k) {
                if (filters[k]) url.searchParams.set(k, filters[k]);
            });
            history.replaceState(null, '', url.toString());

            // Реинициализируем Swiper в новых карточках
            setTimeout(function () {
                $catalog.querySelectorAll('.product-item').forEach(function (item) {
                    var swiper  = item.querySelector('.product-item__images-slider');
                    var btnNext = item.querySelector('.inner-next');
                    var btnPrev = item.querySelector('.inner-prev');
                    if (swiper && btnNext && btnPrev) {
                        btnNext.addEventListener('click', function (e) { e.preventDefault(); if (swiper.swiper) swiper.swiper.slideNext(); });
                        btnPrev.addEventListener('click', function (e) { e.preventDefault(); if (swiper.swiper) swiper.swiper.slidePrev(); });
                    }
                });
            }, 200);
        };

        var params = Object.keys(postData).map(function (k) {
            return encodeURIComponent(k) + '=' + encodeURIComponent(postData[k]);
        }).join('&');

        xhr.send(params);
    }

    // ── Слушаем изменения в фильтрах ─────────────────────
    dropdowns.forEach(function (dd) {
        dd.querySelector('.filter-dropdown__panel').addEventListener('change', function () {
            var filters = collectFilters();
            updateToggles(filters);
            closeAll(null);
            applyFilters(filters, 1);
        });
    });

    // ── При загрузке: восстановить состояние из URL ───────
    (function restoreFromUrl() {
        var params = new URLSearchParams(window.location.search);
        var hasFilter = false;
        dropdowns.forEach(function (dd) {
            var param = dd.dataset.param;
            var val   = params.get(param);
            if (!val) return;
            hasFilter = true;
            val.split(',').forEach(function (v) {
                var input = dd.querySelector('input[value="' + v + '"]');
                if (input) input.checked = true;
            });
        });
        if (hasFilter) updateToggles(collectFilters());
    }());
}());

// Бренды: алфавитный фильтр
(function () {
    const filterLinks = document.querySelectorAll('.brands-filter .products-filter__link');
    if (!filterLinks.length) return;

    // Плавный скролл к секции по клику на букву
    filterLinks.forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = link.getAttribute('href').slice(1);
            const target = document.getElementById(targetId);
            if (!target) return;
            const offset = target.getBoundingClientRect().top + window.scrollY - 100;
            window.scrollTo({ top: offset, behavior: 'smooth' });
        });
    });

    // Подсветка активной буквы при скролле
    const groups = document.querySelectorAll('.brands-group[id]');
    if (!groups.length) return;

    function updateActiveLink() {
        const scrollY = window.scrollY + 120;
        let currentId = null;

        groups.forEach(function (group) {
            if (group.offsetTop <= scrollY) {
                currentId = group.id;
            }
        });

        filterLinks.forEach(function (link) {
            const href = link.getAttribute('href').slice(1);
            link.classList.toggle('active', href === currentId);
        });
    }

    window.addEventListener('scroll', updateActiveLink, { passive: true });
    updateActiveLink();
}());
