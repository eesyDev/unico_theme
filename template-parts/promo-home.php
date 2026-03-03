
<section class="promo">
        <div class="container">
            <div class="promo__wrapper">
                <div class="promo__heading">
                    <div class="promo__heading-top">
                        <h2 class="h2">Скидки</h2>
                        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="button--black medium">Смотреть все</a>
                    </div>
                    <div class="promo__heading-bottom">
                        <div class="promo__controls">
                            <button class="prev-btn swiper-button-prev">
                                <img src="/assets/img/arrow-left.svg" alt="prev" loading="lazy">
                            </button>
                            <button class="next-btn swiper-button-next">
                                <img src="/assets/img/arrow-right.svg" alt="next" loading="lazy">
                            </button>
                        </div>
                    </div>
                </div>
                <swiper-container class="promo__slider" init="false">
                    <?php
                    $sale_ids    = wc_get_product_ids_on_sale();
                    $sale_query  = new WP_Query( [
                        'post_type'      => 'product',
                        'posts_per_page' => 12,
                        'post__in'       => ! empty( $sale_ids ) ? $sale_ids : [ 0 ],
                        'orderby'        => 'post__in',
                    ] );
                    if ( $sale_query->have_posts() ) :
                        while ( $sale_query->have_posts() ) : $sale_query->the_post();
                            global $product;
                            $product = wc_get_product( get_the_ID() );
                    ?>
                        <swiper-slide>
                            <?php wc_get_template_part( 'content', 'product' ); ?>
                        </swiper-slide>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </swiper-container>
            </div>
        </div>
    </section>