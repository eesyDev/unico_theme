<?php
/*
Template Name: Избранное
*/
get_header();
?>

<section class="wishlist">
    <div class="container">
        <div class="h1-block">
            <h1 class="h1"><?php the_title(); ?></h1>
            <?php woocommerce_breadcrumb(); ?>
        </div>
        
        <?php echo do_shortcode('[ti_wishlistsview]'); ?>
    </div>
</section>

<?php get_footer(); ?>