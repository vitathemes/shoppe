<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>
    <main id="primary" class="o-page">
        <div class="o-container">
            <header class="woocommerce-products-header">
				<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                    <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
				<?php endif; ?>

				<?php
				/**
				 * Hook: woocommerce_archive_description.
				 *
				 * @hooked woocommerce_taxonomy_archive_description - 10
				 * @hooked woocommerce_product_archive_description - 10
				 */
				do_action( 'woocommerce_archive_description' );
				?>
            </header>
			<?php if ( get_theme_mod( 'show_mobile_filters', true ) ): ?>
                <div class="o-sidebar o-sidebar--product-filters">
                    <button onclick="openFiltersPopup()" class="o-popup-btn">
                        <svg class="o-popup-btn__icon" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" width="1.4em" height="1.4em" style="-ms-transform: rotate(-90deg); -webkit-transform: rotate(-90deg); transform: rotate(-90deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                            <path d="M133.999 62.706V40a6 6 0 1 0-12 0v22.706a25.994 25.994 0 0 0 0 50.587V216a6 6 0 0 0 12 0V113.293a25.994 25.994 0 0 0 0-50.587zm-6 39.294a14 14 0 1 1 14-14a14.016 14.016 0 0 1-14 14zm98 66a26.04 26.04 0 0 0-20-25.294L206 40a6 6 0 1 0-12 0l-.001 102.706a25.994 25.994 0 0 0 0 50.587L194 216a6 6 0 0 0 12 0l-.001-22.707a26.04 26.04 0 0 0 20-25.293zm-26 14a14 14 0 1 1 14-14a14.016 14.016 0 0 1-14 14zm-138-71.294V40a6 6 0 0 0-12 0v70.706a25.994 25.994 0 0 0 0 50.587V216a6 6 0 0 0 5.999 6a6 6 0 0 0 6-6L62 161.293a25.994 25.994 0 0 0 0-50.587zm-6 39.294a14 14 0 1 1 14-14a14.016 14.016 0 0 1-14 14z"/>
                            <rect x="0" y="0" width="256" height="256" fill="rgba(0, 0, 0, 0)"/>
                        </svg>
						<?php esc_html_e( 'Filters', 'shoppe' ); ?>
                    </button>
                    <div class="o-popup o-popup--filters js-popup-filters">
                        <button onclick="closeFiltersPopup()" aria-label="<?php esc_attr_e( 'Close popup',
							'shoppe' ); ?>" class="o-popup__close js-popup-close">
                            <svg class="o-popup__close__icon" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
                                <path d="M205.657 194.343a8 8 0 1 1-11.314 11.314L128 139.313l-66.343 66.344a8 8 0 0 1-11.314-11.314L116.687 128L50.343 61.657a8 8 0 0 1 11.314-11.314L128 116.687l66.343-66.344a8 8 0 0 1 11.314 11.314L139.313 128z"/>
                            </svg>
                        </button>
                        <div class="c-filters s-filters">
	                        <?php dynamic_sidebar( 'sidebar-2' ); ?>
                        </div>
                    </div>
                </div>
			<?php endif; ?>
            <div class="<?php echo esc_attr( shoppe_page_classes_layout() ); ?>">

				<?php
				if ( shoppe_has_sidebar() ) {
					get_sidebar();
				} ?>
                <div class="o-page__main">
					<?php
					if ( woocommerce_product_loop() ) {

						/**
						 * Hook: woocommerce_before_shop_loop.
						 *
						 * @hooked woocommerce_output_all_notices - 10
						 * @hooked woocommerce_result_count - 20
						 * @hooked woocommerce_catalog_ordering - 30
						 */
						do_action( 'woocommerce_before_shop_loop' );

						woocommerce_product_loop_start();

						if ( wc_get_loop_prop( 'total' ) ) {
							while ( have_posts() ) {
								the_post();

								/**
								 * Hook: woocommerce_shop_loop.
								 */
								do_action( 'woocommerce_shop_loop' );

								wc_get_template_part( 'content', 'product' );
							}
						}

						woocommerce_product_loop_end();

						/**
						 * Hook: woocommerce_after_shop_loop.
						 *
						 * @hooked woocommerce_pagination - 10
						 */
						do_action( 'woocommerce_after_shop_loop' );
					} else {
						/**
						 * Hook: woocommerce_no_products_found.
						 *
						 * @hooked wc_no_products_found - 10
						 */
						do_action( 'woocommerce_no_products_found' );
					}

					/**
					 * Hook: woocommerce_after_main_content.
					 *
					 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
					 */
					do_action( 'woocommerce_after_main_content' );

					/**
					 * Hook: woocommerce_sidebar.
					 *
					 * @hooked woocommerce_get_sidebar - 10
					 */
					do_action( 'woocommerce_sidebar' );

					?>
                </div>
            </div>
        </div>
    </main><!-- #main -->

<?php
get_footer( 'shop' );
