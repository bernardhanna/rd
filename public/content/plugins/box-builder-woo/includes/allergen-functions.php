<?php
defined('ABSPATH') || exit;

function display_donut_allergens_below_cart_button() {
    global $product;

    // Ensure that the $product variable is a valid WC_Product object
    if (!$product || !is_a($product, 'WC_Product')) {
        // Attempt to retrieve product via the current post ID
        $post_id = get_the_ID();
        $product = wc_get_product($post_id);

        // If still null, do not proceed
        if (!$product || !is_a($product, 'WC_Product')) {
            return;
        }
    }

    // Get the product ID
    $product_id = $product->get_id();

    // Check if the product is the custom order product (ID 3947)
    if ($product_id == 3947) {
        echo '';
        return; // Do not display allergens for custom order product
    }

    // Determine the selected products to show allergen information
    $selected_products = [];

    // Get group selection type
    $group_selection = get_post_meta($product_id, '_donut_group_selection', true);

    // Handle group selection based on category, size, or manually selected variations
    if ($group_selection === 'category') {
        // Fetch donuts by selected category
        $selected_category = get_post_meta($product_id, '_donut_category_selection', true);
        if ($selected_category) {
            $args = array(
                'status' => 'publish',
                'limit' => -1,
                'type' => 'variable',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'slug',
                        'terms' => $selected_category,
                    ),
                ),
            );
            $category_products = wc_get_products($args);
            foreach ($category_products as $category_product) {
                $variations = $category_product->get_children();
                foreach ($variations as $variation_id) {
                    $variation_product = wc_get_product($variation_id);
                    if ($variation_product) {
                        $selected_products[] = $variation_product;
                    }
                }
            }
        }
    } elseif ($group_selection === 'all_large_donuts' || $group_selection === 'all_midi_donuts') {
        // Fetch all donuts of a specific size
        $selected_size = ($group_selection === 'all_large_donuts') ? 'large' : 'midi';
        $args = array(
            'status' => 'publish',
            'limit' => -1,
            'type' => 'variable',
            'tax_query' => array(
                array(
                    'taxonomy' => 'rd_product_type',
                    'field' => 'slug',
                    'terms' => 'donut',
                ),
            ),
        );
        $size_products = wc_get_products($args);
        foreach ($size_products as $size_product) {
            if ($size_product->is_type('variable')) {
                $variations = $size_product->get_children();
                foreach ($variations as $variation_id) {
                    $variation_product = wc_get_product($variation_id);
                    if ($variation_product) {
                        $variation_attributes = $variation_product->get_attributes();
                        if (isset($variation_attributes['pa_size']) && strtolower($variation_attributes['pa_size']) === strtolower($selected_size)) {
                            $selected_products[] = $variation_product;
                        }
                    }
                }
            }
        }
    } else {
        // Default: Use manually selected variations if no specific selection is made
        $selected_variations = get_post_meta($product->get_id(), '_custom_box_products', true);
        if ($selected_variations) {
            foreach ($selected_variations as $variation_id) {
                $variation_product = wc_get_product($variation_id);
                if ($variation_product) {
                    $selected_products[] = $variation_product;
                }
            }
        }
    }

    // Use an associative array to keep track of displayed allergens to prevent duplicates
    $displayed_allergens = [];

    // Display allergens info
    if (!empty($selected_products)) {
        echo '<div class="mt-8 border border-black border-solid rounded-sm-8" id="info-open" data-accordion="open" x-data="{ open: null }">';
        echo '<div>';
        echo '<div id="info-open-heading">';
        echo '<button id="accordionButton" type="button" class="flex items-center justify-between w-full px-4 py-3 font-medium text-left"
                @click="open = open === 1 ? null : 1"
                :aria-expanded="open === 1"
                aria-controls="info-open-body">';
       echo '<div class="flex items-center">';
       echo '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
<path d="M22.1099 21.7931L20.8399 23.0631L17.6899 19.9131C17.3599 20.5431 16.9299 21.1031 16.4099 21.5831C15.6468 22.3024 14.7194 22.8242 13.7085 23.1031C12.6976 23.3819 11.6338 23.4094 10.6099 23.1831C7.09986 22.4331 4.86986 18.9731 5.61986 15.4631C5.86986 14.2831 6.44986 13.2031 7.27986 12.3331C7.44375 12.1603 7.5351 11.9312 7.5351 11.6931C7.5351 11.4549 7.44375 11.2259 7.27986 11.0531C6.634 10.2449 6.20697 9.28407 6.03986 8.26308L1.10986 3.33308L2.38986 2.06308L22.1099 21.7931ZM15.2999 19.8931C15.6899 19.4631 15.9999 18.9631 16.1899 18.4131L13.7499 15.9731C13.5699 16.2031 13.2899 16.3331 12.9999 16.3331C12.4499 16.3331 11.9999 15.8831 11.9999 15.3331C11.9999 15.0431 12.1299 14.7631 12.3599 14.5831L9.54986 11.7731C9.52986 12.5131 9.23986 13.2131 8.72986 13.7431C7.02986 15.5531 7.12986 18.4031 8.93986 20.1031L8.94986 20.1131C9.82197 20.9242 10.98 21.3565 12.1703 21.3152C13.3606 21.274 14.486 20.7626 15.2999 19.8931ZM13.9999 17.3331C12.7099 17.3331 12.7199 19.3331 13.9999 19.3331C15.2799 19.3331 15.2899 17.3331 13.9999 17.3331ZM6.89986 4.03308L8.42986 5.56308C8.67986 5.04308 9.04986 4.58308 9.49986 4.22308C10.1999 3.64308 11.0899 3.33308 11.9999 3.33308H12.8799C13.4699 3.47308 13.9999 3.74308 14.4999 4.12308C16.2199 5.50308 16.4999 8.02308 15.1199 9.74308C14.6977 10.2646 14.4619 10.9122 14.4499 11.5831L18.3199 15.4531C18.0699 14.3031 17.4999 13.2531 16.7199 12.3931C16.3699 12.0331 16.3299 11.4631 16.6199 11.0531C16.6199 11.0531 17.9999 9.33308 17.9999 7.33308C17.9999 5.33308 15.9699 1.33008 11.9999 1.33008C8.02986 1.33008 6.89986 4.03308 6.89986 4.03308ZM11.9999 17.3331C11.9999 16.0431 9.99986 16.0531 9.99986 17.3331C9.99986 18.6131 11.9999 18.6231 11.9999 17.3331ZM12.9999 5.33308C11.7099 5.33308 11.7199 7.33308 12.9999 7.33308C14.2799 7.33308 14.2899 5.33308 12.9999 5.33308Z" fill="#291F19"/>
</svg><span class="flex items-start ml-2 font-medium text-black-full text-sm-font lg:text-reg-font">' . __('Allergen Info', 'donut-box-builder') . '</span>';
        echo '</div>';
        echo '<div class="flex items-center justify-center w-12 h-12">';
        echo '<span class="h-full text-black iconify text-md-font" :data-icon="open === 1 ? \'icon-park-outline:minus\' : \'icon-park-outline:plus\'"></span>';
        echo '</div>';
        echo '</button>';
        echo '</div>';

        echo '<div id="info-open-body" class="transition-all duration-500" x-show="open === 1" style="display: none;" aria-labelledby="info-open-heading">';
        echo '<div class="font-light leading-tight transition-all duration-500 max-md:text-sm-font text-sm-font font-laca w/full max-lg:w-11/12">';

        // Loop through each selected product
        foreach ($selected_products as $variation_product) {
            if ($variation_product) {
                // Strip '- Large' and '- Midi' from product name
                $product_name = str_replace(['- Large', '- Midi'], '', $variation_product->get_name());

                // Get parent product ID
                $parent_product_id = $variation_product->get_parent_id();

                // Fetch allergens from parent product (using ACF or other method)
                $allergen_objects = get_field('product_allergens', $parent_product_id);

                if ($allergen_objects) {
                    // Convert allergen objects into an array of allergen names
                    $allergen_names = array_map(function($allergen) {
                        return $allergen->post_title;
                    }, $allergen_objects);

                    // Use a key that combines product name and allergen list to avoid duplicates
                    $allergen_key = $product_name . ':' . implode(',', $allergen_names);

                    if (!isset($displayed_allergens[$allergen_key])) {
                        // Display allergens
                        echo '<div class="flex flex-wrap items-center py-4 border-t border-solid border-grey-disabled">';
                        echo '<span class="flex items-start px-4 font-medium text-black-full text-sm-font lg:text-base-font">'
                            . esc_html($product_name) . ': ' . esc_html(implode(', ', $allergen_names)) . '</span>';
                        echo '</div>';

                        // Mark this combination as displayed
                        $displayed_allergens[$allergen_key] = true;
                    }
                } else {
                    // No allergens found
                    echo '<div class="flex flex-wrap items-center py-4 border-t border-solid border-grey-disabled">';
                    echo '<span class="flex items-start px-4 font-medium text-black-full text-sm-font lg:text-base-font">'
                        . esc_html($product_name) . ': ' . __('No allergens found', 'donut-box-builder') . '</span>';
                    echo '</div>';
                }
            } else {
                // Variation product could not be retrieved
                echo '<div class="flex flex-wrap items-center py-4 border-t border-solid border-grey-disabled">';
                echo '<span class="flex items-start px-4 font-medium text-black-full text-sm-font lg:text-base-font">'
                    . __('Could not retrieve product data', 'donut-box-builder') . '</span>';
                echo '</div>';
            }
        }

        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
}
add_action('woocommerce_after_add_to_cart_button', 'display_donut_allergens_below_cart_button');
