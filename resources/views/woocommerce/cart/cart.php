<?php

/**
 * @Author: Bernard Hanna
 * @Date:   2023-10-24 10:36:25
 * @Last Modified by:   Bernard Hanna
 * @Last Modified time: 2025-03-11 17:03:16
 */

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

<style>
    .product-items {
        display: flex;
        flex-direction: column;
    }

    .cart_item[data-main-product="false"] {
        display: none;
        /* Or any other styling to hide or adjust child items */
    }

    .cart_item[data-main-product="true"] {
        /* Styling for the main product */
    }

    p {
        line-height: 1.5;
    }

    .quantity .border {
        border: 1px solid black !important;
    }


    .woocommerce table.shop_table {
        border: 0px;
        margin: auto;
        text-align: left;
        width: 100%;
        border-collapse: separate;
        border-radius: 5px;
    }

    .woocommerce a.remove {
        color: black !important;
    }

    #add_payment_method table.cart img,
    .woocommerce-cart table.cart img,
    .woocommerce-checkout table.cart img {
        width: 32px;
        box-shadow: none;
        display: flex;
        width: 5.25rem;
        height: 4rem;
        align-items: flex-start;
        flex-shrink: 0;
        border-radius: 0.5rem;
    }

    .coupon button {
        border-radius: 4.5rem !important;
        border: 3px solid #FFED56 !important;
        background: #000 !important;
        color: #FFED56 !important;
        font-family: Edmondsans !important;
        font-size: 1.25rem !important;
        font-style: normal !important;
        font-weight: 420 !important;
        line-height: 1.5rem !important;
    }

    .update-cart button {
        width: 100% !important;
        max-width: 17.25rem !important;
        padding: 1rem 2.5rem !important;
        justify-content: center !important;
        align-items: center !important;
        gap: 1rem !important;
        border-radius: 4.5rem !important;
        background: #FFED56 !important;
        display: flex !important;
    }

    .woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
    .woocommerce-checkout .wc-proceed-to-checkout a.checkout-button {
        text-align: center;
        margin-bottom: 1em;
        font-size: 1.25em !important;
        padding: 1em !important;
        background: black !important;
        border-radius: 4.5rem !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 1.25rem !important;
        font-style: normal !important;
        font-weight: 410 !important;
        line-height: 1.5rem;
    }

    .woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover {
        background: #FFED56 !important;
        color: black !important;
    }

    .pickup-location-field .pickup-location-address {
        font-size: .8em;
        margin: 15px 0;
        font-size: 1.125rem;
        font-style: normal;
        font-weight: 350;
        line-height: 1.625rem;
        margin-bottom: 0px;
    }

    @media (max-width: 575px) {
        .coupon button {
            margin-top: 1rem !important
        }

        .update-cart button {
            width: 100% !important;
            max-width: 100% !important;
        }

        .coupon button:hover {
            background: #FFED56 !important;
            color: #000 !important;
        }
    }

    .nice-select {
        width: auto !important;
    }

    .dropdown-wrapper {
        position: relative;
    }

    .select2-container.select2-container--default.select2-container--open {
        left: 55.25% !important;
    }

    .woosb-cart-child {
        display: none;
    }

    .woocommerce-shipping-contents small {
        display: none !important;
    }

    .woocommerce ul#shipping_method li {
        text-align: right;
    }

    .woocommerce td.product-name dl.variation dt {
        font-weight: bold;
    }

    .cart_item.child-product {
        display: none;
    }

    .woosb-cart-child.woosb-item-child {
        display: none;
    }

    @media (max-width: 768px) {
        .cart_item.child-product {
            display: none !important;
        }

        .woosb-cart-child.woosb-item-child {
            display: none !important;
        }
    }

    .button-clear {
        background-color: transparent !important;
        color: #000000 !important;
        display: flex !important;
        border: 2px solid black !important;
        align-items: center;
        justify-content: center;
        height: 56px;
    }

    .button-clear:hover {
        background-color: black !important;
        color: white !important;
    }

    @media (max-width: 993px) {
        .button-clear {
            margin-bottom: 2rem !important;
        }

        .quantity {
            justify-content: flex-end;
        }

        .update-cart button {
            max-width: 100% !important;
        }

        .coupon {
            flex-direction: column;
            width: 100%;
        }

        #coupon_code {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
        }

        .coupon button {
            min-width: 100% !important;
            max-width: 100% !important;
            width: 100% !important;
        }
    }

    .cxecrt-button-holder {
        clear: both;
        float: none;
        margin: 1.5em 0;
        display: flex;
        justify-content: flex-end;
        width: 92%;
    }

    .cxecrt-cart-page-button.button {
        background-color: #FFED56 !important;
        color: black !important;
    }

    .cxecrt-cart-page-button.button:hover {
        background-color: black !important;
        color: #FFED56 !important;
    }


    @media(max-width: 768px) {

        .woocommerce table.shop_table_responsive tr td,
        .woocommerce-page table.shop_table_responsive tr td {
            display: flex;
            text-align: left !important;
        }

        .product-quantity::before {
            display: none;
        }
    }
