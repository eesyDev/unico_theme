<?php
/*
Template Name: Подбор
*/
get_header();

// 1. Настраиваем кастомный запрос, чтобы получить посты, а не саму страницу
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type'      => 'post',    // Тянем обычные записи
    'posts_per_page' => 3,        // Сколько выводить на одной странице
    'paged'          => $paged
);
$blog_query = new WP_Query($args);
?>

<section class="blog">
    <div class="container">
        <div class="h1-block">
            <h1 class="h1">
                <?php 
                if ( is_home() && ! is_front_page() ) {
                    // Выводит название страницы, выбранной в Настройки -> Чтение
                    single_post_title(); 
                } else {
                    // Универсальный вариант
                    the_title();
                }
                ?>
            </h1>
            <?php woocommerce_breadcrumb(); ?>
        </div>

        <div class="blog-grid" id="blog-container">
            <?php if ( $blog_query->have_posts() ) : while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
                <article class="blog-card">
                    <a href="<?php the_permalink(); ?>" class="blog-card__image">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail('large', ['alt' => get_the_title()]); ?>
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/blog-img1.jpg" alt="No image">
                        <?php endif; ?>
                    </a>
                    <div class="blog-card__content">
                        <h2 class="blog-card__title"><?php the_title(); ?></h2>
                        <p class="blog-card__text">
                            <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                        </p>
                    </div>
                </article>
            <?php endwhile; wp_reset_postdata(); else : ?>
                <p>Подборки отсутствуют. Добавьте их в разделе "Записи".</p>
            <?php endif; ?>
        </div>

        <div class="pagination">
            <?php if ( $blog_query->max_num_pages > 1 ) : ?>
                <button class="pagination__more load-more"
                        data-type="posts"
                        data-max-pages="<?php echo $blog_query->max_num_pages; ?>"
                        data-current-page="<?php echo $paged; ?>"
                        data-per-page="3"
                        data-total="<?php echo $blog_query->found_posts; ?>">
                    Показать больше ↓
                </button>
            <?php endif; ?>
            
            <span class="pagination__quantity">
                Показано <?php echo $blog_query->post_count; ?> из <?php echo $blog_query->found_posts; ?>
            </span>
        </div>
    </div>
</section>

<?php get_footer(); ?>