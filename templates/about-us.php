<?php
/*
Template Name: О нас
*/
get_header();
?>

<section class="about-us">
    <div class="container">
        <div class="h1-block">
            <h1 class="h1"><?php the_title(); ?></h1>
            <?php woocommerce_breadcrumb(); ?>
        </div>

        <div class="about-us__wrapper">
            <?php if ( get_field('about_left_text') ) : ?>
                <div class="about-us__left">
                    <p>
                        <strong>UnicoModa — </strong><?php the_field('about_left_text'); ?>
                    </p>
                </div>
            <?php endif; ?>

            <?php if ( get_field('about_right_content') ) : ?>
                <div class="about-us__right">
                    <?php the_field('about_right_content'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>