</style>
<div class="flex flex-col w-full px-4 pb-6 mx-auto md:px-0 max-w-max-1300">
    <a href="javascript:history.back()" class="mb-4 font-light text-base-font hover:underline">&lt; Back</a>
    <h2 class="text-left text-xl-font font-reg420 text-black-full"><?php _e('Cart', 'rolling-donut'); ?></h2>
    <span class="mb-2 font-light text-sm-md-font">Please Note: Delivery in Dublin area only</span>
    <span class="mb-2 font-light base-font">Orders must be in by 5pm for next day delivery </span>
    <span class="mb-2 font-light base-font">Delivery & Collection available 7 days (8am - 4pm) </span>
    <a target="_blank" href="/our-shops/" class="mb-2 font-light underline hobver:no-underline base-font">Click here for collection locations</a>
</div>
<form class="px-4 md:px-0 woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
    <?php do_action('woocommerce_before_cart_table'); ?>

    <table class="w-full mx-auto shop_table shop_table_responsive cart woocommerce-cart-form__contents max-w-max-1300" cellspacing="0">
        <thead class="border-t border-b border-solid border-black-full max-tablet-sm:hidden">
            <tr>
                <th class="py-4 text-left product-remove"><span class="screen-reader-text"><?php esc_html_e('Remove item', 'woocommerce'); ?></span></th>
                <th class="py-4 text-left product-thumbnai"><span class="screen-reader-text"><?php esc_html_e('Thumbnail image', 'woocommerce'); ?></span></th>
                <th class="py-4 text-left product-name"><?php esc_html_e('Product', 'woocommerce'); ?></th>
                <th class="py-4 text-left product-price"><?php esc_html_e('Price', 'woocommerce'); ?></th>
                <th class="py-4 text-center product-quantity"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
                <th class="py-4 text-left product-subtotal"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php do_action('woocommerce_before_cart_contents'); ?>

            <?php
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                // Output product information for debugging

                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                /**
                 * Filter the product name.
                 *
                 * @since 2.1.0
                 * @param string $product_name Name of the product in the cart.
                 * @param array $cart_item The product in the cart.
                 * @param string $cart_item_key Key for the product in the cart.
                 */
                $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
            ?>
                    <tr class="border-b border-solid border-grey-border woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>" data-main-product="<?php echo isset($cart_item['part_of_box']) && $cart_item['part_of_box'] ? 'false' : 'true'; ?>">

                        <td class="py-4 product-remove">
                            <?php if (!isset($cart_item['part_of_box']) || $cart_item['part_of_box'] !== true) : ?>
                                <?php
                                echo apply_filters(
                                    'woocommerce_cart_item_remove_link',
                                    sprintf(
                                        '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                        esc_url(wc_get_cart_remove_url($cart_item_key)),
                                        esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
                                        esc_attr($product_id),
                                        esc_attr($_product->get_sku())
                                    ),
                                    $cart_item_key
                                );
                                ?>
                            <?php endif; ?>
                        </td>

                        <td class="py-4 product-thumbnail">
                            <?php
                            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('h-[64px] w-[84px] rounded-normal object-cover'), $cart_item, $cart_item_key);

                            if (!$product_permalink) {
                                echo $thumbnail; // PHPCS: XSS ok.
                            } else {
                                printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                            }
                            ?>
                        </td>

                        <td class="py-4 font-light product-name font-laca text-sm-font product-items" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                            <?php
                            if (!$product_permalink) {
                                echo wp_kses_post($product_name . '&nbsp;');
                            } else {
                                /**
                                 * This filter is documented above.
                                 *
                                 * @since 2.1.0
                                 */
                                echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a class="uppercase" href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                            }

                            if ($_product->get_type() === 'donut_box_builder') {
                                if (!empty($cart_item['donut_box_contents'])) {
                                    echo '<ul class="donut-box-builder-items">';
                                    echo '<small>Selected Donuts:</small>';
                                    foreach ($cart_item['donut_box_contents'] as $item_id) {
                                        $item_product = wc_get_product($item_id);
                                        if ($item_product) {
                                            echo '<li>' . $item_product->get_name() . '</li>';
                                        }
                                    }
                                    echo '</ul>';
                                }
                            }

                            do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                            // Meta data.
                            echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

                            // Backorder notification.
                            if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                            }
                            ?>
                        </td>

                        <td class="py-4 font-light product-price font-laca text-sm-font" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                            <?php
                            echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                            ?>
                        </td>
                        <td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                            <?php if (!isset($cart_item['part_of_box']) || $cart_item['part_of_box'] !== true) : ?>
                                <?php
                                if ($_product->is_sold_individually()) {
                                    $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1">', $cart_item_key);
                                } else {
                                    $product_quantity = woocommerce_quantity_input(array(
                                        'input_name'  => "cart[{$cart_item_key}][qty]",
                                        'input_value' => $cart_item['quantity'],
                                        'max_value'   => $_product->get_max_purchase_quantity(),
                                        'min_value'   => '0',
                                        'product_name'  => $_product->get_name(),
                                    ), $_product, false);
                                }

                                echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                                ?>
                            <?php else : ?>
                                <span><?php echo $cart_item['quantity']; ?></span>
                            <?php endif; ?>
                        </td>

                        <td class="py-4 product-subtotal font-laca text-sm-font font-bolder" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
                            <?php
                            echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                            ?>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>

        </tbody>
    </table>

    <?php do_action('woocommerce_cart_contents'); ?>

    <div class="w-full mx-auto my-8 max-w-max-1300">
        <div class="flex flex-col-reverse justify-end w-full py-4 border-t border-b border-solid actions md:flex-row md:justify-between border-black-full">
            <div class="w-full md:2/3 lg:w-1/2 md:max-w-max-584">
                <?php if (wc_coupons_enabled()) { ?>
                    <div class="flex flex-row flex-wrap justify-between w-full coupon max-laptop:flex-col">
                        <input type="text" name="coupon_code" class="flex w-full font-light rounded-lg-x h-input text-black-secondary text-mob-xs-font font-laca pl-11 mobile:max-w-max-358 max-laptop:mb-4" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" /> <button type="submit" class="max-mobile:mt-4 button text-yellow-primary bg-black-full border-3 border-solid border-yellow-primary rounded-btn-72 text-base-font font-reg420 hover:border-black-full h-[56px] hover:bg-yellow-primary hover:text-black-full w-full w-full maz-w-full mobile:min-w-min-208 mobile:w-[208px] flex items-center justify-center max-laptop:mt-4 <?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_html_e('Apply coupon', 'woocommerce'); ?></button>
                        <?php do_action('woocommerce_cart_coupon'); ?>
                    </div>
                <?php } ?>
            </div>
            <div class="flex justify-end w-full md:w-1/3 lg:1/2 max-md:pb-8 update-cart">
                <button type="submit" class="button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?> text-black bg-yellow-primary border-3 border-solid border-yellow-primary rounded-btn-72 text-base-font font-reg420 hover:border-black-full hover:bg-black-full hover:text-yellow-primary min-w-min-208 w-full md:w-[208px] flex items-center justify-center h-[56px]" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>
            </div>
            <?php do_action('woocommerce_cart_actions'); ?>

            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
        </div>
    </div>

    <?php do_action('woocommerce_after_cart_contents'); ?>

    <?php do_action('woocommerce_after_cart_table'); ?>
