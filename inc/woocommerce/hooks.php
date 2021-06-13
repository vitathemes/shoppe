<?php
// Hide `Add to card` button
if ( ! function_exists( 'shoppe_hide_add_to_cart_buttons' ) ) {
	function shoppe_hide_add_to_cart_buttons() {
		if ( is_product_category() || is_shop() ) {
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
		}
	}
}

add_action( 'woocommerce_after_shop_loop_item', 'shoppe_hide_add_to_cart_buttons', 1 );

// Hide `Ordering` select field
if ( ! function_exists( 'shoppe_hide_catalog_ordering' ) ) {
	function shoppe_hide_catalog_ordering() {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	}
}

add_action( 'woocommerce_before_shop_loop', 'shoppe_hide_catalog_ordering', 1 );

// Hide `Breadcrumbs` button
if ( ! function_exists( 'shoppe_hide_breadcrumbs' ) ) {
	function shoppe_hide_breadcrumbs() {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}
}

add_action( 'woocommerce_before_main_content', 'shoppe_hide_breadcrumbs', 1 );


remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

// Move `Results count` to header of page
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_archive_description', 'woocommerce_result_count', 1 );


// Add a wrapper around product thumbnail add move `Add to card` button inside it.
if ( ! function_exists( 'shoppe_product_thumbnail_start' ) ) {
	function shoppe_product_thumbnail_start() {
		global $product;

		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

		echo '<div class="product__header">' . '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>';
	}
}

add_action( 'woocommerce_before_shop_loop_item_title', 'shoppe_product_thumbnail_start', 9 );


// Add a wrapper around product thumbnail add move `Add to card` button inside it.
if ( ! function_exists( 'shoppe_product_thumbnail_end' ) ) {
	function shoppe_product_thumbnail_end() {
		echo '</div>';
	}
}

if ( ! function_exists( 'abChangeProductsTitle' ) ) {
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	add_action( 'woocommerce_shop_loop_item_title', 'abChangeProductsTitle', 10 );
	function abChangeProductsTitle() {
		echo '<a class="woocommerce-loop-product_title-link" href="' . esc_url( get_the_permalink() ) . '"><h2 class="woocommerce-loop-product_title">' . esc_html( get_the_title() ) . '</h2></a>';
	}
}

add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 11 );
add_action( 'woocommerce_before_shop_loop_item_title', 'shoppe_product_thumbnail_end', 11 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 11 );


remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

add_filter( 'wc_add_to_cart_message', 'shoppe_filter_add_to_cart_notice_success', 10, 2 );
function shoppe_filter_add_to_cart_notice_success( $message, $product_id ) {
	return "The item added to your Shopping cart. <a class='button' href='" . wc_get_cart_url() . "'>View Cart</a>";
}


/**
 * WooCommerce Extra Feature
 * --------------------------
 *
 * Change number of related products on product page
 * Set your own value for 'posts_per_page'
 *
 */

add_filter( 'woocommerce_output_related_products_args', 'shoppe_related_products_args' );
function shoppe_related_products_args( $args ) {
	$args['posts_per_page'] = 3;

	return $args;
}
