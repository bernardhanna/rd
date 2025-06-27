<?php
// Save the custom fields data
add_action('woocommerce_process_product_meta', 'save_custom_fields');
function save_custom_fields($post_id) {
    if (isset($_POST['_custom_fields'])) {
        update_post_meta($post_id, '_custom_fields', $_POST['_custom_fields']);
    } else {
        delete_post_meta($post_id, '_custom_fields');
    }
}

// Display custom fields on the product page
add_action('woocommerce_donut_box_builder_after_summary', 'display_custom_fields_on_product_page');
function display_custom_fields_on_product_page() {
    global $product;

    $fields = get_post_meta($product->get_id(), '_custom_fields', true);
    if (!is_array($fields)) {
        $fields = array();
    }

    if (!empty($fields)) {
        echo '<div class="custom-fields-frontend">';
        foreach ($fields as $index => $field) {
            echo '<div class="form-row form-row-wide">';
            echo '<label for="custom_field_' . esc_attr($index) . '">' . esc_html($field['title']) . '</label>';
            switch ($field['type']) {
                case 'text':
                    echo '<input type="text" name="_custom_fields[' . esc_attr($index) . '][value]" id="custom_field_' . esc_attr($index) . '" class="' . esc_attr($field['class']) . '" placeholder="' . esc_attr($field['placeholder']) . '" value="" maxlength="' . esc_attr($field['max_length']) . '" ' . (!empty($field['required']) ? 'required' : '') . '>';
                    break;
                case 'textarea':
                    echo '<textarea name="_custom_fields[' . esc_attr($index) . '][value]" id="custom_field_' . esc_attr($index) . '" class="' . esc_attr($field['class']) . '" placeholder="' . esc_attr($field['placeholder']) . '" rows="' . esc_attr($field['rows']) . '" cols="' . esc_attr($field['cols']) . '" ' . (!empty($field['required']) ? 'required' : '') . '></textarea>';
                    break;
                case 'image':
                    echo '<input type="file" name="_custom_fields[' . esc_attr($index) . '][value]" id="custom_field_' . esc_attr($index) . '" class="' . esc_attr($field['class']) . '" accept="' . esc_attr($field['allowed_types']) . '" ' . (!empty($field['required']) ? 'required' : '') . '>';
                    break;
                case 'checkbox':
                    $options = explode(',', $field['options']);
                    foreach ($options as $option) {
                        $option = trim($option);
                        echo '<label><input type="checkbox" name="_custom_fields[' . esc_attr($index) . '][value][]" value="' . esc_attr($option) . '"> ' . esc_html($option) . '</label>';
                    }
                    break;
                case 'select':
                    $multiple = !empty($field['multiple']) ? 'multiple' : '';
                    echo '<select name="_custom_fields[' . esc_attr($index) . '][value]" id="custom_field_' . esc_attr($index) . '" class="' . esc_attr($field['class']) . '" ' . $multiple . ' ' . (!empty($field['required']) ? 'required' : '') . '>';
                    echo '<option value="" disabled selected>Select an option</option>';
                    $options = explode(',', $field['options']);
                    foreach ($options as $option) {
                        $option = trim($option);
                        echo '<option value="' . esc_attr($option) . '">' . esc_html($option) . '</option>';
                    }
                    echo '</select>';
                    break;
                case 'product':
                    $product_ids = explode(',', $field['product_ids']);
                    foreach ($product_ids as $product_id) {
                        $product_id = trim($product_id);
                        $product = wc_get_product($product_id);
                        if ($product) {
                            echo '<div class="product-option">';
                            echo '<input type="checkbox" name="_custom_fields[' . esc_attr($index) . '][value][]" value="' . esc_attr($product_id) . '">';
                            echo '<img src="' . esc_url($product->get_image('thumbnail')) . '" alt="' . esc_attr($product->get_name()) . '" style="width:50px;height:auto;">';
                            echo '<span>' . esc_html($product->get_name()) . '</span>';
                            echo '<span>' . wc_price($product->get_price()) . '</span>';
                            echo '</div>';
                        }
                    }
                    break;
            }
            echo '</div>';
        }
        echo '</div>';
    }
}
