<?php
/**
 * @Author: Bernard Hanna
 * @Date:   2023-10-23
 * Template Overrides: Customer New Account Email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-new-account.php.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load email heading
do_action( 'woocommerce_email_header', $email_heading, $email );

// Main content
?>
<p><?php esc_html_e( 'Thank you for creating an account with us! You can now log in using your email and the password you set during registration.', 'woocommerce' ); ?></p>

<p><?php esc_html_e( 'From your account area, you can view your orders, manage your password, and more.', 'woocommerce' ); ?></p>

<!-- Link to the account page -->
<p><a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>"><?php esc_html_e( 'Access Your Account', 'woocommerce' ); ?></a></p>

<!-- Password reset link -->
<p><a href="https://therollingdonut.ie/wp/wp-login.php?action=lostpassword"><?php esc_html_e( 'Forgot your password or having issues logging in? Click here to reset it.', 'woocommerce' ); ?></a></p>

<?php
// Load email footer
do_action( 'woocommerce_email_footer', $email );
