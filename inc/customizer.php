<?php
/**
 * Shoppe Theme Customizer
 *
 * @package Shoppe
 */

function wp_meliora_enqueue_customizer_style( $hook_suffix ) {
	// Load your css.
	wp_register_style( 'kirki-styles-css',
		get_template_directory_uri() . '/assets//css/kirki-controls-style.css',
		false,
		'1.0.0' );
	wp_enqueue_style( 'kirki-styles-css' );
}

add_action( 'admin_enqueue_scripts', 'wp_meliora_enqueue_customizer_style' );


/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function shoppe_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'refresh';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'shoppe_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'shoppe_customize_partial_blogdescription',
			)
		);
	}
}

add_action( 'customize_register', 'shoppe_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function shoppe_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function shoppe_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function shoppe_customize_preview_js() {
	wp_enqueue_script( 'shoppe-customizer',
		get_template_directory_uri() . '/js/customizer.js',
		array( 'customize-preview' ),
		THEME_VERSION,
		true );
}

add_action( 'customize_preview_init', 'shoppe_customize_preview_js' );


/**
 * Custom theme customizer
 *
 * If the Kirki customizer framework is not enabled, these controls won't show up.
 */
if ( function_exists( 'Kirki' ) ) {
	add_action( 'init',
		function () {
			// Disable Kiriki help notice
			add_filter( 'kirki_telemetry', '__return_false' );


			// Add config
			Kirki::add_config( 'shoppe',
				array(
					'option_type' => 'theme_mod',
				) );

			// Add Panels
			Kirki::add_panel( 'elements',
				array(
					'priority'    => 10,
					'title'       => esc_html__( 'Elements', 'shoppe' ),
					'description' => esc_html__( 'Elements', 'shoppe' ),
				) );

// Add sections \\
// <editor-fold desc="Sections">


			// Header
			Kirki::add_section( 'header',
				array(
					'title'    => esc_html__( 'Header', 'shoppe' ),
					'panel'    => '',
					'priority' => 1,
				) );


// Branding
			Kirki::add_section( 'colors',
				array(
					'title'    => esc_html__( 'Colors', 'shoppe' ),
					'panel'    => '',
					'priority' => 3,
				) );


// Home Page
			Kirki::add_section( 'homepage',
				array(
					'title'    => esc_html__( 'Homepage', 'shoppe' ),
					'panel'    => '',
					'priority' => 4,
				) );

// Typography
			Kirki::add_section( 'typography',
				array(
					'title'      => esc_html__( 'Typography', 'shoppe' ),
					'panel'      => '',
					'priority'   => 4,
					'capability' => 'edit_theme_options',
				) );

// Account
			Kirki::add_section( 'account',
				array(
					'title'      => esc_html__( 'Account', 'shoppe' ),
					'panel'      => 'woocommerce',
					'priority'   => 4,
					'capability' => 'edit_theme_options',
				) );

// Elements
			Kirki::add_section( 'layout',
				array(
					'title'    => esc_html__( 'Layout', 'shoppe' ),
					'panel'    => '',
					'priority' => 3,
				) );

			// Posts
			Kirki::add_section( 'single_opts',
				array(
					'title'    => esc_html__( 'Single Options', 'shoppe' ),
					'panel'    => 'elements',
					'priority' => 6,
				) );

			Kirki::add_section( 'archive_opts',
				array(
					'title'    => esc_html__( 'Archive Options', 'shoppe' ),
					'panel'    => 'elements',
					'priority' => 6,
				) );

			Kirki::add_section( 'prod_single_opts',
				array(
					'title'    => esc_html__( 'Products Single Options', 'shoppe' ),
					'panel'    => 'elements',
					'priority' => 6,
				) );

			Kirki::add_section( 'prod_archive_opts',
				array(
					'title'    => esc_html__( 'Products Archive Options', 'shoppe' ),
					'panel'    => 'elements',
					'priority' => 6,
				) );

// </editor-fold>


// Header
			Kirki::add_field( 'shoppe',
				[
					'type'     => 'toggle',
					'settings' => 'search_header',
					'label'    => esc_html__( 'Display Search', 'shoppe' ),
					'section'  => 'header',
					'default'  => 1,
					'priority' => 10,
				] );

			if ( shoppe_is_woocommerce_activated() ) {
				Kirki::add_field( 'shoppe',
					[
						'type'     => 'toggle',
						'settings' => 'cart_header',
						'label'    => esc_html__( 'Display Cart', 'shoppe' ),
						'section'  => 'header',
						'default'  => 1,
						'priority' => 10,
					] );

				Kirki::add_field( 'shoppe',
					[
						'type'     => 'toggle',
						'settings' => 'profile_header',
						'label'    => esc_html__( 'Display Profile', 'shoppe' ),
						'section'  => 'header',
						'default'  => 1,
						'priority' => 10,
					] );
			}

// Header
			// -- Typography Fields --
			// <editor-fold desc="Typography">
			Kirki::add_field( 'shoppe',
				[
					'type'     => 'toggle',
					'settings' => 'use_google_fonts',
					'label'    => esc_html__( 'Use google Fonts', 'shoppe' ),
					'section'  => 'typography',
					'default'  => 1,
					'priority' => 10,
				] );

			Kirki::add_field( 'shoppe',
				[
					'active_callback' => [
						[
							'setting'  => 'use_google_fonts',
							'operator' => '==',
							'value'    => true,
						],
					],
					'type'            => 'typography',
					'settings'        => 'text_typography',
					'label'           => esc_html__( 'Base font', 'shoppe' ),
					'section'         => 'typography',
					'default'         => [
						'font-family'    => 'DM Sans',
						'variant'        => '400',
						'font-size'      => '16px',
						'line-height'    => '1.5',
						'letter-spacing' => '0'
						//'color'       => '#000',
					],
					'choices'         => [
						'fonts' => [
							'standard' => [
								'Arial',
								'sans-serif',
								'sans',
								'Helvetica',
								'Verdana',
								'Trebuchet',
								'Georgia',
								'Times New Roman',
								'Palatino',
								'Myriad Pro',
								'Lucida',
								'Gill Sans',
								'Impact',
								'monospace',
								'Tahoma',
							],
						],
					],
					'transport'       => 'auto',
					'priority'        => 10,
					'output'          => array(
						array(
							'element' => 'html',
						),
					),
				] );

			Kirki::add_field( 'shoppe',
				[
					'active_callback' => [
						[
							'setting'  => 'use_google_fonts',
							'operator' => '==',
							'value'    => true,
						],
					],
					'type'            => 'typography',
					'settings'        => 'typography_h1',
					'label'           => esc_html__( 'H1', 'shoppe' ),
					'section'         => 'typography',
					'default'         => [
						'font-family'    => 'DM Sans',
						'font-size'      => '33px',
						'font-weight'    => '500',
						'line-height'    => '1.5',
						'letter-spacing' => '0',
					],
					'choices'         => [
						'fonts' => [
							'standard' => [
								'Arial',
								'sans-serif',
								'sans',
								'Helvetica',
								'Verdana',
								'Trebuchet',
								'Georgia',
								'Times New Roman',
								'Palatino',
								'Myriad Pro',
								'Lucida',
								'Gill Sans',
								'Impact',
								'monospace',
								'Tahoma',
							],
						],
					],
					'transport'       => 'auto',
					'priority'        => 10,
					'output'          => array(
						array(
							'element' => array( 'h1', '.h1' ),
						),
					),
				] );

			Kirki::add_field( 'shoppe',
				[
					'active_callback' => [
						[
							'setting'  => 'use_google_fonts',
							'operator' => '==',
							'value'    => true,
						],
					],
					'type'            => 'typography',
					'settings'        => 'typography_h2',
					'label'           => esc_html__( 'H2', 'shoppe' ),
					'section'         => 'typography',
					'default'         => [
						'font-family'    => 'DM Sans',
						'font-size'      => '26px',
						'font-weight'    => '400',
						'line-height'    => '1.5',
						'letter-spacing' => '0',
					],
					'choices'         => [
						'fonts' => [
							'standard' => [
								'Arial',
								'sans-serif',
								'sans',
								'Helvetica',
								'Verdana',
								'Trebuchet',
								'Georgia',
								'Times New Roman',
								'Palatino',
								'Myriad Pro',
								'Lucida',
								'Gill Sans',
								'Impact',
								'monospace',
								'Tahoma',
							],
						],
					],
					'transport'       => 'auto',
					'priority'        => 10,
					'output'          => array(
						array(
							'element' => array( 'h2', '.h2' ),
						),
					),
				] );

			Kirki::add_field( 'shoppe',
				[
					'active_callback' => [
						[
							'setting'  => 'use_google_fonts',
							'operator' => '==',
							'value'    => true,
						],
					],
					'type'            => 'typography',
					'settings'        => 'typography_h3',
					'label'           => esc_html__( 'H3', 'shoppe' ),
					'section'         => 'typography',
					'default'         => [
						'font-family'    => 'DM Sans',
						'font-size'      => '20px',
						'font-weight'    => '400',
						'line-height'    => '1.5',
						'letter-spacing' => '0',
					],
					'choices'         => [
						'fonts' => [
							'standard' => [
								'Arial',
								'sans-serif',
								'sans',
								'Helvetica',
								'Verdana',
								'Trebuchet',
								'Georgia',
								'Times New Roman',
								'Palatino',
								'Myriad Pro',
								'Lucida',
								'Gill Sans',
								'Impact',
								'monospace',
								'Tahoma',
							],
						],
					],
					'transport'       => 'auto',
					'priority'        => 10,
					'output'          => array(
						array(
							'element' => array( 'h3', '.h3' ),
						),
					),
				] );

			Kirki::add_field( 'shoppe',
				[
					'active_callback' => [
						[
							'setting'  => 'use_google_fonts',
							'operator' => '==',
							'value'    => true,
						],
					],
					'type'            => 'typography',
					'settings'        => 'typography_h4',
					'label'           => esc_html__( 'H4', 'shoppe' ),
					'section'         => 'typography',
					'default'         => [
						'font-family'    => 'DM Sans',
						'font-size'      => '20px',
						'font-weight'    => '500',
						'line-height'    => '1.5',
						'letter-spacing' => '0',
					],
					'choices'         => [
						'fonts' => [
							'standard' => [
								'Arial',
								'sans-serif',
								'sans',
								'Helvetica',
								'Verdana',
								'Trebuchet',
								'Georgia',
								'Times New Roman',
								'Palatino',
								'Myriad Pro',
								'Lucida',
								'Gill Sans',
								'Impact',
								'monospace',
								'Tahoma',
							],
						],
					],
					'transport'       => 'auto',
					'priority'        => 10,
					'output'          => array(
						array(
							'element' => array( 'h4', '.h4' ),
						),
					),
				] );

			Kirki::add_field( 'shoppe',
				[
					'active_callback' => [
						[
							'setting'  => 'use_google_fonts',
							'operator' => '==',
							'value'    => true,
						],
					],
					'type'            => 'typography',
					'settings'        => 'typography_h5',
					'label'           => esc_html__( 'H5', 'shoppe' ),
					'section'         => 'typography',
					'default'         => [
						'font-family'    => 'DM Sans',
						'font-size'      => '16px',
						'font-weight'    => '400',
						'line-height'    => '1.5',
						'letter-spacing' => '0',
					],
					'choices'         => [
						'fonts' => [
							'standard' => [
								'Arial',
								'sans-serif',
								'sans',
								'Helvetica',
								'Verdana',
								'Trebuchet',
								'Georgia',
								'Times New Roman',
								'Palatino',
								'Myriad Pro',
								'Lucida',
								'Gill Sans',
								'Impact',
								'monospace',
								'Tahoma',
							],
						],
					],
					'transport'       => 'auto',
					'priority'        => 10,
					'output'          => array(
						array(
							'element' => array( 'h5', '.h5' ),
						),
					),
				] );

			Kirki::add_field( 'shoppe',
				[
					'active_callback' => [
						[
							'setting'  => 'use_google_fonts',
							'operator' => '==',
							'value'    => true,
						],
					],
					'type'            => 'typography',
					'settings'        => 'typography_h6',
					'label'           => esc_html__( 'H6', 'shoppe' ),
					'section'         => 'typography',
					'default'         => [
						'font-family'    => 'DM Sans',
						'font-size'      => '16px',
						'font-weight'    => '500',
						'line-height'    => '1.5',
						'letter-spacing' => '0',
					],
					'choices'         => [
						'fonts' => [
							'standard' => [
								'Arial',
								'sans-serif',
								'sans',
								'Helvetica',
								'Verdana',
								'Trebuchet',
								'Georgia',
								'Times New Roman',
								'Palatino',
								'Myriad Pro',
								'Lucida',
								'Gill Sans',
								'Impact',
								'monospace',
								'Tahoma',
							],
						],
					],
					'transport'       => 'auto',
					'priority'        => 10,
					'output'          => array(
						array(
							'element' => array( 'h6', '.h6' ),
						),
					),
				] );


			Kirki::add_field( 'shoppe',
				[
					'active_callback' => [
						[
							'setting'  => 'use_google_fonts',
							'operator' => '==',
							'value'    => true,
						],
					],
					'type'            => 'typography',
					'settings'        => 'buttons_typography',
					'label'           => esc_html__( 'Buttons', 'shoppe' ),
					'section'         => 'typography',
					'default'         => [
						'font-family'    => 'DM Sans',
						'variant'        => '700',
						'font-size'      => '16px',
						'line-height'    => '1.5',
						'letter-spacing' => '0',
						//	'color'          => '#000',
					],
					'choices'         => [
						'fonts' => [
							'standard' => [
								'Arial',
								'sans-serif',
								'sans',
								'Helvetica',
								'Verdana',
								'Trebuchet',
								'Georgia',
								'Times New Roman',
								'Palatino',
								'Myriad Pro',
								'Lucida',
								'Gill Sans',
								'Impact',
								'monospace',
								'Tahoma',
							],
						],
					],
					'transport'       => 'auto',
					'priority'        => 10,
					'output'          => array(
						array(
							'element' => '.c-btn, .button, .woocommerce div.product form.cart .button, #add_payment_method .wc-proceed-to-checkout a.checkout-button, .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, .woocommerce-checkout .wc-proceed-to-checkout a.checkout-button, .woocommerce button.button.alt.c-btn, .woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .c-account .c-account__login-form .c-account__btn, .c-account .c-account__register-form .c-account__btn, .c-account .c-account__reset-password .c-account__btn',
						),

					),
				] );
// </editor-fold>
			// -- Typography Fields --

// <editor-fold desc="colors">

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'color',
					'settings' => 'color_primary_color',
					'label'    => __( 'Primary Color', 'shoppe' ),
					'section'  => 'colors',
					'default'  => '#A18A68',
				] );

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'color',
					'settings' => 'color_1',
					'label'    => __( 'Primary Texts Color', 'shoppe' ),
					'section'  => 'colors',
					'default'  => '#000000',
				] );

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'color',
					'settings' => 'color_2',
					'label'    => __( 'Secondary Texts Color', 'shoppe' ),
					'section'  => 'colors',
					'default'  => '#707070',
				] );

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'color',
					'settings' => 'color_3',
					'label'    => __( 'Borders', 'shoppe' ),
					'section'  => 'colors',
					'default'  => '#D8D8D8',
				] );

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'color',
					'settings' => 'color_4',
					'label'    => __( 'Inputs', 'shoppe' ),
					'section'  => 'colors',
					'default'  => '#EFEFEF',
				] );

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'color',
					'settings' => 'color_5',
					'label'    => __( 'Order Dialog Background', 'shoppe' ),
					'section'  => 'colors',
					'default'  => '#F9F9F9',
				] );

