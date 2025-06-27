<?php
// Handle AJAX requests to add the donut box to the cart
add_action('wp_ajax_donut_box_add_to_cart', 'donut_box_add_to_cart');
add_action('wp_ajax_nopriv_donut_box_add_to_cart', 'donut_box_add_to_cart');

function donut_box_add_to_cart() {

    // Verify and log nonce
    if (!check_ajax_referer('donut_box_builder_nonce', 'nonce', false)) {
        error_log('Nonce verification failed');
        wp_send_json_error(array('message' => 'Nonce verification failed.'));
        return;
    }


    $donut_box_product_id = isset($_POST['donut_box_product_id']) ? intval($_POST['donut_box_product_id']) : 0;
    $products_data_json = isset($_POST['products_data']) ? stripslashes($_POST['products_data']) : '';
    $products_data = json_decode($products_data_json, true);
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $custom_price = isset($_POST['custom_price']) ? floatval($_POST['custom_price']) : null;
     // Validate custom price for product ID 3947
    if ($donut_box_product_id == 3947) {
        if ($custom_price === null || $custom_price <= 0) {
            error_log('Invalid custom price: ' . $custom_price);
            wp_send_json_error(array('message' => 'Please enter a valid custom price.'));
            return;
        }
    }
    $custom_product_option = isset($_POST['custom_product_option']) ? sanitize_text_field($_POST['custom_product_option']) : '';
    $special_requests = isset($_POST['special_requests']) ? sanitize_text_field($_POST['special_requests']) : '';
    $logo_upload = '';
    $additional_logos = [];

    $selected_stand_ids = isset($_POST['stand_ids']) ? array_map('intval', explode(',', sanitize_text_field($_POST['stand_ids']))) : array();
    $selected_stand_prices = isset($_POST['stand_prices']) ? array_map('floatval', explode(',', sanitize_text_field($_POST['stand_prices']))) : array();

    $selected_additional_products = isset($_POST['additional_products']) ? array_map('intval', explode(',', sanitize_text_field($_POST['additional_products']))) : array();
    $additional_products_data_json = isset($_POST['additional_products_data']) ? stripslashes($_POST['additional_products_data']) : '';
    $additional_products_data = json_decode($additional_products_data_json, true);
    $total_stand_cost = array_sum($selected_stand_prices);

    if (!empty($_FILES['logo_upload']) && $_FILES['logo_upload']['size'] > 0) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $uploaded_file = wp_handle_upload($_FILES['logo_upload'], array('test_form' => false));
        if (isset($uploaded_file['url'])) {
            $logo_upload = $uploaded_file['url'];
        }
    }

    if (!empty($_FILES['additional_logos']['name'])) {
        foreach ($_FILES['additional_logos']['name'] as $key => $value) {
            if ($_FILES['additional_logos']['size'][$key] > 0) {
                $_FILES['file'] = [
                    'name'     => $_FILES['additional_logos']['name'][$key],
                    'type'     => $_FILES['additional_logos']['type'][$key],
                    'tmp_name' => $_FILES['additional_logos']['tmp_name'][$key],
                    'error'    => $_FILES['additional_logos']['error'][$key],
                    'size'     => $_FILES['additional_logos']['size'][$key],
                ];
                $uploaded_file = wp_handle_upload($_FILES['file'], array('test_form' => false));
                if (isset($uploaded_file['url'])) {
                    $additional_logos[] = $uploaded_file['url'];
                }
            }
        }
    }

   if ($donut_box_product_id > 0 && (!empty($products_data) || $donut_box_product_id == 3947)) {
        $unique_key = uniqid('donut_box_');
        $cart_item_data = array(
            'products_data' => $products_data,
            'custom_price' => $custom_price,
            'custom_product_option' => $custom_product_option,
            'special_requests' => $special_requests,
            'logo_upload' => $logo_upload,
            'additional_logos' => $additional_logos,
            'part_of_box' => false,
            'unique_key' => $unique_key,
            'selected_stand_ids' => $selected_stand_ids,
            'selected_stand_names' => isset($_POST['stand_names']) ? explode(',', sanitize_text_field($_POST['stand_names'])) : [],
            'total_stand_cost' => $total_stand_cost,
            'selected_additional_products' => $additional_products_data,
        );

        $cart_item_key = WC()->cart->add_to_cart($donut_box_product_id, $quantity, 0, array(), $cart_item_data);

        if ($cart_item_key) {
            // Add box items only if products_data is not empty
            if (!empty($products_data)) {
                foreach ($products_data as $product_data) {
                    $product_id = intval($product_data['id']);
                    $product_quantity = intval($product_data['quantity']) * $quantity;
                    WC()->cart->add_to_cart($product_id, $product_quantity, 0, array(), array(
                        'parent_item_key' => $unique_key,
                        'part_of_box' => true,
                        'unique_key' => $unique_key,
                    ));
                }
            }

          // Add additional products with quantities
        // Modify the loop where additional products are added
        if (!empty($additional_products_data)) {
            foreach ($additional_products_data as $additional_product) {
                $additional_product_id = intval($additional_product['id']);
                $additional_product_quantity = intval($additional_product['quantity']) * $quantity; // Multiply by box quantity if needed

                $additional_product_obj = wc_get_product($additional_product_id);
                if ($additional_product_obj) {
                    // Check if the additional product is a box builder product
                    if ($additional_product_obj->get_type() === 'donut_box_builder') {
                        // Fetch the prefilled products for this box builder product
                        $prefilled_products = get_post_meta($additional_product_id, '_prefilled_box_products', true);
                        $prefilled_products_data = [];
                        if ($prefilled_products) {
                            foreach ($prefilled_products as $product_id) {
                                $prefilled_product = wc_get_product($product_id);
                                if ($prefilled_product) {
                                    $prefilled_products_data[] = [
                                        'id' => $product_id,
                                        'name' => $prefilled_product->get_name(),
                                        'thumbnail' => wp_get_attachment_image_url($prefilled_product->get_image_id(), 'woocommerce_thumbnail'),
                                        'price' => $prefilled_product->get_price(),
                                        'quantity' => 1
                                    ];
                                }
                            }
                        }

                        // Generate a unique key for this additional box
                        $additional_box_unique_key = uniqid('donut_box_');

                        // Add the box builder product to the cart
                        $cart_item_data = array(
                            'products_data' => $prefilled_products_data,
                            'custom_price' => $additional_product_obj->get_price(),
                            'part_of_box' => true,
                            'unique_key' => $additional_box_unique_key,
                            'parent_item_key' => $unique_key, // Set the parent as the main box
                        );

                        $additional_cart_item_key = WC()->cart->add_to_cart($additional_product_id, $additional_product_quantity, 0, array(), $cart_item_data);

                        if ($additional_cart_item_key) {
                            // Add the items in the box to the cart
                            if (!empty($prefilled_products_data)) {
                                foreach ($prefilled_products_data as $product_data) {
                                    $product_id = intval($product_data['id']);
                                    $product_quantity = intval($product_data['quantity']) * $additional_product_quantity;
                                    WC()->cart->add_to_cart($product_id, $product_quantity, 0, array(), array(
                                        'parent_item_key' => $additional_box_unique_key,
                                        'part_of_box' => true,
                                        'unique_key' => $additional_box_unique_key,
                                    ));
                                }
                            }
                        }
                    } else {
                        // If it's not a box builder product, add it as usual
                        WC()->cart->add_to_cart($additional_product_id, $additional_product_quantity, 0, array(), array(
                            'parent_item_key' => $unique_key,
                            'part_of_box' => true,
                            'unique_key' => $unique_key,
                        ));
                    }
                }
            }
        }


            foreach ($selected_stand_ids as $index => $selected_stand_id) {
                WC()->cart->add_to_cart($selected_stand_id, $quantity, 0, array(), array(
                    'parent_item_key' => $unique_key,
                    'part_of_box' => true,
                    'unique_key' => $unique_key,
                ));
            }

            foreach ($selected_additional_products as $additional_product_id) {
                WC()->cart->add_to_cart($additional_product_id, $quantity, 0, array(), array(
                    'parent_item_key' => $unique_key,
                    'part_of_box' => true,
                    'unique_key' => $unique_key,
                ));
            }

            wc_add_notice(__('Box added to the cart!', 'donut-box-builder'), 'success');
        } else {
            wp_send_json_error(array('message' => 'Unable to add product to cart.'));
            return;
        }

        wp_send_json_success(array(
            'cart_contents_count' => WC()->cart->get_cart_contents_count(),
            'cart_total' => WC()->cart->get_cart_total(),
        ));
    }
    wp_die();
}

