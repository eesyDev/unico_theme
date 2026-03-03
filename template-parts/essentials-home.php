<section class="collection">
        <div class="container">
            <div сlass="collection__wrapper">
                <div class="collection__heading">
                    <h2 class="h2">Коллекция Essentiel</h2>
                    <div class="collection__heading-right">
                        <?php $essentiel_link = get_term_link( 'kollekcziya-essentiel', 'product_cat' ); ?>
                        <a href="<?php echo esc_url( is_wp_error( $essentiel_link ) ? wc_get_page_permalink( 'shop' ) : $essentiel_link ); ?>" class="button--grey">Смотреть все</a>
                        <div class="collection__controls">
                            <button class="prev-btn swiper-button-prev">
                                <img src="/assets/img/arrow-left.svg" alt="prev" loading="lazy">
                            </button>
                            <button class="next-btn swiper-button-next">
                                <img src="/assets/img/arrow-right.svg" alt="next" loading="lazy">
                            </button>
                        </div>
                    </div>
                </div>
                <swiper-container class="collection-products__slider" init="false">
                    <?php
                    $collection_query = new WP_Query( [
                        'post_type'      => 'product',
                        'posts_per_page' => 12,
                        'tax_query'      => [ [
                            'taxonomy' => 'product_cat',
                            'field'    => 'slug',
                            'terms'    => 'kollekcziya-essentiel',
                        ] ],
                    ] );
                    if ( $collection_query->have_posts() ) :
                        while ( $collection_query->have_posts() ) : $collection_query->the_post();
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