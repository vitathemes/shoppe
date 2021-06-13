<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Shoppe
 */

?>

<footer class="c-footer">
    <div class="o-container--half-padding">
        <div class="o-grid">
            <div class="o-col-12">
                <div class="c-footer__main">
                    <div class="o-grid-spaceBetween">
                        <div class="o-col-12_md-6_lg-5">
                            <div class="c-footer__widget s-footer-widgets">
								<?php dynamic_sidebar( 'sidebar-3' ); ?>
                            </div>
                        </div>
                        <div class="o-col-12_md-6_lg-5">
                            <div class="c-footer__widget s-footer-widgets">
								<?php dynamic_sidebar( 'sidebar-4' ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer><!-- #colophon -->


<?php wp_footer(); ?>

</body>
</html>