// Fix box price
add_filter('woocommerce_get_cart_item_from_session', 'fix_donut_box_builder_price', 10, 2);
function fix_donut_box_builder_price($cart_item, $values) {
    if (isset($values['part_of_box']) && $values['part_of_box'] === true) {
        $cart_item['data']->set_price(0); // Ensure price of box items is set to 0
    } elseif (isset($values['selected_products']) && isset($values['part_of_box']) && $values['part_of_box'] === false) {
        $product = wc_get_product($cart_item['product_id']);
        if ($product && $product->get_type() === 'donut_box_builder') {
            $base_price = floatval($product->get_price()); // Ensure base price is a float
            error_log("Base Price: " . $base_price); // Log base price

            // Check if include_stand_cost is enabled
            $include_stand_cost = get_field('include_stand_cost_in_box_price', $product->get_id());
            $additional_cost = 0;
            if ($include_stand_cost) {
                $additional_cost = isset($values['total_stand_cost']) ? floatval($values['total_stand_cost']) : 0;
                error_log("Total Stand Cost: " . $additional_cost); // Log total stand cost

                // Calculate the cost of additional products
                if (!empty($values['selected_additional_products'])) {
                    foreach ($values['selected_additional_products'] as $additional_product_id) {
                        $additional_product = wc_get_product($additional_product_id);
                        if ($additional_product) {
                            $additional_cost += floatval($additional_product->get_price());
                            error_log("Additional Product Cost: " . $additional_product->get_price()); // Log additional product price
                        }
                    }
                }
            }

            // Log final price calculation before setting it
            error_log("Final Price: " . ($base_price + $additional_cost));

            // Add base price and additional costs
            $cart_item['data']->set_price($base_price + $additional_cost);
        }
    }
    return $cart_item;
}

