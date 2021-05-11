<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Shoppe
 */

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
