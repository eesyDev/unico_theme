<?php
/**
 * unico functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package unico
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function unico_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on unico, use a find and replace
		* to change 'unico' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'unico', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );
	add_theme_support('woocommerce');


	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'unico' ),
			'header_menu' => 'Главное меню в шапке',
			'footer_info' => 'Футер Инфо',
			'footer_nav' => 'Футер Навигация',
			'footer_policy' => 'Футер Политики',
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'unico_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'unico_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function unico_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'unico_content_width', 640 );
}
add_action( 'after_setup_theme', 'unico_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function unico_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'unico' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'unico' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'unico_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function unico_scripts() {

    // SWIPER CSS
    wp_enqueue_style(
        'swiper-style',
        get_template_directory_uri() . '/assets/lib/swiper/swiper-bundle.min.css',
        array(),
        '1.0'
    );

    // Fonts
    wp_enqueue_style(
        'unico-fonts',
        get_template_directory_uri() . '/assets/fonts/stylesheet.css',
        array(),
        '1.0'
    );

    // Main CSS
    wp_enqueue_style(
        'unico-main-style',
        get_template_directory_uri() . '/assets/css/style.css',
        array('swiper-style'),
        filemtime(get_template_directory() . '/assets/css/style.css')
    );

	// Wow JS
	wp_enqueue_script(
		'wow-js',
		'https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js',
		array('jquery'),
		'1.1.2',
		true
	);

    // SWIPER JS
	wp_enqueue_script(
		'swiper-js',
		'https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js',
		array(),
		'11',
		true
	);

    // Main JS

	wp_enqueue_script(
		'unico-main-js',
		get_template_directory_uri() . '/assets/js/script.js',
		array('jquery', 'swiper-js', 'wow-js'),
		'1.0',
		true
	);

    wp_enqueue_script(
        'unico-search',
        get_template_directory_uri() . '/assets/js/search.js',
        array('unico-main-js'),
        filemtime(get_template_directory() . '/assets/js/search.js'),
        true
    );

	$main_js = get_template_directory() . '/assets/js/script.js';

	wp_enqueue_script(
		'unico-woo-logic',
		get_template_directory_uri() . '/assets/js/woo_logic.js',
		array('jquery', 'swiper-js', 'wow-js'),
		'1.0',
		true
	);

}
add_action( 'wp_enqueue_scripts', 'unico_scripts' );



// AJAX поиск товаров
function unico_ajax_search() {
    $query = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';

    if ( mb_strlen($query) < 2 ) {
        wp_send_json([]);
    }

    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        's'              => $query,
        'posts_per_page' => 6,
    );

    $products = new WP_Query($args);
    $results  = array();

    if ( $products->have_posts() ) {
        while ( $products->have_posts() ) {
            $products->the_post();
            $product = wc_get_product( get_the_ID() );
            $results[] = array(
                'title' => get_the_title(),
                'url'   => get_permalink(),
                'image' => get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ),
                'price' => $product ? $product->get_price_html() : '',
            );
        }
        wp_reset_postdata();
    }

    wp_send_json($results);
}
add_action('wp_ajax_unico_ajax_search',        'unico_ajax_search');
add_action('wp_ajax_nopriv_unico_ajax_search', 'unico_ajax_search');


/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}


// Фильтрация каталога по бренду и категории через URL-параметры
add_action( 'pre_get_posts', function ( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) return;
    if ( ! is_shop() && ! is_product_category() && ! is_product_tag() ) return;

    $tax_query = (array) $query->get( 'tax_query' );

    // Фильтр по бренду (?filter_brand=slug1,slug2)
    if ( ! empty( $_GET['filter_brand'] ) ) {
        $slugs = array_map( 'sanitize_title', explode( ',', $_GET['filter_brand'] ) );
        $tax_query[] = [
            'taxonomy' => 'product_brand',
            'field'    => 'slug',
            'terms'    => $slugs,
            'operator' => 'IN',
        ];
    }

    // Фильтр по категории на странице магазина (?filter_cat=slug1,slug2)
    if ( is_shop() && ! empty( $_GET['filter_cat'] ) ) {
        $slugs = array_map( 'sanitize_title', explode( ',', $_GET['filter_cat'] ) );
        $tax_query[] = [
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $slugs,
            'operator' => 'IN',
        ];
    }

    if ( ! empty( $tax_query ) ) {
        $query->set( 'tax_query', $tax_query );
    }
} );

add_filter('get_custom_logo', function($html) {
    return str_replace(
        'custom-logo-link',
        'custom-logo-link header__logo',
        $html
    );
});

add_filter('woocommerce_cart_redirect_after_error', function($url) {
    if (wp_doing_ajax()) return false;
    return $url;
}, 10, 1);

// Шаблон для товара - подарочной карты
add_filter('template_include', 'unico_gift_product_template', 99);

//Custom li classes to menu if needed
function add_additional_class_on_li($classes, $item, $args) {
    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

//Custom <a> classes to menu if needed
add_filter('nav_menu_link_attributes', function($atts, $item, $args) {
    if (isset($args->link_class)) {
        $atts['class'] = (!empty($atts['class']) ? $atts['class'] . ' ' : '') . $args->link_class;
    }
    return $atts;
}, 10, 3);

// Убираем кнопку "Выберите параметры" из карточек — шаблон управляется вручную
add_action( 'init', function() {
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
} );

function add_ajax_support_to_product_button( $html, $product ) {
    return $html;
}
add_filter( 'woocommerce_loop_add_to_cart_link', 'add_ajax_support_to_product_button', 10, 2 );


function unico_gift_product_template($template) {

    if (is_singular('product')) {
        global $post;
        $terms = get_the_terms($post->ID, 'product_cat');
        if ($terms) {
            foreach ($terms as $term) {
                if ($term->slug === 'gift-cards') {
                    $new_template = locate_template(array('single-product-gift.php'));
                    if ($new_template) {
                        return $new_template;
                    }
                }
            }
        }
    }
    return $template;
}

add_filter('woocommerce_add_cart_item_data', function($cart_item_data, $product_id){

    if ( isset( $_POST['custom_price'] ) ) {
        $price = floatval( sanitize_text_field( wp_unslash( $_POST['custom_price'] ) ) );
        if ( $price > 0 ) {
            $cart_item_data['custom_price'] = $price;
        }
    }

    return $cart_item_data;

}, 10, 2);

add_action('woocommerce_before_calculate_totals', function($cart){

    if ( is_admin() && ! defined('DOING_AJAX') ) return;
    if ( ! $cart || ! is_a( $cart, 'WC_Cart' ) ) return;

    foreach ( $cart->get_cart() as $cart_item ) {
        if (
            isset( $cart_item['custom_price'], $cart_item['data'] ) &&
            is_a( $cart_item['data'], 'WC_Product' )
        ) {
            $cart_item['data']->set_price( $cart_item['custom_price'] );
        }
    }

});

/* ── Load More: локализация скрипта ── */
add_action( 'wp_enqueue_scripts', function () {
    wp_localize_script( 'unico-woo-logic', 'unico_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'unico_load_more_nonce' ),
    ) );
}, 20 );

