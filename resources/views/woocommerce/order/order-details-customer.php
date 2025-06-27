<?php

/**
 * Order Customer Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-customer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.7.0
 */

defined('ABSPATH') || exit;

$shipping_method = $order->get_shipping_method(); // Get the shipping method

// Get the pickup location details if Local Pickup was selected
$pickup_location_id = get_post_meta($order->get_id(), '_pickup_location_id', true); // This meta key should store the pickup location ID
$pickup_location_name = get_post_meta($order->get_id(), '_pickup_location_name', true); // Meta key for location name
$pickup_location_address = get_post_meta($order->get_id(), '_pickup_location_address', true); // Meta key for location address

?>
<section class="woocommerce-customer-details">

    <section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses flex flex-col sm:flex-row justify-between pb-8 px-12">
        <div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">
            <h2 class="woocommerce-column__title font-reg420"><?php esc_html_e('Billing address', 'woocommerce'); ?></h2>

            <address>
                <?php echo wp_kses_post($order->get_formatted_billing_address(esc_html__('N/A', 'woocommerce'))); ?>

                <?php if ($order->get_billing_phone()) : ?>
                    <p class="woocommerce-customer-details--phone"><?php echo esc_html($order->get_billing_phone()); ?></p>
                <?php endif; ?>

                <?php if ($order->get_billing_email()) : ?>
                    <p class="woocommerce-customer-details--email"><?php echo esc_html($order->get_billing_email()); ?></p>
                <?php endif; ?>

                <?php
                /**
                 * Action hook fired after an address in the order customer details.
                 *
                 * @since 8.7.0
                 * @param string $address_type Type of address (billing or shipping).
                 * @param WC_Order $order Order object.
                 */
                do_action('woocommerce_order_details_after_customer_address', 'billing', $order);
                ?>
            </address>
        </div><!-- /.col-1 -->

        <?php if ($shipping_method === 'Local Pickup' && $pickup_location_name && $pickup_location_address) : ?>
            <div class="woocommerce-column woocommerce-column--2 woocommerce-column--pickup-address col-2">
                <h2 class="woocommerce-column__title font-reg420"><?php esc_html_e('Pickup Location', 'woocommerce'); ?></h2>
                <address>
                    <?php
                    // Display the pickup location
                    echo wp_kses_post($pickup_location_name . '<br>' . $pickup_location_address);
                    ?>

                    <?php
                    /**
                     * Action hook fired after an address in the order customer details.
                     *
                     * @since 8.7.0
                     * @param string $address_type Type of address (billing or shipping).
                     * @param WC_Order $order Order object.
                     */
                    do_action('woocommerce_order_details_after_customer_address', 'pickup', $order);
                    ?>
                </address>
            </div><!-- /.col-2 -->
        <?php endif; ?>
    </section><!-- /.col2-set -->

    <?php do_action('woocommerce_order_details_after_customer_details', $order); ?>

</section>