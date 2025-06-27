<?php

/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if (! defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}

?>
<style>
    #billing_state {
        width: 100%;
        height: 3.5rem;
        background: transparent;
    }

    #billing_country_field {
        display: flex !important;
        flex-direction: column;
    }

    #billing_country_field .woocommerce-input-wrapper {
        height: 3.5rem;
    }

    #billing_country_field .woocommerce-input-wrapper::before {
        position: absolute;
        margin: auto;
        z-index: 100;
        height: 19.5px;
        width: 19.5px;
        left: 1rem;
        content: url("https://api.iconify.design/ph/map-pin.svg?width=22&height=22");
    }

    .child-product {
        display: none;
    }

    .iconic-wds-fields__fields .single-field-wrapper {
        padding-bottom: 0rem !important;
    }

    .woocommerce ul#shipping_method {
        list-style: none outside;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        width: 100%;
        border: none;
    }

    .woocommerce-input-wrapper select {
        width: 100%;
        border: none !important;
        padding-left: 3rem;
        height: 100%;
    }

    .woocommerce-shipping-total.shipping th {
        display: none !important;
    }

    .woocommerce-error {
        height: max-content !important;
        max-width: 1728px;
        margin: auto;
        background-color: black;
        width: 100%;
    }

    .hide-on-checkout {
        display: none !important;
    }

    #jckwds-delivery-date-description {
        display: none !important;
    }

    .woocommerce-info::before {
        display: none;
    }

    .woocommerce-info {
        border-top-color: #000;
        padding: 1em;
        margin: 0px;
        margin-bottom: 1rem;
    }

    .woocommerce-checkout form.checkout_coupon {
        border: none;
        padding: 0px;
        border: none;
        padding-top: 1rem;
    }

    .woocommerce-checkout #payment {
        background: transparent;
        border-radius: unset;
    }

    .woocommerce-checkout #payment div.payment_box {
        position: relative;
        box-sizing: border-box;
        width: 100%;
        padding: 1em;
        margin: 1em 0;
        font-size: .92em;
        border-radius: 2px;
        line-height: 1.5;
        background-color: transparent;
        color: #515151;
    }

    .pickup-location-address {
        display: none;
    }

    .woocommerce-checkout #payment div.payment_box {
        position: relative;
        box-sizing: unset;
        width: 100%;
        padding: unset;
        margin: unset;
        font-size: unset;
        border-radius: unset;
        line-height: 1.5;
        background-color: transparent;
        color: unset;
    }

    .woocommerce-checkout #payment div.form-row {
        padding: 0px;
    }

    .woocommerce-checkout #payment div.payment_box::before {
        display: none;
    }

    .woocommerce-checkout #payment div.payment_box .form-row {
        margin: 0 0 0em;
    }

    .woocommerce-checkout #payment ul.payment_methods li input {
        margin: 0px;
        width: 20px !important;
        height: 20px !important;
        margin-right: 0.5rem;
    }

    .woocommerce-checkout #payment ul.payment_methods {
        text-align: left;
        padding: 1.5rem;
        margin: 0;
        list-style: none outside;
        margin-bottom: 1rem;
        border: solid;
        border-radius: 1.25rem;
        border: var(--Item-counter, 2px) solid #000;
    }

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
        border: 0px solid #D8D7CE;
    }

    .woocommerce-shipping-totals .select2-container .select2-selection--single {
        height: 3.5rem;
        border-radius: 12.5rem;
        margin-top: 1rem;
    }

    .woocommerce-shipping-totals .select2-container--default .select2-selection--single .select2-selection__rendered {
        padding-left: 1.75rem;
    }

    .woocommerce-shipping-totals .select2-container--default.select2-container--open.select2-container--below .select2-selection--single {
        border-bottom-left-radius: unset;
        border-bottom-right-radius: unset;
        border-radius: 12.5rem;
    }

    @media (min-width: 1733px) {
        .woocommerce-shipping-totals .select2-container--open .select2-dropdown {
            left: 7.5rem !important;
            right: 0 !important;
        }
    }

    .woocommerce #payment #place_order,
    .woocommerce-page #payment #place_order {
        margin-top: 1rem;
        float: right;
        border-radius: 4.5rem;
        border: 3px solid var(--black-key, #000);
        background: var(--yellow-main, #FFED56);
        color: black;
        font-size: 1.5rem;
        font-style: normal;
        font-weight: 420;
        line-height: 1.625rem;
    }

    .woocommerce #payment #place_order:hover,
    .woocommerce-page #payment #place_order:hover {
        background: var(--black-key, #000);
        color: var(--yellow-main, #FFED56);
    }

    .coupon-btn {
        border-radius: 4.5rem !important;
        border: 3px solid #FFED56 !important;
        background: #000 !important;
        color: #FFED56 !important;
        font-family: Edmondsans !important;
        font-size: 1.25rem !important;
        font-style: normal !important;
        font-weight: 420 !important;
        line-height: 1.5rem !important;
    }

    .coupon-btn:hover {
        background: #FFED56 !important;
        color: #000 !important;
    }

    .checkout_coupon [type='text'] {
        border: 1px solid #D8D7CE;
    }

    .woocommerce-shipping-contents {
        display: none;
    }

    .woocommerce ul#shipping_method li label {
        display: inline;
        font-size: 1.125rem;
        font-style: normal;
        font-weight: 400;
        line-height: 0rem;
        font-family: 'laca';
    }

    .pickup-location-field .pickup-location-address {
        font-size: .8em;
        margin: 15px 0;
        font-size: 16px;
        font-style: normal;
        font-weight: 350;
        line-height: 1.625rem;
        margin-bottom: 0px;
    }

    .pickup-location-lookup {
        padding-left: 2rem;
        margin-top: 1rem;
        height: 3.5rem;
        font-weight: 350;
    }

    @media (max-width: 768px) {
        .woocommerce form .form-row {
            width: 100% !important;
        }

        .woocommerce form.checkout_coupon {
            margin: 0px !important;
        }
    }

    .woosb-cart-child {
        display: none;
    }

    .border-grey-bordermixmatch-child,
    .mixmatch-child {
        display: none !important;
    }

    .woocommerce ul#shipping_method li input {
        margin: 0px .5rem 0 0;
        vertical-align: middle;
    }

    .woocommerce ul#shipping_method li {
        margin: 0 0 .5em;
        line-height: 0px;
    }

    .pickup-location-field em {
        display: none;
    }

    .woocommerce-error {
        color: white;
    }

    .woocommerce-form__input.woocommerce-form__input-checkbox {
        height: 20px;
        width: 20px;
    }

    .woocommerce-button button.woocommerce-form-login__submit:hover {
        background-color: #FFED56;
        color: black;
    }

    .custom-woocommerce-notice {
        bottom: 0px !important;
    }

    @media (max-width: 1024px) {
        .custom-woocommerce-notice {
            top: 0px !important;
        }
    }

    .woocommerce form .form-row label.checkbox,
    .woocommerce-page form .form-row label.checkbox {
        display: flex;
    }

    .woocommerce-form__label.woocommerce-form__label-for-checkbox.checkbox {
        line-height: unset;
    }

    .woocommerce form .password-input,
    .woocommerce-page form .password-input {
        width: 100%;
    }

    .woocommerce form .show-password-input,
    .woocommerce-page form .show-password-input {
        top: 1rem;
    }

    .woocommerce form .form-row .input-checkbox {
        color: black;
    }

    .shipping-option-0 {
        padding: 16px 24px;
        border-radius: 8px;
        background: #EAEAEA;
    }

    .shipping-option-1 {
        padding: 16px 24px;
        border-radius: 8px;
        background: #EAEAEA;
    }

    .shipping-option-2 {
        padding: 16px 24px;
        border-radius: 8px;
        background: #EAEAEA;
    }

    .shipping-option-0:hover,
    .shipping-option-1:hover,
    .shipping-option-2:hover,
    .shipping-option-3:hover {
        background: #FFF6A7;
    }

    @media (max-width: 380px) {
        .woocommerce ul#shipping_method li label {
            font-size: 16px;
        }

        .shipping-option-0 {
            padding: .5rem;
        }

        .shipping-option-1 {
            padding: .5rem;
        }

        .shipping-option-2 {
            padding: .5rem;
        }
    }

    #shipping_postcode_field .optional {
        display: none !important;
    }

    #billing_statebilling_state {
        padding-left: 2.75rem;
    }