/* ── AJAX фильтр + пагинация каталога ── */
add_action( 'wp_ajax_unico_filter_products',        'unico_filter_products_handler' );
add_action( 'wp_ajax_nopriv_unico_filter_products', 'unico_filter_products_handler' );

function unico_filter_products_handler() {
    check_ajax_referer( 'unico_load_more_nonce', 'nonce' );

    $page     = max( 1, intval( $_POST['page'] ?? 1 ) );
    $per_page = max( 1, intval( $_POST['per_page'] ?? get_option( 'posts_per_page', 12 ) ) );
    $orderby  = sanitize_key( $_POST['orderby'] ?? 'menu_order' );
    $cat_id   = intval( $_POST['cat'] ?? 0 );

    // tax_query — базовый: исключаем скрытые товары
    $tax_query = array(
        array(
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => array( 'exclude-from-catalog' ),
            'operator' => 'NOT IN',
        ),
    );

    // Фильтр по категории
    $filter_cat = ! empty( $_POST['filter_cat'] )
        ? array_map( 'sanitize_title', explode( ',', $_POST['filter_cat'] ) )
        : array();

    if ( ! empty( $filter_cat ) ) {
        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => $filter_cat,
            'operator' => 'IN',
        );
    } elseif ( $cat_id ) {
        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => $cat_id,
        );
    }

    // Фильтр по бренду
    $filter_brand = ! empty( $_POST['filter_brand'] )
        ? array_map( 'sanitize_title', explode( ',', $_POST['filter_brand'] ) )
        : array();

    if ( ! empty( $filter_brand ) ) {
        $tax_query[] = array(
            'taxonomy' => 'product_brand',
            'field'    => 'slug',
            'terms'    => $filter_brand,
            'operator' => 'IN',
        );
    }

    // Фильтры по WooCommerce атрибутам (pa_size, pa_color и т.д.)
    foreach ( wc_get_attribute_taxonomies() as $attr ) {
        $param = 'filter_' . $attr->attribute_name;
        if ( ! empty( $_POST[ $param ] ) ) {
            $vals = array_map( 'sanitize_title', explode( ',', $_POST[ $param ] ) );
            $tax_query[] = array(
                'taxonomy' => 'pa_' . $attr->attribute_name,
                'field'    => 'slug',
                'terms'    => $vals,
                'operator' => 'IN',
            );
        }
    }

    $ordering = WC()->query->get_catalog_ordering_args( $orderby );

    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => $per_page,
        'paged'          => $page,
        'orderby'        => $ordering['orderby'],
        'order'          => $ordering['order'],
        'tax_query'      => $tax_query,
    );

    if ( ! empty( $ordering['meta_key'] ) ) {
        $args['meta_key'] = $ordering['meta_key'];
    }

    $query = new WP_Query( $args );

    ob_start();
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            global $product;
            $product = wc_get_product( get_the_ID() );
            if ( $product && $product->is_visible() ) {
                wc_get_template_part( 'content', 'product' );
            }
        }
        wp_reset_postdata();
    }
    $html = ob_get_clean();

    wp_send_json( array(
        'products'  => $html,
        'total'     => (int) $query->found_posts,
        'max_pages' => (int) $query->max_num_pages,
        'shown'     => (int) min( $page * $per_page, $query->found_posts ),
        'page'      => $page,
        'per_page'  => $per_page,
    ) );
}

