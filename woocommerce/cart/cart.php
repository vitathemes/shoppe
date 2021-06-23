<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<div class="o-grid o-grid--larger-gap">
    <div class="o-col-12_md-6">
        <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
			<?php do_action( 'woocommerce_before_cart_table' ); ?>

            <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                <thead>
                <tr>
                    <th class="product-thumbnail">&nbsp;</th>
                    <th class="product-name"><span class="screen-reader-text"><?php esc_html_e( 'Product',
								'shoppe' ); ?></span></th>
                    <th class="product-quantity"><span class="screen-reader-text"><?php esc_html_e( 'Quantity',
								'shoppe' ); ?></span></th>
                    <th class="product-remove">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
				<?php do_action( 'woocommerce_before_cart_contents' ); ?>

				<?php
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
					$_product   = apply_filters( 'woocommerce_cart_item_product',
						$cart_item['data'],
						$cart_item,
						$cart_item_key );
					$product_id = apply_filters( 'woocommerce_cart_item_product_id',
						$cart_item['product_id'],
						$cart_item,
						$cart_item_key );

					if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible',
							true,
							$cart_item,
							$cart_item_key ) ) {
						$product_permalink = apply_filters( 'woocommerce_cart_item_permalink',
							$_product->is_visible() ? $_product->get_permalink( $cart_item ) : '',
							$cart_item,
							$cart_item_key );
						?>
                        <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class',
							'cart_item',
							$cart_item,
							$cart_item_key ) ); ?>">

                            <td class="product-thumbnail">
								<?php
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail',
									$_product->get_image(),
									$cart_item,
									$cart_item_key );

								if ( ! $product_permalink ) {
									echo $thumbnail; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								} else {
									printf( '<a href="%s">%s</a>',
										esc_url( $product_permalink ),
										$thumbnail ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								}
								?>
                            </td>

                            <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'shoppe' ); ?>">
								<?php
								if ( ! $product_permalink ) {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name',
											$_product->get_name(),
											$cart_item,
											$cart_item_key ) . '&nbsp;' );
								} else {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name',
										sprintf( '<a class="product-link" href="%s">%s</a>',
											esc_url( $product_permalink ),
											$_product->get_name() ),
										$cart_item,
										$cart_item_key ) );
								}

								do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

								// Meta data.
								echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

								// Backorder notification.
								if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
									echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification',
										'<p class="backorder_notification">' . esc_html__( 'Available on backorder',
											'shoppe' ) . '</p>',
										$product_id ) );
								}
								?>
                                <span class="product-price" data-title="<?php esc_attr_e( 'Price', 'shoppe' ); ?>"><?php
									echo apply_filters( 'woocommerce_cart_item_price',
										WC()->cart->get_product_price( $_product ),
										$cart_item,
										$cart_item_key ); // phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped
									?></span>
                            </td>

                            <td class="product-quantity" data-title="<?php esc_attr_e( 'Quantity', 'shoppe' ); ?>">
								<?php
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />',
										$cart_item_key );
								} else {
									$product_quantity = woocommerce_quantity_input(
										array(
											'input_name'   => "cart[{$cart_item_key}][qty]",
											'input_value'  => $cart_item['quantity'],
											'max_value'    => $_product->get_max_purchase_quantity(),
											'min_value'    => '0',
											'product_name' => $_product->get_name(),
										),
										$_product,
										false
									);
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity,$cart_item_key,$cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								?>
                            </td>

                            <td class="product-remove">
								<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><svg class="o-popup__close__icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path d="M205.657 194.343a8 8 0 1 1-11.314 11.314L128 139.313l-66.343 66.344a8 8 0 0 1-11.314-11.314L116.687 128L50.343 61.657a8 8 0 0 1 11.314-11.314L128 116.687l66.343-66.344a8 8 0 0 1 11.314 11.314L139.313 128z" /></svg></a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										esc_html__( 'Remove this item', 'shoppe' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
								?>
                            </td>
                        </tr>
						<?php
					}
				}
				?>

				<?php do_action( 'woocommerce_cart_contents' ); ?>

                <tr>
                    <td colspan="6" class="actions">
                        <button type="submit" class="button update-card-btn" name="update_cart" value="<?php esc_attr_e( 'Update cart',
							'shoppe' ); ?>"><?php esc_html_e( 'Update cart', 'shoppe' ); ?></button>
						<?php if ( wc_coupons_enabled() ) { ?>
                            <div class="coupon">
                                <label for="coupon_code"><?php esc_html_e( 'Coupon:', 'shoppe' ); ?></label>
                                <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code',
									'shoppe' ); ?>"/>
                                <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon',
									'shoppe' ); ?>"><?php esc_html_e( 'Apply coupon', 'shoppe' ); ?></button>
								<?php do_action( 'woocommerce_cart_coupon' ); ?>
                            </div>
						<?php } ?>

						<?php do_action( 'woocommerce_cart_actions' ); ?>

						<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                    </td>
                </tr>

				<?php do_action( 'woocommerce_after_cart_contents' ); ?>
                </tbody>
            </table>
			<?php do_action( 'woocommerce_after_cart_table' ); ?>
        </form>
    </div>
	<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>
    <div class="o-col-12_md-6" data-sticky-container>
        <div class="cart-collaterals js-cart-total" data-sticky data-margin-top="40">
			<?php
			/**
			 * Cart collaterals hook.
			 *
			 * @hooked woocommerce_cross_sell_display
			 * @hooked woocommerce_cart_totals - 10
			 */
			do_action( 'woocommerce_cart_collaterals' );
			?>
        </div>
    </div>
</div>
<?php do_action( 'woocommerce_after_cart' ); ?>
