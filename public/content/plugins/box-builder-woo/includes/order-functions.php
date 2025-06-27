<?php
// Add metadata to order items for processing and display
function add_metadata_to_order_items($item, $cart_item_key, $values, $order)
{
    // Add processing metadata
    if (isset($values['selected_products'])) {
        $item->add_meta_data('_selected_products', implode(', ', $values['selected_products']), true);
    }
    if (isset($values['unique_key'])) {
        $item->add_meta_data('_unique_key', $values['unique_key'], true);
    }

    // Add display metadata
    if (isset($values['custom_product_option'])) {
        $item->add_meta_data('', $values['custom_product_option'], true);
    }
    if (isset($values['special_requests'])) {
        $item->add_meta_data('Special Requests', $values['special_requests'], true);
    }
    if (isset($values['logo_upload'])) {
        $item->add_meta_data('Logo Upload', $values['logo_upload'], true);
    }
    if (isset($values['additional_logos']) && !empty($values['additional_logos'])) {
        $item->add_meta_data('Additional Logos', implode(', ', $values['additional_logos']), true);
    }
    if (isset($values['selected_stand_names']) && !empty($values['selected_stand_names'])) {
        $item->add_meta_data('Selected Stands', implode(', ', $values['selected_stand_names']), true);
    }

    // Include stand cost in price if applicable
    $include_stand_cost = get_post_meta($item->get_product_id(), '_include_stand_cost_in_box_price', true) === 'yes';
    if ($include_stand_cost && isset($values['selected_stand_ids'])) {
        $total_stand_price = 0;
        foreach ($values['selected_stand_ids'] as $stand_id) {
            $stand_product = wc_get_product($stand_id);
            if ($stand_product) {
                $total_stand_price += floatval($stand_product->get_price());
            }
        }
        $item->add_meta_data('Stand Cost', wc_price($total_stand_price), true);
    }

    // Add additional products to the order item
    if (isset($values['additional_products']) && !empty($values['additional_products'])) {
        $item->add_meta_data('Additional Products', implode(', ', $values['additional_products']), true);
    }

    // Include additonal product cost in price if applicable
    $additional_product_cost = get_post_meta($item->get_product_id(), '_additional_product_cost', true) === 'yes';
    if ($additional_product_cost && isset($values['additional_products'])) {
        $total_additional_product_price = 0;
        foreach ($values['additional_products'] as $additional_product_id) {
            $additional_product = wc_get_product($additional_product_id);
            if ($additional_product) {
                $total_additional_product_price += floatval($additional_product->get_price());
            }
        }
        $item->add_meta_data('Additional Product Cost', wc_price($total_additional_product_price), true);
    }
}
add_action('woocommerce_checkout_create_order_line_item', 'add_metadata_to_order_items', 10, 4);

// Filter to hide specific order item meta keys and their values
add_filter('woocommerce_order_item_display_meta_key', 'hide_custom_order_item_meta', 10, 3);
add_filter('woocommerce_order_item_get_formatted_meta_data', 'hide_order_item_meta', 10, 2);

function hide_custom_order_item_meta($display_key, $meta, $item)
{
    // Specify meta keys you want to hide
    $keys_to_hide = array('_unique_key', '_selected_products');

    // Return false if the meta key is in the list to hide
    if (in_array($meta->key, $keys_to_hide)) {
        return false;
    }

    return $display_key;
}

function hide_order_item_meta($formatted_meta, $item)
{
    // Specify meta keys you want to hide
    $keys_to_hide = array('_unique_key', '_selected_products');

    foreach ($formatted_meta as $key => $meta) {
        if (in_array($meta->key, $keys_to_hide)) {
            unset($formatted_meta[$key]); // Remove the meta from the formatted array
        }
    }

    return $formatted_meta;
}
// Display custom metadata in order details, excluding certain fields
function display_custom_metadata_in_order($html, $item, $args)
{
    $custom_option = $item->get_meta('Custom Product Option');
    $special_requests = $item->get_meta('Special Requests');
    $logo_upload = $item->get_meta('Logo Upload');
    $additional_logos = $item->get_meta('Additional Logos');
    $selected_stands = $item->get_meta('Selected Stands');
    $stand_cost = $item->get_meta('Stand Cost');
    //addintnal products
    $additional_products = $item->get_meta('Additional Products');
    //addintnal products cost
    $additional_product_cost = $item->get_meta('Additional Product Cost');

    // Display only relevant metadata
    if ($custom_option) {
        $html .= '<p><strong>' . __('Special Occasion', 'woocommerce') . ':</strong> ' . esc_html($custom_option) . '</p>';
    }
    if ($special_requests) {
        $html .= '<p><strong>' . __('Special Requests', 'woocommerce') . ':</strong> ' . esc_html($special_requests) . '</p>';
    }
    if ($logo_upload) {
        $html .= '<p><strong>' . __('Logo', 'woocommerce') . ':</strong> <img src="' . esc_url($logo_upload) . '" alt="Logo" style="max-width:50px;"></p>';
    }
    if ($additional_logos) {
        $logos = explode(', ', $additional_logos);
        $html .= '<p><strong>' . __('Additional Logos', 'woocommerce') . ':</strong></p><ul>';
        foreach ($logos as $logo) {
            $html .= '<li><img src="' . esc_url($logo) . '" alt="Additional Logo" style="max-width:50px;"></li>';
        }
        $html .= '</ul>';
    }
    if ($selected_stands) {
        $stands = explode(', ', $selected_stands);
        $html .= '<p><strong>' . __('Selected Stands', 'woocommerce') . ':</strong></p><ul>';
        foreach ($stands as $stand_name) {
            $html .= '<li>' . esc_html($stand_name) . '</li>';
        }
        $html .= '</ul>';
    }
    if ($stand_cost) {
        $html .= '<p><strong>' . __('Stand Cost', 'woocommerce') . ':</strong> ' . esc_html($stand_cost) . '</p>';
    }
    if ($additional_products) {
        $products = explode(', ', $additional_products);
        $html .= '<p><strong>' . __('Additional Products', 'woocommerce') . ':</strong></p><ul>';
        foreach ($products as $product_id) {
            $product = wc_get_product($product_id);
            if ($product) {
                $html .= '<li>' . esc_html($product->get_name()) . ' - ' . $product->get_price_html() . '</li>';
            }
        }
        $html .= '</ul>';
    }
    if ($additional_product_cost) {
        $html .= '<p><strong>' . __('Additional Product Cost', 'woocommerce') . ':</strong> ' . esc_html($additional_product_cost) . '</p>';
    }

    return $html;
}
add_filter('woocommerce_display_item_meta', 'display_custom_metadata_in_order', 10, 3);
