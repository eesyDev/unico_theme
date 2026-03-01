<?php 
/**
 * Template part for displaying the footer banner
 */

// Проверяем, есть ли вообще данные, чтобы не плодить пустые теги
if( get_field('fb_l_img') || get_field('fb_r_img') ) : 
?>

<section class="footer-banner">
    <div class="container">
        <div class="footer-banner__wrapper">

            <div class="footer-banner__part">
                <?php $img_l = get_field('fb_l_img'); ?>
                <img src="<?php echo $img_l; ?>" alt="banner-img" class="bg-img" loading="lazy">
                
                <div class="footer-banner__info">
                    <?php if( get_field('fb_l_label') ): ?>
                        <span class="label label--white"><?php the_field('fb_l_label'); ?></span>
                    <?php endif; ?>
                    
                    <h3 class="h3"><?php the_field('fb_l_title'); ?></h3>
                    
                    <a href="<?php the_field('fb_l_link'); ?>" class="button--link">
                        Купить <i class="icon">→</i>
                    </a>
                </div>
            </div>

            <div class="footer-banner__part">
                <?php $img_r = get_field('fb_r_img'); ?>
                <img src="<?php echo $img_r; ?>" alt="banner-img" class="bg-img" loading="lazy">
                
                <div class="footer-banner__info">
                    <?php if( get_field('fb_r_label') ): ?>
                        <span class="label label--white"><?php the_field('fb_r_label'); ?></span>
                    <?php endif; ?>
                    
                    <h3 class="h3"><?php the_field('fb_r_title'); ?></h3>
                    
                    <a href="<?php the_field('fb_r_link'); ?>" class="button--link">
                        Найти <i class="icon">→</i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

<?php endif; ?>