<?php
defined('ABSPATH') || exit;

get_header();

while ( have_posts() ) :
    the_post();

    global $product;
?>

<section class="gift-card-page">
    <div class="container">
        <?php
            $notices = wc_get_notices();

            if ( ! empty( $notices ) ) :
            ?>
                <div class="cart-notices">
                    <?php foreach ( $notices as $type => $notice_group ) : ?>
                        <?php foreach ( $notice_group as $notice ) : ?>
                            <div class="cart-notice cart-notice--<?php echo esc_attr($type); ?>">
                                <?php echo wp_kses_post( $notice['notice'] ); ?>
                                <button class="notice-close">×</button>
                            </div>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </div>
            <?php
            endif;
            wc_clear_notices();
        ?>
        <div class="h1-block">
            <h1 class="h1">
                <?php
                    $terms = get_the_terms(get_the_ID(), 'product_cat');
                    if ($terms && !is_wp_error($terms)) {
                        foreach ($terms as $term) {
                            if ($term->slug === 'gift-cards') {
                                echo '<h1 class="h1">' . esc_html($term->name) . '</h1>';
                                break;
                            }
                        }
                    }
                ?>
            </h1>
            <?php woocommerce_breadcrumb(); ?>
        </div>

        <div class="gift-card">
            <!-- IMAGE -->
            <div class="gift-card__image">
                <?php
                // Главное изображение
                if ( $product->get_image_id() ) {
                    echo wp_get_attachment_image( $product->get_image_id(), 'large' );
                }

                // Галерея
                $gallery_ids = $product->get_gallery_image_ids();
                foreach ( $gallery_ids as $id ) {
                    echo wp_get_attachment_image($id, 'large');
                }
                ?>
            </div>

            <!-- CONTENT -->
            <div class="gift-card__content">
                <h2 class="gift-card__title">
                    <?php echo $product->get_name(); ?>
                </h2>

                <div class="gift-card__field">
                    <label>
                        Введите свою цену*
                        <span>(от <?php echo wc_price(1000); ?>)</span>
                    </label>
                </div>
                <form class="cart" method="post" enctype="multipart/form-data">
                    <?php do_action('woocommerce_before_add_to_cart_button'); ?>

                    <!-- QUANTITY -->
                    <div class="gift-card__field">
                        <label>Количество*</label>
                        <?php
                        woocommerce_quantity_input(array(
                            'min_value' => 1,
                            'input_value' => 1,
                        ));
                        ?>
                    </div>

                    <!-- CTA -->
                    <div class="gift-card__actions">

                        <button type="submit"
                                name="add-to-cart"
                                value="<?php echo esc_attr($product->get_id()); ?>"
                                class="single_add_to_cart_button button--black big">
                            В корзину
                        </button>

                        <p class="gift-card__note">
                            Цифровая подарочная карта после покупки будет отправлена
                            на указанный адрес электронной почты в течение нескольких минут
                        </p>
                    </div>

                    <?php do_action('woocommerce_after_add_to_cart_button'); ?>

                </form>

                <!-- INFO BLOCK -->
                <section class="gift-card-info">
                    <h2>Полезно знать:</h2>
                    <ul>
                        <li>Подарочные карты можно использовать на сайте</li>
                        <li>Подарочная карта действительна 1 год</li>
                        <li>Можно использовать частично или полностью</li>
                        <li class="important">
                            Подарочные карты возврату не подлежат
                        </li>
                    </ul>
                </section>

            </div>

        </div>

    </div>
</section>

<?php
endwhile;
get_footer();