// Ensure prices are recalculated for both cart and basket
add_action('woocommerce_before_calculate_totals', 'recalculate_box_item_prices', 10, 1);
function recalculate_box_item_prices($cart) {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    // Loop through cart items
    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        // Child items of the box should have a price of 0
        if (isset($cart_item['part_of_box']) && $cart_item['part_of_box'] === true) {
            $cart_item['data']->set_price(0);
        }
        // Main product logic
        elseif (isset($cart_item['part_of_box']) && $cart_item['part_of_box'] === false) {
            $product = wc_get_product($cart_item['product_id']);

            if ($product && $product->get_type() === 'donut_box_builder') {
                // Check if custom price is set for 'custom-order' product
                if (isset($cart_item['custom_price']) && $cart_item['custom_price'] > 0) {
                    // Use the custom price provided by the customer
                    $cart_item['data']->set_price($cart_item['custom_price']);
                } else {
                    // Existing logic for other 'donut_box_builder' products
                    $base_price = floatval($product->get_price());

                    // Include stand cost if applicable
                    $include_stand_cost = get_field('include_stand_cost_in_box_price', $product->get_id());
                    $additional_cost = $include_stand_cost ? (isset($cart_item['total_stand_cost']) ? floatval($cart_item['total_stand_cost']) : 0) : 0;

                // Include additional product costs
                if (!empty($cart_item['selected_additional_products'])) {
                    foreach ($cart_item['selected_additional_products'] as $additional_product) {
                        $additional_product_id = intval($additional_product['id']);
                        $additional_product_quantity = intval($additional_product['quantity']);
                        $additional_product_obj = wc_get_product($additional_product_id);
                        if ($additional_product_obj) {
                            $additional_cost += floatval($additional_product_obj->get_price()) * $additional_product_quantity;
                        }
                    }
                }

                    // Calculate the final price
                    $final_price = $base_price + $additional_cost;
                    $cart_item['data']->set_price($final_price);
                }
            }
        }
    }
}

// Adjust cart count to only show main products for box builder products
add_filter('woocommerce_cart_contents_count', 'adjust_cart_contents_count', 10, 1);
function adjust_cart_contents_count($count) {
    $main_product_count = 0;
    foreach (WC()->cart->get_cart() as $cart_item) {
        // Check if this is a box builder main product (has 'selected_products')
        if (isset($cart_item['selected_products'])) {
            $main_product_count += $cart_item['quantity'];
        }
        // Check if this is NOT a part of a box
        elseif (!isset($cart_item['part_of_box']) || $cart_item['part_of_box'] === false) {
            $main_product_count += $cart_item['quantity'];
        }
        // Else, it's an item inside a box builder product, do not count
    }
    return $main_product_count;
}


