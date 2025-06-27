<?php

add_action('woocommerce_add_custom_field_templates', 'add_textarea_field_template');

function add_textarea_field_template() {
    global $post;

    $fields = get_post_meta($post->ID, '_custom_fields', true);
    if (!is_array($fields)) {
        $fields = array();
    }

    ?>
    <script>
        jQuery(document).ready(function($) {
            $('#add_textarea_field').click(function(e) {
                e.preventDefault();
                var newField = $('#custom_textarea_field_template').html();
                newField = newField.replace(/{{index}}/g, fieldCount);
                $('#custom_fields_wrapper').append(newField);
                fieldCount++;
                updateFieldOrder();
            });
        });
    </script>

    <div id="custom_fields_wrapper" class="custom-field-container">
        <?php if (!empty($fields)) : ?>
            <?php foreach ($fields as $index => $field) : ?>
                <?php if ($field['type'] === 'textarea') : ?>
                    <div class="custom_field">
                        <div class="custom-field-title">
                            <span>Textarea Field</span>
                            <span class="toggle-indicator">▼</span>
                            <button class="remove_field button"><?php _e('Remove', 'woocommerce'); ?></button>
                        </div>
                        <div class="custom-field-body">
                            <input type="hidden" name="_custom_fields[<?php echo esc_attr($index); ?>][type]" value="textarea" />
                            <p>
                                <label><?php _e('Textarea Field Title', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][title]" value="<?php echo esc_attr($field['title']); ?>" placeholder="Enter field title" />
                            </p>
                            <p>
                                <label><?php _e('Textarea Field Name', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][name]" value="<?php echo esc_attr($field['name']); ?>" placeholder="Enter field name" />
                            </p>
                            <p>
                                <label><?php _e('Textarea Field Placeholder', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][placeholder]" value="<?php echo esc_attr($field['placeholder']); ?>" placeholder="Enter placeholder text" />
                            </p>
                            <p>
                                <label><?php _e('Textarea Field Class', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][class]" value="<?php echo esc_attr($field['class']); ?>" placeholder="Enter CSS class" />
                            </p>
                            <p>
                                <label><?php _e('Textarea Field Default Value', 'woocommerce'); ?>:</label>
                                <textarea name="_custom_fields[<?php echo esc_attr($index); ?>][value]" placeholder="Enter default value"><?php echo esc_textarea($field['value']); ?></textarea>
                            </p>
                            <p>
                                <label><?php _e('Textarea Rows', 'woocommerce'); ?>:</label>
                                <input type="number" name="_custom_fields[<?php echo esc_attr($index); ?>][rows]" value="<?php echo esc_attr($field['rows']); ?>" placeholder="Enter rows" />
                            </p>
                            <p>
                                <label><?php _e('Textarea Columns', 'woocommerce'); ?>:</label>
                                <input type="number" name="_custom_fields[<?php echo esc_attr($index); ?>][cols]" value="<?php echo esc_attr($field['cols']); ?>" placeholder="Enter columns" />
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

    <button id="add_textarea_field" class="button"><?php _e('Add Textarea Field', 'woocommerce'); ?></button>

    <script type="text/template" id="custom_textarea_field_template">
        <div class="custom_field">
            <div class="custom-field-title">
                <span>Textarea Field</span>
                <span class="toggle-indicator">▼</span>
                <button class="remove_field button"><?php _e('Remove', 'woocommerce'); ?></button>
            </div>
            <div class="custom-field-body">
                <input type="hidden" name="_custom_fields[{{index}}][type]" value="textarea" />
                <p>
                    <label><?php _e('Textarea Field Title', 'woocommerce'); ?>:</label>
                    <input type="text" name="_custom_fields[{{index}}][title]" placeholder="Enter field title" />
                </p>
                <p>
                    <label><?php _e('Textarea Field Name', 'woocommerce'); ?>:</label>
                    <input type="text" name="_custom_fields[{{index}}][name]" placeholder="Enter field name" />
                </p>
                <p>
                    <label><?php _e('Textarea Field Placeholder', 'woocommerce'); ?>:</label>
                    <input type="text" name="_custom_fields[{{index}}][placeholder]" placeholder="Enter placeholder text" />
                </p>
                <p>
                    <label><?php _e('Textarea Field Class', 'woocommerce'); ?>:</label>
                    <input type="text" name="_custom_fields[{{index}}][class]" placeholder="Enter CSS class" />
                </p>
                <p>
                    <label><?php _e('Textarea Field Default Value', 'woocommerce'); ?>:</label>
                    <textarea name="_custom_fields[{{index}}][value]" placeholder="Enter default value"></textarea>
                </p>
                <p>
                    <label><?php _e('Textarea Rows', 'woocommerce'); ?>:</label>
                    <input type="number" name="_custom_fields[{{index}}][rows]" placeholder="Enter rows" />
                </p>
                <p>
                    <label><?php _e('Textarea Columns', 'woocommerce'); ?>:</label>
                    <input type="number" name="_custom_fields[{{index}}][cols]" placeholder="Enter columns" />
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

add_action('woocommerce_display_custom_field', 'display_textarea_field_on_frontend', 10, 1);
function display_textarea_field_on_frontend($field) {
    if ($field['type'] === 'textarea') {
        echo '<div class="form-row form-row-wide">';
        echo '<label for="' . esc_attr($field['name']) . '">' . esc_html($field['title']) . '</label>';
        echo '<textarea name="' . esc_attr($field['name']) . '" id="' . esc_attr($field['name']) . '" class="' . esc_attr($field['class']) . '" placeholder="' . esc_attr($field['placeholder']) . '" rows="' . esc_attr($field['rows']) . '" cols="' . esc_attr($field['cols']) . '" ' . (!empty($field['required']) ? 'required' : '') . '>' . esc_textarea($field['value']) . '</textarea>';
        echo '</div>';
    }
}
