<?php
if (!defined('ABSPATH')) {
    exit;
}

global $product;
$product_id = $product->get_id();

// Run a custom WP Query to get related products based on 'rd_product_type'
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => 4,
    'post__not_in'   => array($product_id),
    'tax_query'      => array(
        array(
            'taxonomy' => 'rd_product_type',
            'field'    => 'term_id',
            'terms'    => wp_get_post_terms($product_id, 'rd_product_type', array('fields' => 'ids')),
            'operator' => 'IN',
        ),
    ),
);

$related_products = new WP_Query($args);

if ($related_products->have_posts()) : ?>

    <div class="w-full overflow-hidden related rd-related-product pb-5-5rem product <?php echo !is_product() ? 'notebook:px-4' : ''; ?>">
        <h4 class="px-4 pt-12 pb-4 text-black-full text-sm-md-font lg:text-lg-font font-reg420">
            <?php
            // Display dynamic heading based on 'rd_product_type'
            $terms = get_the_terms(get_the_ID(), 'rd_product_type');
            $product_type = (!is_wp_error($terms) && !empty($terms)) ? get_term($terms[0], 'rd_product_type')->name : '';
            if ($product_type === 'merch') {
                esc_html_e('Other designs you might like', 'woocommerce');
            } elseif ($product_type === 'box') {
                esc_html_e('Other boxes you might like', 'woocommerce');
            } else {
                esc_html_e('Other donuts you might like', 'woocommerce');
            }
            ?>
        </h4>

        <?php woocommerce_product_loop_start(); ?>

        <?php while ($related_products->have_posts()) : $related_products->the_post(); ?>
            <?php
            global $product;
            $rd_product_type = get_rd_product_type($product->get_id());
            // Set button URL based on product type for each related product
            $button_url = ($rd_product_type == 'Donut') ? '/donut-box/' : get_permalink();
            ?>
            <li <?php wc_product_class('flex flex-col w-full relative lg:w-23 max-xs:w-full sm-mob:w-48 h-auto', $product); ?> x-data="{ showAllergens: false }">

                <!-- Allergen Information Section -->
                <?php
                $product_allergens = get_field('product_allergens', $product->get_id());
                if ($product_allergens) : ?>
                    <div class="absolute z-50 cursor-pointer top-4 right-4 " @click="showAllergens = !showAllergens">
                        <!-- Allergen Icon Display -->
                        <div x-show="!showAllergens" class="z-50">
                            <span class="sr-only"><?php _e('info icon', 'rolling-donut'); ?></span>
                            <!-- SVG Icon here -->
                        </div>
                        <!-- Close Icon -->
                        <div x-show="showAllergens" class="z-50 relative rounded-t-lg top-1.5 right-1.5">
                            <span class="sr-only"><?php _e('close', 'rolling-donut'); ?></span>
                            <!-- SVG Icon here -->
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Product Link -->
                <a class="relative w-full h-full bg-white border-2 border-black border-solid cursor-pointer related-post hover:border-yellow-primary rounded-sm-8" href="<?php echo esc_url($button_url); ?>">
                    <?php echo woocommerce_get_product_thumbnail('related', array('class' => 'w-full object-cover related-post-img h-[157px] lg:h-[200px] m-0')); ?>
                    <div class="relative top-0 left-0 z-10 w-full p-4 bg-white min-h-[200px]">
                        <h4 class="lg:pb-8 text-black-full text-mob-md-font font-reg420"><?php the_title(); ?></h4>
                        <?php if ($rd_product_type !== 'Donut') : ?>
                            <span class="pb-4 text-black-full font-laca font-reg420 text-sm-md-font md:text-md-font"><?php woocommerce_template_loop_price(); ?></span>
                        <?php endif; ?>
                        <button
                            class="button w-full text-mob-xs-font md:text-sm-font font-reg420 h-[56px] flex justify-center items-center rounded-large border-black-full border-2 bg-white hover:bg-yellow-primary">
                            <?php
                            if ($rd_product_type == 'Donut') {
                                echo __('Order now', 'rolling-donut');
                            } elseif ($rd_product_type == 'Merch') {
                                echo __('View Product', 'rolling-donut');
                            } else {
                                echo __('View Box', 'rolling-donut');
                            }
                            ?>
                        </button>
                    </div>
                </a>
            </li>
        <?php endwhile; ?>

        <?php woocommerce_product_loop_end(); ?>
    </div>

<?php
endif;

wp_reset_postdata();
?>
