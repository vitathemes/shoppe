<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Shoppe
 */

if ( ! function_exists( 'shoppe_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function shoppe_posted_on() {
		$time_string = '<time class="c-post__date entry-date" datetime="%1$s">%2$s</time>';

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		echo '<span class="c-post__date__published">' . $time_string . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'shoppe_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function shoppe_posted_by() {
		$byline = sprintf(
		/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'shoppe' ),
			'<span class="author vcard"><a class="c-post__author__link url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="c-post__author byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'shoppe_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function shoppe_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'shoppe' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'shoppe' ) . '</span>',
					$categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'shoppe' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'shoppe' ) . '</span>',
					$tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
					/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'shoppe' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'shoppe' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'shoppe_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function shoppe_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

            <div class="c-post__thumbnail c-post__thumbnail--single s-post-thumbnail">
				<?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->

		<?php else : ?>

			<?php if ( shoppe_has_sidebar() ): ?>
                <a class="c-post__thumbnail s-post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php
					the_post_thumbnail(
						'shoppe_thumbnail_blog',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
					?>
                </a>
			<?php else: ?>
                <a class="c-post__thumbnail s-post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
					<?php
					the_post_thumbnail(
						'shoppe_thumbnail_square',
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
					?>
                </a>
			<?php endif; ?>


		<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;


if ( ! function_exists( 'shoppe_header_nav' ) ) {
	/**
	 * Show header nav
	 */
	function shoppe_header_nav() {
		if ( has_nav_menu( 'menu-1' ) ) {
			$shoppe_header_menu_args = array(
				'theme_location' => 'menu-1',
				'menu_class'     => 'c-nav s-nav',
				'container'      => '',
			);

			echo "<nav class='c-menu js-header-menu'>";
			get_search_form();
			wp_nav_menu( $shoppe_header_menu_args );
			echo "</nav>";
		}
	}
}

if ( ! function_exists( 'shoppe_show_header_icons' ) ) {
	/**
	 * Show header icons
	 *
	 *
	 */
	function shoppe_show_header_icons() {
		$shoppe_kses_defaults = wp_kses_allowed_html( 'post' );
		$shoppe_search_icon   = '<button aria-label="' . __( 'Search',
				'shoppe' ) . '" class="c-header__link o-search-btn js-search-btn"><svg class="c-header__link__icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1.5em" height="1.5em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path d="M229.651 218.344l-43.222-43.223a92.112 92.112 0 1 0-11.315 11.314l43.223 43.223a8 8 0 1 0 11.314-11.314zM40 116a76 76 0 1 1 76 76a76.086 76.086 0 0 1-76-76z" /></svg></button>';
		$shoppe_cart_icon     = '<svg class="c-header__link__icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1.5em" height="1.5em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path d="M217.065 146.862l13.091-72A16 16 0 0 0 214.414 56H46.677l-4.884-26.862A15.992 15.992 0 0 0 26.051 16H8a8 8 0 0 0 0 16h18.05l26.703 146.862a16.003 16.003 0 0 0 1.187 3.765A27.993 27.993 0 1 0 97.293 192h69.414A27.997 27.997 0 1 0 192 176H68.495l-2.91-16h135.738a15.992 15.992 0 0 0 15.742-13.138zM84 204a12 12 0 1 1-12-12a12.013 12.013 0 0 1 12 12zm120 0a12 12 0 1 1-12-12a12.013 12.013 0 0 1 12 12zM49.586 72h164.828l-13.09 72H62.676z" /></svg><path d="M229.651 218.344l-43.222-43.223a92.112 92.112 0 1 0-11.315 11.314l43.223 43.223a8 8 0 1 0 11.314-11.314zM40 116a76 76 0 1 1 76 76a76.086 76.086 0 0 1-76-76z" /></svg>';
		$shoppe_user_icon     = '<svg class="c-header__link__icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1.5em" height="1.5em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path d="M231.937 211.986a120.486 120.486 0 0 0-67.12-54.142a72 72 0 1 0-73.633 0a120.488 120.488 0 0 0-67.12 54.14a8 8 0 1 0 13.85 8.013a104.037 104.037 0 0 1 180.174.002a8 8 0 1 0 13.849-8.013zM72 96a56 56 0 1 1 56 56a56.064 56.064 0 0 1-56-56z" /></svg>';
		$shoppe_svg_args      = array(
			'svg'   => array(
				'class'           => true,
				'aria-hidden'     => true,
				'aria-labelledby' => true,
				'role'            => true,
				'xmlns'           => true,
				'width'           => true,
				'height'          => true,
				'viewbox'         => true, // <= Must be lower case!
			),
			'g'     => array( 'fill' => true ),
			'title' => array( 'title' => true ),
			'path'  => array( 'd' => true, 'fill' => true, ),
		);
		$shoppe_allowed_tags  = array_merge( $shoppe_kses_defaults, $shoppe_svg_args );

		if ( get_theme_mod( 'cart_header',
				true ) && shoppe_is_woocommerce_activated() || get_theme_mod( 'search_header',
				true ) || get_theme_mod( 'profile_header', true ) && shoppe_is_woocommerce_activated() ) {
			echo '<span class="c-header__separator"></span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		if ( get_theme_mod( 'search_header', true ) ) {
			echo wp_kses( $shoppe_search_icon, $shoppe_allowed_tags );
		}
		if ( get_theme_mod( 'cart_header', true ) && shoppe_is_woocommerce_activated() ) {
			echo wp_kses( sprintf( '<a class="c-header__link" href="%s" aria-label="%s">',
				esc_url( wc_get_cart_url() ),
				__( 'Cart', 'shoppe' ) ),
				$shoppe_allowed_tags );
			echo wp_kses( $shoppe_cart_icon, $shoppe_allowed_tags );
			echo wp_kses( "</a>", $shoppe_allowed_tags );
		}
		if ( get_theme_mod( 'profile_header', true ) && shoppe_is_woocommerce_activated() ) {
			echo wp_kses( sprintf( '<a class="c-header__link" href="%s" aria-label="%s">',
				esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ),
				__( 'Account', 'shoppe' ) ),
				$shoppe_allowed_tags );
			echo wp_kses( $shoppe_user_icon, $shoppe_allowed_tags );
			echo wp_kses( "</a>", $shoppe_allowed_tags );
		}
		echo '<button aria-label="Menu Toggle" class="c-header__menu-toggle menu-toggle hamburger--spin js-header-menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="hamburger-box"><span class="hamburger-inner"></span></span></button>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}

if ( ! function_exists( 'shoppe_post_categories' ) ) {
	/**
	 * Show post categories
	 */
	function shoppe_post_categories() {
		$categories = get_the_category();

		echo "<ul class='c-cats'>";

		foreach ( $categories as $category ) {
			echo sprintf( '<li class="c-cats__item"><a href="%s" class="c-cats__item__link">%s</a></li>',
				esc_url( get_category_link( $category->term_id ) ),
				esc_html( $category->name ) );
		}

		echo "</ul>";
	}
}

if ( ! function_exists( 'shoppe_separator' ) ) {
	/**
	 * Dash separator
	 */
	function shoppe_separator( $condition = true ) {
		if ( $condition ) {
			echo '<span class="o-separator">-</span>';
		}

		return null;
	}
}

if ( ! function_exists( 'shoppe__share_links' ) ) {
	function shoppe__share_links() {
		if ( get_theme_mod( 'show_share_icons', true ) ) {
			$shoppe_linkedin_url = "https://www.linkedin.com/shareArticle?mini=true&url=" . get_permalink() . "&title=" . get_the_title();
			$shoppe_twitter_url  = "https://twitter.com/intent/tweet?url=" . get_permalink() . "&title=" . get_the_title();
			$shoppe_facebook_url = "https://www.facebook.com/sharer.php?u=" . get_permalink();

			echo '<div class="c-social-share">';  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo sprintf( '<a class="c-social-share__link" target="_blank" href="%s"><svg class="c-social-share__link__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><rect x="0" fill="none" width="20" height="20"/><g><path d="M8.46 18h2.93v-7.3h2.45l.37-2.84h-2.82V6.04c0-.82.23-1.38 1.41-1.38h1.51V2.11c-.26-.03-1.15-.11-2.19-.11-2.18 0-3.66 1.33-3.66 3.76v2.1H6v2.84h2.46V18z"/></g></svg></span></a>',
				esc_url( $shoppe_facebook_url ) );
			echo sprintf( '<a class="c-social-share__link" target="_blank" href="%s"><svg class="c-social-share__link__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><rect x="0" fill="none" width="20" height="20"/><g><path d="M18.94 4.46c-.49.73-1.11 1.38-1.83 1.9.01.15.01.31.01.47 0 4.85-3.69 10.44-10.43 10.44-2.07 0-4-.61-5.63-1.65.29.03.58.05.88.05 1.72 0 3.3-.59 4.55-1.57-1.6-.03-2.95-1.09-3.42-2.55.22.04.45.07.69.07.33 0 .66-.05.96-.13-1.67-.34-2.94-1.82-2.94-3.6v-.04c.5.27 1.06.44 1.66.46-.98-.66-1.63-1.78-1.63-3.06 0-.67.18-1.3.5-1.84 1.81 2.22 4.51 3.68 7.56 3.83-.06-.27-.1-.55-.1-.84 0-2.02 1.65-3.66 3.67-3.66 1.06 0 2.01.44 2.68 1.16.83-.17 1.62-.47 2.33-.89-.28.85-.86 1.57-1.62 2.02.75-.08 1.45-.28 2.11-.57z"/></g></svg></a>',
				esc_url( $shoppe_twitter_url ) );
			echo sprintf( '<a class="c-social-share__link" target="_blank" href="%s"><svg class="c-social-share__link__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><rect x="0" fill="none" width="20" height="20"/><g><path d="M2.5 18h3V6.9h-3V18zM4 2c-1 0-1.8.8-1.8 1.8S3 5.6 4 5.6s1.8-.8 1.8-1.8S5 2 4 2zm6.6 6.6V6.9h-3V18h3v-5.7c0-3.2 4.1-3.4 4.1 0V18h3v-6.8c0-5.4-5.7-5.2-7.1-2.6z"/></g></svg></a>',
				esc_url( $shoppe_linkedin_url ) );
			echo '</div>';  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}


if ( ! function_exists( 'shoppe_posts_pagination' ) ) :
	/**
	 * Generate Posts Pagination
	 */
	function shoppe_posts_pagination() {
		the_posts_pagination( array(
			'screen_reader_text' => ' ',
			'mid_size'           => 2,
			'prev_text'          => '<span class="dashicons dashicons-arrow-left-alt2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><rect x="0" fill="none" width="20" height="20"/><g><path d="M14 5l-5 5 5 5-1 2-7-7 7-7z"/></g></svg></span>',
			'next_text'          => '<span class="dashicons dashicons-arrow-right-alt2"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><rect x="0" fill="none" width="20" height="20"/><g><path d="M6 15l5-5-5-5 1-2 7 7-7 7z"/></g></svg></span>',
		) );
	}
endif;
