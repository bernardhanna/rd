<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php do_action( 'wpo_wcpdf_before_document', $this->type, $this->order ); ?>

<table class="container head">
    <tr>
        <td class="header">
        <?php
        if( $this->has_header_logo() ) {
            $this->header_logo();
        } else {
            echo $this->get_title();
        }
        ?>
        </td>
        <td class="shop-info">
            <div class="shop-name"><h3><?php $this->shop_name(); ?></h3></div>
            <div class="shop-address"><?php $this->shop_address(); ?></div>
        </td>
    </tr>
</table>

<h1 class="document-type-label">
<?php if( $this->has_header_logo() ) echo $this->get_title(); ?>
</h1>

<?php do_action( 'wpo_wcpdf_after_document_label', $this->type, $this->order ); ?>

<table class="order-data-addresses">
    <tr>
        <td class="address billing-address">
            <?php do_action( 'wpo_wcpdf_before_billing_address', $this->type, $this->order ); ?>
            <?php $this->billing_address(); ?>
            <?php do_action( 'wpo_wcpdf_after_billing_address', $this->type, $this->order ); ?>
            <?php if ( isset($this->settings['display_email']) ) { ?>
            <div class="billing-email"><?php $this->billing_email(); ?></div>
            <?php } ?>
            <?php if ( isset($this->settings['display_phone']) ) { ?>
            <div class="billing-phone"><?php $this->billing_phone(); ?></div>
            <?php } ?>
        </td>
        <td class="address shipping-address">
            <?php if ( isset($this->settings['display_shipping_address']) && $this->ships_to_different_address()) { ?>
            <h3><?php _e( 'Ship To:', 'woocommerce-pdf-invoices-packing-slips' ); ?></h3>
            <?php do_action( 'wpo_wcpdf_before_shipping_address', $this->type, $this->order ); ?>
            <?php $this->shipping_address(); ?>
            <?php do_action( 'wpo_wcpdf_after_shipping_address', $this->type, $this->order ); ?>
            <?php } ?>
        </td>
        <td class="order-data">
            <table>
                <?php do_action( 'wpo_wcpdf_before_order_data', $this->type, $this->order ); ?>
                <tr class="order-number">
                    <th><?php _e( 'Order Number:', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
                    <td><?php $this->order_number(); ?></td>
                </tr>
                <tr class="order-date">
                    <th><?php _e( 'Order Date:', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
                    <td><?php $this->order_date(); ?></td>
                </tr>
                <?php if ( $this->get_shipping_method() ) : ?>
                    <tr class="shipping-method">
                        <th><?php _e( 'Shipping Method:', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
                        <td><?php $this->shipping_method(); ?></td>
                    </tr>
                <?php endif; ?>
                <?php do_action( 'wpo_wcpdf_after_order_data', $this->type, $this->order ); ?>
            </table>
        </td>
    </tr>
</table>

<?php do_action( 'wpo_wcpdf_before_order_details', $this->type, $this->order ); ?>

<table class="order-details">
    <thead>
        <tr>
            <th class="product"><?php _e('Product', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
            <th class="quantity"><?php _e('Quantity', 'woocommerce-pdf-invoices-packing-slips' ); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $items = $this->get_order_items(); if( sizeof( $items ) > 0 ) : foreach( $items as $item_id => $item ) : ?>
        <tr class="<?php echo apply_filters( 'wpo_wcpdf_item_row_class', $item_id, $this->type, $this->order, $item_id ); ?>">
            <td class="product">
                <?php $description_label = __( 'Description', 'woocommerce-pdf-invoices-packing-slips' ); // registering alternate label translation ?>
                <span class="item-name"><?php echo $item['name']; ?></span>
                <?php do_action( 'wpo_wcpdf_before_item_meta', $this->type, $item, $this->order  ); ?>
                <span class="item-meta"><?php echo $item['meta']; ?></span>
                <dl class="meta">
                    <?php $description_label = __( 'SKU', 'woocommerce-pdf-invoices-packing-slips' ); // registering alternate label translation ?>
                    <?php if( !empty( $item['sku'] ) ) : ?><dt class="sku"><?php _e( 'SKU:', 'woocommerce-pdf-invoices-packing-slips' ); ?></dt><dd class="sku"><?php echo $item['sku']; ?></dd><?php endif; ?>
                    <?php if( !empty( $item['weight'] ) ) : ?><dt class="weight"><?php _e( 'Weight:', 'woocommerce-pdf-invoices-packing-slips' ); ?></dt><dd class="weight"><?php echo $item['weight']; ?><?php echo get_option('woocommerce_weight_unit'); ?></dd><?php endif; ?>
                </dl>
                <?php do_action( 'wpo_wcpdf_after_item_meta', $this->type, $item, $this->order  ); ?>
            </td>
            <td class="quantity"><?php echo $item['quantity']; ?></td>
        </tr>
        <?php endforeach; endif; ?>
    </tbody>
</table>

<?php do_action( 'wpo_wcpdf_after_order_details', $this->type, $this->order ); ?>

<?php if ( $this->get_footer() ): ?>
<div id="footer">
    <?php $this->footer(); ?>
</div><!-- #letter-footer -->
<?php endif; ?>
<?php do_action( 'wpo_wcpdf_after_document', $this->type, $this->order ); ?>