// Ensure box items are removed with the main product
// Ensure box items are removed with the main product
add_action('woocommerce_cart_item_removed', 'remove_associated_box_items', 10, 2);
function remove_associated_box_items($cart_item_key, $cart) {
    // Check if the removed item is a main product (box)
    if (isset($cart->removed_cart_contents[$cart_item_key])) {
        $removed_item = $cart->removed_cart_contents[$cart_item_key];

        // Check if this is a box builder main product by looking for 'unique_key' or other identifiers
        if (isset($removed_item['unique_key']) && $removed_item['part_of_box'] === false) {
            $box_unique_key = $removed_item['unique_key'];

            // Loop through the current cart items
            foreach ($cart->get_cart() as $key => $item) {
                // If the item has the same 'parent_item_key' as the removed box
                if (isset($item['parent_item_key']) && $item['parent_item_key'] === $box_unique_key) {
                    // Remove the child item from the cart
                    WC()->cart->remove_cart_item($key);
                }
            }
        }
    }
}


add_action('woocommerce_cart_loaded_from_session', 'log_cart_items');
function log_cart_items() {
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $product = $cart_item['data'];
        $product_id = $product->get_id();
        $product_type = $product->get_type();
        $is_box_builder = get_post_meta($product_id, 'is_donut_box_builder', true);

        error_log("Product ID: $product_id, Type: $product_type, Is Box Builder: $is_box_builder");
    }
}

// Remove product link in cart for custom orders
add_filter( 'woocommerce_cart_item_permalink', 'remove_permalink_for_custom_order', 10, 3 );
function remove_permalink_for_custom_order( $permalink, $cart_item, $cart_item_key ) {
    $product = $cart_item['data'];
    if ( $product->get_id() == 3947 ) {
        return ''; // Return empty permalink to prevent link wrapping
    }
    return $permalink;
}


// Remove link from product name in cart for custom orders
add_filter( 'woocommerce_cart_item_name', 'remove_link_from_custom_order_name', 10, 3 );
function remove_link_from_custom_order_name( $product_name, $cart_item, $cart_item_key ) {
    $product = $cart_item['data'];
    if ( $product->get_id() == 3947 ) {
        // Return the product name without the link
        $product_name = $product->get_name();
    }
    return $product_name;
}

// Remove link from product thumbnail in cart for custom orders
add_filter( 'woocommerce_cart_item_thumbnail', 'remove_link_from_custom_order_thumbnail', 10, 3 );
function remove_link_from_custom_order_thumbnail( $product_image, $cart_item, $cart_item_key ) {
    $product = $cart_item['data'];
    if ( $product->get_id() == 3947 ) {
        // Return the product image without the link
        $product_image = $product->get_image();
    }
    return $product_image;
}

