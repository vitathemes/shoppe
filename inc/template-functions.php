<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Shelly
 */

define( 'SITE_LAYOUT', get_theme_mod( 'blog_layout', 'left' ) );
define( 'SHOP_LAYOUT', get_theme_mod( 'shop_layout', 'left' ) );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function shelly_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}

add_filter( 'body_class', 'shelly_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function shelly_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

add_action( 'wp_head', 'shelly_pingback_header' );


if ( ! function_exists( 'shelly_branding' ) ) {
	/**
	 * Displays branding
	 *
	 * If there is not any custom logo the function will show site title
	 */
	function shelly_branding() {
		if ( has_custom_logo() ) {
			the_custom_logo();
		} else {
			if ( is_front_page() && is_home() ) :
				?>
                <h1 class="c-header__branding__title site-title">
                    <a class="c-header__branding__title__link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                </h1>
			<?php
			else :
				?>
                <p class="c-header__branding__title site-title h1">
                    <a class="c-header__branding__title__link h1" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                </p>
			<?php
			endif;
		}


	}

	add_action( 'shelly_branding_hook', 'shelly_branding' );
}

if ( ! function_exists( 'shelly_header' ) ) {
	/**
	 * Displays header nav
	 *
	 * This function will show header nav
	 */
	function shelly_header() {
		shelly_header_nav();
		shelly_show_header_icons();
	}

	add_action( 'shelly_header_hook', 'shelly_header' );
}

if ( ! function_exists( 'shelly_is_blog_page' ) ) {
	/**
	 * Check if we are in blog page.
	 */
	function shelly_is_blog_page() {

		global $post;

		//Post type must be 'post'.
		$post_type = get_post_type( $post );

		//Check all blog-related conditional tags, as well as the current post type,
		//to determine if we're viewing a blog page.
		return (
			( is_home() || is_archive() || is_single() || is_search() )
			&& ( $post_type == 'post' )
		) ? true : false;

	}
}
if ( ! function_exists( 'shelly_page_classes_layout' ) ) {
	/**
	 * Generate page classes according to layout.
	 */
	function shelly_page_classes_layout() {
		$shelly_page_classes = "o-page__grid";

		if ( shelly_is_blog_page() && SITE_LAYOUT !== "center" ) {
			$shelly_page_classes .= " o-page__grid--has-sidebar o-page__grid--sidebar-" . SITE_LAYOUT;
		}

		if ( shelly_is_woocommerce_activated() ) {
			if ( is_shop() && SHOP_LAYOUT !== "center" ) {
				$shelly_page_classes .= " o-page__grid--has-sidebar o-page__grid--sidebar-" . SHOP_LAYOUT;
			}
		}

		return $shelly_page_classes;
	}
}
if ( ! function_exists( 'shelly_container_classes_layout' ) ) {
	/**
	 * Generate container classes according to layout.
	 */
	function shelly_container_classes_layout() {
		$shelly_container_classes = "o-container";

		if ( shelly_is_blog_page() && SITE_LAYOUT !== "center" ) {
			$shelly_container_classes .= "--half-padding";
		}

		if ( shelly_is_woocommerce_activated() ) {
			if ( is_shop() && SHOP_LAYOUT !== "center" ) {
				$shelly_container_classes .= "--half-padding";
			}
		}

		return $shelly_container_classes;
	}
}
if ( ! function_exists( 'shelly_has_sidebar' ) ) {
	/**
	 * Generate page classes according to layout.
	 */
	function shelly_has_sidebar() {

		if ( shelly_is_blog_page() && SITE_LAYOUT !== "center" ) {
			return true;
		}

		if ( shelly_is_woocommerce_activated() ) {
			if ( is_shop() && SHOP_LAYOUT !== "center" ) {
				return true;
			}
		}

		return false;
	}
}
if ( ! function_exists( 'shelly_shop_grid_classes' ) ) {
	/**
	 * Generate shop classes according to layout.
	 */
	function shelly_shop_grid_classes() {

		if ( is_singular( 'product' ) ) {
			return " o-grid--larger-gap";
		} else {

			if ( SHOP_LAYOUT === "center" ) {
				return " o-grid--larger-gap";
			}
		}

		return null;
	}
}
if ( ! function_exists( 'shelly_blog_grid_classes' ) ) {
	/**
	 * Generate shop classes according to layout.
	 */
	function shelly_blog_grid_classes() {

		if ( SITE_LAYOUT === "center" ) {
			return " o-grid--larger-gap";
		}

		return null;
	}
}

/**
 * Remove Woocommerce labels
 */

if ( ! function_exists( 'shelly_shipping_fields' ) ) {
	function shelly_shipping_fields( $fields ) {

		$fields['shipping_first_name']['placeholder'] = "First Name*";
		$fields['shipping_first_name']['label']       = "";

		$fields['shipping_last_name']['placeholder'] = "Last Name*";
		$fields['shipping_last_name']['label']       = "";

		$fields['shipping_company']['placeholder'] = "Company name (optional)";
		$fields['shipping_company']['label']       = false;

		$fields['shipping_country']['label'] = "";

		$fields['shipping_address_1']['label'] = "";

		$fields['shipping_city']['placeholder'] = "Town / City";
		$fields['shipping_city']['label']       = "";

		$fields['shipping_state']['placeholder'] = "Country";
		$fields['shipping_state']['label']       = null;

		$fields['shipping_postcode']['placeholder'] = "Postcode*";
		$fields['shipping_postcode']['label']       = "";

		$fields['shipping_phone']['placeholder'] = "Phone*";
		$fields['shipping_phone']['label']       = "";

		$fields['shipping_email']['placeholder'] = "Email*";
		$fields['shipping_email']['label']       = "";

		return $fields;
	}
}
add_filter( 'woocommerce_shipping_fields', 'shelly_shipping_fields' );


if ( ! function_exists( 'shelly_billing_fields' ) ) {
	/**
	 * Remove Woocommerce labels
	 */
	function shelly_billing_fields( $fields ) {

		$fields['billing_first_name']['placeholder'] = "First Name*";
		$fields['billing_first_name']['label']       = "";

		$fields['billing_last_name']['placeholder'] = "Last Name*";
		$fields['billing_last_name']['label']       = "";

		$fields['billing_company']['placeholder'] = "Company name (optional)";
		$fields['billing_company']['label']       = false;

		$fields['billing_country']['label'] = "";

		$fields['billing_address_1']['label'] = "";

		$fields['billing_city']['placeholder'] = "Town / City";
		$fields['billing_city']['label']       = "";

		$fields['billing_state']['placeholder'] = "Country";
		$fields['billing_state']['label']       = null;

		$fields['billing_postcode']['placeholder'] = "Postcode*";
		$fields['billing_postcode']['label']       = "";

		$fields['billing_phone']['placeholder'] = "Phone*";
		$fields['billing_phone']['label']       = "";

		$fields['billing_email']['placeholder'] = "Email*";
		$fields['billing_email']['label']       = "";

		return $fields;
	}
}
add_filter( 'woocommerce_billing_fields', 'shelly_billing_fields' );


if ( ! function_exists( 'shelly_remove_billing_fields' ) ) {
	/**
	 * Remove Woocommerce labels
	 */
	function shelly_remove_billing_fields( $fields ) {


		//$fields[ 'shipping_postcode' ]['placeholder'] = "Postcode*";
		//$fields[ 'shipping_postcode' ]['label'] = "";

		$fields['billing_company']['placeholder'] = "Company name (optional)";
		$fields['billing_company']['label']       = false;

		$fields['billing_postcode']['placeholder'] = "Postcode*";
		$fields['billing_postcode']['label']       = "";

		$fields['billing_phone']['placeholder'] = "Phone*";
		$fields['billing_phone']['label']       = "";

		$fields['billing_email']['placeholder'] = "Email*";
		$fields['billing_email']['label']       = "";

		$fields['billing_state']['placeholder'] = "Country (optional)";
		$fields['billing_state']['label']       = "";

		return $fields;

	}
}
add_filter( 'woocommerce_billing_fields', 'shelly_remove_billing_fields' );

if ( ! function_exists( 'shelly_empty_cart_message' ) ) {

	function shelly_empty_cart_message() {
		echo '	<div class="c-notice s-notice"' . esc_html(wc_get_notice_data_attr( $notice )) .
		'
		<div class="c-notice__main">' .
		     esc_html__( "Your cart is currently empty.", 'shelly' )
		     . '</div>
	</div>';
	}
}

remove_action( 'woocommerce_cart_is_empty', 'wc_empty_cart_message', 10, 0 );

add_action( 'woocommerce_cart_is_empty', 'shelly_empty_cart_message', 10, 0 );


if ( ! function_exists( 'shelly_theme_settings' ) ) {
	function shelly_theme_settings() {
		$vars = ':root {	
	            --shelly-branding-color: ' . get_theme_mod( "color_primary_color", "#A18A68" ) . ';
	            --shelly-primary-color: ' . get_theme_mod( "color_1", "#000000" ) . ';
	            --shelly-secondary-color: ' . get_theme_mod( "color_2", "#707070" ) . ';
	            --shelly-tertiary-color: ' . get_theme_mod( "color_3", "#D8D8D8" ) . ';
	            --shelly-quaternary-color: ' . get_theme_mod( "color_4", "#EFEFEF" ) . ';
	            --shelly-quinary-color: ' . get_theme_mod( "color_5", "#F9F9F9" ) . ';
	        
			}';

		?>
        <style>
            <?php echo esc_html($vars); ?>
        </style>
		<?php
	}
}
add_action( 'wp_head', 'shelly_theme_settings' );

