<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>

<form role="search" method="get" class="c-search-form search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="c-search-form__label">
        <span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'shoppe' ); ?></span>
        <input type="search" class="c-search-form__label__field search-field" placeholder="Search …" value="<?php echo get_search_query(); ?>" name="s">
    </label>
    <input type="hidden" name="post_type" value="product"/>
    <button aria-label="Submit" class="c-search-form__submit" type="submit">
        <svg class="c-search-form__submit__icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256">
            <path d="M229.651 218.344l-43.222-43.223a92.112 92.112 0 1 0-11.315 11.314l43.223 43.223a8 8 0 1 0 11.314-11.314zM40 116a76 76 0 1 1 76 76a76.086 76.086 0 0 1-76-76z"/>
        </svg>
    </button>
</form>
