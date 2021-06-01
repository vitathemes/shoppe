<?php
/**
 * Shoppe functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Shoppe
 */

if ( ! defined( 'THEME_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'THEME_VERSION', '1.0.0' );
}

if ( ! function_exists( 'shoppe_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function shoppe_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Shoppe, use a find and replace
		 * to change 'shoppe' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'shoppe', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => __( 'Header Menu', 'shoppe' ),
		) );


		/*
		 * Add image sizes
		 */
		add_image_size( "shoppe_thumbnail_square_mobile", 140, 140, true );
		add_image_size( "shoppe_thumbnail_square", 380, 380, true );
		add_image_size( "shoppe_thumbnail_blog", 450, 300, true );
		add_image_size( "shoppe_thumbnail_single", 700, 600, false );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'shoppe_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 25,
				'width'       => 150,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		/**
		* WooCommerce Support
		 */
		add_theme_support( 'woocommerce' );
	}
endif;
add_action( 'after_setup_theme', 'shoppe_setup' );

/**
 * Check if WooCommerce is activated
 */
if ( ! function_exists( 'shoppe_is_woocommerce_activated' ) ) {
	function shoppe_is_woocommerce_activated() {
		if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
	}
}

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function shoppe_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'shoppe_content_width', 1248 );
}
add_action( 'after_setup_theme', 'shoppe_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function shoppe_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Sidebar', 'shoppe' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'shoppe' ),
			'before_widget' => '<section id="%1$s" class="c-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="c-widget__title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Shop Sidebar', 'shoppe' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Add widgets here.', 'shoppe' ),
			'before_widget' => '<section id="%1$s" class="c-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="c-widget__title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Sidebar - Left', 'shoppe' ),
			'id'            => 'sidebar-3',
			'description'   => esc_html__( 'Add widgets here.', 'shoppe' ),
			'before_widget' => '<section id="%1$s" class="c-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="c-widget__title">',
			'after_title'   => '</h3>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer sidebar - Right', 'shoppe' ),
			'id'            => 'sidebar-4',
			'description'   => esc_html__( 'Add widgets here.', 'shoppe' ),
			'before_widget' => '<section id="%1$s" class="c-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="c-widget__title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'shoppe_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function shoppe_scripts() {
	if ( ! shoppe_is_woocommerce_activated()) {
		wp_enqueue_style( 'shoppe-style',
			get_template_directory_uri() . '/assets/css/main.css',
			array(),
			THEME_VERSION );
		wp_style_add_data( 'shoppe-style', 'rtl', 'replace' );
	} else {
		wp_enqueue_style( 'shoppe-style', get_template_directory_uri() . '/assets/css/main-woocommerce.css', array(), THEME_VERSION );
		wp_enqueue_script( 'flickity-main-scripts','https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js', array(), THEME_VERSION, true );
	}

	wp_enqueue_script( 'shoppe-vendor-scripts', get_template_directory_uri() . '/assets/js/vendor.min.js', array(), THEME_VERSION, true );
	wp_enqueue_script( 'shoppe-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), THEME_VERSION, true );
	wp_enqueue_script( 'shoppe-main-scripts', get_template_directory_uri() . '/assets/js/main.js', array('shoppe-vendor-scripts'), THEME_VERSION, true );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}


}
add_action( 'wp_enqueue_scripts', 'shoppe_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';


/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Comments walker
 */
require get_template_directory() . '/classes/class_shoppe_walker_comment.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce Files
 */
if ( shoppe_is_woocommerce_activated() ) {
	require get_template_directory() . '/inc/woocommerce/setup.php';
}

/**
 * Load TGMPA file
 */
require_once get_template_directory() . '/inc/tgmpa/class-tgm-plugin-activation.php';
require_once get_template_directory() . '/inc/tgmpa-config.php';