/* ── Load More: товары каталога ── */
add_action( 'wp_ajax_unico_load_more_products',        'unico_load_more_products_handler' );
add_action( 'wp_ajax_nopriv_unico_load_more_products', 'unico_load_more_products_handler' );

function unico_load_more_products_handler() {
    check_ajax_referer( 'unico_load_more_nonce', 'nonce' );

    $page     = max( 1, intval( $_POST['page']     ?? 1 ) );
    $per_page = max( 1, intval( $_POST['per_page'] ?? get_option( 'posts_per_page', 12 ) ) );
    $cat_id   = intval( $_POST['cat'] ?? 0 );
    $orderby  = sanitize_key( $_POST['orderby'] ?? 'menu_order' );

    if ( ! WC()->query ) {
        wp_die();
    }

    if ( ! WC()->query ) {
        wp_send_json( array( 'products' => '', 'total' => 0, 'max_pages' => 0, 'shown' => 0, 'page' => 1, 'per_page' => $per_page ) );
    }

    $ordering = WC()->query->get_catalog_ordering_args( $orderby );

    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'posts_per_page' => $per_page,
        'paged'          => $page,
        'orderby'        => $ordering['orderby'],
        'order'          => $ordering['order'],
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_visibility',
                'field'    => 'name',
                'terms'    => array( 'exclude-from-catalog' ),
                'operator' => 'NOT IN',
            ),
        ),
    );

    if ( ! empty( $ordering['meta_key'] ) ) {
        $args['meta_key'] = $ordering['meta_key'];
    }

    if ( $cat_id ) {
        $args['tax_query'][] = array(
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => $cat_id,
        );
    }

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            global $product;
            $product = wc_get_product( get_the_ID() );
            if ( $product && $product->is_visible() ) {
                wc_get_template_part( 'content', 'product' );
            }
        }
        wp_reset_postdata();
    }

    wp_die();
}

/* ── Load More: статьи блога ── */
add_action( 'wp_ajax_unico_load_more_posts',        'unico_load_more_posts_handler' );
add_action( 'wp_ajax_nopriv_unico_load_more_posts', 'unico_load_more_posts_handler' );

function unico_load_more_posts_handler() {
    check_ajax_referer( 'unico_load_more_nonce', 'nonce' );

    $page     = max( 1, intval( $_POST['page'] ) );
    $per_page = max( 1, intval( $_POST['per_page'] ) );

    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => $per_page,
        'paged'          => $page,
    );

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            ?>
            <article class="blog-card">
                <a href="<?php the_permalink(); ?>" class="blog-card__image">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) ); ?>
                    <?php else : ?>
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/blog-img1.jpg" alt="No image">
                    <?php endif; ?>
                </a>
                <div class="blog-card__content">
                    <h2 class="blog-card__title"><?php the_title(); ?></h2>
                    <p class="blog-card__text"><?php echo wp_trim_words( get_the_excerpt(), 20, '...' ); ?></p>
                </div>
            </article>
            <?php
        }
        wp_reset_postdata();
    }

    wp_die();
}

// Код для хлебных крошек в записях чтобы они брали родителем стр. Блога
add_filter( 'woocommerce_get_breadcrumb', 'custom_wc_breadcrumb_for_posts', 99, 2 );

function custom_wc_breadcrumb_for_posts( $crumbs, $breadcrumb ) {
    // 1. Проверяем, что мы находимся именно в записи блога (тип post)
    // 2. И что это не страница товара (product)
    if ( is_singular( 'post' ) && !is_singular( 'product' ) ) {
        $blog_page_id = get_option('page_for_posts');
        if ( $blog_page_id ) {
            $blog_title = get_the_title( $blog_page_id );
            $blog_url   = get_permalink( $blog_page_id );

            // Создаем новый массив крошек
            $new_crumbs = array();
            // Сохраняем "Главную" (обычно это первый элемент)
            $new_crumbs[] = $crumbs[0];
            // Добавляем нашу страницу Блог вторым пунктом
            $new_crumbs[] = array( $blog_title, $blog_url );
            // Добавляем название текущей статьи последним пунктом
            $new_crumbs[] = end($crumbs);

            return $new_crumbs;
        }
    }
    // Во всех остальных случаях (товары, категории магазина) возвращаем как было
    return $crumbs;
}
// Код для хлебных крошек в записях чтобы они брали родителем стр. Блога

add_filter('loop_shop_per_page', function($cols) {
    return 24; // поставь нужное число
}, 20);

add_filter( 'render_block', function( $block_content, $block ) {
    if ( $block['blockName'] === 'woocommerce/checkout' ) {                                                         
        return '<div class="container">' . $block_content . '</div>';                                               
    }
    return $block_content;
}, 10, 2 );