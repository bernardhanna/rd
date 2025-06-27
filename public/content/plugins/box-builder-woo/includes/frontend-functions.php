<?php
// Add custom fields to the product page
add_action( 'woocommerce_donut_box_builder_after_summary',
            'add_custom_fields_to_product_page', 10 );

add_action( 'woocommerce_default_after_summary',
            'add_custom_fields_to_product_page', 10 );
function add_custom_fields_to_product_page()
{
    global $product;


    if (function_exists('get_field')) {
        // Fetch the relevant fields
        $enable_special_occasion = get_field('enable_special_occasion', $product->get_id());
        $enable_logo_upload = get_field('enable_logo_upload', $product->get_id());
        $enable_additional_logos = get_field('enable_additional_logos', $product->get_id());
        $enable_special_requests = get_field('enable_special_requests', $product->get_id());
        $enable_stand_selection = get_field('enable_stand_selection', $product->get_id());
        $include_stand_cost = get_field('include_stand_cost_in_box_price', $product->get_id());

        echo '<div id="custom-product-addons">';

        // Special Occasion Dropdown
        if ($enable_special_occasion) {
            echo '<div class="mb-4 product-addon-field">';
            echo '<label for="custom_product_option" class="block text-sm font-medium text-gray-700">Select an Option</label>';
            echo '<select name="custom_product_option" id="custom_product_option" class="block w-full py-2 pl-3 pr-10 mt-1 text-base border-gray-300 rounded-md form-select focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">';
            echo '<option value="">Select an option...</option>';
            echo '<option value="Happy Birthday Logo">Happy Birthday Logo</option>';
            echo '<option value="Congratulations Logo">Congratulations</option>';
            echo '<option value="Thank You Logo">Thank You</option>';
            echo '<option value="Holy Communion Logo">Holy Communion</option>';
            echo '<option value="Confirmation Logo">Confirmation</option>';
            echo '<option value="Its a Girl Logo">Its a Girl</option>';
            echo '<option value="Its a Boy Logo">Its a Boy</option>';
            echo '<option value="Bride to be Logo">Bride to be</option>';
            echo '<option value="Groom to be Logo">Groom to be</option>';
            echo '<option value="Anniversary Logo">Anniversary</option>';
            echo '<option value="Get well soon Logo">Get well soon</option>';
            echo '<option value="Good luck Logo">Good luck</option>';
            echo '</select>';
            echo '</div>';
        }

        // Single Logo Upload
        if ($enable_logo_upload) {
            echo '<div class="mb-4 product-addon-field">';
            echo '<label for="logo_upload" class="block text-sm font-medium text-gray-700">Upload Your Logo</label>';
            echo '<input type="file" name="logo_upload" id="logo_upload" accept=".png,.pdf,.jpeg,.jpg" class="block w-full mt-1 text-base border-gray-300 rounded-md form-file focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">';
            echo '</div>';
        }

        // Multiple Logo Uploads
        if ($enable_additional_logos) {
            echo '<div class="mb-4 product-addon-field">';
            echo '<label class="block text-sm font-medium text-gray-700">Upload Additional Logos</label>';
            echo '<input type="file" name="logo_uploads[]" id="additional_logos" multiple accept=".png,.pdf,.jpeg,.jpg" class="block w-full mt-1 text-base border-gray-300 rounded-md form-file focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">';
            echo '</div>';
        }

        // Special Requests Textarea
        if ($enable_special_requests) {
            echo '<div class="mb-4 product-addon-field">';
            echo '<label for="special_requests" class="block text-sm font-medium text-gray-700">Note to customer</label>';
            echo '<textarea name="special_requests" id="special_requests" rows="4" placeholder="Enter your message here. (Note: Please do not enter requests to the driver or bakery here)" class="block w-full mt-1 text-base border-gray-300 rounded-md form-textarea focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>';
            echo '</div>';

            // Inline JavaScript to limit characters to 200
            echo '
            <script>
            document.addEventListener("DOMContentLoaded", function() {
                var specialRequests = document.getElementById("special_requests");
                specialRequests.addEventListener("input", function() {
                    var maxLength = 200;
                    if (this.value.length > maxLength) {
                        this.value = this.value.substring(0, maxLength);
                        alert("Special Requests cannot exceed 200 characters.");
                    }
                });
            });
            </script>';
        }

        // Stand Type Selection
        if ($enable_stand_selection) {
            echo '<div class="mb-4 product-addon-field border border-black border-solid rounded-sm-8">';

            // Accordion header with button and SVG icon
            echo '<div id="info-open-heading">';
            echo '<button id="accordionButton" type="button" class="flex justify-between items-center w-full font-medium text-left px-4 py-3" onclick="toggleAccordion()" aria-controls="info-open-body" aria-expanded="false">';
            echo '<div class="flex items-center">';
            echo '<span class="ml-2 flex items-start text-black-full text-sm-font lg:text-reg-font font-medium">Select Stand Type</span>';
            echo '</div>';
            echo '<div class="w-12 h-12 flex justify-center items-center">';
            echo '<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" viewBox="0 0 48 48" id="accordionIcon" class="iconify h-full text-black text-md-font iconify--icon-park-outline">';
            echo '<path id="accordionIconPath" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="m24.06 10l-.036 28M10 24h28"></path>';
            echo '</svg>';
            echo '</div>';
            echo '</button>';
            echo '</div>';

            // Accordion content
            echo '<div id="info-open-body" class="transition-all duration-500" style="display: none;" aria-labelledby="info-open-heading">';
            echo '<div class="leading-tight max-md:text-sm-font text-sm-font font-light font-laca w-full max-lg:w-11/12 transition-all duration-500">';

            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'rd_product_type',
                        'field'    => 'slug',
                        'terms'    => 'rental',
                    ),
                ),
            );

            $stand_products = new WP_Query($args);
            if ($stand_products->have_posts()) {
                echo '<ul>';
                while ($stand_products->have_posts()) {
                    $stand_products->the_post();
                    $stand_product = wc_get_product(get_the_ID());
                    $price = $stand_product->get_price();  // Get the raw price instead of HTML
                    echo '<li class="flex flex-wrap items-center border-t border-grey-disabled border-solid py-4 px-4">';
                    echo '<label class="flex items-center">';
                    echo '<input type="checkbox" class="mr-2 stand-type-checkbox" value="' . esc_attr($stand_product->get_id()) . '" data-name="' . esc_attr($stand_product->get_name()) . '" data-price="' . esc_attr($price) . '">';
                    echo esc_html($stand_product->get_name()) . ' - ' . wc_price($price);  // Use wc_price() for formatted price
                    echo '</label>';
                    echo '</li>';
                }
                echo '</ul>';
                wp_reset_postdata();
            } else {
                echo '<p>No stands available.</p>';
            }

            echo '</div>'; // Close accordion content
            echo '</div>'; // Close product-addon-field
            echo '</div>'; // Close product-addon-field

            // Add inline JavaScript for accordion functionality
            echo '
    <script>
    function toggleAccordion() {
        var content = document.getElementById("info-open-body");
        var iconPath = document.getElementById("accordionIconPath");

        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block";
            iconPath.setAttribute("d", "M10 24h28"); // Minus icon
        } else {
            content.style.display = "none";
            iconPath.setAttribute("d", "M24.06 10l-.036 28M10 24h28"); // Plus icon
        }
    }
    </script>';
        }

        // Add Additional Products
        // Add Additional Products
        $additional_products = get_field('product_with_additional_cost', $product->get_id());
        if ($additional_products) {
            echo '<div class="mb-4 product-addon-field border border-black border-solid rounded-sm-8">';

            // Accordion header with button and SVG icon
            echo '<div id="additional-products-heading">';
            echo '<button id="additionalProductsAccordionButton" type="button" class="flex justify-between items-center w-full font-medium text-left px-4 py-3" onclick="toggleAdditionalProductsAccordion()" aria-controls="additional-products-body" aria-expanded="false">';
            echo '<div class="flex items-center">';
            echo '<span class="ml-2 flex items-start text-black-full text-sm-font lg:text-reg-font font-medium">Add Additional Products</span>';
            echo '</div>';
            echo '<div class="w-12 h-12 flex justify-center items-center">';
            echo '<svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="img" width="1em" height="1em" viewBox="0 0 48 48" id="additionalProductsAccordionIcon" class="iconify h-full text-black text-md-font iconify--icon-park-outline">';
            echo '<path id="additionalProductsAccordionIconPath" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="m24.06 10l-.036 28M10 24h28"></path>';
            echo '</svg>';
            echo '</div>';
            echo '</button>';
            echo '</div>';

            // Accordion content
            echo '<div id="additional-products-body" class="transition-all duration-500" style="display: none;" aria-labelledby="additional-products-heading">';
            echo '<div class="leading-tight max-md:text-sm-font text-sm-font font-light font-laca w-full max-lg:w-11/12 transition-all duration-500">';

            echo '<ul>';
            foreach ($additional_products as $additional_product) {
                $product_obj = $additional_product['product'];
                if ($product_obj) {
                    foreach ($product_obj as $single_product) {
                        $wc_product = wc_get_product($single_product->ID);
                        $show_additional_cost = $additional_product['additional_cost'];

                        echo '<li class="flex flex-wrap items-center border-t border-grey-disabled border-solid py-4 px-4">';
                        echo '<div class="flex items-center">';
                        echo '<input type="checkbox" class="mr-2 additional-product-checkbox" value="' . esc_attr($wc_product->get_id()) . '" data-name="' . esc_attr($wc_product->get_name()) . '" data-price="' . esc_attr($wc_product->get_price()) . '">';
                        echo '<span>' . esc_html($wc_product->get_name());

                        if ($show_additional_cost && $wc_product->get_price()) {
                            $additional_cost = $wc_product->get_price();
                            echo '&nbsp;' . wc_price($additional_cost);
                        }
                        echo '</span>';
                        echo '</div>';

                        // Add quantity input field
                        echo '<div class="ml-4">';
                        echo '<label for="additional_product_quantity_' . esc_attr($wc_product->get_id()) . '"></label>';
                        echo '<input type="number" id="additional_product_quantity_' . esc_attr($wc_product->get_id()) . '" class="mx-4 additional-product-quantity text-center max-w-[50px]" name="additional_product_quantity[' . esc_attr($wc_product->get_id()) . ']" min="1" value="1" disabled>';
                        echo '</div>';

                        echo '</li>';
                    }
                }
            }
            echo '</ul>';

            echo '</div>'; // Close accordion content
            echo '</div>'; // Close product-addon-field
            echo '</div>'; // Close product-addon-field

            // Add inline JavaScript for accordion functionality and quantity inputs
            echo '
    <script>
    function toggleAdditionalProductsAccordion() {
        var content = document.getElementById("additional-products-body");
        var iconPath = document.getElementById("additionalProductsAccordionIconPath");

        if (content.style.display === "none" || content.style.display === "") {
            content.style.display = "block";
            iconPath.setAttribute("d", "M10 24h28"); // Minus icon
        } else {
            content.style.display = "none";
            iconPath.setAttribute("d", "M24.06 10l-.036 28M10 24h28"); // Plus icon
        }
    }

    // Enable/disable quantity inputs based on checkbox state
    document.addEventListener("DOMContentLoaded", function() {
        var checkboxes = document.querySelectorAll(".additional-product-checkbox");
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener("change", function() {
                var productId = this.value;
                var quantityInput = document.getElementById("additional_product_quantity_" + productId);
                if (this.checked) {
                    quantityInput.disabled = false;
                } else {
                    quantityInput.disabled = true;
                    quantityInput.value = 1;
                }
            });
        });
    });
    </script>';
        }



        echo '</div>';
    }
}
// Enqueue frontend script and localize
add_action('wp_enqueue_scripts', 'enqueue_donut_box_builder_frontend_scripts');
function enqueue_donut_box_builder_frontend_scripts()
{
    if (is_product()) {
        global $product;
        if (is_a($product, 'WC_Product') && $product->get_type() === 'donut_box_builder') {
            wp_enqueue_script('donut_box_builder_script', plugin_dir_url(__FILE__) . '../js/donut-box-builder.js', array('jquery'), '1.0', true);

            // Get prefilled products details
            $prefilled_products = get_post_meta($product->get_id(), '_prefilled_box_products', true);
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

            // Localize script with data
            wp_localize_script('donut_box_builder_script', 'my_script_object', array(
                'ajax_url' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('donut_box_builder_nonce'),
                'prefilled_products_data' => $prefilled_products_data
            ));
        }
    }
}