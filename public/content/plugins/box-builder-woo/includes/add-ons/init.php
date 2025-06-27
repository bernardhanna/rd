<?php
// Ensure WooCommerce is active
if (!defined('ABSPATH')) {
    exit;
}

// Add a custom tab for custom fields in the product data section
add_filter('woocommerce_product_data_tabs', 'add_custom_field_tab');
function add_custom_field_tab($tabs) {
    $tabs['custom_fields'] = array(
        'label'    => __('Custom Fields', 'woocommerce'),
        'target'   => 'custom_fields_data',
        'class'    => array('show_if_simple', 'show_if_donut_box_builder'),
    );
    return $tabs;
}