// </editor-fold>

			// -- Layout Fields --
// <editor-fold desc="colors">

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'radio-image',
					'settings' => 'blog_layout',
					'label'    => __( 'Blog Layout', 'shoppe' ),
					'section'  => 'layout',
					'default'  => 'left',
					'priority' => 10,
					'choices'  => [
						'left'   => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqAgMAAAAjP0ATAAAACVBMVEX///8+yP/V1dXG9YqxAAAAWElEQVR42mNgGAXDE4RCQMDAKONaBQINWqtWrWBatQDIaxg8ygYqQIAOYwC6bwHUmYNH2eBPSMhgBQXKRr0w6oVRL4x6YdQLo14Y9cKoF0a9QCO3jYLhBADvmFlNY69qsQAAAABJRU5ErkJggg==',
						'center' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqAQMAAABknzrDAAAABlBMVEX////V1dXUdjOkAAAAPUlEQVRIx2NgGAUkAcb////Y/+d/+P8AdcQoc8vhH/X/5P+j2kG+GA3CCgrwi43aMWrHqB2jdowEO4YpAACyKSE0IzIuBgAAAABJRU5ErkJggg==',
						'right'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqAgMAAAAjP0ATAAAACVBMVEX///8+yP/V1dXG9YqxAAAAWUlEQVR42mNgGAUjB4iGgkEIzZStAoEVTECiQWsVkLdiECkboAABOmwBF9BtUGcOImUDEiCkJCQU0ECBslEvjHph1AujXhj1wqgXRr0w6oVRLwyEF0bBUAUAz/FTNXm+R/MAAAAASUVORK5CYII=',
					],
				] );

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'radio-image',
					'settings' => 'shop_layout',
					'label'    => __( 'Shop Layout', 'shoppe' ),
					'section'  => 'layout',
					'default'  => 'left',
					'priority' => 10,
					'choices'  => [
						'left'   => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqAgMAAAAjP0ATAAAACVBMVEX///8+yP/V1dXG9YqxAAAAWElEQVR42mNgGAXDE4RCQMDAKONaBQINWqtWrWBatQDIaxg8ygYqQIAOYwC6bwHUmYNH2eBPSMhgBQXKRr0w6oVRL4x6YdQLo14Y9cKoF0a9QCO3jYLhBADvmFlNY69qsQAAAABJRU5ErkJggg==',
						'center' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqAQMAAABknzrDAAAABlBMVEX////V1dXUdjOkAAAAPUlEQVRIx2NgGAUkAcb////Y/+d/+P8AdcQoc8vhH/X/5P+j2kG+GA3CCgrwi43aMWrHqB2jdowEO4YpAACyKSE0IzIuBgAAAABJRU5ErkJggg==',
						'right'  => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqAgMAAAAjP0ATAAAACVBMVEX///8+yP/V1dXG9YqxAAAAWUlEQVR42mNgGAUjB4iGgkEIzZStAoEVTECiQWsVkLdiECkboAABOmwBF9BtUGcOImUDEiCkJCQU0ECBslEvjHph1AujXhj1wqgXRr0w6oVRLwyEF0bBUAUAz/FTNXm+R/MAAAAASUVORK5CYII=',
					],
				] );

