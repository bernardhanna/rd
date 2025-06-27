<?php

/**
 * Thankyou page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/thankyou.php.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */
defined('ABSPATH') || exit;
custom_thankyou_order_details($order->get_id());
$order = wc_get_order($order->get_id());

$is_local_pickup_plus = false;
$location_id = '';
$is_delivery = false; // Flag to check if delivery was selected

// Loop through shipping items to check for Local Pickup Plus and fetch location ID
foreach ($order->get_items('shipping') as $item) {
    if ($item->get_method_id() === 'local_pickup_plus') { // Ensure this matches your method ID
        $is_local_pickup_plus = true;
        $location_id = $item->get_meta('_pickup_location_id');
    }
    if ($item->get_method_id() === 'flat_rate' || $item->get_method_id() === 'delivery_method_id') {
        $is_delivery = true; // Adjust the method ID to your actual delivery method
    }
}

$delivery_date = $order->get_meta('jckwds_date'); // Replace with your meta key for the delivery date

?>
<style>
    [x-cloak] {
        display: none !important;
    }
</style>
<div class="px-4 m-auto woocommerce-order lg:max-w-max-1568">
    <?php
    $ty_image = get_field('ty_image', 'option');
    ?>
    <div class="flex flex-col items-center h-full lg:flex-row lg:justify-between">
        <?php if ($ty_image) : ?>
            <div class="flex items-center justify-center w-full lg:w-1/2">
                <img class="h-[346px] lg:h-auto w-full object-contain" src="<?php echo esc_url($ty_image); ?>" alt="Order Success">
            </div>
        <?php endif; ?>
        <div class="w-full lg:w-1/2">
            <?php if ($order) :

                do_action('woocommerce_before_thankyou', $order->get_id());
            ?>

                <?php if ($order->has_status('failed')) : ?>

                    <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e('Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce'); ?></p>

                    <p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
                        <a href="<?php echo esc_url($order->get_checkout_payment_url()); ?>" class="button pay"><?php esc_html_e('Pay', 'woocommerce'); ?></a>
                        <?php if (is_user_logged_in()) : ?>
                            <a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>" class="button pay"><?php esc_html_e('My account', 'woocommerce'); ?></a>
                        <?php endif; ?>
                    </p>

                <?php else : ?>

                    <?php wc_get_template('checkout/order-received.php', array('order' => $order)); ?>

                    <ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">

                        <li class="flex items-center justify-center py-4 my-4 text-white border-t border-b border-white order-numb woocommerce-order-overview__order order text-sm-md-font lg:text-md-font">
                            <?php esc_html_e('Order number:', 'woocommerce'); ?>
                            <strong class="font-reg420"><?php echo $order->get_order_number(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                        ?></strong>
                        </li>

                        <li class="text-white woocommerce-order-overview__date date text-sm-md-font lg:text-md-font">
                            <strong><?php esc_html_e('Order Date:', 'woocommerce'); ?></strong>
                            <?php echo wc_format_datetime($order->get_date_created()); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            ?>
                        </li>

                        <?php if ($is_delivery && $delivery_date) : // Display delivery date if it's a delivery order ?>
                            <li class="text-white woocommerce-order-overview__date date text-sm-md-font lg:text-md-font">
                                <strong>Delivery Date:</strong> <?php echo esc_html($delivery_date); ?><br>
                            </li>
                        <?php endif; ?>

                        <?php if (is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email()) : ?>
                            <li class="text-white woocommerce-order-overview__email email text-sm-md-font lg:text-mob-md-font">
                                <?php esc_html_e('Email:', 'woocommerce'); ?>
                                <?php echo $order->get_billing_email(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                ?>
                            </li>
                        <?php endif; ?>
                        <li class="text-white woocommerce-order-overview__total total text-mob-md-font">
                            <?php esc_html_e('Total:', 'woocommerce'); ?>
                            <?php echo $order->get_formatted_order_total(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            ?>
                        </li>
                        <?php

                        $shipping_items = $order->get_items('shipping');
                        $is_local_pickup_plus = false;
                        foreach ($shipping_items as $item_id => $shipping_item) {
                            if (strpos($shipping_item->get_method_title(), 'Collection') !== false) {
                                $is_local_pickup_plus = true;
                                break;
                            }
                        }

                        if ($is_local_pickup_plus && $location_id) :
                            $location_post = get_post($location_id);
                            $location_name = $location_post ? $location_post->post_title : '';
                            $location_address_meta = get_post_meta($location_id, '_pickup_location_address', true);
                        ?>
                            <li class="mt-4 text-white text-sm-font lg:text-mob-md-font">
                                <?php
                                $location_id = '';
                                $pickup_date = $order->get_meta('jckwds_date');
                                $timeslot = $order->get_meta('jckwds_timeslot');
                                $location_details = get_location_details_by_id($location_id);
                                echo '<p><strong>Collection Date:</strong> ' . esc_html($pickup_date) . '</p>';
                                echo '<p><strong>Collection Location:</strong> ' . esc_html($location_name) . '</p>';
                                echo '<p><strong>Your Donuts Will Be Available When the Store Opens!</strong> <a class="underline hover:no-underline" target="_blank" href="/our-shops/">View Opening Hours</a></p>';
                                ?>
                            </li>
                        <?php else : ?>
                            <li class="mt-4 text-white text-sm-font lg:text-mob-md-font">
                                <?php echo esc_html($order->get_formatted_billing_full_name()); ?>
                            </li>
                            <?php if ($order->get_billing_address_1()) : ?>
                                <li class="text-white text-sm-font lg:text-mob-md-font">
                                    <?php echo esc_html($order->get_billing_address_1()); ?>
                                </li>
                            <?php endif; ?>
                            <?php if ($order->get_billing_address_2()) : ?>
                                <li class="text-white text-sm-font lg:text-mob-md-font">
                                    <?php echo esc_html($order->get_billing_address_2()); ?>
                                </li>
                            <?php endif; ?>
                            <?php if ($order->get_billing_city()) : ?>
                                <li class="text-white text-sm-font lg:text-mob-md-font">
                                    <?php echo esc_html($order->get_billing_city() . ', ' . $order->get_billing_state() . ' ' . $order->get_billing_postcode()); ?>
                                </li>
                            <?php endif; ?>
                            <?php if ($order->get_billing_country()) : ?>
                                <li class="text-white text-sm-font lg:text-mob-md-font">
                                    <?php echo esc_html(WC()->countries->countries[$order->get_billing_country()]); ?>
                                </li>
                            <?php endif; ?>
                                      <!-- Display Shipping Address if "Ship to a different address" is selected -->
                        <?php if ($order->get_shipping_address_1()) : ?>
                            <li class="text-white text-sm-font lg:text-mob-md-font">
                                <strong><?php esc_html_e('Shipping Address:', 'woocommerce'); ?></strong><br>
                                <?php echo wp_kses_post($order->get_formatted_shipping_address()); ?>
                            </li>
                        <?php endif; ?>
                        <?php endif; ?>
                        
                    </ul>

                    <div class="mt-4">
                        <a href="/donut-box/" class="w-full border-2 text-white border-white border-solid woocommerce-button button wc-forward text-sm-font font-white font-reg420 h-[58px] text-center flex justify-center items-center rounded-btn-72 hover:bg-white hover:text-black-full transition-all">
                            <?php esc_html_e('Keep Shopping', 'woocommerce'); ?>
                        </a>
                    </div>


                <?php endif; ?> <?php else : ?> <?php wc_get_template('checkout/order-received.php', array('order' => false)); ?> <?php endif; ?>
        </div>
    </div>
</div>
