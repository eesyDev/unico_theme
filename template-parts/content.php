<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package unico
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('article-page'); ?>>
    <div class="container">
        <div class="article-hero">
            <div class="article-hero__left">
                <?php the_title( '<h1 class="h1 article-hero__title">', '</h1>' ); ?>
                
                <?php woocommerce_breadcrumb(); ?>

                <div class="article-hero__text">
                    <?php 
                    // Выводим основной контент статьи
                    the_content(); 
                    ?>
                </div>
            </div>

            <div class="article-hero__right">
                <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail('full', ['alt' => get_the_title()]); ?>
                <?php else : ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/article-img1.jpg" alt="article-image">
                <?php endif; ?>
            </div>
        </div>

		<div class="article-gallery">
			<?php
			$gallery_indexes = [1, 2, 3, 4]; 

			foreach ( $gallery_indexes as $index ) :
				$image = get_field('gallery_img_' . $index);
				// Теперь это массив объектов товаров
				$linked_products = get_field('gallery_product_link_' . $index);

				if ( ! $image ) continue;
				?>
				
				<div class="article-gallery__item">
					<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
					
					<?php if ( $linked_products ) : ?>
						<div class="product-tags">
							<?php foreach ( $linked_products as $product_obj ) : ?>
								<a href="<?php echo get_permalink( $product_obj->ID ); ?>" class="product-tag">
									<?php echo get_the_title( $product_obj->ID ); ?>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>

			<?php endforeach; ?>
		</div>

    </div>
</article>