<?php

// Add custom data to WooCommerce order emails
add_filter('woocommerce_email_order_meta_fields', 'donut_box_builder_email_order_meta_fields', 10, 3);
function donut_box_builder_email_order_meta_fields($fields, $sent_to_admin, $order) {
    foreach ($order->get_items() as $item_id => $item) {
        if ($item->get_meta('Selected Products')) {
            $fields['selected_products'] = array(
                'label' => __('Selected Products', 'donut-box-builder'),
                'value' => $item->get_meta('Selected Products'),
            );
        }
        if ($item->get_meta('Special Occasion')) {
            $fields['special_occasion'] = array(
                'label' => __('Special Occasion', 'donut-box-builder'),
                'value' => $item->get_meta('Special Occasion'),
            );
        }
        if ($item->get_meta('Special Requests')) {
            $fields['special_requests'] = array(
                'label' => __('Special Requests', 'donut-box-builder'),
                'value' => $item->get_meta('Special Requests'),
            );
        }
        if ($item->get_meta('Uploaded Logo')) {
            $fields['uploaded_logo'] = array(
                'label' => __('Uploaded Logo', 'donut-box-builder'),
                'value' => '<a href="' . esc_url($item->get_meta('Uploaded Logo')) . '">' . __('View Logo', 'donut-box-builder') . '</a>',
            );
        }
    }
    return $fields;
}

// Add custom styles to order emails
add_action('woocommerce_email_styles', 'donut_box_builder_email_styles');
function donut_box_builder_email_styles($css) {
    $custom_css = "
        .selected-products {
            margin-left: 20px;
        }
        .selected-products li {
            list-style: disc;
            margin-bottom: 5px;
        }
    ";
    return $css . $custom_css;
}

// Hide certain meta keys from emails
add_filter('woocommerce_email_order_meta_keys', 'hide_meta_keys_from_email');
function hide_meta_keys_from_email($keys) {
    $keys = array_diff($keys, array('_selected_products', '_unique_key'));
    return $keys;
}