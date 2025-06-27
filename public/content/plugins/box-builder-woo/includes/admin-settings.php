<?php
defined('ABSPATH') || exit;

// Add custom settings tab for Donut Box Builder product type
add_action('woocommerce_product_data_tabs', 'add_donut_box_builder_product_tab');
function add_donut_box_builder_product_tab($tabs)
{
    $tabs['donut_box_builder'] = array(
        'label'  => __('Donut Box Builder', 'donut-box-builder'),
        'target' => 'donut_box_builder_options',
        'class'  => array('show_if_donut_box_builder'),
    );
    return $tabs;
}

// Display custom product fields
add_action('woocommerce_product_data_panels', 'donut_box_builder_options_product_tab_content');
function donut_box_builder_options_product_tab_content()
{
    global $post;

    // Retrieve values
    $box_quantity = get_post_meta($post->ID, '_donut_box_builder_box_quantity', true);
    $pre_filled = get_post_meta($post->ID, '_donut_box_builder_pre_filled', true);
    $disable_add_remove = get_post_meta($post->ID, '_donut_box_builder_disable_add_remove', true);
    $group_selection = get_post_meta($post->ID, '_donut_group_selection', true);
    $selected_category = get_post_meta($post->ID, '_donut_category_selection', true);
    $selected_size = get_post_meta($post->ID, '_donut_size_selection', true);

    $selected_variations = get_post_meta($post->ID, '_custom_box_products', true);
    if (!is_array($selected_variations)) $selected_variations = array();

    $disabled_variations = get_post_meta($post->ID, '_disabled_box_products', true);
    if (!is_array($disabled_variations)) $disabled_variations = array();

    $prefilled_products = get_post_meta($post->ID, '_prefilled_box_products', true);
    if (!is_array($prefilled_products)) $prefilled_products = array();

    // Set default group_selection to 'all_donuts' if not set
    if (empty($group_selection)) {
        $group_selection = 'all_donuts';
    }

    echo '<div id="donut_box_builder_options" class="panel woocommerce_options_panel">';
    echo '<div class="options_group show_if_donut_box_builder">';

    // Box Quantity
    woocommerce_wp_text_input(array(
        'id'          => '_donut_box_builder_box_quantity',
        'label'       => __('Box Quantity', 'donut-box-builder'),
        'description' => __('Maximum number of items allowed in the box.', 'donut-box-builder'),
        'desc_tip'    => true,
        'type'        => 'number',
        'value'       => $box_quantity,
    ));

    /* Disable add/remove prefilled items
    echo '<p class="form-field"><label>' . __('Disable add/remove of prefilled items', 'donut-box-builder') . '</label>';
    echo '<input type="radio" name="_donut_box_builder_disable_add_remove" value="yes" ' . checked($disable_add_remove, 'yes', false) . '> ' . __('Yes', 'donut-box-builder');
    echo '<input type="radio" name="_donut_box_builder_disable_add_remove" value="no" ' . checked($disable_add_remove, 'no', false) . '> ' . __('No', 'donut-box-builder');
    echo '</p>'; */

    // Group selection
    echo '<p class="form-field"><label for="donut_group_selection">' . __('Select Donut Group', 'woocommerce') . '</label>';
    echo '<select id="donut_group_selection" name="donut_group_selection" class="wc-enhanced-select" style="width: 100%;">';
    echo '<option value="none" ' . selected($group_selection, 'none', false) . '>' . __('Selected Flavours Only (Select below)', 'woocommerce') . '</option>';
    echo '<option value="all_donuts" ' . selected($group_selection, 'all_donuts', false) . '>' . __('All Donuts', 'woocommerce') . '</option>';
    echo '<option value="all_large_donuts" ' . selected($group_selection, 'all_large_donuts', false) . '>' . __('All Large Donuts', 'woocommerce') . '</option>';
    echo '<option value="all_midi_donuts" ' . selected($group_selection, 'all_midi_donuts', false) . '>' . __('All Midi Donuts', 'woocommerce') . '</option>';
    echo '<option value="category" ' . selected($group_selection, 'category', false) . '>' . __('Select by Category', 'woocommerce') . '</option>';
    echo '</select></p>';

    // Wrapper for category and size fields
    echo '<div id="category_size_wrapper">';
    $product_categories = get_terms(array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
    ));
    // Category selection
    echo '<p class="form-field"><label for="donut_category_selection">' . __('Select Donut Category', 'woocommerce') . '</label>';
    echo '<select id="donut_category_selection" name="donut_category_selection" class="wc-enhanced-select" style="width: 100%;">';
    foreach ($product_categories as $category) {
        echo '<option value="' . esc_attr($category->slug) . '" ' . selected($selected_category, $category->slug, false) . '>' . esc_html($category->name) . '</option>';
    }
    echo '</select></p>';

    // Size selection
    echo '<p class="form-field"><label for="donut_size_selection">' . __('Select Donut Size', 'woocommerce') . '</label>';
    echo '<select id="donut_size_selection" name="donut_size_selection" class="wc-enhanced-select" style="width: 100%;">';
    echo '<option value="all" ' . selected($selected_size, 'all', false) . '>' . __('All Sizes', 'woocommerce') . '</option>';
    echo '<option value="large" ' . selected($selected_size, 'large', false) . '>' . __('Large', 'woocommerce') . '</option>';
    echo '<option value="midi" ' . selected($selected_size, 'midi', false) . '>' . __('Midi', 'woocommerce') . '</option>';
    echo '</select></p>';
    echo '</div>'; // end #category_size_wrapper

    // Fetch variations for custom_box_products and disabled_box_products
    $variation_products = wc_get_products(array(
        'status' => 'publish',
        'limit' => -1,
        'type' => array('variation'),
    ));
    usort($variation_products, function ($a, $b) {
        return strcasecmp($a->get_name(), $b->get_name());
    });

    // Custom box products (Only show if 'none' is selected)
    echo '<div id="custom_box_products_wrapper">';
    echo '<p class="form-field"><label for="custom_box_products">' . __('Select Donut Flavours', 'woocommerce') . '</label>';
    echo '<select id="custom_box_products" name="custom_box_products[]" multiple="multiple" class="wc-enhanced-select" style="width: 100%;">';
    foreach ($variation_products as $vp) {
        $vid = $vp->get_id();
        $vname = $vp->get_name();
        $selected = in_array($vid, $selected_variations) ? 'selected' : '';
        echo '<option value="' . esc_attr($vid) . '" ' . $selected . '>' . esc_html($vname) . '</option>';
    }
    echo '</select></p>';
    echo '</div>';

    // Disabled box products
    echo '<p class="form-field"><label for="disabled_box_products">' . __('Disable Donut Flavours', 'woocommerce') . '</label>';
    echo '<select id="disabled_box_products" name="disabled_box_products[]" multiple="multiple" class="wc-enhanced-select" style="width: 100%;">';
    foreach ($variation_products as $vp) {
        $vid = $vp->get_id();
        $vname = $vp->get_name();
        $selected = in_array($vid, $disabled_variations) ? 'selected' : '';
        echo '<option value="' . esc_attr($vid) . '" ' . $selected . '>' . esc_html($vname) . '</option>';
    }
    echo '</select></p>';

    // Disable donut categories
    $disabled_categories = get_post_meta($post->ID, '_disabled_box_categories', true);
    if (!is_array($disabled_categories)) $disabled_categories = array();

    echo '<p class="form-field"><label for="disabled_box_categories">' . __('Disable Donut Categories', 'woocommerce') . '</label>';
    echo '<select id="disabled_box_categories" name="disabled_box_categories[]" multiple="multiple" class="wc-enhanced-select" style="width: 100%;">';

    $product_categories = get_terms(array(
        'taxonomy'   => 'product_cat',
        'hide_empty' => false,
    ));

    foreach ($product_categories as $category) {
        $slug = $category->slug;
        $name = $category->name;
        $selected = in_array($slug, $disabled_categories) ? 'selected' : '';
        echo '<option value="' . esc_attr($slug) . '" ' . $selected . '>' . esc_html($name) . '</option>';
    }

    echo '</select></p>';


    // Disable Build Your Own Button
