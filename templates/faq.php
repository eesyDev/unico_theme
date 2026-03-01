<?php
/*
Template Name: F.A.Q.
*/
get_header();
?>

<section class="faq">
    <div class="container">
        <div class="h1-block">
            <h1 class="h1"><?php the_title(); ?></h1>
            <?php woocommerce_breadcrumb(); ?>
        </div>

        <div class="faq-wrapper">
            <?php 
            // Массив индексов для циклов (создаем столько, сколько вкладок в ACF)
            $faq_indices = [1, 2, 3, 4, 5]; 

            foreach ($faq_indices as $i) :
                $cat_title = get_field('faq_cat_' . $i);
                $content = get_field('faq_content_' . $i);

                if ($cat_title) : ?>
                    <div class="faq-item <?php echo ($i === 1) ? 'is-open' : ''; ?>">
                        <div class="faq-head">
                            <h3><?php echo esc_html($cat_title); ?></h3>
                            <span class="faq-icon"></span>
                        </div>
                        <div class="faq-body">
                            <div class="faq-block">
                                <?php // Выводим содержимое редактора. 
                                      // Чтобы соответствовать верстке, менеджеру нужно писать:
                                      // H4 -> Заголовок
                                      // P -> Текст
                                      echo $content; 
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endif; 
            endforeach; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>