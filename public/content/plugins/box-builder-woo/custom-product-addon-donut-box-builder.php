<?php
/*
Plugin Name: Custom Product Add-on and Donut Box Builder
Description: Adds custom fields and functionality to WooCommerce products, including custom product add-ons and a Donut Box Builder.
Version: 1.3
Author: Bernard Hanna
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Activation hook
register_activation_hook(__FILE__, 'donut_box_builder_activate');
function donut_box_builder_activate()
{
    // Check if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        deactivate_plugins(plugin_basename(__FILE__));
        wp_die(__('WooCommerce must be installed and activated for this plugin to work.', 'donut-box-builder'), 'Plugin dependency check', array('back_link' => true));
    }

    // Perform activation tasks, such as setting default options
    update_option('donut_box_builder_version', '1.3');
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'donut_box_builder_deactivate');
function donut_box_builder_deactivate()
{
    // Clean up actions like removing cron jobs or clearing options
    delete_option('donut_box_builder_version');
}

// Ensure WooCommerce is active
if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    // Include the necessary files
    include_once plugin_dir_path(__FILE__) . 'includes/class-donut-box-product-type.php';
    include_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';
    include_once plugin_dir_path(__FILE__) . 'includes/frontend-functions.php';
    include_once plugin_dir_path(__FILE__) . 'includes/cart-functions.php';
    include_once plugin_dir_path(__FILE__) . 'includes/order-functions.php';
    include_once plugin_dir_path(__FILE__) . 'includes/allergen-functions.php';
    include_once plugin_dir_path(__FILE__) . 'includes/email-functions.php';
    include_once plugin_dir_path(__FILE__) . 'includes/order-again-functions.php';
    include_once plugin_dir_path(__FILE__) . 'includes/manual-product-functions.php';
}
