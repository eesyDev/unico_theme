<?php
get_header();
?>

<main class="product-page">
    <div class="container">
        <?php while ( have_posts() ) : the_post(); global $product; ?>
            <div class="product-page__gallery">
                <!-- ГАЛЕРЕЯ -->
                <div class="product-page__gallery-wrapper-main woocommerce-product-gallery">
                <div class="product-page__gallery-wrapper">
                    <?php

                    $attachment_ids = array();
                    
                    if ( $product->get_image_id() ) {
                        $attachment_ids[] = $product->get_image_id();
                    }
                    
                    $gallery_ids = $product->get_gallery_image_ids();
                    if ( ! empty( $gallery_ids ) ) {
                        $attachment_ids = array_merge( $attachment_ids, $gallery_ids );
                    }

                    if ( ! empty( $attachment_ids ) ) :
                        foreach ( $attachment_ids as $attachment_id ) : 
                            $full_size_url = wp_get_attachment_image_url( $attachment_id, 'full' );
                            ?>
                            <div class="product-page__gallery-img" data-src="<?php echo esc_url($full_size_url); ?>">
                                <?php echo wp_get_attachment_image( $attachment_id, 'large', false, array( 'class' => 'img-fluid' ) ); ?>
                            </div>
                        <?php 
                        endforeach;
                    else :
                        // Заглушка, если картинок вообще нет
                        echo wc_placeholder_img( 'large' );
                    endif;
                    ?>
                </div>
                </div>

                <div class="product-page__right">
                    <div class="product-page__info">
                        <h1 class="product-page__name"><?php the_title(); ?></h1>
                        <div class="product-page__price">
                            <?php woocommerce_template_single_price(); ?>
                        </div>

                        <div class="product-page__cart-wrapper">
                            <?php woocommerce_template_single_add_to_cart(); ?>
                        </div>
                    </div>

                    <!-- FAQ блок -->
                    <div class="product-page__faq">
                        <!-- О товаре -->
                        <div class="product-page__faq-item is-open">
                            <div class="product-page__faq-head">О товаре</div>
                            <div class="product-page__faq-content">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        <!-- Доставка (можно потом через ACF) -->
                        <div class="product-page__faq-item">
                            <div class="product-page__faq-head">Доставка</div>
                            <div class="product-page__faq-content">
                                Бесплатная доставка по России при заказе от 20 000 ₽.
                            </div>
                        </div>
                        <!-- Возврат -->
                        <div class="product-page__faq-item">
                            <div class="product-page__faq-head">Возврат товара</div>
                            <div class="product-page__faq-content">
                                Возврат возможен в течение 14 дней.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<?php
get_footer();