<?php

/**
 * Shipping Methods Display
 *
 * In 2.1 we show methods per package. This allows for multiple methods per order if so desired.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-shipping.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.8.0
 */

defined('ABSPATH') || exit;

$formatted_destination    = isset($formatted_destination) ? $formatted_destination : WC()->countries->get_formatted_address($package['destination'], ', ');
$has_calculated_shipping  = !empty($has_calculated_shipping);
$show_shipping_calculator = !empty($show_shipping_calculator);
$calculator_text          = '';
?>
<div class="flex flex-col items-center justify-between bg-white text-black-full text-base-font font-reg420 border-black-full">
    <div class="w-full pb-0 woocommerce-shipping-totals shipping">
        <div data-title="<?php echo esc_attr($package_name); ?>">
            <?php if (!empty($available_methods) && is_array($available_methods)) : ?>
                <ul id="shipping_method" class="flex justify-between px-8 py-4 border-b woocommerce-shipping-methods border-grey-border">
                    <?php foreach ($available_methods as $method) : ?>
                        <li>
                            <?php
                            if (1 < count($available_methods)) {
                                printf('<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" %4$s />', $index, esc_attr(sanitize_title($method->id)), esc_attr($method->id), checked($method->id, $chosen_method, false)); // WPCS: XSS ok.
                            } else {
                                printf('<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method" />', $index, esc_attr(sanitize_title($method->id)), esc_attr($method->id)); // WPCS: XSS ok.
                            }
                            printf('<label for="shipping_method_%1$s_%2$s">%3$s</label>', $index, esc_attr(sanitize_title($method->id)), wc_cart_totals_shipping_method_label($method)); // WPCS: XSS ok.
                            do_action('woocommerce_after_shipping_rate', $method, $index);
                            ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php
            elseif (!$has_calculated_shipping || !$formatted_destination) :
                if (is_cart() && 'no' === get_option('woocommerce_enable_shipping_calc')) {
                    echo wp_kses_post(apply_filters('woocommerce_shipping_not_enabled_on_cart_html', __('Shipping costs are calculated during checkout.', 'woocommerce')));
                } else {
                    echo wp_kses_post(apply_filters('woocommerce_shipping_may_be_available_html', __('Enter your Shipping address to view all shipping options.', 'woocommerce')));
                }
            elseif (!is_cart()) :
                echo wp_kses_post(apply_filters('woocommerce_no_shipping_available_html', __('There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'woocommerce')));
            else :
                echo wp_kses_post(
                    /**
                     * Provides a means of overriding the default 'no shipping available' HTML string.
                     *
                     * @since 3.0.0
                     *
                     * @param string $html                  HTML message.
                     * @param string $formatted_destination The formatted shipping destination.
                     */
                    apply_filters(
                        'woocommerce_cart_no_shipping_available_html',
                        // Translators: $s shipping destination.
                        sprintf(esc_html__('No shipping options were found for %s.', 'woocommerce') . ' ', '<strong>' . esc_html($formatted_destination) . '</strong>'),
                        $formatted_destination
                    )
                );
                $calculator_text = esc_html__('Enter a different address', 'woocommerce');
            endif;
            ?>
        </div>
    </div>
</div>
<?php
