<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Shoppe
 */

get_header();
?>

    <main id="primary" class="o-page o-page--404">
        <div class="o-container">
            <div class="o-page__main">

                <section class="error-404 not-found">
                    <div class="o-grid-center">
                        <div class="o-col-12_md-5">
                            <header class="page-header">
                                <span style="font-size: 3rem;"><?php esc_html_e('404 ERROR', 'shoppe') ?></span>
                                <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.',
										'shoppe' ); ?></h1>
                            </header><!-- .page-header -->

                            <div class="page-content">
                                <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?',
										'shoppe' ); ?></p>

                                <p style="margin: 3rem 0 4rem;">
                                    <a href="<?php echo esc_url(home_url()); ?>" class="c-btn c-btn--primary c-btn--ghost c-btn--lg"><?php esc_html_e('Homepage', 'shoppe') ?></a>
                                </p>

                                <div class="o-grid-center">
                                    <div class="o-col-12_md-8">
                                        <div class="c-widget widget_search">
											<?php get_search_form(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- .page-content -->
                </section><!-- .error-404 -->
            </div>
        </div>
    </main><!-- #main -->

<?php
get_footer();
