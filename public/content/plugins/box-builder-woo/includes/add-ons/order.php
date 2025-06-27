<?php
// Save custom fields data to order
add_action('woocommerce_checkout_create_order_line_item', 'save_custom_fields_to_order', 10, 4);
function save_custom_fields_to_order($item, $cart_item_key, $values, $order) {
    if (isset($values['custom_fields'])) {
        foreach ($values['custom_fields'] as $field) {
            if (!empty($field['value'])) {
                $item->add_meta_data($field['title'], $field['value'], true);
            }
        }
    }
}
// Unified function for displaying custom metadata in order details
add_filter('woocommerce_display_item_meta', 'display_custom_metadata_in_order_combined', 10, 3);
function display_custom_metadata_in_order_combined($html, $item, $args) {
    // Modify this section according to which details you want to show or hide
    $custom_fields = $item->get_meta_data();
    foreach ($custom_fields as $meta) {
        // Adjust this conditional logic as necessary
        if (!in_array($meta->key, array('_unique_key', '_selected_products'))) {
            $html .= '<p><strong>' . esc_html($meta->key) . ':</strong> ' . esc_html($meta->value) . '</p>';
        }
    }
    return $html;
}

add_filter('woocommerce_order_item_get_formatted_meta_data', 'show_custom_order_meta', 10, 2);
function show_custom_order_meta($formatted_meta, $item) {
    // No filtering needed, return the entire meta
    return $formatted_meta;
}

