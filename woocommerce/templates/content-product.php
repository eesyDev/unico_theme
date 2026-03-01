<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! is_a( $product, WC_Product::class ) || ! $product->is_visible() ) {
    return;
}

$is_new      = ( time() - get_the_time( 'U', $product->get_id() ) ) < 30 * DAY_IN_SECONDS;
$is_sale     = $product->is_on_sale();
$gallery_ids = $product->get_gallery_image_ids();
$tpl_uri     = get_template_directory_uri();

if ( $product->is_type( 'variable' ) ) {
    $price_current = $product->get_variation_price( 'min', true );
    $price_regular = $product->get_variation_regular_price( 'min', true );
} else {
    $price_current = $product->get_price();
    $price_regular = $product->get_regular_price();
}

$color_terms = wc_get_product_terms( $product->get_id(), 'pa_color', array( 'fields' => 'all' ) );
?>

<div class="product-item">
    <a href="<?php the_permalink(); ?>" class="product-item__image">

        <?php if ( $is_sale || $is_new ) : ?>
            <span class="label label--black">
                <?php echo $is_sale ? 'Sale' : 'Новинка'; ?>
            </span>
        <?php endif; ?>

        <div class="favorite">
            <img src="<?php echo esc_url( $tpl_uri ); ?>/assets/img/like-o.svg" alt="" loading="lazy" class="favorite-o">
            <img src="<?php echo esc_url( $tpl_uri ); ?>/assets/img/like-f.svg" alt="" loading="lazy" class="favorite-f">
        </div>

        <swiper-container
            class="product-item__images-slider"
            nested="true"
            resistance-ratio="0"
            slides-per-view="1"
            space-between="0">

            <swiper-slide>
                <?php echo woocommerce_get_product_thumbnail(); ?>
            </swiper-slide>

            <?php foreach ( $gallery_ids as $attachment_id ) : ?>
                <swiper-slide>
                    <?php echo wp_get_attachment_image( $attachment_id, 'woocommerce_thumbnail' ); ?>
                </swiper-slide>
            <?php endforeach; ?>

        </swiper-container>

        <?php if ( ! empty( $gallery_ids ) ) : ?>
            <div class="inner-nav">
                <button class="inner-prev swiper-button-prev">
                    <img src="<?php echo esc_url( $tpl_uri ); ?>/assets/img/arrow-prev.svg" alt="">
                </button>
                <button class="inner-next swiper-button-next">
                    <img src="<?php echo esc_url( $tpl_uri ); ?>/assets/img/arrow-next.svg" alt="">
                </button>
            </div>
        <?php endif; ?>

    </a>

    <div class="product-item__info">
        <a href="<?php the_permalink(); ?>" class="product-item__title">
            <?php the_title(); ?>
        </a>

        <div class="price">
            <?php if ( $is_sale && $price_regular ) : ?>
                <div class="current"><?php echo wc_price( $price_current ); ?></div>
                <div class="old"><?php echo wc_price( $price_regular ); ?></div>
            <?php else : ?>
                <div class="current"><?php echo wc_price( $price_current ); ?></div>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $color_terms ) ) : ?>
            <ul class="product-item__variants">
                <?php foreach ( $color_terms as $i => $term ) :
                    $thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                    if ( ! $thumb_id ) continue;
                ?>
                    <li <?php echo $i === 0 ? 'class="active"' : ''; ?>>
                        <?php echo wp_get_attachment_image( $thumb_id, 'thumbnail' ); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
