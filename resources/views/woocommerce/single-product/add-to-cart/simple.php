<?php
/**
 * Simple product add to cart
 *
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

global $product;

if (!$product->is_purchasable()) {
    return;
}

echo wc_get_stock_html($product); // WPCS: XSS ok.

if ($product->is_in_stock()) : ?>

    <?php do_action('woocommerce_before_add_to_cart_form'); ?>
    <style>
        .quantity_input {
            height: 44px;
            width: 100%;
            max-width: 418px;
        }
        .quantity {
            width: 100%;
            margin-bottom: 1rem;
            justify-content: flex-start;
            max-width: 416px;
        }
    </style>

    <form id="simple-add-to-cart-form" class="cart" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post" enctype='multipart/form-data'>
        <?php do_action('woocommerce_before_add_to_cart_button'); ?>

        <?php
        do_action('woocommerce_before_add_to_cart_quantity');

        woocommerce_quantity_input(array(
            'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
            'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
            'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
        ));

        do_action('woocommerce_after_add_to_cart_quantity');
        ?>

        <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt">
            <?php echo esc_html($product->single_add_to_cart_text()); ?>
        </button>

        <?php do_action('woocommerce_after_add_to_cart_button'); ?>
    </form>

    <div class="woocommerce-notices-wrapper"></div>

    <?php do_action('woocommerce_after_add_to_cart_form'); ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Trigger WooCommerce cart fragments refresh
            if (typeof wc_cart_fragments_params !== 'undefined') {
                console.log('wc_cart_fragments_params found, ensuring cart fragments update.');
                $(document.body).trigger('wc_fragment_refresh');
            } else {
                console.error('wc_cart_fragments_params not found. Ensure wc-cart-fragments script is loaded.');
            }

            // Listen for added_to_cart event to update the cart count
            $(document.body).on('added_to_cart', function() {
                console.log('Product added to cart. Triggering fragment refresh.');
                $(document.body).trigger('wc_fragment_refresh');
                updateCartContentsCount();
            });

            // Manually refresh cart fragments after a short delay (fallback)
            setTimeout(function() {
                console.log('Manually triggering wc_fragment_refresh as a fallback.');
                $(document.body).trigger('wc_fragment_refresh');
                updateCartContentsCount();
            }, 2000);

            // Function to update cart contents count directly
            function updateCartContentsCount() {
                $.ajax({
                    url: wc_cart_fragments_params.wc_ajax_url.toString().replace('%%endpoint%%', 'get_cart_contents_count'),
                    type: 'GET',
                    success: function(response) {
                        if (response && response.count) {
                            $('#cart-contents-count').text(response.count);
                            console.log('Cart count updated to:', response.count);
                        } else {
                            console.warn('Failed to retrieve cart count.');
                        }
                    },
                    error: function() {
                        console.error('Error occurred while fetching cart count.');
                    }
                });
            }
        });
    </script>

<?php endif; ?>