$disable_build_your_own = get_post_meta($post->ID, '_donut_box_builder_disable_build_button', true);
echo '<p class="form-field"><label>' . __('Disable "Build Your Own Box" Button', 'donut-box-builder') . '</label>';
echo '<input type="radio" name="_donut_box_builder_disable_build_button" value="yes" ' . checked($disable_build_your_own, 'yes', false) . '> ' . __('Yes', 'donut-box-builder') . ' ';
echo '<input type="radio" name="_donut_box_builder_disable_build_button" value="no" ' . checked($disable_build_your_own, 'no', false) . '> ' . __('No', 'donut-box-builder');
echo '</p>';



    // Prefilled Products Section
    echo '<h3>' . __('Pre-filled Products', 'donut-box-builder') . '</h3>';
    echo '<p>' . __('Select a flavour and click Add. You can reorder items using the arrows. Removing items re-enables adding. The total count cannot exceed the box quantity.', 'donut-box-builder') . '</p>';

    // For prefilled products, also use variations
    $all_products = $variation_products; // We already fetched and sorted them above.

    echo '<select id="prefilled_product_select" style="width:300px;">';
    echo '<option value="">' . __('Select Flavour...', 'donut-box-builder') . '</option>';
    foreach ($all_products as $p) {
        $pid = $p->get_id();
        $name = $p->get_name();
        echo '<option value="' . esc_attr($pid) . '">' . esc_html($name) . '</option>';
    }
    echo '</select> ';
    echo '<button type="button" class="button" id="add_prefilled_product">' . __('Add', 'donut-box-builder') . '</button>';

    echo '<table class="widefat" style="margin-top:10px;max-width:600px;" id="prefilled_products_table">';
    echo '<thead><tr><th>' . __('Product', 'donut-box-builder') . '</th><th>' . __('Actions', 'donut-box-builder') . '</th></tr></thead>';
    echo '<tbody id="prefilled_products_list">';

    $count = 0;
    foreach ($prefilled_products as $index => $product_id) {
        $product = wc_get_product($product_id);
        if ($product) {
            $name = $product->get_name();
            echo '<tr data-product_id="' . esc_attr($product_id) . '">';
            echo '<td>' . esc_html($name) . '</td>';
            echo '<td style="white-space: nowrap;">';
            echo '<button type="button" class="move_prefilled_product_up button">▲</button> ';
            echo '<button type="button" class="move_prefilled_product_down button">▼</button> ';
            echo '<button type="button" class="remove_prefilled_product button">Remove</button>';
            echo '<input type="hidden" class="prefilled_product_input" name="_prefilled_box_products[]" value="' . esc_attr($product_id) . '">';
            echo '</td>';
            echo '</tr>';
            $count++;
        }
    }

    echo '</tbody>';
    echo '</table>';