// Display Stand Types and Additional Products in the Cart
add_action('woocommerce_cart_item_name', 'display_donut_box_items_below', 10, 3);
function display_donut_box_items_below($product_name, $cart_item, $cart_item_key) {
    // Check if the cart item is a main box product (part_of_box is false)
    if (isset($cart_item['part_of_box']) && $cart_item['part_of_box'] === false) {
        $output = '<strong>' . $product_name . '</strong>';

        if (isset($cart_item['custom_price']) && $cart_item['custom_price'] > 0) {
            $output .= '<small class="hidden">Custom Price: ' . wc_price($cart_item['custom_price']) . '</small>';
        }

        if (!empty($cart_item['custom_product_option'])) {
            $output .= '<small>Occasion: ' . esc_html($cart_item['custom_product_option']) . '</small>';
        }
        if (!empty($cart_item['special_requests'])) {
            $output .= '<small>Requests: ' . esc_html($cart_item['special_requests']) . '</small>';
        }
        if (!empty($cart_item['logo_upload'])) {
            $output .= '<small>Logo: <img src="' . esc_url($cart_item['logo_upload']) . '" alt="Uploaded Logo" style="max-width:50px;"></small>';
        }
        if (!empty($cart_item['additional_logos'])) {
            $output .= '<small>Additional Logos:</small><ul>';
            foreach ($cart_item['additional_logos'] as $logo) {
                $output .= '<li><img src="' . esc_url($logo) . '" alt="Additional Logo" style="max-width:50px;"></li>';
            }
            $output .= '</ul>';
        }

        // Display selected stand types only if there are selected stands
        if (!empty($cart_item['selected_stand_ids']) && !empty($cart_item['selected_stand_names'])) { 
            $output .= '<small></small><ul>';
            foreach ($cart_item['selected_stand_names'] as $stand_name) {
                $output .= '<li>' . esc_html($stand_name) . '</li>';
            }
            $output .= '</ul>';
        }

        // Display additional products
        if (!empty($cart_item['selected_additional_products'])) {
            $output .= '<small>Additional Products:</small><ul>';
            foreach ($cart_item['selected_additional_products'] as $additional_product) {
                $additional_product_id = intval($additional_product['id']);
                $additional_product_quantity = intval($additional_product['quantity']);
                $additional_product_obj = wc_get_product($additional_product_id);
                if ($additional_product_obj) {
                    $output .= '<li>' . $additional_product_obj->get_name() . ' x ' . $additional_product_quantity . '</li>';
                }
            }
            $output .= '</ul>';
        }

        // Display child items (donuts inside the box)
        $child_items_output = '';
        foreach (WC()->cart->get_cart() as $key => $item) {
            if (isset($item['parent_item_key']) && $item['parent_item_key'] === $cart_item['unique_key']) {
                // Ensure stands are not included in this section
                if (!in_array($item['product_id'], $cart_item['selected_stand_ids'])) {
                    // Check if the item is an additional box builder product
                    $child_product = $item['data'];
                    if ($child_product->get_type() === 'donut_box_builder') {
                        // Display the additional box builder product and its items
                        $child_output = '<strong>' . $child_product->get_name() . '</strong>';

                        // Get the child item's unique_key
                        $child_unique_key = $item['unique_key'];

                        // Display the items inside the additional box builder product
                        $grandchild_items_output = '';
                        foreach (WC()->cart->get_cart() as $gkey => $gitem) {
                            if (isset($gitem['parent_item_key']) && $gitem['parent_item_key'] === $child_unique_key) {
                                $grandchild_items_output .= '<li>' . $gitem['data']->get_name() . ' x ' . $gitem['quantity'] . '</li>';
                            }
                        }

                        if (!empty($grandchild_items_output)) {
                            $child_output .= '<br><small>Selected Flavours:</small><ul class="donut-box-builder-items">' . $grandchild_items_output . '</ul>';
                        }

                        $child_items_output .= '<li>' . $child_output . '</li>';
                    } else {
                        // Regular child item (donut)
                        $child_items_output .= '<li>' . $item['data']->get_name() . ' x ' . $item['quantity'] . '</li>';
                    }
                }
            }
        }

        if (!empty($child_items_output)) {
            $output .= '<br><small>Selected Flavours:</small>';
            $output .= '<ul class="donut-box-builder-items">' . $child_items_output . '</ul>';
        }

        return $output;
    }

    // Handle additional box builder products added as additional products
    elseif (isset($cart_item['part_of_box']) && $cart_item['part_of_box'] === true) {
        $product = $cart_item['data'];
        if ($product->get_type() === 'donut_box_builder') {
            // This is an additional box builder product added as an additional product
            $output = '<strong>' . $product_name . '</strong>';

            // Display the items inside this box
            $child_items_output = '';
            foreach (WC()->cart->get_cart() as $key => $item) {
                if (isset($item['parent_item_key']) && $item['parent_item_key'] === $cart_item['unique_key']) {
                    $child_items_output .= '<li>' . $item['data']->get_name() . ' x ' . $item['quantity'] . '</li>';
                }
            }

            if (!empty($child_items_output)) {
                $output .= '<br><small>Selected Flavours:</small>';
                $output .= '<ul class="donut-box-builder-items">' . $child_items_output . '</ul>';
            }

            return $output;
        }
    }

    // For other products, return the default product name
    return $product_name;
}


// Enhance Cart Item Display with Hooks
add_filter('woocommerce_cart_item_class', 'custom_cart_item_classes', 10, 3);

function custom_cart_item_classes($class, $cart_item, $cart_item_key) {
    if (isset($cart_item['part_of_box']) && $cart_item['part_of_box'] === false) {
        $class .= ' main-product';
    } elseif (isset($cart_item['parent_item_key'])) {
        $class .= ' child-product';
    }
    return $class;
}

