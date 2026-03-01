<?php 
/**
 * Template part for Features section
 */
?>

<div class="features">
    
    <?php // ФИЧА 1 ?>
    <?php if ( get_field('f_title_1') ) : ?>
        <div class="features__item">
            <?php if ( $icon1 = get_field('f_icon_1') ) : ?>
                <img src="<?php echo esc_url($icon1); ?>" alt="<?php the_field('f_title_1'); ?>">
            <?php endif; ?>
            <div class="features__title"><?php the_field('f_title_1'); ?></div>
            <div class="features__txt"><?php the_field('f_txt_1'); ?></div>
        </div>
    <?php endif; ?>

    <?php // ФИЧА 2 ?>
    <?php if ( get_field('f_title_2') ) : ?>
        <div class="features__item">
            <?php if ( $icon2 = get_field('f_icon_2') ) : ?>
                <img src="<?php echo esc_url($icon2); ?>" alt="<?php the_field('f_title_2'); ?>">
            <?php endif; ?>
            <div class="features__title"><?php the_field('f_title_2'); ?></div>
            <div class="features__txt"><?php the_field('f_txt_2'); ?></div>
        </div>
    <?php endif; ?>

    <?php // ФИЧА 3 ?>
    <?php if ( get_field('f_title_3') ) : ?>
        <div class="features__item">
            <?php if ( $icon3 = get_field('f_icon_3') ) : ?>
                <img src="<?php echo esc_url($icon3); ?>" alt="<?php the_field('f_title_3'); ?>">
            <?php endif; ?>
            <div class="features__title"><?php the_field('f_title_3'); ?></div>
            <div class="features__txt"><?php the_field('f_txt_3'); ?></div>
        </div>
    <?php endif; ?>

</div>