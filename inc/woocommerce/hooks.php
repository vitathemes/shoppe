<?php
if ( ! function_exists( 'shelly_products_filters' ) ) {
	function shelly_products_filters() {

	}
}
add_action( 'woocommerce_before_shop_loop', 'shelly_products_filters', 35 );
//add_action( 'woocommerce_after_shop_loop',  'shelly_products_filters' , 35 );
//add_action( 'woocommerce_after_shop_loop_item',  'shelly_products_filters' , 35 );
//add_action( 'woocommerce_after_shop_loop_item_title',  'shelly_products_filters' , 35 );

// Hide `Add to card` button
if ( ! function_exists( 'shelly_hide_add_to_cart_buttons' ) ) {
	function shelly_hide_add_to_cart_buttons() {
		if ( is_product_category() || is_shop() ) {
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
		}
	}
}

add_action( 'woocommerce_after_shop_loop_item', 'shelly_hide_add_to_cart_buttons', 1 );

// Hide `Ordering` select field
if ( ! function_exists( 'shelly_hide_catalog_ordering' ) ) {
	function shelly_hide_catalog_ordering() {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	}
}

add_action( 'woocommerce_before_shop_loop', 'shelly_hide_catalog_ordering', 1 );

// Hide `Breadcrumbs` button
if ( ! function_exists( 'shelly_hide_breadcrumbs' ) ) {
	function shelly_hide_breadcrumbs() {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}
}

add_action( 'woocommerce_before_main_content', 'shelly_hide_breadcrumbs', 1 );


remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

// Move `Results count` to header of page
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'woocommerce_archive_description', 'woocommerce_result_count', 1 );


// Add a wrapper around product thumbnail add move `Add to card` button inside it.
if ( ! function_exists( 'shelly_product_thumbnail_start' ) ) {
	function shelly_product_thumbnail_start() {
		global $product;

		$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );

		echo '<div class="product__header">' . '<a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link"></a>';
	}
}

add_action( 'woocommerce_before_shop_loop_item_title', 'shelly_product_thumbnail_start', 9 );


// Add a wrapper around product thumbnail add move `Add to card` button inside it.
if ( ! function_exists( 'shelly_product_thumbnail_end' ) ) {
	function shelly_product_thumbnail_end() {
		echo '</div>';
	}
}

if ( ! function_exists( 'abChangeProductsTitle' ) ) {
	remove_action( 'woocommerce_shop_loop_item_title','woocommerce_template_loop_product_title', 10 );
	add_action('woocommerce_shop_loop_item_title', 'abChangeProductsTitle', 10 );
	function abChangeProductsTitle() {
		echo '<a class="woocommerce-loop-product_title-link h3" href="'. esc_url(get_the_permalink()) .'"><h2 class="woocommerce-loop-product_title h3">' . esc_html(get_the_title()) . '</h2></a>';
	}
}

add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 11 );
add_action( 'woocommerce_before_shop_loop_item_title', 'shelly_product_thumbnail_end', 11 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 11 );


remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');

add_filter('wc_add_to_cart_message', 'shelly_filter_add_to_cart_notice_success', 10, 2);
function shelly_filter_add_to_cart_notice_success($message, $product_id) {
	return "The item added to your Shopping cart. <a class='button' href='". wc_get_cart_url() ."'>View Cart</a>";
}
