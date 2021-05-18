<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Shoppe
 */

if ( ! is_active_sidebar( 'sidebar-1' ) && ! is_active_sidebar( 'sidebar-2' ) ) {
	return;
}

if ( shoppe_is_woocommerce_activated() && is_woocommerce() ) :

    if (get_theme_mod('shop_layout', 'left') != 'center') :
	?>

    <aside id="secondary" class="o-sidebar o-sidebar--shop <?php echo esc_attr("o-sidebar--") . esc_attr(get_theme_mod('shop_layout', 'left')); ?>">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
    </aside><!-- #secondary -->

<?php
    endif;
else:
	if (get_theme_mod('blog_layout', 'left') != 'center') :
		?>

    <aside id="secondary" class="o-sidebar <?php echo esc_attr("o-sidebar--")  . esc_attr(get_theme_mod('blog_layout', 'left')); ?>">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
    </aside><!-- #secondary -->

<?php
	endif;
endif;
