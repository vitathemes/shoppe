<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = $product->get_image_id();
$wrapper_classes = apply_filters(
	'woocommerce_single_product_image_gallery_classes',
	array(
		'woocommerce-product-gallery',
		'woocommerce-product-gallery--' . ( $product->get_image_id() ? 'with-images' : 'without-images' ),
		'woocommerce-product-gallery--columns-' . absint( $columns ),
		'images',
	)
);

$attachment_ids = $product->get_gallery_image_ids();

$images_count = count( $attachment_ids );
?>
<div class="<?php echo esc_attr( implode( ' ',
	array_map( 'sanitize_html_class',
		$wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
    <figure class="woocommerce-product-gallery__wrapper o-grid-noGutter">
        <div class="o-col product-thumbnails">
            <div class="carousel carousel-nav"
                    data-flickity='{
              "asNavFor": ".carousel-main",
              "draggable": false,
              "prevNextButtons": false,
              "percentPosition": false,
              "pageDots": false,
              "cellAlign": "left",
              "freeScroll": true
              <?php if ( $images_count > 4 ) {
						echo ',"wrapAround": true';
					} else {
						echo ',"groupCells": "100%"';
					} ?>
            }'>
				<?php

				foreach ( $attachment_ids as $attachment_id ) {
					$image_link = wp_get_attachment_image_src( $attachment_id, 'woocommerce_gallery_thumbnail' )[0];
					$alt_text   = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
					echo "<div class='carousel-cell'>" . sprintf( '<img src="%s" alt="%s" class="wp-post-image" />',
							$image_link,
							$alt_text ) . "</div>"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
            </div>
        </div>
        <div class="o-col product-slider">
            <div class="carousel carousel-main"
                    data-flickity='{
             "contain": true,
             "pageDots": true,
             "prevNextButtons": false
             <?php if ( $images_count > 4 ) {
						echo ',"wrapAround": true';
					} ?>
           }'>
				<?php
				$attachment_ids = $product->get_gallery_image_ids();

				foreach ( $attachment_ids as $attachment_id ) {
					$image_link = wp_get_attachment_url( $attachment_id );
					$alt_text   = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
					echo "<div class='carousel-cell'>" . sprintf( '<img src="%s" alt="%s" class="wp-post-image" />',
							$image_link,
							$alt_text ) . "</div>"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				if (has_post_thumbnail()) {
					echo apply_filters( 'woocommerce_single_product_image_thumbnail_html',
						$html,
						$post_thumbnail_id ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
				}
                    if (!$attachment_ids && has_post_thumbnail()) {
	                    echo "<div class='carousel-cell'>" . sprintf( '<img src="%s" alt="%s" class="wp-post-image" />',
			                    get_the_post_thumbnail_url(),
			                    get_the_title() ) . "</div>"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    }
				if (!$attachment_ids && !has_post_thumbnail()) {
					echo "<div class='carousel-cell'>" . sprintf( '<img src="%s" alt="%s" class="wp-post-image" />',
							wc_placeholder_img_src('woocommerce_get_image_size_single'),
							get_the_title() ) . "</div>"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
            </div>
        </div>
    </figure>
</div>
