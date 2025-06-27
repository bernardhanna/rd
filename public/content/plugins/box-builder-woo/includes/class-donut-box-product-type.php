<?php

// Register the custom product type
if (!function_exists('register_donut_box_builder_product_type')) {
    add_action('init', 'register_donut_box_builder_product_type');

    function register_donut_box_builder_product_type()
    {
        if (!class_exists('WC_Product_Donut_Box_Builder')) {
            class WC_Product_Donut_Box_Builder extends WC_Product
            {
                public $product_type;

                public function __construct($product)
                {
                    $this->product_type = 'donut_box_builder';
                    parent::__construct($product);
                }
            }
        }
    }
}

// Add custom product type to the dropdown
if (!function_exists('add_donut_box_builder_product')) {
    add_filter('product_type_selector', 'add_donut_box_builder_product');

    function add_donut_box_builder_product($types)
    {
        $types['donut_box_builder'] = __('Donut Box Builder', 'donut-box-builder');
        return $types;
    }
}


add_action('woocommerce_single_product_summary', 'render_my_build_own_section', 25);
function render_my_build_own_section()
{
    global $product;

    // Only display for the "donut_box_builder" product type if desired:
    if (! $product || $product->get_type() !== 'donut_box_builder') {
        return;
    }
?>
    <!-- "Build Your Own" button, shown near the normal Add to Cart -->
    <button id="open-builder" type="button" class="button alt" style="margin-bottom:10px;">
        <?php esc_html_e('Build Your Own', 'my-theme'); ?>
    </button>

    <!-- Builder UI is hidden by default, e.g. a simple toggled div or a modal -->
    <div id="my-builder-modal" style="display:none; border:1px solid #ccc; padding:1rem;">
        <div class="builder-content">
            <?php
            /*
           *  Load your builder template from:
           *  /resources/views/woocommerce/content-single-product-donut-box-builder.php
           *
           *  Option A) Use wc_get_template(). (Good if you have a custom path set)
           *  Option B) Directly include the file with get_stylesheet_directory().
           */
            include get_stylesheet_directory() . '/resources/views/woocommerce/content-single-product-donut-box-builder.php';
            ?>
        </div>
    </div>

<?php
}