// Adjust quantities of box items when the main product's quantity changes
add_action('woocommerce_after_cart_item_quantity_update', 'adjust_box_item_quantities', 10, 3);
function adjust_box_item_quantities($cart_item_key, $quantity, $old_quantity) {
    $cart = WC()->cart->get_cart();

    // Check if the cart item is a main product
    if (isset($cart[$cart_item_key]['part_of_box']) && $cart[$cart_item_key]['part_of_box'] === false) {
        $factor = $quantity / max($old_quantity, 1); // Avoid division by zero

        // Loop through all cart items
        foreach ($cart as $key => $item) {
            // If the item is a child of the current main product
            if (isset($item['parent_item_key']) && $item['parent_item_key'] === $cart[$cart_item_key]['unique_key']) {
                // Calculate the new quantity for the child items
                $new_quantity = $item['original_quantity'] * $factor;

                // Update the quantity of the child item
                WC()->cart->set_quantity($key, $new_quantity);
            }
        }
    }
}

add_filter('woocommerce_get_cart_contents', 'custom_reorder_cart_items_for_display', 10, 1);
function custom_reorder_cart_items_for_display($cart_contents) {
    $ordered_cart_contents = [];
    $main_products = [];

    // Collect main products with their unique keys
    foreach ($cart_contents as $cart_item_key => $cart_item) {
        if (isset($cart_item['part_of_box']) && $cart_item['part_of_box'] === false) {
            $main_products[$cart_item_key] = $cart_item;
        }
    }

    // Order items: each main product followed by its child items
    foreach ($main_products as $main_key => $main_item) {
        $ordered_cart_contents[$main_key] = $main_item;
        foreach ($cart_contents as $child_key => $child_item) {
            if (isset($child_item['parent_item_key']) && $child_item['parent_item_key'] === $main_item['unique_key']) {
                $ordered_cart_contents[$child_key] = $child_item;
            }
        }
    }

    // Add any remaining items that were not reordered
    foreach ($cart_contents as $cart_item_key => $cart_item) {
        if (!isset($ordered_cart_contents[$cart_item_key])) {
            $ordered_cart_contents[$cart_item_key] = $cart_item;
        }
    }

    return $ordered_cart_contents;
}

// Remove quantity and delete options for box items
add_filter('woocommerce_cart_item_quantity', 'custom_cart_item_quantity', 10, 3);
function custom_cart_item_quantity($product_quantity, $cart_item_key, $cart_item) {
    if (isset($cart_item['part_of_box']) && $cart_item['part_of_box'] === true) {
        return '<span>' . $cart_item['quantity'] . '</span>'; // Display correct quantity for box items
    }
    return $product_quantity;
}

// Remove the remove link for box items
add_filter('woocommerce_cart_item_remove_link', 'custom_cart_item_remove_link', 10, 2);
function custom_cart_item_remove_link($link, $cart_item_key) {
    $cart = WC()->cart->get_cart();
    if (isset($cart[$cart_item_key]['part_of_box']) && $cart[$cart_item_key]['part_of_box'] === true) {
        return ''; // No remove link for box items
    }
    return $link;
}

// Display additional product add-ons in the cart
add_filter('woocommerce_get_item_data', 'display_product_add_ons_in_cart', 10, 2);
function display_product_add_ons_in_cart($item_data, $cart_item) {
    if (isset($cart_item['custom_fields'])) {
        foreach ($cart_item['custom_fields'] as $field) {
            if ($field['type'] === 'select' && isset($field['selected_options'])) {
                $selected_options = implode(', ', $field['selected_options']);
                $item_data[] = array(
                    'name' => $field['title'],
                    'value' => $selected_options,
                );
            }
            if ($field['type'] === 'checkbox' && isset($field['checked_options'])) {
                $checked_options = implode(', ', $field['checked_options']);
                $item_data[] = array(
                    'name' => $field['title'],
                    'value' => $checked_options,
                );
            }
            if ($field['type'] === 'text' || $field['type'] === 'textarea') {
                $item_data[] = array(
                    'name' => $field['title'],
                    'value' => $field['value'],
                );
            }
            if ($field['type'] === 'image' && !empty($field['image_url'])) {
                $item_data[] = array(
                    'name' => $field['title'],
                    'value' => '<img src="' . esc_url($field['image_url']) . '" style="max-width: 50px;">',
                );
            }
        }
    }
    return $item_data;
}