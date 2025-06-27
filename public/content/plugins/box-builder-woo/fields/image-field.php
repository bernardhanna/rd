<?php

add_action('woocommerce_add_custom_field_templates', 'add_image_field_template');

function add_image_field_template() {
    global $post;

    $fields = get_post_meta($post->ID, '_custom_fields', true);
    if (!is_array($fields)) {
        $fields = array();
    }

    ?>
    <script>
        jQuery(document).ready(function($) {
            $('#add_image_field').click(function(e) {
                e.preventDefault();
                var newField = $('#custom_image_field_template').html();
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
                <?php if ($field['type'] === 'image') : ?>
                    <div class="custom_field">
                        <div class="custom-field-title">
                            <span>Image Upload Field</span>
                            <span class="toggle-indicator">▼</span>
                            <button class="remove_field button"><?php _e('Remove', 'woocommerce'); ?></button>
                        </div>
                        <div class="custom-field-body">
                            <input type="hidden" name="_custom_fields[<?php echo esc_attr($index); ?>][type]" value="image" />
                            <p>
                                <label><?php _e('Image Upload Title', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][title]" value="<?php echo esc_attr($field['title']); ?>" placeholder="Enter field title" />
                            </p>
                            <p>
                                <label><?php _e('Image Upload Name', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][name]" value="<?php echo esc_attr($field['name']); ?>" placeholder="Enter field name" />
                            </p>
                            <p>
                                <label><?php _e('Image Upload Class', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][class]" value="<?php echo esc_attr($field['class']); ?>" placeholder="Enter CSS class" />
                            </p>
                            <p>
                                <label><?php _e('Max File Size (MB)', 'woocommerce'); ?>:</label>
                                <input type="number" name="_custom_fields[<?php echo esc_attr($index); ?>][max_file_size]" value="<?php echo esc_attr($field['max_file_size']); ?>" placeholder="Enter max file size" />
                            </p>
                            <p>
                                <label><?php _e('Allowed File Types', 'woocommerce'); ?>:</label>
                                <input type="text" name="_custom_fields[<?php echo esc_attr($index); ?>][allowed_file_types]" value="<?php echo esc_attr($field['allowed_file_types']); ?>" placeholder="e.g. jpg, png, gif, pdf" />
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

    <button id="add_image_field" class="button"><?php _e('Add Image Upload Field', 'woocommerce'); ?></button>

    <script type="text/template" id="custom_image_field_template">
        <div class="custom_field">
            <div class="custom-field-title">
                <span>Image Upload Field</span>
                <span class="toggle-indicator">▼</span>
                <button class="remove_field button"><?php _e('Remove', 'woocommerce'); ?></button>
            </div>
            <div class="custom-field-body">
                <input type="hidden" name="_custom_fields[{{index}}][type]" value="image" />
                <p>
                    <label><?php _e('Image Upload Title', 'woocommerce'); ?>:</label>
                    <input type="text" name="_custom_fields[{{index}}][title]" placeholder="Enter field title" />
                </p>
                <p>
                    <label><?php _e('Image Upload Name', 'woocommerce'); ?>:</label>
                    <input type="text" name="_custom_fields[{{index}}][name]" placeholder="Enter field name" />
                </p>
                <p>
                    <label><?php _e('Image Upload Class', 'woocommerce'); ?>:</label>
                    <input type="text" name="_custom_fields[{{index}}][class]" placeholder="Enter CSS class" />
                </p>
                <p>
                    <label><?php _e('Max File Size (MB)', 'woocommerce'); ?>:</label>
                    <input type="number" name="_custom_fields[{{index}}][max_file_size]" placeholder="Enter max file size" />
                </p>
                <p>
                    <label><?php _e('Allowed File Types', 'woocommerce'); ?>:</label>
                    <input type="text" name="_custom_fields[{{index}}][allowed_file_types]" placeholder="e.g. jpg, png, gif, pdf" />
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

add_action('woocommerce_display_custom_field', 'display_image_field_on_frontend', 10, 1);
function display_image_field_on_frontend($field) {
    if ($field['type'] === 'image') {
        echo '<div class="form-row form-row-wide">';
        echo '<label for="' . esc_attr($field['name']) . '">' . esc_html($field['title']) . '</label>';
        echo '<input type="file" name="' . esc_attr($field['name']) . '" id="' . esc_attr($field['name']) . '" class="' . esc_attr($field['class']) . '" accept="' . esc_attr($field['allowed_file_types']) . '" ' . (!empty($field['required']) ? 'required' : '') . '>';
        echo '</div>';
    }
}
