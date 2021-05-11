<?php
// Declare WooCommerce support.
add_filter( 'woocommerce_get_image_size_thumbnail', function( $size ) {
	return array(
		'width'  => 380,
		'height' => 380,
		'crop'   => 1,
	);
} );

add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
	return array(
		'width'  => 120,
		'height' => 120,
		'crop'   => 1,
	);
} );


add_filter( 'woocommerce_get_image_size_single', function( $size ) {
	return array(
		'width'  => 700,
		'height' => 0,
		'crop'   => 1,
	);
} );

