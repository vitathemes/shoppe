<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Shoppe
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
function shoppe_body_classes( $classes ) {
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

add_filter( 'body_class', 'shoppe_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function shoppe_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}

add_action( 'wp_head', 'shoppe_pingback_header' );


if ( ! function_exists( 'shoppe_branding' ) ) {
	/**
	 * Displays branding
	 *
	 * If there is not any custom logo the function will show site title
	 */
	function shoppe_branding() {
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

	add_action( 'shoppe_branding_hook', 'shoppe_branding' );
}

if ( ! function_exists( 'shoppe_header' ) ) {
	/**
	 * Displays header nav
	 *
	 * This function will show header nav
	 */
	function shoppe_header() {
		shoppe_header_nav();
		shoppe_show_header_icons();
	}

	add_action( 'shoppe_header_hook', 'shoppe_header' );
}

if ( ! function_exists( 'shoppe_is_blog_page' ) ) {
	/**
	 * Check if we are in blog page.
	 */
	function shoppe_is_blog_page() {

		global $post;
		//Post type must be 'post'.
		$post_type = get_post_type( $post );

		//Check all blog-related conditional tags, as well as the current post type,
		//to determine if we're viewing a blog page.
		if ( is_search() ) {
			return true;
		}

		return (
		( is_home() || is_archive() || is_single() && ( $post_type == 'post' ) )
		) ? true : false;

	}
}
if ( ! function_exists( 'shoppe_page_classes_layout' ) ) {
	/**
	 * Generate page classes according to layout.
	 */
	function shoppe_page_classes_layout() {
		$shoppe_page_classes = "o-page__grid";

		if ( shoppe_is_blog_page() && SITE_LAYOUT !== "center" ) {
			$shoppe_page_classes .= " o-page__grid--has-sidebar o-page__grid--sidebar-" . SITE_LAYOUT;
		}

		if ( shoppe_is_woocommerce_activated() ) {
			if ( is_shop() && SHOP_LAYOUT !== "center" ) {
				$shoppe_page_classes .= " o-page__grid--has-sidebar o-page__grid--sidebar-" . SHOP_LAYOUT;
			}
		}

		return $shoppe_page_classes;
	}
}
if ( ! function_exists( 'shoppe_container_classes_layout' ) ) {
	/**
	 * Generate container classes according to layout.
	 */
	function shoppe_container_classes_layout() {
		$shoppe_container_classes = "o-container";

		if ( shoppe_is_blog_page() && SITE_LAYOUT !== "center" ) {
			$shoppe_container_classes .= "--half-padding";
		}

		if ( shoppe_is_woocommerce_activated() ) {
			if ( is_shop() && SHOP_LAYOUT !== "center" ) {
				$shoppe_container_classes .= "--half-padding";
			}
		}

		return $shoppe_container_classes;
	}
}
if ( ! function_exists( 'shoppe_has_sidebar' ) ) {
	/**
	 * Generate page classes according to layout.
	 */
	function shoppe_has_sidebar() {

		if ( shoppe_is_blog_page() && SITE_LAYOUT !== "center" ) {
			return true;
		}

		if ( shoppe_is_woocommerce_activated() ) {
			if ( is_shop() && SHOP_LAYOUT !== "center" ) {
				return true;
			}
		}

		return false;
	}
}
if ( ! function_exists( 'shoppe_shop_grid_classes' ) ) {
	/**
	 * Generate shop classes according to layout.
	 */
	function shoppe_shop_grid_classes() {

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
if ( ! function_exists( 'shoppe_blog_grid_classes' ) ) {
	/**
	 * Generate shop classes according to layout.
	 */
	function shoppe_blog_grid_classes() {

		if ( SITE_LAYOUT === "center" ) {
			return " o-grid--larger-gap";
		}

		return null;
	}
}

/**
 * Remove Woocommerce labels
 */

if ( ! function_exists( 'shoppe_shipping_fields' ) ) {
	function shoppe_shipping_fields( $fields ) {

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
add_filter( 'woocommerce_shipping_fields', 'shoppe_shipping_fields' );


if ( ! function_exists( 'shoppe_billing_fields' ) ) {
	/**
	 * Remove Woocommerce labels
	 */
	function shoppe_billing_fields( $fields ) {

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
add_filter( 'woocommerce_billing_fields', 'shoppe_billing_fields' );


if ( ! function_exists( 'shoppe_remove_billing_fields' ) ) {
	/**
	 * Remove Woocommerce labels
	 */
	function shoppe_remove_billing_fields( $fields ) {


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

		$fields['billing_state']['placeholder'] = "State (optional)";
		$fields['billing_state']['label']       = "";

		return $fields;

	}
}
add_filter( 'woocommerce_billing_fields', 'shoppe_remove_billing_fields' );


if ( ! function_exists( 'shoppe_theme_settings' ) ) {
	function shoppe_theme_settings() {
		$vars = ':root {	
	            --shoppe-branding-color: ' . get_theme_mod( "color_primary_color", "#A18A68" ) . ';
	            --shoppe-primary-color: ' . get_theme_mod( "color_1", "#000000" ) . ';
	            --shoppe-secondary-color: ' . get_theme_mod( "color_2", "#707070" ) . ';
	            --shoppe-tertiary-color: ' . get_theme_mod( "color_3", "#D8D8D8" ) . ';
	            --shoppe-quaternary-color: ' . get_theme_mod( "color_4", "#EFEFEF" ) . ';
	            --shoppe-quinary-color: ' . get_theme_mod( "color_5", "#F9F9F9" ) . ';
	        
			}';

		?>
        <style>
            <?php echo esc_html($vars); ?>
        </style>
		<?php
	}
}
add_action( 'wp_head', 'shoppe_theme_settings' );

if ( ! function_exists( 'shoppe_is_woocommerce_page' ) ) {
	/**
	 * Check if we are in a woocommerce page
	 */
	function shoppe_is_woocommerce_page() {
		if ( shoppe_is_woocommerce_activated() ) {
			if ( is_woocommerce() || is_cart() || is_checkout() || is_product() || is_shop() || is_product_category() || is_product_tag() || is_account_page() || is_wc_endpoint_url() ) {
				return true;
			}
		}

		return null;
	}
}

if ( ! function_exists( 'shoppe_add_placeholder_comment_form' ) ) {
	/**
	 * Comment Form Placeholder Author, Email, URL
	 */
	function shoppe_add_placeholder_comment_form( $fields ) {
		$replace_author = __( 'Your Name *', 'shoppe' );
		$replace_email  = __( 'Your Email *', 'shoppe' );
		$replace_url    = __( 'Your Website', 'shoppe' );

		if ( ! isset( $req ) ) {
			$req = false;
		}

		if ( ! isset( $commenter ) ) {
			$commenter = false;
		}

		$fields['author'] = '<p class="comment-form-author">' . '<label class="screen-reader-text" for="author">' . esc_html__( 'Name',
				'shoppe' ) . '</label>' .
		                    '<input required="required" id="author" name="author" type="text" placeholder="' . $replace_author . '" value="' . ( $commenter ? esc_attr( $commenter['comment_author'] ) : '' ) . '" size="20" /></p>';

		$fields['email'] = '<p class="comment-form-email"><label class="screen-reader-text" for="email">' . esc_html__( 'Email',
				'shoppe' ) . '</label>' .
		                   '<input  required="required"  id="email" name="email" type="text" placeholder="' . $replace_email . '" value="' . ( $commenter ? esc_attr( $commenter['comment_author_email'] ) : '' ) .
		                   '" size="30"/></p>';

		$fields['url'] = '<p class="comment-form-url"><label class="screen-reader-text" for="url">' . esc_html__( 'Website',
				'shoppe' ) . '</label>' .
		                 '<input id="url" name="url" type="text" placeholder="' . $replace_url . '" value="' . ( $commenter ? esc_attr( $commenter['comment_author_url'] ) : '' ) .
		                 '" size="30" /></p>';

		return $fields;
	}
}

add_filter( 'comment_form_default_fields', 'shoppe_add_placeholder_comment_form' );


if ( ! function_exists( 'shoppe_reply_title' ) ) {
	function shoppe_reply_title( $defaults ) {
		$defaults['title_reply_before'] = '<h3 id="reply-title" class="h2 comment-reply-title">';
		$defaults['title_reply_after']  = '</h3>';

		return $defaults;
	}
}
add_filter( 'comment_form_defaults', 'shoppe_reply_title' );

if ( ! function_exists( 'shoppe_header_image' ) ) :
	/**
	 * Header Image
	 *
	 */
	function shoppe_header_image() {
		if ( has_header_image() ) {
			echo sprintf( '<img class="c-header__bg-img" src="%s" height="%s" width="%s" alt="%s" />',
				esc_url( get_header_image() ),
				esc_attr( get_custom_header()->height ),
				esc_attr( get_custom_header()->width ),
				esc_attr__( 'Header Image', 'shoppe' ) );
		}
	}
endif;

if ( ! function_exists( 'shoppe_header_text_color' ) ) :
	function shoppe_header_text_color() {
		if ( get_theme_mod( 'header_textcolor', 0 ) ) {
			?>
            <style id="header-text-color" type="text/css">
                .s-nav a {
                    color: <?php echo"#" . esc_html(get_theme_mod('header_textcolor', '000000')); ?>;
                }
            </style>
			<?php
		}
	}
endif;
add_action( 'wp_head', 'shoppe_header_text_color' );
