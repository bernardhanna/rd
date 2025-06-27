<?php
/**
 * Order details table shown in emails.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-order-details.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

defined('ABSPATH') || exit;

$text_align = is_rtl() ? 'right' : 'left';

do_action('woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text, $email); ?>

<h2>
    <?php
    if ($sent_to_admin) {
        $before = '<a class="link" href="' . esc_url($order->get_edit_order_url()) . '">';
        $after  = '</a>';
    } else {
        $before = '';
        $after  = '';
    }
    /* translators: %s: Order ID. */
    echo wp_kses_post($before . sprintf(__('[Order #%s]', 'woocommerce') . $after . ' (<time datetime="%s">%s</time>)', $order->get_order_number(), $order->get_date_created()->format('c'), wc_format_datetime($order->get_date_created())));
    ?>
</h2>

<div style="margin-bottom: 40px;">
    <table class="td" cellspacing="0" cellpadding="6" style="width: 100%; font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;" border="0">
        <thead>
            <tr>
                <th class="td" scope="col" style="text-align:<?php echo esc_attr($text_align); ?>;"><?php esc_html_e('Product', 'woocommerce'); ?></th>
                <th class="td" scope="col" style="text-align:<?php echo esc_attr($text_align); ?>;"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
                <th class="td" scope="col" style="text-align:<?php echo esc_attr($text_align); ?>;"><?php esc_html_e('Price', 'woocommerce'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $items = $order->get_items();
            $box_item = null;
            $selected_items = [];

            // Separate the default box item and selected items
            foreach ($items as $item_id => $item) {
                $product = $item->get_product();
                $product_name = $product->get_name();
                if (strpos($product_name, 'Personalised Large Sourdough') !== false) {
                    $box_item = $item;
                } else {
                    $selected_items[] = $item;
                }
            }

            if ($box_item) {
                // Display the default box item first
                ?>
                <tr>
                    <td class="td" style="text-align:<?php echo esc_attr($text_align); ?>;"><?php echo esc_html($box_item->get_name()); ?></td>
                    <td class="td" style="text-align:<?php echo esc_attr($text_align); ?>;"><?php echo esc_html($box_item->get_quantity()); ?></td>
                    <td class="td" style="text-align:<?php echo esc_attr($text_align); ?>;"><?php echo wp_kses_post($order->get_formatted_line_subtotal($box_item)); ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="td" style="text-align:<?php echo esc_attr($text_align); ?>;"><strong><?php esc_html_e('Selected Products:', 'woocommerce'); ?></strong></td>
                </tr>
                <?php
                // Display each selected item
                foreach ($selected_items as $selected_item) {
                    ?>
                    <tr>
                        <td class="td" style="text-align:<?php echo esc_attr($text_align); ?>;"><?php echo esc_html($selected_item->get_name()); ?></td>
                        <td class="td" style="text-align:<?php echo esc_attr($text_align); ?>;"><?php echo esc_html($selected_item->get_quantity()); ?></td>
                        <td class="td" style="text-align:<?php echo esc_attr($text_align); ?>;"><?php echo wp_kses_post($order->get_formatted_line_subtotal($selected_item)); ?></td>
                    </tr>
                    <?php
                }
            } else {
                // Display all items if no default box is found
                foreach ($items as $item) {
                    ?>
                    <tr>
                        <td class="td" style="text-align:<?php echo esc_attr($text_align); ?>;"><?php echo esc_html($item->get_name()); ?></td>
                        <td class="td" style="text-align:<?php echo esc_attr($text_align); ?>;"><?php echo esc_html($item->get_quantity()); ?></td>
                        <td class="td" style="text-align:<?php echo esc_attr($text_align); ?>;"><?php echo wp_kses_post($order->get_formatted_line_subtotal($item)); ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
        <tfoot>
            <?php
            $item_totals = $order->get_order_item_totals();

            if ($item_totals) {
                $i = 0;
                foreach ($item_totals as $total) {
                    $i++;
                    ?>
                    <tr>
                        <th class="td" scope="row" colspan="2" style="text-align:<?php echo esc_attr($text_align); ?>; <?php echo (1 === $i) ? 'border-top-width: 0px;' : ''; ?>"><?php echo wp_kses_post($total['label']); ?></th>
                        <td class="td" style="text-align:<?php echo esc_attr($text_align); ?>; <?php echo (1 === $i) ? 'border-top-width: 0px;' : ''; ?>"><?php echo wp_kses_post($total['value']); ?></td>
                    </tr>
                    <?php
                }
            }
            if ($order->get_customer_note()) {
                ?>
                <tr>
                    <th class="td" scope="row" colspan="2" style="text-align:<?php echo esc_attr($text_align); ?>;"><?php esc_html_e('Note:', 'woocommerce'); ?></th>
                    <td class="td" style="text-align:<?php echo esc_attr($text_align); ?>;"><?php echo wp_kses_post(nl2br(wptexturize($order->get_customer_note()))); ?></td>
                </tr>
                <?php
            }
            ?>
        </tfoot>
    </table>
</div>

<?php do_action('woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text, $email); ?>