</form>

<?php do_action('woocommerce_before_cart_collaterals'); ?>
<div class="w-full mx-auto max-w-max-1300">
    <div class="flex justify-end cart-collaterals">
        <?php
        /**
         * Cart collaterals hook.
         *
         * @hooked woocommerce_cross_sell_display
         * @hooked woocommerce_cart_totals - 10
         */
        do_action('woocommerce_cart_collaterals');
        ?>
    </div>
</div>
<?php do_action('woocommerce_after_cart'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Find all instances of the shipping options container
        const shippingOptions = document.querySelectorAll('.woocommerce-shipping-totals');
        // If more than one instance found, remove duplicates
        if (shippingOptions.length > 1) {
            for (let i = 1; i < shippingOptions.length; i++) {
                shippingOptions[i].remove();
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        var deliveryTimeField = document.getElementById('jckwds-delivery-time');
        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function() {
                setTimeout(function() {
                    var savedDeliveryTime = <?php echo json_encode(WC()->session->get('iconic_delivery_time')); ?>;
                    if (deliveryTimeField && savedDeliveryTime) {
                        deliveryTimeField.value = savedDeliveryTime;
                    }
                }, 100); // Adjust this delay as needed
            });
        });

        var config = {
            childList: true,
            subtree: true
        };
        var target = document.querySelector('.woocommerce-checkout-review-order-table'); // Adjust based on actual target
        if (target) observer.observe(target, config);
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Target the element containing the "Collection" text. This selector might need adjustment.
        var shippingLabel = document.querySelector('.checkout .col-1 h3');
        if (shippingLabel && shippingLabel.textContent.includes('Collection')) {
            shippingLabel.textContent = shippingLabel.textContent.replace('Collection.', '');
            // Or set to a completely new value
            // shippingLabel.textContent = '1. Delivery Method';
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        var col1 = document.querySelector('.col-1.hideText'); // Select the container

        if (col1) {
            // This assumes 'Collection' is a direct text node of .col-1.hideText
            Array.from(col1.childNodes).forEach(function(node) {
                if (node.nodeType === 3 && node.textContent.trim() === 'Collection') { // nodeType 3 is a text node
                    node.remove(); // Removes the 'Collection' text node
                }
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const targetNode = document.body; // You can adjust this to a more specific parent if known

        const config = {
            childList: true,
            subtree: true
        };

        const callback = function(mutationsList, observer) {
            for (const mutation of mutationsList) {
                if (mutation.type === "childList") {
                    const noticeGroup = document.querySelector(".woocommerce-NoticeGroup");
                    const targetLocation = document.getElementById("moveNotice");

                    if (noticeGroup && targetLocation) {
                        targetLocation.appendChild(noticeGroup);
                        observer.disconnect(); // Stop observing once we've moved the element
                    }
                }
            }
        };

        const observer = new MutationObserver(callback);
        observer.observe(targetNode, config);
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Target the close button using its class or other identifiable selector
        var closeButton = document.querySelector('.woocommerce-error .close-button'); // Adjust the selector based on your actual close button's class

        if (closeButton) {
            // Add click event listener to the close button
            closeButton.addEventListener('click', function() {
                // Hide the parent .woocommerce-NoticeGroup when the button is clicked
                var noticeGroup = closeButton.closest('.woocommerce-NoticeGroup');
                if (noticeGroup) {
                    noticeGroup.style.display = 'none';
                }
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Function to move the WooCommerce notice
        function moveWooCommerceNotice() {
            var noticeGroup = document.querySelector('.woocommerce-NoticeGroup.woocommerce-NoticeGroup-checkout');
            var checkoutForm = document.querySelector('.checkout.woocommerce-checkout');

            if (noticeGroup && checkoutForm) {
                checkoutForm.parentNode.insertBefore(noticeGroup, checkoutForm);
            }
        }

        // Initially move the notice
        moveWooCommerceNotice();

        // Optional: Listen for changes and move the notice again
        // Useful if your checkout page triggers notices dynamically with AJAX
        var observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.addedNodes.length || mutation.removedNodes.length) {
                    moveWooCommerceNotice();
                }
            });
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true
        });

        // Optional: Clean up the observer when leaving the page to prevent memory leaks
        window.addEventListener('beforeunload', function() {
            observer.disconnect();
        });
    });

    document.addEventListener('click', function(event) {
        // Check if the clicked element is the close button
        if (event.target.classList.contains('close-button')) {
            // Find the parent error message div
            var errorMessage = event.target.closest('.woocommerce-error');
            // Hide the error message div
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        jQuery('.select2-container--open').each(function() {
            var $this = jQuery(this);
            // Assuming .dropdown-wrapper is the intended parent for the dropdown
            var $dropdownParent = $this.closest('.dropdown-wrapper');

            // Log the jQuery object to see if it's correctly identified
            console.log($dropdownParent);

            if ($dropdownParent.length === 0) {
                // Fallback if no .dropdown-wrapper is found
                $dropdownParent = jQuery('body');
                console.log('Fallback to body, .dropdown-wrapper not found.');
            }

            $this.select2({
                dropdownParent: $dropdownParent
            });
        });
    });

    // Updated code starts here
    jQuery(document).ready(function($) {
        // Function to refresh cart totals
        function refreshCartFragments() {
            $.ajax({
                url: wc_cart_params.ajax_url,
                type: 'POST',
                data: {
                    action: 'woocommerce_get_refreshed_fragments'
                },
                success: function(data) {
                    if (data && data.fragments) {
                        // Replace the cart totals HTML
                        $.each(data.fragments, function(key, value) {
                            $(key).replaceWith(value);
                        });
                        // Trigger WooCommerce cart totals updated event
                        $(document.body).trigger('updated_cart_totals');
                    }
                },
                error: function() {
                    console.error('Failed to refresh cart totals');
                }
            });
        }

        // Handle coupon form submission and cart updates
        $(document).on('submit', 'form.woocommerce-cart-form', function(e) {
            e.preventDefault();
            var $form = $(this);
            var formData = $form.serializeArray();

            // Check if a coupon is being applied
            var isApplyingCoupon = formData.some(function(field) {
                return field.name === 'apply_coupon';
            });

            if (isApplyingCoupon) {
                // Apply coupon via AJAX
                var couponCode = $('#coupon_code').val();
                $.ajax({
                    url: wc_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'apply_coupon'),
                    type: 'POST',
                    data: {
                        security: wc_cart_params.apply_coupon_nonce,
                        coupon_code: couponCode
                    },
                    success: function(response) {
                        if (response && !response.error) {
                            // Refresh cart and totals
                            refreshCartFragments();
                            // Clear coupon code input
                            $('#coupon_code').val('');
                            // Display success message
                            if (response.messages) {
                                $('.woocommerce-notices-wrapper').html(response.messages);
                            }
                        } else if (response && response.error) {
                            // Display error message
                            if (response.messages) {
                                $('.woocommerce-notices-wrapper').html(response.messages);
                            } else {
                                alert(response.error);
                            }
                        }
                    },
                    error: function() {
                        console.error('Failed to apply coupon');
                    }
                });
            } else {
                // Handle quantity changes or other cart updates
                // Trigger the update_cart action via AJAX
                $.ajax({
                    url: wc_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'update_cart'),
                    type: 'POST',
                    data: $form.serialize(),
                    success: function(response) {
                        if (response && response.fragments) {
                            // Refresh cart and totals
                            refreshCartFragments();
                            // Update the cart form contents
                            $('.woocommerce-cart-form').html($(response.fragments['.woocommerce-cart-form']).html());
                        }
                    },
                    error: function() {
                        console.error('Failed to update cart');
                    }
                });
            }
        });

        // Handle quantity changes automatically
        $(document).on('change', '.woocommerce-cart-form input.qty', function() {
            // Trigger form submission
            $('.woocommerce-cart-form').submit();
        });

        // Optional: Remove notices after a certain time
        function removeNotices() {
            setTimeout(function() {
                $('.woocommerce-error, .woocommerce-message, .woocommerce-info').fadeOut('slow');
            }, 5000); // Adjust the time as needed
        }

        // Run removeNotices on page load and after AJAX events
        $(document).ready(removeNotices);
        $(document.body).on('updated_cart_totals', removeNotices);
    });
    // Updated code ends here

    jQuery(function($) {
        // Function to toggle visibility of the shipping contents paragraph
        function toggleShippingContents() {
            // Check if local pickup is selected
            var isLocalPickupSelected = $('input[name^="shipping_method"]:checked').val() === 'local_pickup_plus';

            // Toggle the paragraph based on local pickup selection
            if (isLocalPickupSelected) {
                $('.woocommerce-shipping-contents').hide();
            } else {
                $('.woocommerce-shipping-contents').show();
            }
        }

        // Bind the toggle function to the shipping method change event
        $(document).on('change', 'input[name^="shipping_method"]', toggleShippingContents);

        // Also run it on page load in case the local pickup is already selected
        $(document).ready(toggleShippingContents);
    });
</script>