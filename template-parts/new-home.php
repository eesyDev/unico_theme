<section class="new-products">
        <div class="container">
            <div сlass="new-products__wrapper">
                <div class="new-products__heading">
                    <h2 class="h2">Новинки</h2>
                    <div class="new-products__heading-right">
                        <a href="<?php echo esc_url( get_term_link( 'novinki', 'product_cat' ) ); ?>" class="button--grey">Смотреть все</a>
                        <div class="new-products__controls">
                            <button class="prev-btn swiper-button-prev">
                                <img src="/assets/img/arrow-left.svg" alt="prev" loading="lazy">
                            </button>
                            <button class="next-btn swiper-button-next">
                                <img src="/assets/img/arrow-right.svg" alt="next" loading="lazy">
                            </button>
                        </div>
                    </div>
                </div>
                <swiper-container class="new-products__slider" init="false">
                    <?php
                    $novinki_query = new WP_Query( [
                        'post_type'      => 'product',
                        'posts_per_page' => 12,
                        'tax_query'      => [ [
                            'taxonomy' => 'product_cat',
                            'field'    => 'slug',
                            'terms'    => 'novinki',
                        ] ],
                    ] );
                    if ( $novinki_query->have_posts() ) :
                        while ( $novinki_query->have_posts() ) : $novinki_query->the_post();
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