</style>
<div id="moveNotice"></div>
<div class="pt-8 pb-24 mb-10">
    <form name="checkout" method="post" class="mx-auto checkout woocommerce-checkout woo-move-notice max-w-max-1568" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

        <?php if ($checkout->get_checkout_fields()) : ?>
            <div class="flex flex-col lg:flex-row lg:justify-between">
                <?php do_action('woocommerce_checkout_before_customer_details'); ?>
                <div class="xxl:w-1/2 desktop:w-[772px] w-full pr-0 md:pr-8 desktop:pr-0" id="customer_details">
                    <div class="col-1 hideText">
                        <h1 class="mb-6 uppercase w-90 text-md-font font-reg420">Enter your Delivery details or Collect from one of our stores</h1>
                        <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>

                        <?php endif; ?>

                        <?php do_action('woocommerce_checkout_billing'); ?>
                    </div>

                    <div class="col-2">
                        <?php do_action('woocommerce_checkout_shipping'); ?>
                    </div>
                </div>

                <?php do_action('woocommerce_checkout_after_customer_details'); ?>

            <?php endif; ?>
            <div class="xxl:w-1/2 desktop:w-[640px] w-full ">
                <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

                <h3 class="mb-6 text-md-font font-reg420" id="order_review_heading"><?php esc_html_e('Your order', 'woocommerce'); ?></h3>

                <?php do_action('woocommerce_checkout_before_order_review'); ?>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action('woocommerce_checkout_order_review'); ?>
                </div>

                <?php do_action('woocommerce_checkout_after_order_review'); ?>
            </div>
            </div>
    </form>
</div>
<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
<script>
    jQuery(document).ready(function($) {
        $('#order_comments').on('input', function() {
            var maxLength = 200;
            var currentLength = $(this).val().length;

            if (currentLength > maxLength) {
                $(this).val($(this).val().substring(0, maxLength));
                alert('Customer note cannot exceed 200 characters.');
            }
        });
    });

    jQuery(window).on('load', function() {
        addUniqueClassesToShippingMethods();
    });

    jQuery(document.body).on('updated_checkout', function() {
        addUniqueClassesToShippingMethods();
    });

    function addUniqueClassesToShippingMethods() {
        jQuery('#shipping_method li').each(function(index) {
            // Add a unique class to each li based on its index
            jQuery(this).addClass('shipping-option-' + index);

            // Wrap the input and label inside a new div if not already wrapped
            if (!jQuery(this).find('.shipping-method-wrapper').length) {
                jQuery(this).find('input.shipping_method, label').wrapAll('<div class="shipping-method-wrapper"></div>');
            }
        });
    }
    jQuery(document).ready(function($) {
        // Close the notice on button click
        $('body').on('click', '.close-notice-button', function() {
            $(this).closest('#custom-woocommerce-notice').fadeOut('fast');
        });

        // Auto-fade after 5 seconds
        setTimeout(function() {
            $('#custom-woocommerce-notice').fadeOut('slow');
        }, 5000);
    });
</script>