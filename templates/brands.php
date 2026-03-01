<?php
/*
Template Name: Бренды
*/
get_header();

// Получаем все термины таксономии product_brand в алфавитном порядке
$brands = get_terms( array(
    'taxonomy'   => 'product_brand',
    'hide_empty' => false,
    'orderby'    => 'name',
    'order'      => 'ASC',
) );

// Группируем по первой букве
$grouped = array();
if ( ! is_wp_error( $brands ) && ! empty( $brands ) ) {
    foreach ( $brands as $brand ) {
        $first_char = mb_strtoupper( mb_substr( $brand->name, 0, 1 ) );
        if ( is_numeric( $first_char ) ) {
            $first_char = '0–9';
        }
        $grouped[ $first_char ][] = array(
            'title' => $brand->name,
            'url'   => get_term_link( $brand ),
        );
    }
    ksort( $grouped );
    // Группа с цифрами — в начало
    if ( isset( $grouped['0–9'] ) ) {
        $grouped = array( '0–9' => $grouped['0–9'] ) + $grouped;
    }
}

$available_letters = array_keys( $grouped );
?>

<section class="brands">
    <div class="container">
        <div class="h1-block">
            <h1 class="h1"><?php the_title(); ?></h1>
            <?php woocommerce_breadcrumb(); ?>

            <?php if ( ! empty( $available_letters ) ) : ?>
            <div class="products-filter brands-filter">
                <div class="products-filter__left">
                    <?php foreach ( $available_letters as $letter ) :
                        $anchor = ( $letter === '0–9' ) ? '0-9' : $letter;
                    ?>
                    <a href="#brands-<?php echo esc_attr( $anchor ); ?>" class="products-filter__link">
                        <?php echo esc_html( $letter === '0–9' ? '0-9' : $letter ); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $grouped ) ) : ?>
        <div class="brands__grid">
            <?php foreach ( $grouped as $letter => $items ) :
                $anchor = ( $letter === '0–9' ) ? '0-9' : $letter;
            ?>
            <div class="brands-group" id="brands-<?php echo esc_attr( $anchor ); ?>">
                <div class="brands-group__letter"><?php echo esc_html( $letter ); ?></div>
                <ul class="brands-group__list">
                    <?php foreach ( $items as $item ) : ?>
                    <li>
                        <a href="<?php echo esc_url( $item['url'] ); ?>">
                            <?php echo esc_html( $item['title'] ); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else : ?>
        <p class="brands__empty">Бренды пока не добавлены.</p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
