<?php
/**
 * Single Product Sale Flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/sale-flash.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>

<?php if ( ! $product->is_in_stock() ) : ?>

	<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sold Out', 'shoppe' ) . '</span>', $post, $product ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped ?>

<?php
endif;

 if ( $product->is_on_sale() ) :

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


 echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">- ' . $percentage . '</span>', $post, $product ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped


endif;

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */

