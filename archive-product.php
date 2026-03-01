<?php
get_header();

// Активные значения фильтров из URL
$active_cats   = ! empty( $_GET['filter_cat'] )   ? array_map( 'sanitize_title', explode( ',', $_GET['filter_cat'] ) )   : [];
$active_brands = ! empty( $_GET['filter_brand'] ) ? array_map( 'sanitize_title', explode( ',', $_GET['filter_brand'] ) ) : [];
$active_orderby = ! empty( $_GET['orderby'] ) ? sanitize_key( $_GET['orderby'] ) : get_option( 'woocommerce_default_catalog_orderby', 'menu_order' );

// Активные атрибуты (pa_size, pa_color и т.д.)
$active_attrs = [];
$wc_attr_taxonomies = wc_get_attribute_taxonomies();
foreach ( $wc_attr_taxonomies as $attr ) {
    $param = 'filter_' . $attr->attribute_name;
    if ( ! empty( $_GET[ $param ] ) ) {
        $active_attrs[ $attr->attribute_name ] = array_map( 'sanitize_title', explode( ',', $_GET[ $param ] ) );
    }
}

// Данные для фильтров
$categories = get_terms( [
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
    'parent'     => 0,
    'exclude'    => [ get_option( 'default_product_cat' ) ],
] );
$brands = get_terms( [
    'taxonomy'   => 'product_brand',
    'hide_empty' => true,
] );

$sort_options = [
    'menu_order' => 'По умолчанию',
    'popularity' => 'По популярности',
    'rating'     => 'По рейтингу',
    'date'       => 'Новинки',
    'price'      => 'Цена: по возрастанию',
    'price-desc' => 'Цена: по убыванию',
];
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

                    <?php // ── Категория ──────────────────────────────────
                    if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) :
                        $cnt = count( $active_cats ); ?>
                    <div class="filter-dropdown" data-param="filter_cat">
                        <button class="products-filter__link filter-dropdown__toggle<?php echo $cnt ? ' is-active' : ''; ?>" type="button">
                            Категория<?php echo $cnt ? " ({$cnt})" : ' ↓'; ?>
                        </button>
                        <div class="filter-dropdown__panel">
                            <?php foreach ( $categories as $cat ) : ?>
                            <label class="filter-dropdown__option">
                                <input type="checkbox" value="<?php echo esc_attr( $cat->slug ); ?>"<?php checked( in_array( $cat->slug, $active_cats ) ); ?>>
                                <span><?php echo esc_html( $cat->name ); ?></span>
                                <span class="filter-dropdown__count"><?php echo $cat->count; ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php // ── Бренд ──────────────────────────────────────
                    if ( ! is_wp_error( $brands ) && ! empty( $brands ) ) :
                        $cnt = count( $active_brands ); ?>
                    <div class="filter-dropdown" data-param="filter_brand">
                        <button class="products-filter__link filter-dropdown__toggle<?php echo $cnt ? ' is-active' : ''; ?>" type="button">
                            Бренд<?php echo $cnt ? " ({$cnt})" : ' ↓'; ?>
                        </button>
                        <div class="filter-dropdown__panel">
                            <?php foreach ( $brands as $brand ) : ?>
                            <label class="filter-dropdown__option">
                                <input type="checkbox" value="<?php echo esc_attr( $brand->slug ); ?>"<?php checked( in_array( $brand->slug, $active_brands ) ); ?>>
                                <span><?php echo esc_html( $brand->name ); ?></span>
                                <span class="filter-dropdown__count"><?php echo $brand->count; ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php // ── WooCommerce атрибуты (Размер, Цвет, Материал…) ──
                    foreach ( $wc_attr_taxonomies as $attr ) :
                        $tax   = 'pa_' . $attr->attribute_name;
                        $terms = get_terms( [ 'taxonomy' => $tax, 'hide_empty' => true ] );
                        if ( is_wp_error( $terms ) || empty( $terms ) ) continue;
                        $param      = 'filter_' . $attr->attribute_name;
                        $active_val = $active_attrs[ $attr->attribute_name ] ?? [];
                        $cnt        = count( $active_val ); ?>
                    <div class="filter-dropdown" data-param="<?php echo esc_attr( $param ); ?>">
                        <button class="products-filter__link filter-dropdown__toggle<?php echo $cnt ? ' is-active' : ''; ?>" type="button">
                            <?php echo esc_html( $attr->attribute_label ); ?><?php echo $cnt ? " ({$cnt})" : ' ↓'; ?>
                        </button>
                        <div class="filter-dropdown__panel">
                            <?php foreach ( $terms as $term ) : ?>
                            <label class="filter-dropdown__option">
                                <input type="checkbox" value="<?php echo esc_attr( $term->slug ); ?>"<?php checked( in_array( $term->slug, $active_val ) ); ?>>
                                <span><?php echo esc_html( $term->name ); ?></span>
                                <span class="filter-dropdown__count"><?php echo $term->count; ?></span>
                            </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php // ── Сортировать по ─────────────────────────────── ?>
                <div class="filter-dropdown filter-dropdown--right" data-param="orderby">
                    <button class="products-filter__link filter-dropdown__toggle" type="button">
                        <?php echo esc_html( $sort_options[ $active_orderby ] ?? 'Сортировать по' ); ?> ↓
                    </button>
                    <div class="filter-dropdown__panel filter-dropdown__panel--right">
                        <?php foreach ( $sort_options as $val => $label ) : ?>
                        <label class="filter-dropdown__option filter-dropdown__option--radio">
                            <input type="radio" name="orderby" value="<?php echo esc_attr( $val ); ?>"<?php checked( $active_orderby, $val ); ?>>
                            <span><?php echo esc_html( $label ); ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
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

        <?php get_template_part( 'template-parts/features' ); ?>
    </div>
</section>
</main>

<?php get_footer(); ?>