?>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var currentCount = <?php echo (int)$count; ?>;
            var $addButton = $('#add_prefilled_product');

            function getBoxQuantity() {
                var val = parseInt($('#_donut_box_builder_box_quantity').val(), 10);
                return isNaN(val) ? 0 : val;
            }

            function updateAddButton() {
                var boxQuantity = getBoxQuantity();
                if (boxQuantity > 0 && currentCount >= boxQuantity) {
                    $addButton.prop('disabled', true);
                } else {
                    $addButton.prop('disabled', false);
                }
            }

            function toggleCategorySizeFields() {
                var groupVal = $('#donut_group_selection').val();
                if (groupVal === 'category') {
                    $('#category_size_wrapper').show();
                } else {
                    $('#category_size_wrapper').hide();
                }
            }

            function toggleCustomBoxProducts() {
                var groupVal = $('#donut_group_selection').val();
                if (groupVal === 'none') {
                    $('#custom_box_products_wrapper').show();
                } else {
                    $('#custom_box_products_wrapper').hide();
                }
            }

            updateAddButton();
            toggleCategorySizeFields();
            toggleCustomBoxProducts();

            $addButton.on('click', function() {
                var product_id = $('#prefilled_product_select').val();
                if (!product_id) return;

                var boxQuantity = getBoxQuantity();
                if (boxQuantity > 0 && currentCount >= boxQuantity) return;

                var product_name = $('#prefilled_product_select option:selected').text();
                var newRow = `
                <tr data-product_id="${product_id}">
                    <td>${product_name}</td>
                    <td style="white-space: nowrap;">
                        <button type="button" class="move_prefilled_product_up button">▲</button>
                        <button type="button" class="move_prefilled_product_down button">▼</button>
                        <button type="button" class="remove_prefilled_product button">Remove</button>
                        <input type="hidden" class="prefilled_product_input" name="_prefilled_box_products[]" value="${product_id}">
                    </td>
                </tr>
                `;
                $('#prefilled_products_list').append(newRow);
                currentCount++;
                updateAddButton();
            });

            $(document).on('click', '.remove_prefilled_product', function() {
                $(this).closest('tr').remove();
                currentCount--;
                updateAddButton();
            });

            // Move product up
            $(document).on('click', '.move_prefilled_product_up', function() {
                var $row = $(this).closest('tr');
                var $prev = $row.prev('tr');
                if ($prev.length > 0) {
                    $row.insertBefore($prev);
                }
            });

            // Move product down
            $(document).on('click', '.move_prefilled_product_down', function() {
                var $row = $(this).closest('tr');
                var $next = $row.next('tr');
                if ($next.length > 0) {
                    $row.insertAfter($next);
                }
            });

            $('#_donut_box_builder_box_quantity').on('change keyup', function() {
                updateAddButton();
            });

            $('#donut_group_selection').on('change', function() {
                toggleCategorySizeFields();
                toggleCustomBoxProducts();
            });

            // Ensure fields visible for donut_box_builder
            $('.options_group.pricing, .show_if_simple').addClass('show_if_donut_box_builder');
            $('.inventory_options, .show_if_simple').addClass('show_if_donut_box_builder');
            $('.general_options').addClass('show_if_donut_box_builder');
        });
    </script>
