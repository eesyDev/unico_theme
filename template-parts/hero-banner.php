<?php 
/**
 * Template part for Hero Section
 */

// Проверяем наличие главного изображения
$hero_img = get_field('hero_img');

if ( $hero_img ) : 
?>

<section class="hero">
    <div class="container">
        <div class="hero__wrapper">
            
            <img src="<?php echo esc_url($hero_img); ?>" alt="<?php the_field('hero_title'); ?>">
            
            <div class="hero__info">
                <?php if ( $subtitle = get_field('hero_subtitle') ) : ?>
                    <div class="hero__sub subtitle"><?php echo esc_html($subtitle); ?></div>
                <?php endif; ?>

                <?php if ( $title = get_field('hero_title') ) : ?>
                    <h1 class="h2"><?php echo esc_html($title); ?></h1>
                <?php endif; ?>

                <?php if ( $link = get_field('hero_link') ) : ?>
                    <a href="<?php echo esc_url($link); ?>" class="button--link white">
                        Подробнее <i class="icon">→</i>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>

<?php endif; ?>