<?php 
/**
 * Template part for Grid Banner
 * Используем прямые вызовы the_field() и get_field()
 */

// Проверяем, заполнен ли хотя бы один из главных баннеров
if ( get_field('top_banner_img') || get_field('bl_banner_img') || get_field('br_banner_img') ) : 
?>

<section class="grid-banner">
    <div class="container">
        <div class="grid-banner__wrapper">
            
            <?php // 1. ВЕРХНИЙ БАННЕР ?>
            <?php if ( get_field('top_banner_img') ) : ?>
                <div class="grid-banner__top">
                    <img src="<?php the_field('top_banner_img'); ?>" alt="" class="bg-img" loading="lazy">
                    <div class="grid-banner__top-info">
                        <?php if ( get_field('top_banner_title') ) : ?>
                            <h3 class="h3"><?php the_field('top_banner_title'); ?></h3>
                        <?php endif; ?>
                        
                        <?php if ( get_field('top_banner_link') ) : ?>
                            <a href="<?php the_field('top_banner_link'); ?>" class="button--link">
                                Смотреть <i class="icon">→</i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="grid-banner__bottom">
                
                <?php // 2. НИЖНИЙ ЛЕВЫЙ ?>
                <?php if ( get_field('bl_banner_img') ) : ?>
                    <div class="grid-banner__bottom-left">
                        <img src="<?php the_field('bl_banner_img'); ?>" alt="" class="bg-img" loading="lazy">
                        <div class="grid-banner__bottom-info">
                            <?php if ( $label_l = get_field('bl_banner_label') ) : ?>
                                <span class="label label--white"><?php echo esc_html($label_l); ?></span>
                            <?php endif; ?>

                            <?php if ( get_field('bl_banner_title') ) : ?>
                                <h3 class="h3"><?php the_field('bl_banner_title'); ?></h3>
                            <?php endif; ?>

                            <?php if ( get_field('bl_banner_link') ) : ?>
                                <a href="<?php the_field('bl_banner_link'); ?>" class="button--link">
                                    Смотреть <i class="icon">→</i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php // 3. НИЖНИЙ ПРАВЫЙ ?>
                <?php if ( get_field('br_banner_img') ) : ?>
                    <div class="grid-banner__bottom-right">
                        <img src="<?php the_field('br_banner_img'); ?>" alt="" class="bg-img" loading="lazy">
                        <div class="grid-banner__bottom-info">
                            <?php if ( $label_r = get_field('br_banner_label') ) : ?>
                                <span class="label label--green"><?php echo esc_html($label_r); ?></span>
                            <?php endif; ?>

                            <?php if ( get_field('br_banner_title') ) : ?>
                                <h3 class="h3"><?php the_field('br_banner_title'); ?></h3>
                            <?php endif; ?>

                            <?php if ( get_field('br_banner_link') ) : ?>
                                <a href="<?php the_field('br_banner_link'); ?>" class="button--link">
                                    Смотреть <i class="icon">→</i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<?php endif; ?>