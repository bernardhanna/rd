<?php
add_filter('woocommerce_order_again_cart_item_data', 'custom_order_again_cart_item_data', 10, 3);

function custom_order_again_cart_item_data($cart_item_data, $item, $order) {
    $selected_products = $item->get_meta('_selected_products') ? explode(', ', $item->get_meta('_selected_products')) : [];
    $custom_product_option = $item->get_meta('Custom Product Option');
    $special_requests = $item->get_meta('Special Requests');
    $logo_upload = $item->get_meta('Logo Upload');
    $additional_logos = $item->get_meta('Additional Logos') ? explode(', ', $item->get_meta('Additional Logos')) : [];
    $selected_stands = $item->get_meta('Selected Stands') ? explode(', ', $item->get_meta('Selected Stands')) : [];
    $additional_products = $item->get_meta('Additional Products') ? explode(', ', $item->get_meta('Additional Products')) : [];

    $stand_cost = floatval($item->get_meta('Stand Cost')); // Ensure numeric
    $additional_product_cost = floatval($item->get_meta('Additional Product Cost')); // Ensure numeric

    $unique_key = uniqid('donut_box_');

    // If the item is part of a donut box, add necessary data
    if (!empty($selected_products)) {
        $cart_item_data['selected_products'] = $selected_products;
        $cart_item_data['custom_product_option'] = $custom_product_option;
        $cart_item_data['special_requests'] = $special_requests;
        $cart_item_data['logo_upload'] = $logo_upload;
        $cart_item_data['additional_logos'] = $additional_logos;
        $cart_item_data['part_of_box'] = false;  // Mark this as the main product
        $cart_item_data['unique_key'] = $unique_key;
        $cart_item_data['selected_stand_ids'] = $selected_stands;
        $cart_item_data['total_stand_cost'] = $stand_cost;
        $cart_item_data['additional_products'] = $additional_products;
    }

    return $cart_item_data;
}

add_action('woocommerce_after_order_again_cart_item_added', 'add_child_items_to_cart_for_order_again', 10, 3);
function add_child_items_to_cart_for_order_again($cart_item_key, $item, $order) {
    if ($item->get_meta('_part_of_box') || $item->get_meta('_parent_item_key')) {
        WC()->cart->remove_cart_item($cart_item_key);
        return;
    }
    // Get selected products from the order item meta
    $selected_products = $item->get_meta('_selected_products') ? explode(', ', $item->get_meta('_selected_products')) : [];

    // Get the unique key of the main product in the cart
    $unique_key = WC()->cart->get_cart_item($cart_item_key)['unique_key'] ?? '';

    if (!empty($selected_products) && $unique_key) {
        foreach ($selected_products as $selected_product_id) {
            // Ensure selected_product_id is numeric
            if (is_numeric($selected_product_id)) {
                // Add each selected product to the cart as a child item
                WC()->cart->add_to_cart(intval($selected_product_id), 1, 0, array(), array(
                    'parent_item_key' => $unique_key,  // Link to the main product
                    'part_of_box' => true,
                    'unique_key' => $unique_key,
                ));
            }
        }
    }
}

/*
add_action('woocommerce_before_cart', 'dump_cart_contents');

function dump_cart_contents() {
    echo '<h2>Cart Contents</h2>';
    echo '<pre>';
    var_dump(WC()->cart->get_cart());
    echo '</pre>';
} */