<?php

    echo '</div>';
    echo '</div>';
}

// Save the custom fields
add_action('woocommerce_process_product_meta', 'save_donut_box_builder_options_fields');
function save_donut_box_builder_options_fields($post_id)
{
    $box_quantity = isset($_POST['_donut_box_builder_box_quantity']) ? intval($_POST['_donut_box_builder_box_quantity']) : '';
    update_post_meta($post_id, '_donut_box_builder_box_quantity', $box_quantity);

    $pre_filled = isset($_POST['_donut_box_builder_pre_filled']) ? wc_clean($_POST['_donut_box_builder_pre_filled']) : 'no';
    update_post_meta($post_id, '_donut_box_builder_pre_filled', $pre_filled);

    $disable_add_remove = isset($_POST['_donut_box_builder_disable_add_remove']) ? wc_clean($_POST['_donut_box_builder_disable_add_remove']) : 'no';
    update_post_meta($post_id, '_donut_box_builder_disable_add_remove', $disable_add_remove);

    $disable_build_button = isset($_POST['_donut_box_builder_disable_build_button']) ? wc_clean($_POST['_donut_box_builder_disable_build_button']) : 'no';
update_post_meta($post_id, '_donut_box_builder_disable_build_button', $disable_build_button);

    $group_selection = isset($_POST['donut_group_selection']) ? sanitize_text_field($_POST['donut_group_selection']) : 'all_donuts';
    update_post_meta($post_id, '_donut_group_selection', $group_selection);

    $selected_category = isset($_POST['donut_category_selection']) ? sanitize_text_field($_POST['donut_category_selection']) : '';
    update_post_meta($post_id, '_donut_category_selection', $selected_category);

    $selected_size = isset($_POST['donut_size_selection']) ? sanitize_text_field($_POST['donut_size_selection']) : 'all';
    update_post_meta($post_id, '_donut_size_selection', $selected_size);

    $selected_variations = isset($_POST['custom_box_products']) ? array_map('intval', $_POST['custom_box_products']) : array();
    update_post_meta($post_id, '_custom_box_products', $selected_variations);

    $disabled_variations = isset($_POST['disabled_box_products']) ? array_map('intval', $_POST['disabled_box_products']) : array();
    update_post_meta($post_id, '_disabled_box_products', $disabled_variations);

    $prefilled_products = isset($_POST['_prefilled_box_products']) ? array_map('intval', $_POST['_prefilled_box_products']) : array();
    update_post_meta($post_id, '_prefilled_box_products', $prefilled_products);
}

// Show price fields for Donut Box Builder product type
add_action('woocommerce_product_options_general_product_data', 'add_pricing_fields_for_donut_box_builder');
function add_pricing_fields_for_donut_box_builder()
{
    global $post;
    $product = wc_get_product($post->ID);

    if ($product && $product->get_type() === 'donut_box_builder') {
        woocommerce_wp_text_input(array(
            'id'        => '_regular_price',
            'label'     => __('Regular price', 'woocommerce') . ' (' . get_woocommerce_currency_symbol() . ')',
            'data_type' => 'price',
        ));

        woocommerce_wp_text_input(array(
            'id'        => '_sale_price',
            'label'     => __('Sale price', 'woocommerce') . ' (' . get_woocommerce_currency_symbol() . ')',
            'data_type' => 'price',
        ));
    }
}
