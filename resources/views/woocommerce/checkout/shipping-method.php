<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this
 * as little as possible, but it does happen. When this occurs the version of the template file
 * will be bumped and the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @author WooCommerce
 * @package WooCommerce/Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>
<style>

</style>
<div class="woocommerce-checkout-review-order-table">
    <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

        <div class="flex flex-col justify-between w-full px-4 border-b woocommerce-shipping-totals shipping cart_item border-grey-border mixmatch-parent">
            <div class="w-full pb-8">
                <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

                <div class="woocommerce-shipping-methods">
                    <?php wc_cart_totals_shipping_html(); ?>
                </div>

                <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
            </div>
        </div>

    <?php endif; ?>
</div>