if ( ! function_exists( 'shelly_is_woocommerce_page' ) ) {
	/**
	 * Check if we are in a woocommerce page
	 */
	function shelly_is_woocommerce_page() {
		if ( shelly_is_woocommerce_activated() ) {
			if ( is_woocommerce() || is_cart() || is_checkout() || is_product() || is_shop() || is_product_category() || is_product_tag() || is_account_page() || is_wc_endpoint_url() ) {
				return true;
			}
		}

		return null;
	}
}


if ( ! function_exists( 'add_percentage_to_sale_badge' ) ) {
	function add_percentage_to_sale_badge( $html, $post, $product ) {
		if ( $product->is_type( 'variable' ) ) {
			$percentages = array();

			// Get all variation prices
			$prices = $product->get_variation_prices();

			// Loop through variation prices
			foreach ( $prices['price'] as $key => $price ) {
				// Only on sale variations
				if ( $prices['regular_price'][ $key ] !== $price ) {
					// Calculate and set in the array the percentage for each variation on sale
					$percentages[] = round( 100 - ( $prices['sale_price'][ $key ] / $prices['regular_price'][ $key ] * 100 ) );
				}
			}
			$percentage = max( $percentages ) . '%';
		} else {
			$regular_price = (float) $product->get_regular_price();
			$sale_price    = (float) $product->get_sale_price();

			$percentage = round( 100 - ( $sale_price / $regular_price * 100 ) ) . '%';
		}

		return '<span class="onsale">- ' . $percentage . '</span>';
	}
}
add_filter( 'woocommerce_sale_flash', 'add_percentage_to_sale_badge', 20, 3 );

