<?php
// Add fields to the custom fields tab
add_action('woocommerce_product_data_panels', 'add_custom_fields');
function add_custom_fields() {
    echo '<div id="custom_fields_data" class="panel woocommerce_options_panel hidden">';
    echo '<div class="options_group">';

    // Add CSS for labels and sortable fields
    ?>
    <style>
        .custom-field-container label {
            margin: 0px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        #custom_fields_wrapper {
            margin-top: 10px;
        }
        .custom_field {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
            position: relative;
            cursor: move;
        }
        .remove_field {
            position: absolute;
            top: 10px;
            right: 10px;
            color: red;
            cursor: pointer;
        }
        .custom-field-title {
            font-weight: bold;
            cursor: pointer;
            padding: 10px;
            background-color: #f1f1f1;
            border: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .custom-field-body {
            display: none;
            padding: 10px;
            border: 1px solid #ddd;
            border-top: none;
        }
        .custom-field.expanded .custom-field-body {
            display: block;
        }
        .custom-field.expanded .custom-field-title {
            background-color: #e1e1e1;
        }
        .toggle-indicator {
            font-size: 18px;
            line-height: 1;
        }
    </style>

    <?php

    // Get existing fields
    $fields = get_post_meta(get_the_ID(), '_custom_fields', true);
    if (!is_array($fields)) {
        $fields = array();
    }

    // JavaScript to manage repeater fields and enable sorting
    ?>
    <script>
        jQuery(document).ready(function($) {
            var fieldCount = <?php echo count($fields); ?>;

            $('#add_field').click(function(e) {
                e.preventDefault();
                var newField = $('#custom_field_template').html();
                newField = newField.replace(/{{index}}/g, fieldCount);
                $('#custom_fields_wrapper').append(newField);
                fieldCount++;
                updateFieldOrder();
            });

            $(document).on('click', '.remove_field', function(e) {
                e.preventDefault();
                $(this).closest('.custom_field').remove();
                updateFieldOrder();
            });

            // Make the fields sortable
            $('#custom_fields_wrapper').sortable({
                items: '.custom_field',
                handle: '.custom-field-title',
                update: function(event, ui) {
                    updateFieldOrder();
                }
            });

            function updateFieldOrder() {
                $('#custom_fields_wrapper .custom_field').each(function(index) {
                    $(this).find('input, select, textarea').each(function() {
                        var name = $(this).attr('name');
                        if (name) {
                            name = name.replace(/\[\d+\]/, '[' + index + ']');
                            $(this).attr('name', name);
                        }
                    });
                });
            }

            // Toggle fields
            $(document).on('click', '.custom-field-title', function() {
                var fieldContainer = $(this).parent();
                fieldContainer.toggleClass('expanded');
                fieldContainer.find('.custom-field-body').slideToggle();
                $(this).find('.toggle-indicator').text(fieldContainer.hasClass('expanded') ? '▲' : '▼');
            });

            // Toggle options based on field type
            $(document).on('change', '.field-type-selector', function() {
                var fieldContainer = $(this).closest('.custom_field');
                fieldContainer.find('.field-options').hide();
                fieldContainer.find('.' + $(this).val() + '-options').show();
            });
        });
    </script>

    <div id="custom_fields_wrapper" class="custom-field-container">
        <?php if (!empty($fields)) : ?>
            <?php foreach ($fields as $index => $field) : ?>
                <div class="custom_field">
                    <div class="custom-field-title">
                        <span><?php echo esc_html($field['title']); ?></span>
                        <span class="toggle-indicator">▼</span>
                        <button class="remove_field button"><?php _e('Remove', 'woocommerce'); ?></button>
                    </div>
                    <div class="custom-field-body">
                        <p>
                            <label><?php _e('Field Title', 'woocommerce'); ?>:</label>
                            <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][title]" value="<?php echo esc_attr($field['title']); ?>" placeholder="Enter field title" />
                        </p>
                        <p>
                            <label><?php _e('Field Type', 'woocommerce'); ?>:</label>
                            <select name="_custom_fields[<?php echo esc_attr($index); ?>][type]" class="field-type-selector">
                                <option value="text" <?php selected($field['type'], 'text'); ?>><?php _e('Text', 'woocommerce'); ?></option>
                                <option value="textarea" <?php selected($field['type'], 'textarea'); ?>><?php _e('Textarea', 'woocommerce'); ?></option>
                                <option value="image" <?php selected($field['type'], 'image'); ?>><?php _e('Image Upload', 'woocommerce'); ?></option>
                                <option value="checkbox" <?php selected($field['type'], 'checkbox'); ?>><?php _e('Checkbox', 'woocommerce'); ?></option>
                                <option value="select" <?php selected($field['type'], 'select'); ?>><?php _e('Select', 'woocommerce'); ?></option>
                                <option value="product" <?php selected($field['type'], 'product'); ?>><?php _e('Product', 'woocommerce'); ?></option>
                            </select>
                        </p>
                        <div class="text-options field-options" style="display: <?php echo $field['type'] == 'text' ? 'block' : 'none'; ?>;">
                            <p>
                                <label><?php _e('Field Name', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][name]" value="<?php echo esc_attr($field['name']); ?>" placeholder="Enter field name" />
                            </p>
                            <p>
                                <label><?php _e('Placeholder', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][placeholder]" value="<?php echo esc_attr($field['placeholder']); ?>" placeholder="Enter placeholder text" />
                            </p>
                            <p>
                                <label><?php _e('CSS Class', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][class]" value="<?php echo esc_attr($field['class']); ?>" placeholder="Enter CSS class" />
                            </p>
                            <p>
                                <label><?php _e('Default Value', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][value]" value="<?php echo esc_attr($field['value']); ?>" placeholder="Enter default value" />
                            </p>
                            <p>
                                <label><?php _e('Max Length', 'woocommerce'); ?>:</label>
                                <input type="number" name="_custom_fields[<?php echo esc_attr($index); ?>][max_length]" value="<?php echo esc_attr($field['max_length']); ?>" placeholder="Enter max length" />
                            </p>
                            <p>
                                <label><?php _e('Additional Cost', 'woocommerce'); ?>:</label>
                                <input type="number" step="0.01" name="_custom_fields[<?php echo esc_attr($index); ?>][additional_cost]" value="<?php echo esc_attr($field['additional_cost']); ?>" placeholder="0.00" />
                            </p>
                            <p>
                                <label><?php _e('Field Required', 'woocommerce'); ?>:</label>
                               <input type="checkbox" name="_custom_fields[<?php echo esc_attr($index); ?>][required]" value="yes" <?php echo isset($field['required']) && $field['required'] === 'yes' ? 'checked' : ''; ?> />
                            </p>
                        </div>
                        <div class="textarea-options field-options" style="display: <?php echo $field['type'] == 'textarea' ? 'block' : 'none'; ?>;">
                            <p>
                                <label><?php _e('Field Name', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][name]" value="<?php echo esc_attr($field['name']); ?>" placeholder="Enter field name" />
                            </p>
                            <p>
                                <label><?php _e('Placeholder', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][placeholder]" value="<?php echo esc_attr($field['placeholder']); ?>" placeholder="Enter placeholder text" />
                            </p>
                            <p>
                                <label><?php _e('CSS Class', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][class]" value="<?php echo esc_attr($field['class']); ?>" placeholder="Enter CSS class" />
                            </p>
                            <p>
                                <label><?php _e('Default Value', 'woocommerce'); ?>:</label>
                                <textarea name="_custom_fields[<?php echo esc_attr($index); ?>][value]" placeholder="Enter default value"><?php echo esc_textarea($field['value']); ?></textarea>
                            </p>
                            <p>
                                <label><?php _e('Rows', 'woocommerce'); ?>:</label>
                                <input type="number" name="_custom_fields[<?php echo esc_attr($index); ?>][rows]" value="<?php echo esc_attr($field['rows']); ?>" placeholder="Enter number of rows" />
                            </p>
                            <p>
                                <label><?php _e('Cols', 'woocommerce'); ?>:</label>
                                <input type="number" name="_custom_fields[<?php echo esc_attr($index); ?>][cols]" value="<?php echo esc_attr($field['cols']); ?>" placeholder="Enter number of cols" />
                            </p>
                            <p>
                                <label><?php _e('Additional Cost', 'woocommerce'); ?>:</label>
                                <input type="number" step="0.01" name="_custom_fields[<?php echo esc_attr($index); ?>][additional_cost]" value="<?php echo esc_attr($field['additional_cost']); ?>" placeholder="0.00" />
                            </p>
                            <p>
                                <label><?php _e('Field Required', 'woocommerce'); ?>:</label>
                               <input type="checkbox" name="_custom_fields[<?php echo esc_attr($index); ?>][required]" value="yes" <?php echo isset($field['required']) && $field['required'] === 'yes' ? 'checked' : ''; ?> />
                            </p>
                        </div>
                        <div class="image-options field-options" style="display: <?php echo $field['type'] == 'image' ? 'block' : 'none'; ?>;">
                            <p>
                                <label><?php _e('Field Name', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][name]" value="<?php echo esc_attr($field['name']); ?>" placeholder="Enter field name" />
                            </p>
                            <p>
                                <label><?php _e('CSS Class', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][class]" value="<?php echo esc_attr($field['class']); ?>" placeholder="Enter CSS class" />
                            </p>
                            <p>
                                <label><?php _e('Max File Size (MB)', 'woocommerce'); ?>:</label>
                                <input type="number" step="0.1" name="_custom_fields[<?php echo esc_attr($index); ?>][max_size]" value="<?php echo esc_attr($field['max_size']); ?>" placeholder="Enter max file size" />
                            </p>
                            <p>
                                <label><?php _e('Allowed File Types', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][allowed_types]" value="<?php echo esc_attr($field['allowed_types']); ?>" placeholder="e.g. jpg, png, pdf" />
                            </p>
                            <p>
                                <label><?php _e('Additional Cost', 'woocommerce'); ?>:</label>
                                <input type="number" step="0.01" name="_custom_fields[<?php echo esc_attr($index); ?>][additional_cost]" value="<?php echo esc_attr($field['additional_cost']); ?>" placeholder="0.00" />
                            </p>
                            <p>
                                <label><?php _e('Field Required', 'woocommerce'); ?>:</label>
                                <input type="checkbox" name="_custom_fields[<?php echo esc_attr($index); ?>][required]" value="yes" <?php echo isset($field['required']) && $field['required'] === 'yes' ? 'checked' : ''; ?> />
                            </p>
                        </div>
                        <div class="checkbox-options field-options" style="display: <?php echo $field['type'] == 'checkbox' ? 'block' : 'none'; ?>;">
                            <p>
                                <label><?php _e('Field Name', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][name]" value="<?php echo esc_attr($field['name']); ?>" placeholder="Enter field name" />
                            </p>
                            <p>
                                <label><?php _e('CSS Class', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][class]" value="<?php echo esc_attr($field['class']); ?>" placeholder="Enter CSS class" />
                            </p>
                            <p>
                                <label><?php _e('Checkbox Options (comma-separated)', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][options]" value="<?php echo esc_attr($field['options']); ?>" placeholder="Option 1, Option 2, Option 3" />
                            </p>
                            <p>
                                <label><?php _e('Additional Cost', 'woocommerce'); ?>:</label>
                                <input type="number" step="0.01" name="_custom_fields[<?php echo esc_attr($index); ?>][additional_cost]" value="<?php echo esc_attr($field['additional_cost']); ?>" placeholder="0.00" />
                            </p>
                            <p>
                                <label><?php _e('Field Required', 'woocommerce'); ?>:</label>
                               <input type="checkbox" name="_custom_fields[<?php echo esc_attr($index); ?>][required]" value="yes" <?php echo isset($field['required']) && $field['required'] === 'yes' ? 'checked' : ''; ?> />
                            </p>
                        </div>
                        <div class="select-options field-options" style="display: <?php echo $field['type'] == 'select' ? 'block' : 'none'; ?>;">
                            <p>
                                <label><?php _e('Field Name', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][name]" value="<?php echo esc_attr($field['name']); ?>" placeholder="Enter field name" />
                            </p>
                            <p>
                                <label><?php _e('CSS Class', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][class]" value="<?php echo esc_attr($field['class']); ?>" placeholder="Enter CSS class" />
                            </p>
                            <p>
                                <label><?php _e('Select Options (comma-separated)', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][options]" value="<?php echo esc_attr($field['options']); ?>" placeholder="Option 1, Option 2, Option 3" />
                            </p>
                            <p>
                                <label><?php _e('Allow Multiple Selections', 'woocommerce'); ?>:</label>
                               <input type="checkbox" name="_custom_fields[<?php echo esc_attr($index); ?>][required]" value="yes" <?php echo isset($field['required']) && $field['required'] === 'yes' ? 'checked' : ''; ?> />
                            </p>
                            <p>
                                <label><?php _e('Additional Cost', 'woocommerce'); ?>:</label>
                                <input type="number" step="0.01" name="_custom_fields[<?php echo esc_attr($index); ?>][additional_cost]" value="<?php echo esc_attr($field['additional_cost']); ?>" placeholder="0.00" />
                            </p>
                            <p>
                                <label><?php _e('Field Required', 'woocommerce'); ?>:</label>
                               <input type="checkbox" name="_custom_fields[<?php echo esc_attr($index); ?>][required]" value="yes" <?php echo isset($field['required']) && $field['required'] === 'yes' ? 'checked' : ''; ?> />
                            </p>
                        </div>
                        <div class="product-options field-options" style="display: <?php echo $field['type'] == 'product' ? 'block' : 'none'; ?>;">
                            <p>
                                <label><?php _e('Field Name', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][name]" value="<?php echo esc_attr($field['name']); ?>" placeholder="Enter field name" />
                            </p>
                            <p>
                                <label><?php _e('CSS Class', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][class]" value="<?php echo esc_attr($field['class']); ?>" placeholder="Enter CSS class" />
                            </p>
                            <p>
                                <label><?php _e('Select Products (comma-separated IDs)', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][product_ids]" value="<?php echo esc_attr($field['product_ids']); ?>" placeholder="Enter product IDs" />
                            </p>
                            <p>
                                <label><?php _e('Additional Cost', 'woocommerce'); ?>:</label>
                                <input type="number" step="0.01" name="_custom_fields[<?php echo esc_attr($index); ?>][additional_cost]" value="<?php echo esc_attr($field['additional_cost']); ?>" placeholder="0.00" />
                            </p>
                            <p>
                                <label><?php _e('Field Required', 'woocommerce'); ?>:</label>
                                <input type="checkbox" name="_custom_fields[<?php echo esc_attr($index); ?>][required]" value="yes" <?php echo isset($field['required']) && $field['required'] === 'yes' ? 'checked' : ''; ?> />
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <button id="add_field" class="button"><?php _e('Add Product Add-On', 'woocommerce'); ?></button>

    <script type="text/template" id="custom_field_template">
        <div class="custom_field">
            <div class="custom-field-title">
                <span>Field</span>
                <span class="toggle-indicator">▼</span>
                <button class="remove_field button"><?php _e('Remove', 'woocommerce'); ?></button>
            </div>
            <div class="custom-field-body">
                <p>
                    <label><?php _e('Field Title', 'woocommerce'); ?>:</label>
                    <input type="text" name="_custom_fields[{{index}}][title]" placeholder="Enter field title" />
                </p>
                <p>
                    <label><?php _e('Field Type', 'woocommerce'); ?>:</label>
                    <select name="_custom_fields[{{index}}][type]" class="field-type-selector">
                        <option value="text"><?php _e('Text', 'woocommerce'); ?></option>
                        <option value="textarea"><?php _e('Textarea', 'woocommerce'); ?></option>
                        <option value="image"><?php _e('Image Upload', 'woocommerce'); ?></option>
                        <option value="checkbox"><?php _e('Checkbox', 'woocommerce'); ?></option>
                        <option value="select"><?php _e('Select', 'woocommerce'); ?></option>
                        <option value="product"><?php _e('Product', 'woocommerce'); ?></option>
                    </select>
                </p>
                <div class="text-options field-options">
                    <p>
                        <label><?php _e('Field Name', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][name]" placeholder="Enter field name" />
                    </p>
                    <p>
                        <label><?php _e('Placeholder', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][placeholder]" placeholder="Enter placeholder text" />
                    </p>
                    <p>
                        <label><?php _e('CSS Class', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][class]" placeholder="Enter CSS class" />
                    </p>
                    <p>
                        <label><?php _e('Default Value', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][value]" placeholder="Enter default value" />
                    </p>
                    <p>
                        <label><?php _e('Max Length', 'woocommerce'); ?>:</label>
                        <input type="number" name="_custom_fields[{{index}}][max_length]" placeholder="Enter max length" />
                    </p>
                    <p>
                        <label><?php _e('Additional Cost', 'woocommerce'); ?>:</label>
                        <input type="number" step="0.01" name="_custom_fields[{{index}}][additional_cost]" placeholder="0.00" />
                    </p>
                    <p>
                        <label><?php _e('Field Required', 'woocommerce'); ?>:</label>
                        <input type="checkbox" name="_custom_fields[{{index}}][required]" value="yes" />
                    </p>
                </div>
                <div class="textarea-options field-options" style="display:none;">
                    <p>
                        <label><?php _e('Field Name', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][name]" placeholder="Enter field name" />
                    </p>
                    <p>
                        <label><?php _e('Placeholder', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][placeholder]" placeholder="Enter placeholder text" />
                    </p>
                    <p>
                        <label><?php _e('CSS Class', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][class]" placeholder="Enter CSS class" />
                    </p>
                    <p>
                        <label><?php _e('Default Value', 'woocommerce'); ?>:</label>
                        <textarea name="_custom_fields[{{index}}][value]" placeholder="Enter default value"></textarea>
                    </p>
                    <p>
                        <label><?php _e('Rows', 'woocommerce'); ?>:</label>
                        <input type="number" name="_custom_fields[{{index}}][rows]" placeholder="Enter number of rows" />
                    </p>
                    <p>
                        <label><?php _e('Cols', 'woocommerce'); ?>:</label>
                        <input type="number" name="_custom_fields[{{index}}][cols]" placeholder="Enter number of cols" />
                    </p>
                    <p>
                        <label><?php _e('Additional Cost', 'woocommerce'); ?>:</label>
                        <input type="number" step="0.01" name="_custom_fields[{{index}}][additional_cost]" placeholder="0.00" />
                    </p>
                    <p>
                        <label><?php _e('Field Required', 'woocommerce'); ?>:</label>
                        <input type="checkbox" name="_custom_fields[{{index}}][required]" value="yes" />
                    </p>
                </div>
                <div class="image-options field-options" style="display:none;">
                    <p>
                        <label><?php _e('Field Name', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][name]" placeholder="Enter field name" />
                    </p>
                    <p>
                        <label><?php _e('CSS Class', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][class]" placeholder="Enter CSS class" />
                    </p>
                    <p>
                        <label><?php _e('Max File Size (MB)', 'woocommerce'); ?>:</label>
                        <input type="number" step="0.1" name="_custom_fields[{{index}}][max_size]" placeholder="Enter max file size" />
                    </p>
                    <p>
                        <label><?php _e('Allowed File Types', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][allowed_types]" placeholder="e.g. jpg, png, pdf" />
                    </p>
                    <p>
                        <label><?php _e('Additional Cost', 'woocommerce'); ?>:</label>
                        <input type="number" step="0.01" name="_custom_fields[{{index}}][additional_cost]" placeholder="0.00" />
                    </p>
                    <p>
                        <label><?php _e('Field Required', 'woocommerce'); ?>:</label>
                        <input type="checkbox" name="_custom_fields[{{index}}][required]" value="yes" />
                    </p>
                </div>
                <div class="checkbox-options field-options" style="display:none;">
                    <p>
                        <label><?php _e('Field Name', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][name]" placeholder="Enter field name" />
                    </p>
                    <p>
                        <label><?php _e('CSS Class', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][class]" placeholder="Enter CSS class" />
                    </p>
                    <p>
                        <label><?php _e('Checkbox Options (comma-separated)', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][options]" placeholder="Option 1, Option 2, Option 3" />
                    </p>
                    <p>
                        <label><?php _e('Additional Cost', 'woocommerce'); ?>:</label>
                        <input type="number" step="0.01" name="_custom_fields[{{index}}][additional_cost]" placeholder="0.00" />
                    </p>
                    <p>
                        <label><?php _e('Field Required', 'woocommerce'); ?>:</label>
                        <input type="checkbox" name="_custom_fields[{{index}}][required]" value="yes" />
                    </p>
                </div>
                <div class="select-options field-options" style="display:none;">
                    <p>
                        <label><?php _e('Field Name', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][name]" placeholder="Enter field name" />
                    </p>
                    <p>
                        <label><?php _e('CSS Class', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][class]" placeholder="Enter CSS class" />
                    </p>
                    <p>
                        <label><?php _e('Select Options (comma-separated)', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][options]" placeholder="Option 1, Option 2, Option 3" />
                    </p>
                    <p>
                        <label><?php _e('Allow Multiple Selections', 'woocommerce'); ?>:</label>
                        <input type="checkbox" name="_custom_fields[{{index}}][multiple]" value="yes" />
                    </p>
                    <p>
                        <label><?php _e('Additional Cost', 'woocommerce'); ?>:</label>
                        <input type="number" step="0.01" name="_custom_fields[{{index}}][additional_cost]" placeholder="0.00" />
                    </p>
                    <p>
                        <label><?php _e('Field Required', 'woocommerce'); ?>:</label>
                        <input type="checkbox" name="_custom_fields[{{index}}][required]" value="yes" />
                    </p>
                </div>
                <div class="product-options field-options" style="display:none;">
                    <p>
                        <label><?php _e('Field Name', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][name]" placeholder="Enter field name" />
                    </p>
                    <p>
                        <label><?php _e('CSS Class', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][class]" placeholder="Enter CSS class" />
                    </p>
                    <p>
                        <label><?php _e('Select Products (comma-separated IDs)', 'woocommerce'); ?>:</label>
                        <input type="text" name="_custom_fields[{{index}}][product_ids]" placeholder="Enter product IDs" />
                    </p>
                    <p>
                        <label><?php _e('Additional Cost', 'woocommerce'); ?>:</label>
                        <input type="number" step="0.01" name="_custom_fields[{{index}}][additional_cost]" placeholder="0.00" />
                    </p>
                    <p>
                        <label><?php _e('Field Required', 'woocommerce'); ?>:</label>
                        <input type="checkbox" name="_custom_fields[{{index}}][required]" value="yes" />
                    </p>
                </div>
            </div>
        </div>
    </script>
    <?php

    echo '</div>';
    echo '</div>';
}