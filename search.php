<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Shoppe
 */

get_header();
?>

    <main id="primary" class="o-page">
        <div class="<?php echo esc_attr(shoppe_container_classes_layout()) ?>">
            <div class="o-page__header">
		        <?php /* translators: %s: search term */ ?>
                <h1 class="o-page__header__title h1"><?php printf( esc_html__( 'Search Results for: %s', 'shoppe' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
            </div>
            <div class="<?php echo esc_attr(shoppe_page_classes_layout()); ?>">
				<?php
				if ( shoppe_has_sidebar() ) {
					get_sidebar();
				} ?>
                <div class="o-page__main">
                    <div class="o-grid-1_md-2<?php echo esc_attr(shoppe_blog_grid_classes()); ?>">
						<?php
						if ( have_posts() ) :

							if ( is_home() && ! is_front_page() ) :
								?>
                                <header>
                                    <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                                </header>
							<?php
							endif;

							/* Start the Loop */
							while ( have_posts() ) :
								the_post();

								/*
								 * Include the Post-Type-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content', get_post_type() );

							endwhile;
							?>
                            <div class="c-pagination s-pagination">
								<?php shoppe_posts_pagination(); ?>
                            </div>
						<?php
						else :

							get_template_part( 'template-parts/content', 'none' );

						endif;
						?>
                    </div>
                </div>
            </div>
        </div>
    </main><!-- #main -->

<?php
get_footer();