// </editor-fold>

			// Posts
			Kirki::add_field( 'shoppe',
				[
					'type'     => 'toggle',
					'settings' => 'show_posts_thumbnail_archive',
					'label'    => esc_html__( 'Show posts thumbnail', 'shoppe' ),
					'section'  => 'archive_opts',
					'default'  => 0,
					'priority' => 10,
				] );

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'toggle',
					'settings' => 'show_posts_thumbnail',
					'label'    => esc_html__( 'Show posts thumbnail', 'shoppe' ),
					'section'  => 'single_opts',
					'default'  => 1,
					'priority' => 10,
				] );

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'toggle',
					'settings' => 'show_share_icons',
					'label'    => esc_html__( 'Show share buttons', 'shoppe' ),
					'section'  => 'single_opts',
					'default'  => 1,
					'priority' => 10,
				] );

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'toggle',
					'settings' => 'show_post_date',
					'label'    => esc_html__( 'Show published date', 'shoppe' ),
					'section'  => 'single_opts',
					'default'  => 1,
					'priority' => 10,
				] );

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'toggle',
					'settings' => 'show_post_author',
					'label'    => esc_html__( 'Show author name', 'shoppe' ),
					'section'  => 'single_opts',
					'default'  => 1,
					'priority' => 10,
				] );

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'toggle',
					'settings' => 'show_post_tags',
					'label'    => esc_html__( 'Show post tags', 'shoppe' ),
					'section'  => 'single_opts',
					'default'  => 1,
					'priority' => 10,
				] );


			Kirki::add_field( 'shoppe',
				[
					'type'     => 'toggle',
					'settings' => 'show_cat_archive',
					'label'    => esc_html__( 'Show categories', 'shoppe' ),
					'section'  => 'archive_opts',
					'default'  => 1,
					'priority' => 10,
				] );

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'toggle',
					'settings' => 'show_date_archive',
					'label'    => esc_html__( 'Show publish date', 'shoppe' ),
					'section'  => 'archive_opts',
					'default'  => 1,
					'priority' => 10,
				] );

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'toggle',
					'settings' => 'show_post_excerpt',
					'label'    => esc_html__( 'Show posts excerpt', 'shoppe' ),
					'section'  => 'archive_opts',
					'default'  => 1,
					'priority' => 10,
				] );

			// Posts

			// Shop
			Kirki::add_field( 'shoppe',
				[
					'type'     => 'toggle',
					'settings' => 'show_mobile_filters',
					'label'    => esc_html__( 'Show Mobile Filters', 'shoppe' ),
					'section'  => 'prod_archive_opts',
					'default'  => 1,
					'priority' => 10,
				] );
			// Shop

			// Secondary Menu
			Kirki::add_field( 'shoppe',
				[
					'type'     => 'toggle',
					'settings' => 'show_slider_menu_index',
					'label'    => esc_html__( 'Show Slider Menu on Home/Blog page', 'shoppe' ),
					'section'  => 'secondary_menu',
					'default'  => 1,
					'priority' => 10,
				] );

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'toggle',
					'settings' => 'show_slider_menu_cats',
					'label'    => esc_html__( 'Show Slider Menu on Category pages', 'shoppe' ),
					'section'  => 'secondary_menu',
					'default'  => 1,
					'priority' => 10,
				] );

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'toggle',
					'settings' => 'show_slider_menu_tags',
					'label'    => esc_html__( 'Show Slider Menu on Tags pages', 'shoppe' ),
					'section'  => 'secondary_menu',
					'default'  => 1,
					'priority' => 10,
				] );

			Kirki::add_field( 'shoppe',
				[
					'type'     => 'toggle',
					'settings' => 'show_slider_menu_author',
					'label'    => esc_html__( 'Show Slider Menu on Author pages', 'shoppe' ),
					'section'  => 'secondary_menu',
					'default'  => 1,
					'priority' => 10,
				] );
			// Slider Menu

			// Account
			Kirki::add_field( 'shoppe', [
				'type'        => 'switch',
				'settings'    => 'account_navigation',
				'label'       => esc_html__( 'Account page navigation', 'shoppe' ),
				'section'     => 'account',
				'default'     => 'on',
				'priority'    => 10,
				'choices'     => [
					'on'  => esc_html__( 'Tabs', 'shoppe' ),
					'off' => esc_html__( 'Sidebar', 'shoppe' ),
				],
			] );
			// Account
		} );


	function wp_indigo_add_edit_icons( $wp_customize ) {
		$wp_customize->selective_refresh->add_partial( 'show_slider_menu_index',
			array(
				'selector' => '.c-categories-list',
			) );

		$wp_customize->selective_refresh->add_partial( 'search_header',
			array(
				'selector' => '.c-header .c-search-form',
			) );

		$wp_customize->selective_refresh->add_partial( 'show_posts_thumbnail',
			array(
				'selector' => '.c-post__thumbnail',
			) );

		$wp_customize->selective_refresh->add_partial( 'show_post_date',
			array(
				'selector' => '.c-post--single .c-post__meta__date',
			) );

		$wp_customize->selective_refresh->add_partial( 'show_post_author',
			array(
				'selector' => '.byline .author',
			) );

		$wp_customize->selective_refresh->add_partial( 'show_share_icons',
			array(
				'selector' => '.c-social-share',
			) );

		$wp_customize->selective_refresh->add_partial( 'show_post_tags',
			array(
				'selector' => '.c-post__footer__tags',
			) );


		$wp_customize->selective_refresh->add_partial( 'show_posts_thumbnail',
			array(
				'selector' => '.c-post__thumbnail--single',
			) );
	}

	add_action( 'customize_preview_init', 'wp_indigo_add_edit_icons' );
}
