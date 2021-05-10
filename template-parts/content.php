<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Shoppe
 */
if ( ! is_singular() ):
	?>
    <div class="o-col u-margin-bottom-lg-large u-margin-bottom-sm-large">
        <article id="post-<?php the_ID(); ?>" <?php post_class( 'c-post c-post--archive c-post--blog' ); ?>>
			<?php
			if ( get_theme_mod( 'show_posts_thumbnail_archive', true ) ) {
				shoppe_post_thumbnail();
			} ?>
            <div class="c-post__meta">
				<?php
				if ( get_theme_mod( 'show_cat_archive', true ) ) {
					shoppe_post_categories();
				}
				if ( get_theme_mod( 'show_cat_archive', true ) && get_theme_mod( 'show_date_archive', true ) ) {
					shoppe_separator();
				}
				if ( get_theme_mod( 'show_date_archive', true ) ) {
					shoppe_posted_on();
				}
				?>
            </div>
            <a class="c-post__title-link" href="<?php the_permalink(); ?>">
				<?php the_title( '<h2 class="c-post__title h3">', '</h2>' ); ?>
            </a>
			<?php if ( get_theme_mod( 'show_post_excerpt', true ) ) { ?>
                <div class="c-post__excerpt"><?php the_excerpt(); ?></div>
			<?php } ?>
            <div class="c-post__read-more">
                <a href="<?php the_permalink(); ?>" class="c-post__read-more__link" title="<?php the_title() ?>" aria-label="<?php the_title() ?>">Read More</a>
            </div>
        </article><!-- #post-<?php the_ID(); ?> -->
    </div>
<?php
else: ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class( 'c-post c-post--single c-post--blog' ); ?>>
        <header class="c-post__header">
			<?php the_title( '<h1 class="c-post__title">', '</h1>' ); ?>
            <div class="c-post__header__meta">
				<?php
				if ( get_theme_mod( 'show_post_author', true ) ) {
					shoppe_posted_by();
				}
				if ( get_theme_mod( 'show_post_author', true ) && get_theme_mod( 'show_post_date', true ) ) {
					shoppe_separator();
				}
				if ( get_theme_mod( 'show_post_date', true ) ) {
					shoppe_posted_on();
				}
				?>
            </div>
        </header>
		<?php
		if ( get_theme_mod( 'show_posts_thumbnail', true ) ) {
			shoppe_post_thumbnail();
		} ?>
        <div class="c-post__container">
            <div class="c-post__content"><?php the_content(); ?></div>
            <?php
            wp_link_pages(
	            array(
		            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'shoppe' ),
		            'after'  => '</div>',
	            )
            );
            ?>
            <footer class="c-post__footer">
				<?php if ( get_theme_mod( 'show_post_tags', true ) ) { ?>
					<?php if ( has_tag() ) : ?>
                        <div class="c-post__footer__tags s-post-tags">
                            <span class="c-post__tags__title"><?php esc_html_e( 'Tags', 'shoppe' ); ?></span>
							<?php the_tags( '' ); ?>
                        </div>
					<?php endif; ?>
				<?php } ?>
				<?php if ( get_theme_mod( 'show_share_icons', true ) ) { ?>
                    <div class="c-post__footer__share">
                        <span class="c-post__tags__title"><?php esc_html_e( 'Share', 'shoppe' ); ?></span>
						<?php shoppe__share_links() ?>
                    </div>
				<?php } ?>
            </footer>
        </div>
    </article><!-- #post-<?php the_ID(); ?> -->

<?php endif;
