<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Shoppe
 */

get_header();
?>

    <main id="primary" class="o-page o-page--blog-single">
        <div class="o-container">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );
			?>
            <div class="o-page__wrapper">
            <div class="c-pagination s-pagination c-pagination--post-navigation">
	            <?php
	            the_post_navigation(
		            array(
                        'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'shoppe' ) . '</span> <span class="nav-title">%title</span>',
                        'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'shoppe' ) . '</span> <span class="nav-title">%title</span>',
				)
			);
        ?>
            </div>

				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>
            </div>
		<?php
		endwhile; // End of the loop.
		?>

        </div>
	</main><!-- #main -->

<?php
get_footer();
