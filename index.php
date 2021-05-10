<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Shoppe
 */

get_header();
?>

    <main id="primary" class="o-page">
        <div class="<?php echo esc_attr(shoppe_container_classes_layout()) ?>">
            <div class="o-page__header">
                <h2 class="o-page__header__title h1"><?php esc_html_e('Blog', 'shoppe'); ?></h2>
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
