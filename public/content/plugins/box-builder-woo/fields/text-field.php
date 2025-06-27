<?php

add_action('woocommerce_add_custom_field_templates', 'add_text_field_template');

function add_text_field_template() {
    global $post;

    // Get existing fields
    $fields = get_post_meta($post->ID, '_custom_fields', true);
    if (!is_array($fields)) {
        $fields = array();
    }

    // JavaScript and template for text fields
    ?>
    <style>
        .custom-field-container label {
            margin: 0px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
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

    <script>
        jQuery(document).ready(function($) {
            var fieldCount = <?php echo count($fields); ?>;

            $('#add_text_field').click(function(e) {
                e.preventDefault();
                var newField = $('#custom_text_field_template').html();
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

            $('#custom_fields_wrapper').sortable({
                items: '.custom_field',
                handle: '.custom-field-title',
                update: function(event, ui) {
                    updateFieldOrder();
                }
            });

            function updateFieldOrder() {
                $('#custom_fields_wrapper .custom_field').each(function(index) {
                    $(this).find('input, select').each(function() {
                        var name = $(this).attr('name');
                        if (name) {
                            name = name.replace(/\[\d+\]/, '[' + index + ']');
                            $(this).attr('name', name);
                        }
                    });
                });
            }

            $(document).on('click', '.custom-field-title', function() {
                var fieldContainer = $(this).parent();
                fieldContainer.toggleClass('expanded');
                fieldContainer.find('.custom-field-body').slideToggle();
                $(this).find('.toggle-indicator').text(fieldContainer.hasClass('expanded') ? '▲' : '▼');
            });
        });
    </script>

    <div id="custom_fields_wrapper" class="custom-field-container">
        <?php if (!empty($fields)) : ?>
            <?php foreach ($fields as $index => $field) : ?>
                <?php if ($field['type'] === 'text') : ?>
                    <div class="custom_field">
                        <div class="custom-field-title">
                            <span>Text Field</span>
                            <span class="toggle-indicator">▼</span>
                            <button class="remove_field button"><?php _e('Remove', 'woocommerce'); ?></button>
                        </div>
                        <div class="custom-field-body">
                            <input type="hidden" name="_custom_fields[<?php echo esc_attr($index); ?>][type]" value="text" />
                            <p>
                                <label><?php _e('Text Field Title', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][title]" value="<?php echo esc_attr($field['title']); ?>" placeholder="Enter field title" />
                            </p>
                            <p>
                                <label><?php _e('Text Field Name', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][name]" value="<?php echo esc_attr($field['name']); ?>" placeholder="Enter field name" />
                            </p>
                            <p>
                                <label><?php _e('Text Field Placeholder', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][placeholder]" value="<?php echo esc_attr($field['placeholder']); ?>" placeholder="Enter placeholder text" />
                            </p>
                            <p>
                                <label><?php _e('Text Field Class', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][class]" value="<?php echo esc_attr($field['class']); ?>" placeholder="Enter CSS class" />
                            </p>
                            <p>
                                <label><?php _e('Text Field Default Value', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][value]" value="<?php echo esc_attr($field['value']); ?>" placeholder="Enter default value" />
                            </p>
                            <p>
                                <label><?php _e('Text Field Max Length', 'woocommerce'); ?>:</label>
                                <input type="number" name="_custom_fields[<?php echo esc_attr($index); ?>][max_length]" value="<?php echo esc_attr($field['max_length']); ?>" placeholder="Enter max length" />
                            </p>
                            <p>
                                <label><?php _e('Additional Cost', 'woocommerce'); ?>:</label>
                                <input type="number" name="_custom_fields[<?php echo esc_attr($index); ?>][additional_cost]" value="<?php echo esc_attr($field['additional_cost']); ?>" placeholder="Enter additional cost" />
                            </p>
                            <p>
                                <label><?php _e('Field Required', 'woocommerce'); ?>:</label>
                                <input type="checkbox" name="_custom_fields[<?php echo esc_attr($index); ?>][required]" value="yes" <?php checked($field['required'], 'yes'); ?> />
                            </p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <button id="add_text_field" class="button"><?php _e('Add Text Field', 'woocommerce'); ?></button>

    <script type="text/template" id="custom_text_field_template">
        <div class="custom_field">
            <div class="custom-field-title">
                <span>Text Field</span>
                <span class="toggle-indicator">▼</span>
                <button class="remove_field button"><?php _e('Remove', 'woocommerce'); ?></button>
            </div>
            <div class="custom-field-body">
                <input type="hidden" name="_custom_fields[{{index}}][type]" value="text" />
                <p>
                    <label><?php _e('Text Field Title', 'woocommerce'); ?>:</label>
                    <input type="text" name="_custom_fields[{{index}}][title]" placeholder="Enter field title" />
                </p>
                <p>
                    <label><?php _e('Text Field Name', 'woocommerce'); ?>:</label>
                    <input type="text" name="_custom_fields[{{index}}][name]" placeholder="Enter field name" />
                </p>
                <p>
                    <label><?php _e('Text Field Placeholder', 'woocommerce'); ?>:</label>
                    <input type="text" name="_custom_fields[{{index}}][placeholder]" placeholder="Enter placeholder text" />
                </p>
                <p>
                    <label><?php _e('Text Field Class', 'woocommerce'); ?>:</label>
                    <input type="text" name="_custom_fields[{{index}}][class]" placeholder="Enter CSS class" />
                </p>
                <p>
                    <label><?php _e('Text Field Default Value', 'woocommerce'); ?>:</label>
                    <input type="text" name="_custom_fields[{{index}}][value]" placeholder="Enter default value" />
                </p>
                <p>
                    <label><?php _e('Text Field Max Length', 'woocommerce'); ?>:</label>
                    <input type="number" name="_custom_fields[{{index}}][max_length]" placeholder="Enter max length" />
                </p>
                <p>
                    <label><?php _e('Additional Cost', 'woocommerce'); ?>:</label>
                    <input type="number" name="_custom_fields[{{index}}][additional_cost]" placeholder="Enter additional cost" />
                </p>
                <p>
                    <label><?php _e('Field Required', 'woocommerce'); ?>:</label>
                    <input type="checkbox" name="_custom_fields[{{index}}][required]" value="yes" />
                </p>
            </div>
        </div>
    </script>
    <?php
}

add_action('woocommerce_display_custom_field', 'display_text_field_on_frontend', 10, 1);
function display_text_field_on_frontend($field) {
    if ($field['type'] === 'text') {
        echo '<div class="form-row form-row-wide">';
        echo '<label for="' . esc_attr($field['name']) . '">' . esc_html($field['title']) . '</label>';
        echo '<input type="text" name="' . esc_attr($field['name']) . '" id="' . esc_attr($field['name']) . '" class="' . esc_attr($field['class']) . '" placeholder="' . esc_attr($field['placeholder']) . '" value="' . esc_attr($field['value']) . '" maxlength="' . esc_attr($field['max_length']) . '" ' . (!empty($field['required']) ? 'required' : '') . '>';
        echo '</div>';
    }
}
