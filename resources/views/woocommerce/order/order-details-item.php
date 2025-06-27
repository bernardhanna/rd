<?php
/**
 * Order Item Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-item.php.
 *
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

if (!defined('ABSPATH')) {
    exit;
}

// Ensure the item is visible
if (!apply_filters('woocommerce_order_item_visible', true, $item)) {
    return;
}

$item_total = $order->get_line_total($item, true, true); // Get item total

// Initialize an array to keep track of displayed meta keys
$displayed_meta_keys = [];

// Get the product object
$product = $item->get_product();  // Initialize the $product variable

// Define the $show_purchase_note and $purchase_note variables
$show_purchase_note = $order->has_status(apply_filters('woocommerce_purchase_note_order_statuses', array('completed', 'processing')));
$purchase_note = $product ? $product->get_purchase_note() : '';

// Start of the table row
?>
<tr class="bg-white border-t-2 border-grey-disabled <?php echo esc_attr(apply_filters('woocommerce_order_item_class', 'woocommerce-table__line-item order_item', $item, $order)); ?>">

    <td class="px-10 py-5 border-t-2 woocommerce-table__product-name product-name border-grey-disabled">
        <?php
        $is_visible = $product && $product->is_visible();
        $product_permalink = apply_filters('woocommerce_order_item_permalink', $is_visible ? $product->get_permalink($item) : '', $item, $order);

        echo wp_kses_post(apply_filters('woocommerce_order_item_name', $product_permalink ? sprintf('<a href="%s">%s</a>', $product_permalink, $item->get_name()) : $item->get_name(), $item, $is_visible));

        $qty = $item->get_quantity();
        $refunded_qty = $order->get_qty_refunded_for_item($item_id);

        if ($refunded_qty) {
            $qty_display = '<del>' . esc_html($qty) . '</del> <ins>' . esc_html($qty - ($refunded_qty * -1)) . '</ins>';
        } else {
            $qty_display = esc_html($qty);
        }

        echo apply_filters('woocommerce_order_item_quantity_html', ' <strong class="product-quantity">' . sprintf('&times;&nbsp;%s', $qty_display) . '</strong>', $item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

        // Display metadata only for items with a total greater than 0 and avoid displaying twice
        if ($item_total > 0) {
            do_action('woocommerce_order_item_meta_start', $item_id, $item, $order, false);
            
            // Fetch and display metadata, avoiding duplication
            $meta_data = $item->get_formatted_meta_data();
            foreach ($meta_data as $meta_id => $meta) {
                if (in_array($meta->key, $displayed_meta_keys)) {
                    continue; // Skip already displayed metadata
                }

                // Handle special cases for logo URLs and images
                if ($meta->key === 'Logo Upload' || $meta->key === 'Additional Logos') {
                    if (filter_var($meta->value, FILTER_VALIDATE_URL)) {
                        // Display the image directly if the value is a URL
                        echo '<p><strong>' . esc_html($meta->display_key) . ':</strong> <img src="' . esc_url($meta->value) . '" alt="Logo" style="max-width:50px;"></p>';
                    } else {
                        // Display the URL if it's not an image URL
                        echo '<p><strong>' . esc_html($meta->display_key) . ':</strong> ' . esc_html($meta->value) . '</p>';
                    }
                } else {
                    // Display other metadata normally
                    echo '<p><strong>' . esc_html($meta->display_key) . ':</strong> ' . wp_kses_post(make_clickable($meta->value)) . '</p>';
                }

                // Mark this meta key as displayed
                $displayed_meta_keys[] = $meta->key;
            }

            do_action('woocommerce_order_item_meta_end', $item_id, $item, $order, false);
        }
        ?>
    </td>

    <td class="text-center border-t-2 woocommerce-table__product-total product-total border-grey-disabled">
        <?php echo $order->get_formatted_line_subtotal($item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        ?>
    </td>

</tr>

<?php if ($show_purchase_note && $purchase_note) : ?>

    <tr class="woocommerce-table__product-purchase-note product-purchase-note">

        <td colspan="2"><?php echo wpautop(do_shortcode(wp_kses_post($purchase_note))); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        ?></td>

    </tr>

<?php endif; ?>
