<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="c-account c-account--login">
    <div class="c-account__nav">
        <div class="c-account__nav__items">
            <button class="c-account__nav__btn js-account-carousel-btn h3 is-active" onclick="selectCarouselSlide('.js-account-carousel', 0)">Sign In</button>
	        <?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
            <button class="c-account__nav__btn js-account-carousel-btn h3" onclick="selectCarouselSlide('.js-account-carousel', 1)">Register</button>
            <?php endif; ?>
        </div>
    </div>
    <div class="c-account__carousel js-account-carousel" data-flickity='{ "cellAlign": "left", "contain": false, "draggable": false, "pageDots": false, "prevNextButtons": false }'>

		<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

        <div class="c-account__carousel__cell" id="customer_login">

			<?php endif; ?>

            <form class="c-account__login-form woocommerce-form woocommerce-form-login login" method="post">

				<?php do_action( 'woocommerce_login_form_start' ); ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label class="screen-reader-text" for="username"><?php esc_html_e( 'Username or email address',
							'shoppe' ); ?>&nbsp;<span class="required">*</span></label>
                    <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Username or email address',
	                    'shoppe' ); ?>" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                </p>
                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                    <label class="screen-reader-text" for="password"><?php esc_html_e( 'Password',
							'shoppe' ); ?>&nbsp;<span class="required">*</span></label>
                    <input class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Password', 'shoppe' ); ?>" type="password" name="password" id="password" autocomplete="current-password"/>
                </p>

				<?php do_action( 'woocommerce_login_form' ); ?>

                <p class="form-row">
                    <label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
                        <input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever"/>
                        <span><?php esc_html_e( 'Remember me', 'shoppe' ); ?></span>
                    </label>
					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                    <button type="submit" class="c-account__btn woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in',
						'shoppe' ); ?>"><?php esc_html_e( 'Log in', 'shoppe' ); ?></button>
                </p>
                <p class="c-account__forgot-password woocommerce-LostPassword lost_password">
                    <a class="c-account__forgot-password__link" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Have you forgotten your password?',
							'shoppe' ); ?></a>
                </p>

				<?php do_action( 'woocommerce_login_form_end' ); ?>

            </form>
        </div>
		<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>


            <div class="c-account__carousel__cell" id="customer_register">

                <form method="post" class="c-account__register-form woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

					<?php do_action( 'woocommerce_register_form_start' ); ?>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label class="screen-reader-text" for="reg_username"><?php esc_html_e( 'Username',
									'shoppe' ); ?>&nbsp;<span class="required">*</span></label>
                            <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Username',
	                            'shoppe' ); ?>" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                        </p>

					<?php endif; ?>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="reg_email" class="screen-reader-text"><?php esc_html_e( 'Email address',
								'shoppe' ); ?>&nbsp;<span class="required">*</span></label>
                        <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Email address',
	                        'shoppe' ); ?>" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>"/><?php // @codingStandardsIgnoreLine ?>
                    </p>

					<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                            <label class="screen-reader-text" for="reg_password"><?php esc_html_e( 'Password',
									'shoppe' ); ?>&nbsp;<span class="required">*</span></label>
                            <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_attr_e( 'Password',
	                            'shoppe' ); ?>" name="password" id="reg_password" autocomplete="new-password"/>
                        </p>

					<?php else : ?>

                        <p><?php esc_html_e( 'A password will be sent to your email address.', 'shoppe' ); ?></p>

					<?php endif; ?>

					<?php do_action( 'woocommerce_register_form' ); ?>

                    <p class="woocommerce-form-row form-row">
						<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                        <button type="submit" class="c-account__btn woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register',
							'shoppe' ); ?>"><?php esc_html_e( 'Register', 'shoppe' ); ?></button>
                    </p>

					<?php do_action( 'woocommerce_register_form_end' ); ?>

                </form>

            </div>


		<?php endif; ?>
    </div>
</div>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
