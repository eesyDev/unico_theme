<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
?>
<section class="cart-empty">
    <div class="container">
    <?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
        <div class="cart-empty__inner">
            <div class="cart-empty__upper">
                <div class="cart-empty__icon">🛍️</div>
                <h2 class="cart-empty__title">Ваша корзина пуста</h2>
            </div>

            <p class="cart-empty__text">
                Добавьте товары, чтобы оформить заказ.
                Мы подобрали для вас лучшие модели из Италии.
            </p>

            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
            class="button--black big">
                Перейти в каталог
            </a>
        </div>
    <?php endif; ?>
    </div>
</section>