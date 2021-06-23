<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Shoppe
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
	wp_body_open();
} else {
	do_action( 'wp_body_open' );
}
?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'shoppe' ); ?></a>
<header class="c-header">
    <?php shoppe_header_image(); ?>
    <div class="o-container--half-padding">
        <div class="c-header__grid">
            <div class="o-grid-middle">
                <div class="o-col-6_md-3">
                    <div class="c-header__branding s-header-branding">
						<?php do_action( 'shoppe_branding_hook' ); ?>
                    </div>
                </div>
                <div class="o-col-6_md-9">
                    <div class="c-header__nav js-header-nav">
						<?php do_action( 'shoppe_header_hook' ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="o-popup js-popup">
    <button aria-label="<?php esc_attr_e('Close popup', 'shoppe'); ?>" class="o-popup__close js-popup-close">
        <svg class="o-popup__close__icon" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path d="M205.657 194.343a8 8 0 1 1-11.314 11.314L128 139.313l-66.343 66.344a8 8 0 0 1-11.314-11.314L116.687 128L50.343 61.657a8 8 0 0 1 11.314-11.314L128 116.687l66.343-66.344a8 8 0 0 1 11.314 11.314L139.313 128z" /></svg>
    </button>
    <div class="o-popup__main">
	    <?php get_search_form(); ?>
    </div>
</div>
