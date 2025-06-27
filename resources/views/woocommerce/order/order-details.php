 <?php
$order = wc_get_order($order_id); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if (is_wc_endpoint_url('view-order')) {
    echo '<div class="w-full px-4 mx-auto max-w-max-1000 wc-backward-container"><a href="' . wc_get_account_endpoint_url('orders') . '" class="flex items-center font-bold leading-none woocommerce-button button wc-backward font-laca text-mob-md-font text-yellow-primary hover:underline flex-container"><svg class="mr-2" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M27 14C27 6.8203 21.1797 1 14 1C6.8203 1 0.999998 6.8203 0.999999 14C0.999999 21.1797 6.8203 27 14 27C21.1797 27 27 21.1797 27 14Z" fill="#FFED56" stroke="black" stroke-width="2"/>
<path fill-rule="evenodd" clip-rule="evenodd" d="M15.0406 18.3071C15.3047 18.5711 15.7327 18.5711 15.9967 18.3071L16.1533 18.1506C16.4171 17.8868 16.4173 17.4591 16.1538 17.195L13.0184 14.0528L16.1538 10.9105C16.4173 10.6464 16.4171 10.2188 16.1533 9.95496L15.9967 9.79841C15.7327 9.53439 15.3047 9.53439 15.0406 9.79841L10.7863 14.0528L15.0406 18.3071Z" fill="black"/>
</svg>
' . esc_html__('Back to orders', 'woocommerce') . '</a></div>';
}


if (!$order) {
    return;
}

$order_items = $order->get_items(apply_filters('woocommerce_purchase_order_item_types', 'line_item'));
$show_purchase_note = $order->has_status(apply_filters('woocommerce_purchase_note_order_statuses', array('completed', 'processing')));
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$downloads = $order->get_downloadable_items();
$show_downloads = $order->has_downloadable_item() && $order->is_download_permitted();
$text_align = is_rtl() ? 'right' : 'left';
?>
<style>
    .item-ordered .woocommerce-Price-amount.amount {
        display: none;
    }
</style>
<div class="flex flex-col w-full">
    <!-- Header -->
    <div class="flex justify-between px-10 py-2 bg-grey-disabled">
        <div class="font-bold text-left"><?php esc_html_e('Product', 'woocommerce'); ?></div>
        <div class="font-bold text-center"><?php esc_html_e('Total', 'woocommerce'); ?></div>
    </div>
    <div class="flex flex-col ">
        <?php
        $main_product = null;
        $selected_items = [];

        // Separate the main product and selected items
        foreach ($order_items as $item_id => $item) {
            $product = $item->get_product();
            if ($product && $product->get_type() === 'donut_box_builder') {
                $main_product = $item;
            } else {
                $selected_items[] = $item;
            }
        }

        if ($main_product) {
            // Display the main product first with a custom class
            echo '<div class="flex justify-between bg-white border-b-2 line-item border-grey-disabled last:border-b-0">';
            echo '<div class="px-10 py-5 text-left item-ordered">';
            // Render product details, but exclude the price
            wc_get_template('order/order-details-item.php', array(
                'item_id' => $main_product->get_id(),
                'item' => $main_product,
                'order' => $order,
                'custom_class' => 'main-product',
                'show_price' => false, // Pass a variable to conditionally exclude price
            ));
            echo '</div>'; // End left div

            echo '<div class="px-10 py-5 text-center">';
            // Display the price only here in the total column
            echo '<span class="woocommerce-Price-amount amount">' . wc_price($main_product->get_total()) . '</span>';
            echo '</div>'; // End right div

            echo '</div>'; // End main product div

            // Display the selected items under the main product
            foreach ($selected_items as $selected_item) {
                echo '<div class="flex justify-between bg-white border-b-2 line-item border-grey-disabled last:border-b-0">';
                echo '<div class="px-10 py-5 text-left item-ordered">';
                // Render product details, but exclude the price
                wc_get_template('order/order-details-item.php', array(
                    'item_id' => $selected_item->get_id(),
                    'item' => $selected_item,
                    'order' => $order,
                    'show_price' => false, // Pass a variable to conditionally exclude price
                ));
                echo '</div>'; // End left div

                echo '<div class="px-10 py-5 text-center">';
                // Display the price only in the total column
                echo '<span class="woocommerce-Price-amount amount">' . wc_price($selected_item->get_total()) . '</span>';
                echo '</div>'; // End right div

                echo '</div>'; // End selected item div
            }
        } else {
            // Display all items if no main product is found
            foreach ($order_items as $item_id => $item) {
                echo '<div class="flex justify-between bg-white border-b-2 line-item border-grey-disabled last:border-b-0">';
                echo '<div class="px-10 py-5 text-left">';
                // Render product details, but exclude the price
                wc_get_template('order/order-details-item.php', array(
                    'item_id' => $item_id,
                    'item' => $item,
                    'order' => $order,
                    'show_price' => false, // Pass a variable to conditionally exclude price
                ));
                echo '</div>'; // End left div

                echo '<div class="px-10 py-5 text-center">';
                // Display the price only in the total column
                echo '<span class="woocommerce-Price-amount amount">' . wc_price($item->get_total()) . '</span>';
                echo '</div>'; // End right div

                echo '</div>'; // End item div
            }
        }
        ?>
    </div>
    <!-- Footer -->
    <div class="flex flex-col border-t-2 border-grey-disabled">
        <?php
        foreach ($order->get_order_item_totals() as $key => $total) {
            ?>
            <div class="flex justify-between bg-white border-b-2 border-grey-disabled last:border-b-0">
                <div class="px-10 py-5 text-left"><?php echo esc_html($total['label']); ?></div>
                <div class="px-10 py-5 text-center"><span class="woocommerce-Price-amount amount"><?php echo wp_kses_post($total['value']); ?></span></div>
            </div>
            <?php
        }
        ?>
        <?php if ($order->get_customer_note()) : ?>
            <div class="flex justify-between bg-white border-b-2 border-grey-disabled last:border-b-0">
                <div class="px-10 py-5 text-left"><?php esc_html_e('Note:', 'woocommerce'); ?></div>
                <div class="px-10 py-5 text-center"><?php echo wp_kses_post(nl2br(wptexturize($order->get_customer_note()))); ?></div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php do_action('woocommerce_order_details_after_order_table', $order); ?>

<?php if ($show_customer_details) : ?>
    <?php wc_get_template('order/order-details-customer.php', array('order' => $order)); ?>
<?php endif; ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var backButton = document.querySelector('.woocommerce-MyAccount-content .wc-backward-container');
        if (backButton) {
            var myAccountContent = document.querySelector('.woocommerce-MyAccount-content');
            if (myAccountContent) {
                myAccountContent.parentNode.insertBefore(backButton, myAccountContent);
            }
        }

        // Ensure the "Order Again" button is placed correctly
        moveOrderAgainButton();
    });

    function moveOrderAgainButton() {
        // Select the "Order Again" button
        var orderAgainButton = document.querySelector('.wc-reorder-button-container');
        // Select the My Account content section
        var myAccountContent = document.querySelector('.woocommerce-MyAccount-content');

        // Check if both elements exist
        if (orderAgainButton && myAccountContent) {
            // Clone the "Order Again" button
            var clonedButton = orderAgainButton.cloneNode(true);
            // Remove the original button to prevent duplicates
            orderAgainButton.remove();
            // Insert the cloned button after the My Account content section
            myAccountContent.parentNode.insertBefore(clonedButton, myAccountContent.nextSibling);
        }
    }
</script>
