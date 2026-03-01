<?php
get_header();
?>

<main id="primary">
<section class="catalog">
    <div class="container">

        <div class="h1-block">
            <h1 class="h1"><?php woocommerce_page_title(); ?></h1>
            <?php woocommerce_breadcrumb(); ?>

            <div class="products-filter">
                <div class="products-filter__left">
                    <a href="#" class="products-filter__link mobile">Фильтры</a>
                    <?php
                    // Категории Woo
                    wp_list_categories(array(
                        'taxonomy' => 'product_cat',
                        'title_li' => '',
                        'depth'    => 1,
                    ));
                    ?>
                </div>

                <div class="products-filter__link">
                    <?php woocommerce_catalog_ordering(); ?>
                </div>
            </div>
        </div>

        <div class="catalog__items">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php wc_get_template_part( 'content', 'product' ); ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>


        <div class="pagination">
            <?php
            global $wp_query;
            $max_pages = intval( $wp_query->max_num_pages );
            $paged     = max( 1, get_query_var( 'paged' ) );
            $total     = intval( $wp_query->found_posts );
            $per_page  = intval( $wp_query->get( 'posts_per_page' ) );
            $shown     = min( $paged * $per_page, $total );
            $cat_id    = is_product_category() ? get_queried_object_id() : 0;
            $orderby   = isset( $_GET['orderby'] ) ? sanitize_key( $_GET['orderby'] ) : get_option( 'woocommerce_default_catalog_orderby', 'menu_order' );
            if ( $max_pages > 1 ) : ?>
                <button class="pagination__more load-more"
                        data-type="products"
                        data-max-pages="<?php echo $max_pages; ?>"
                        data-current-page="<?php echo $paged; ?>"
                        data-per-page="<?php echo $per_page; ?>"
                        data-total="<?php echo $total; ?>"
                        data-cat="<?php echo $cat_id; ?>"
                        data-orderby="<?php echo esc_attr( $orderby ); ?>">
                    Показать больше ↓
                </button>
            <?php endif; ?>
            <span class="pagination__quantity">
                Показано <?php echo $shown; ?> из <?php echo $total; ?>
            </span>
        </div>

        <?php 
            get_template_part('template-parts/features');
        ?>
    </div>
</section>
</main>

<?php
get_footer();