<?php
// Add custom fields data to cart item data
add_filter('woocommerce_add_cart_item_data', 'add_custom_fields_to_cart_item_data_separate', 10, 2);
function add_custom_fields_to_cart_item_data_separate($cart_item_data, $product_id) {
    if (isset($_POST['custom_fields'])) {
        $custom_fields = json_decode(stripslashes($_POST['custom_fields']), true);
        
        if (is_array($custom_fields)) {
            foreach ($custom_fields as $name => $field) {
                // Set a default text for select fields
                $default_value = ($field['type'] === 'select') ? 'Select an option' : '';

                // Check if there's a meaningful value
                $has_value = isset($field['value']) && $field['value'] !== $default_value && !empty($field['value']);

                if ($has_value) {
                    $cart_item_data['custom_fields_separate'][] = array(
                        'title' => isset($field['title']) ? sanitize_text_field($field['title']) : '',
                        'value' => is_array($field['value']) ? array_map('sanitize_text_field', $field['value']) : sanitize_text_field($field['value']),
                        'type'  => isset($field['type']) ? sanitize_text_field($field['type']) : '',
                        'additional_cost' => isset($field['additional_cost']) ? floatval($field['additional_cost']) : 0,
                        'default' => $default_value,
                    );
                }
            }
        }
        // Log to verify the correct data is being added to the cart item
        error_log('Added Custom Fields to Cart (Separate): ' . print_r($cart_item_data['custom_fields_separate'], true));
    }
    return $cart_item_data;
}


// Adjust price in cart based on custom fields
add_action('woocommerce_before_calculate_totals', 'adjust_cart_item_price_based_on_custom_fields_separate', 10, 1);
function adjust_cart_item_price_based_on_custom_fields_separate($cart) {
    if (is_admin() && !defined('DOING_AJAX')) return;

    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        if (isset($cart_item['custom_fields_separate'])) {
            $additional_cost = 0;
            foreach ($cart_item['custom_fields_separate'] as $field) {
                if (isset($field['additional_cost'])) {
                    $additional_cost += (float)$field['additional_cost'];
                }
            }
            if ($additional_cost > 0) {
                $cart_item['data']->set_price($cart_item['data']->get_price() + $additional_cost);
                // Log the new price after adjustment
                error_log("Adjusted Cart Item Price (Separate): " . $cart_item['data']->get_price());
            }
        }
    }
}

// Rename the function to avoid conflict
add_action('wp_ajax_donut_box_add_to_cart_separate', 'donut_box_add_to_cart_separate');
add_action('wp_ajax_nopriv_donut_box_add_to_cart_separate', 'donut_box_add_to_cart_separate');

function donut_box_add_to_cart_separate() {
    check_ajax_referer('donut_box_builder_nonce', 'nonce');

    $donut_box_product_id = isset($_POST['donut_box_product_id']) ? intval($_POST['donut_box_product_id']) : 0;
    $selected_products = isset($_POST['products']) ? array_map('intval', explode(',', sanitize_text_field($_POST['products']))) : array();
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $custom_fields = isset($_POST['custom_fields']) ? json_decode(stripslashes($_POST['custom_fields']), true) : array();

    if ($donut_box_product_id > 0 && !empty($selected_products)) {
        $unique_key = uniqid('donut_box_');
        $cart_item_data = array(
            'selected_products' => $selected_products,
            'custom_fields_separate' => $custom_fields,
            'part_of_box' => false,
            'unique_key' => $unique_key,
        );

        $cart_item_key = WC()->cart->add_to_cart($donut_box_product_id, $quantity, 0, array(), $cart_item_data);

        if ($cart_item_key) {
            foreach ($selected_products as $selected_product_id) {
                WC()->cart->add_to_cart($selected_product_id, $quantity, 0, array(), array(
                    'parent_item_key' => $unique_key,
                    'part_of_box' => true,
                    'unique_key' => $unique_key,
                ));
            }
            wc_add_notice(__('Box added to the cart!', 'donut-box-builder'), 'success');
            wp_send_json_success(array(
                'cart_contents_count' => WC()->cart->get_cart_contents_count(),
                'cart_total' => WC()->cart->get_cart_total(),
            ));
        } else {
            wp_send_json_error(array('message' => 'Unable to add product to cart.'));
        }
    }
    wp_die();
}
// Display custom fields and product add-ons in the cart
add_filter('woocommerce_get_item_data', 'display_custom_fields_and_add_ons_in_cart', 10, 2);
function display_custom_fields_and_add_ons_in_cart($item_data, $cart_item) {
    if (isset($cart_item['custom_fields_separate'])) {
        $unique_fields = [];

        foreach ($cart_item['custom_fields_separate'] as $field) {
            // Set a default text for select fields
            $default_value = isset($field['default']) ? $field['default'] : 'Select an option';
            $has_value = isset($field['value']) && $field['value'] !== $default_value && !empty($field['value']);

            // Specifically handle the 'select' field to check for a meaningful selection
            if ($field['type'] === 'select' && $field['value'] === $default_value) {
                $has_value = false;  // If the value is the default (e.g., first option), treat as no selection
            }

            if ($has_value) {
                if ($field['type'] === 'image' && !empty($field['value'])) {
                    $field_value = '<img src="' . esc_url($field['value']) . '" style="max-width: 50px;">';
                } else {
                    $field_value = is_array($field['value']) ? implode(', ', $field['value']) : wc_clean($field['value']);
                }

                // Use the field's title as a unique key to avoid duplication
                $unique_fields[$field['title']] = array(
                    'name' => $field['title'],
                    'value' => $field_value,
                );
            }

            // Handle checkbox fields if applicable
            if ($field['type'] === 'checkbox' && isset($field['checked_options'])) {
                $checked_options = implode(', ', $field['checked_options']);
                if (!empty($checked_options)) {
                    $unique_fields[$field['title']] = array(
                        'name' => $field['title'],
                        'value' => $checked_options,
                    );
                }
            }
        }

        // Add unique fields to item data
        foreach ($unique_fields as $field) {
            $item_data[] = $field;
        }

        // Log the custom fields stored in the cart item
        error_log('Custom Fields in Cart Item (Combined): ' . print_r($unique_fields, true));
    }

    return $item_data;
}