if ( ! function_exists( 'shelly_add_placeholder_comment_form' ) ) {
	/**
	 * Comment Form Placeholder Author, Email, URL
	 */
	function shelly_add_placeholder_comment_form( $fields ) {
		$replace_author = __( 'Your Name', 'shelly' );
		$replace_email  = __( 'Your Email', 'shelly' );
		$replace_url    = __( 'Your Website', 'shelly' );

		$fields['author'] = '<p class="comment-form-author">' . '<label class="screen-reader-text" for="author">' . esc_html__( 'Name',
				'shelly' ) . '</label> ' . ( $req ? '<span class="required">*</span>' : '' ) .
		                    '<input id="author" name="author" type="text" placeholder="' . $replace_author . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="20"' . $aria_req . ' /></p>';

		$fields['email'] = '<p class="comment-form-email"><label class="screen-reader-text" for="email">' . esc_html__( 'Email',
				'shelly' ) . '</label> ' .
		                   ( $req ? '<span class="required">*</span>' : '' ) .
		                   '<input id="email" name="email" type="text" placeholder="' . $replace_email . '" value="' . esc_attr( $commenter['comment_author_email'] ) .
		                   '" size="30"' . $aria_req . ' /></p>';

		$fields['url'] = '<p class="comment-form-url"><label class="screen-reader-text" for="url">' . esc_html__( 'Website',
				'shelly' ) . '</label>' .
		                 '<input id="url" name="url" type="text" placeholder="' . $replace_url . '" value="' . esc_attr( $commenter['comment_author_url'] ) .
		                 '" size="30" /></p>';

		return $fields;
	}
}

add_filter( 'comment_form_default_fields', 'shelly_add_placeholder_comment_form' );


if ( ! function_exists( 'shelly_reply_title' ) ) {
	function shelly_reply_title( $defaults ) {
		$defaults['title_reply_before'] = '<h3 id="reply-title" class="h2 comment-reply-title">';
		$defaults['title_reply_after']  = '</h3>';

		return $defaults;
	}
}
add_filter( 'comment_form_defaults', 'shelly_reply_title' );
