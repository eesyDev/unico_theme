jQuery(document).ready(function($) {
    $(document).on('submit', 'form.cart:not(.woocommerce-cart-form)', function(e) {
        e.preventDefault();

        var $form = $(this),
            $button = $form.find('.single_add_to_cart_button'),
            data = $form.serialize();

        // Для простого товара product_id передаётся как value кнопки name="add-to-cart",
        // но WC AJAX-эндпоинт add_to_cart ожидает product_id явно.
        if ($button.attr('name') === 'add-to-cart' && data.indexOf('product_id=') === -1) {
            data += '&product_id=' + $button.val();
        }

        data += '&action=woocommerce_add_to_cart_featured_grid';

        $button.removeClass('added').addClass('loading');

        $.post(wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'), data, function(response) {
            if (!response) return;

            if (response.error && response.product_url) {
                window.location = response.product_url;
                return;
            }

            $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $button]);
            
            $button.removeClass('loading').addClass('added');
            
            $button.text('Добавлено в корзину');
        });
    });
});

jQuery(function ($) {
    /* ── Кнопки − / + ── */
    $(document).on("click", ".qty-minus, .qty-plus", function () {
      var $qty = $(this).siblings(".quantity").find("input.qty");
      if (!$qty.length) $qty = $(this).parent().find("input.qty");
  
      var val = parseFloat($qty.val()) || 1;
      var min = parseFloat($qty.attr("min")) || 1;
      var max = parseFloat($qty.attr("max")) || Infinity;
  
      if ($(this).hasClass("qty-minus") && val > min) {
        $qty.val(val - 1);
      } else if ($(this).hasClass("qty-plus") && val < max) {
        $qty.val(val + 1);
      }
  
      $qty.trigger("change");
    });
  
    /* ── Переключение цветовых свотчей в карточке товара ── */
    $(document).on('click', '.product-item__variants li', function () {
        var $li      = $(this);
        var $card    = $li.closest('.product-item');
        var imgUrl   = $li.data('img');

        // Активный класс
        $li.addClass('active').siblings().removeClass('active');

        // Меняем картинку и возвращаем слайдер на первый слайд
        if ( imgUrl ) {
            $card.find('.product-item__images-slider swiper-slide').first().find('img').attr('src', imgUrl);
            var swiperEl = $card.find('.product-item__images-slider')[0];
            if ( swiperEl && swiperEl.swiper ) {
                swiperEl.swiper.slideTo(0);
            }
        }
    });

    /* ── Load More: каталог и блог ── */
    $(document).on('click', '.load-more', function () {
        var $btn        = $(this);
        var type        = $btn.data('type');
        var maxPages    = parseInt($btn.data('max-pages'), 10);
        var currentPage = parseInt($btn.data('current-page'), 10);
        var perPage     = parseInt($btn.data('per-page'), 10);
        var total       = parseInt($btn.data('total'), 10);
        var nextPage    = currentPage + 1;

        var action     = type === 'products' ? 'unico_load_more_products' : 'unico_load_more_posts';
        var $container = type === 'products' ? $('.catalog__items') : $('#blog-container');
        var $counter   = $btn.siblings('.pagination__quantity');

        $btn.prop('disabled', true).text('Загрузка...');

        var postData = {
            action:   action,
            nonce:    unico_ajax.nonce,
            page:     nextPage,
            per_page: perPage,
        };

        if (type === 'products') {
            postData.cat     = $btn.data('cat') || 0;
            postData.orderby = $btn.data('orderby') || 'menu_order';
        }

        $.post(unico_ajax.ajax_url, postData, function (html) {
            if (!html) return;

            var $newItems = $(html);
            $container.append($newItems);

            // Инициализируем Swiper-навигацию для новых карточек товаров
            if (type === 'products') {
                setTimeout(function () {
                    $newItems.filter('.product-item').each(function () {
                        var item    = this;
                        var swiper  = item.querySelector('.product-item__images-slider');
                        var btnNext = item.querySelector('.inner-next');
                        var btnPrev = item.querySelector('.inner-prev');
                        if (swiper && btnNext && btnPrev) {
                            btnNext.addEventListener('click', function (e) { e.preventDefault(); if (swiper.swiper) swiper.swiper.slideNext(); });
                            btnPrev.addEventListener('click', function (e) { e.preventDefault(); if (swiper.swiper) swiper.swiper.slidePrev(); });
                        }
                    });
                }, 200);
            }

            $btn.data('current-page', nextPage).prop('disabled', false);

            var shown = Math.min(nextPage * perPage, total);
            $counter.text('Показано ' + shown + ' из ' + total);

            if (nextPage >= maxPages) {
                $btn.hide();
            } else {
                $btn.text('Показать больше ↓');
            }
        });
    });

    /* ── AJAX-обновление корзины при изменении qty ── */
    var timer;
  
    $(document).on("change", ".woocommerce-cart-form input.qty", function () {
        clearTimeout(timer);

        var $form = $(".woocommerce-cart-form");

        timer = setTimeout(function () {
            $(".cart-page__items, .cart-summary").css("opacity", "0.5");

            $.ajax({
                type: "POST",
                url: $form.attr("action"),
                data: $form.serialize() + "&update_cart=Update+Cart",
                dataType: "html",
                success: function (response) {
                    var $page = $('<div>').html(response);

                    if ($page.find(".cart-page__items").length) {
                        $(".cart-page__items").replaceWith($page.find(".cart-page__items"));
                    }

                    if ($page.find(".cart-summary").length) {
                        $(".cart-summary").replaceWith($page.find(".cart-summary"));
                    }
                },
                error: function() {
                    $(".cart-page__items, .cart-summary").css("opacity", "1");
                },
                complete: function () {
                    $(".cart-page__items, .cart-summary").css("opacity", "1");
                },
            });
        }, 500);
    });
  });