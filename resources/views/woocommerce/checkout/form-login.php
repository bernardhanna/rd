<?php
defined('ABSPATH') || exit;

if (is_user_logged_in() || 'no' === get_option('woocommerce_enable_checkout_login_reminder')) {
    return;
}

// Customization starts here
?>
<?php wc_print_notices(); ?>

<div id="checkout-login-container" class="woocommerce-form-login-toggle xxl:w-1/2 desktop:w-[772px] w-full">
    <style>
   .woocommerce-form-login .form-row {
    display: flex;
    flex-direction: column;
    }

   .woocommerce-form.woocommerce-form-login.login input {
        height: 3.5rem;
        padding-left: 1rem;
    }


   .woocommerce-form-login  .show-password-input, .woocommerce-form-login  .show-password-input {
        position: absolute;
        right: .7em;
        cursor: pointer;
        vertical-align: middle;
        display: flex;
        align-items: center;
        height: 100%;
    }

    .woocommerce-form-login-toggle .woocommerce-info {
        border: none;
        background: white;
        padding-left: 0;
    }

    .woocommerce-form.woocommerce-form-login.login .form-row-first,
    .woocommerce-form.woocommerce-form-login.login .form-row-last {
        font-weight: 420;
    }

     .woocommerce-form.woocommerce-form-login.login .lost_password {
        text-decoration: underline;
    }
     .woocommerce-form.woocommerce-form-login.login .lost_password:hover {
        text-decoration: none;
    }

    .woocommerce-form-login input,
    [type='text'],
    [type='email'],
    [type='url'],
    [type='password'],
    [type='number'],
    [type='date'],
    [type='datetime-local'],
    [type='month'],
    [type='tel'],
    [type='time'],
    [type='week'],
    [multiple],
    textarea,
    select {
        border: 1px solid #D8D7CE;
    }


    .woocommerce-checkout .woocommerce form.login {
        border: 2px solid black;
        padding: 1.5rem;
        margin: 2em 0;
        text-align: left;
        border-radius: 20px;
    }

    .woocommerce .woocommerce-form-login .woocommerce-form-login__submit {
        float: left;
        margin-top: 1em;
        border-radius: 4.5rem;
        border: 3px solid #FFED56;
        background: #000;
        color: #FFED56;
        font-family: Edmondsans;
        font-size: 1.25rem;
        font-style: normal;
        font-weight: 420;
        line-height: 1.5rem;
    }

    .woocommerce-checkout .woocommerce form.login {
    box-shadow: 0 4px 0 0 #00000040;
    }

    .woocommerce form .show-password-input, .woocommerce-page form .show-password-input {
        position: absolute;
        right: .7em;
        top: 0px;
        cursor: pointer;
    }

    .woocommerce-form__input.woocommerce-form__input-checkbox{
        height: 20px!important;
        width: 20px!important;
    }

    .woocommerce .woocommerce-form-login .woocommerce-form-login__submit:hover {
        background-color: #FFED56!important;
        color: black !important;
    }

    :where(body:not(.woocommerce-block-theme-has-button-styles)) .woocommerce button.button:hover {
        background-color: #FFED56!important;
        color: black !important;
    }
    .woocommerce-password-strength.bad {
        color: red!important
    }
</style>
    <?php wc_print_notice( apply_filters( 'woocommerce_checkout_login_message', esc_html__( 'Returning customer?', 'woocommerce' ) ) . ' <a href="#"  class="font-bold underline showlogin login-scroll-link">' . esc_html__( 'Click here to login', 'woocommerce' ) . '</a>', 'notice' ); ?>
    
    <?php woocommerce_login_form(
        array(
            'message'  => esc_html__( 'If you have shopped with us before, please enter your details below. If you are a new customer, please proceed to the Billing section.', 'woocommerce' ),
            'redirect' => wc_get_checkout_url(),
            'hidden'   => true,
        )
    ); ?>
</div>