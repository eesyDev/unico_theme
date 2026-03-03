<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.1.0
 */

defined('ABSPATH') || exit;
get_header();
?>

<section class="cart-page">
    <div class="container">

        <div class="h1-block">
            <?php woocommerce_breadcrumb(); ?>
        </div>

        <div class="cart-page__wrapper">

            <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

                <!-- LEFT -->
                <div class="cart-page__items">

                    <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :

                        $_product   = $cart_item['data'];
                        $product_id = $cart_item['product_id'];

                        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 ) :
                    ?>

                    <div class="cart-item">
                        <!-- IMAGE -->
                        <div class="cart-item__image">
                            <?php echo $_product->get_image( 'woocommerce_thumbnail' ); ?>
                        </div>

                        

                        <!-- CONTENT -->
                        <div class="cart-item__content">
                            <h3 class="cart-item__name">
                                <a href="<?php echo esc_url( $_product->get_permalink() ); ?>">
                                    <?php echo $_product->get_name(); ?>
                                </a>
                            </h3>
                            <div class="cart-item__price">
                                <?php echo WC()->cart->get_product_price( $_product ); ?>
                            </div>

                            <div class="cart-item__total-row">
                                <div class="cart-item__quantity cart-item__qty">
                                    <?php if ( $_product->get_max_purchase_quantity() === 1 ) : ?>
                                        <input type="hidden"
                                            name="cart[<?php echo esc_attr( $cart_item_key ); ?>][qty]"
                                            value="1">
                                        <span><?php echo esc_html( $cart_item['quantity'] ); ?></span>
                                    <?php else : ?>
                                        <?php woocommerce_quantity_input( array(
                                            'input_name'  => "cart[{$cart_item_key}][qty]",
                                            'input_value' => $cart_item['quantity'],
                                            'min_value'   => 1,
                                            'max_value'   => $_product->get_max_purchase_quantity(),
                                            'hidden'      => false,
                                        ), $_product ); ?>
                                    <?php endif; ?>
                                </div>
                                <div class="cart-item__subtotal">
                                    <?php
                                    echo WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] );
                                    ?>
                                </div>
                            </div>
                            <a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>"class="cart-item__remove">Удалить ×</a>
                        </div>

                    </div>

                    <?php endif; endforeach; ?>

                </div>

                <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>

                <button type="submit" name="update_cart" value="Update Cart" disabled aria-hidden="true" style="display:none !important;">Обновить корзину</button>

            </form>

            <!-- RIGHT -->
            <div class="cart-page__summary">

                <div class="cart-summary">
                    <h2 class="cart-summary__title">Итоговая сумма</h2>

                    <div class="cart-summary__row">
                        <span>Предварительная сумма:</span>
                        <span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                    </div>

                    <div class="cart-summary__row">
                        <span>Доставка</span>
                        <span><?php wc_cart_totals_shipping_html(); ?></span>
                    </div>

                    <div class="cart-summary__promo">
                        <?php if ( wc_coupons_enabled() ) : ?>
                            <form class="coupon" method="post">
                                <label>Промокод / Подарочная карта</label>
                                <input type="text" name="coupon_code" placeholder="XVBS4GQH">
                                <button type="submit" name="apply_coupon" class="button--link">
                                    Применить
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <div class="cart-summary__low">
                        <div class="cart-summary__total">
                            <span>Итого:</span>
                            <span><?php wc_cart_totals_order_total_html(); ?></span>
                        </div>

                        <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
                           class="button--black big">
                            Оплатить
                        </a>
                    </div>
                </div>

                <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
                   class="button--link">
                    Продолжить покупки →
                </a>

            </div>

        </div>

    </div>
</section>


<?php do_action( 'woocommerce_after_cart' ); ?>

<?php get_footer(); ?>