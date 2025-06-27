<style>
    #donut-builder-ui {
        transition: opacity 0.4s ease-in-out;
    }

    #donut-builder-ui {
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.4s ease-in-out;
    }

    #donut-builder-ui.active {
        opacity: 1;
        pointer-events: auto;
    }


    /* Slider specific styles */
    #box-container .in-box img {
        border-radius: 100%;
        border: 2px solid #ffed56;
        max-height: 100px;
        max-width: 100px;
        min-height: 100px;
        min-width: 100px;
    }

    #available-products {
        height: fit-content;
    }

    @media (max-width: 1084px) {
        #available-products .slick-track {
            text-align: center;
        }

        #available-products .slick-slide img {
            display: block;
            margin: auto;
        }
    }

    .max-w-160px {
        max-width: 160px;
    }

    .quantity {
        margin: auto;
        /*border: 1px solid #d8d7ce !important; */
        padding: 1rem;
        border-radius: 2rem;
        width: 167px;
    }

    @media (min-width: 1200px) {
        .quantity {
            width: 200px;
        }
    }

    @media (min-width: 1200px) {
        .postid-3947 .quantity {
            width: auto;
            max-width: 150px;
        }
    }

    .input-text.qty.text.hasQtyButtons {
        border: none !important;
    }

    .decrement-btn,
    .increment-btn {
    padding: 2px;
    width: 50px;
    display: flex
;
    align-items: center;
    justify-content: center;
    border: 1px solid;
    }

    .decrement-btn svg {
        width: 10px;
    }

    .grid-cols-4 {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }

    @media (max-width: 1450px) {
        .grid-cols-4 {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (max-width: 420px) {
        .container-box {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    .grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    @media(max-width: 1085px) {
        .max-w-480px {
            max-width: 480px;
        }
    }

    .summary {
        height: fit-content;
    }

    .border-top-right-radius {
        border-top-right-radius: 1.5rem;
    }

    .bg-red-btn {
        background-color: #C70000;
    }

    .toast-message {
        border-radius: 8px;
        background: #E3645F;
        width: 272px;
        padding: 16px;
        justify-content: center;
        align-items: center;
        gap: 8px;
        color: var(--black-full, #000);
        text-align: center;
        font-family: 'Edmondsans', sans-serif;
        font-size: 16px;
        font-style: normal;
        font-weight: 420;
        line-height: 22px;
        bottom: 0px;
        position: absolute;
    }

    .woocommerce-notice.error .woocommerce-error {
        background-color: #f55959;
        color: #000;
        font-size: 1.2em;
        font-weight: bold;
        text-align: center;
        padding: 1em;
    }

    .box-item {
        position: relative;
        cursor: pointer;
    }

    .tooltip {
        display: none;
        position: absolute;
        top: 0px;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 0px;
        border-radius: 5px;
        font-size: 14px;
        text-align: center;
        z-index: 10;
        width: 50%;
        border-radius: 100%;
        max-height: 100px;
        max-width: 100px;
        min-height: 100px;
        min-width: 100px;
    }

    .box-item:hover .tooltip {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #available-products-mobile {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem; /* adjust as needed */
    }

    @media (max-width: 420px) {
    #available-products-mobile {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 1084px) {
        .product-sum h2 {
            display: none;
        }

        .product-sum p {
            text-align: center;
        }
    }

    .postid-3947 .pd_box_list .decrement-btn,
    .postid-3947 .pd_box_list .increment-btn {
        padding: 0px;
        width: auto;
        box-shadow: none;
    }


    .woocommerce-notices-wrapper {
        position: fixed;
        bottom: 50%;
        left: 50%;
        right: 50%;
        width: 100%;
        z-index: 1000;
    }

        @media (max-width: 1084px) {
            #available-products-container {
                order: 2;
                border-radius: 0 0 1.5rem 1.5rem;
                background: white;
            }

            #box_items {
                order: 1;
            }

            #info-open {
                margin-bottom: 0px;
                padding-bottom: 0px;
            }

            .product-sum {
                padding-bottom: 1rem;
            }
        }


          #default-product-layout .quantity {
            width: 100%;
            max-width: 416px;
            margin-left: 1px;
            margin-right: auto;
        }
.plus-btn { transition: background .2s ease, transform .15s ease; }
.plus-btn:hover { transform: scale(1.05); }

@keyframes slideUpBounce {
    0% { transform: translateY(100%); }
    60% { transform: translateY(-10px); }
    80% { transform: translateY(5px); }
    100% { transform: translateY(0); }
}

@keyframes slideDownBounce {
    0% { transform: translateY(0); }
    20% { transform: translateY(-5px); }
    100% { transform: translateY(100%); }
}

#mobile-modal-content.slide-up { animation: slideUpBounce 0.5s forwards; }
#mobile-modal-content.slide-down { animation: slideDownBounce 0.5s forwards; }

</style>
<?php defined('ABSPATH') || exit;

global $product;
$product_id = $product->get_id();

// Hook: woocommerce_before_single_product.
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form();
    return;
}

// Ensure the global product is available
if (!is_a($product, 'WC_Product')) {
    $product = wc_get_product(get_the_ID());
}

if (!$product || !is_a($product, 'WC_Product')) {
    return; // Exit if $product is not a valid product
}

// Fetch box quantity
$box_quantity = get_post_meta($product->get_id(), '_donut_box_builder_box_quantity', true);
if ($box_quantity === '') {
    $box_quantity = 0; // 0 means unlimited
}

// Fetch prefilled products
$pre_filled = get_post_meta($product->get_id(), '_donut_box_builder_pre_filled', true);
$prefilled_products = get_post_meta($product->get_id(), '_prefilled_box_products', true);

// Placeholder URL
$placeholder_url = '/content/uploads/2024/04/Donuts.svg';

// Fetch manually selected variations
$selected_variations = get_post_meta($product->get_id(), '_custom_box_products', true);
$selected_products = array();

if ($selected_variations) {
    foreach ($selected_variations as $variation_id) {
        $variation_product = wc_get_product($variation_id);
        if ($variation_product) {
            $selected_products[] = $variation_product;
        }
    }
}

// Fetch disabled products
$disabled_variations = get_post_meta($product->get_id(), '_disabled_box_products', true);
if (!$disabled_variations) {
    $disabled_variations = [];
}

// Get selected filter type (e.g., all_donuts, all_large_donuts, all_midi_donuts, selected_flavours_only, category)
$group_selection = get_post_meta($product->get_id(), '_donut_group_selection', true);
$selected_size = get_post_meta($product->get_id(), '_donut_size_selection', true); // Fetch the size selection

// Initialize array for all products to display
$all_products = array();

// Determine products to fetch based on group selection
if ($group_selection === 'all_donuts') {
    // Fetch all donuts without size restriction
    $args = array(
        'status' => 'publish',
        'limit' => -1,
        'type' => 'variable',
        'tax_query' => array(
            array(
                'taxonomy' => 'rd_product_type',
                'field' => 'slug',
                'terms' => 'donut',
            ),
        ),
    );

    $all_donuts = wc_get_products($args);
    foreach ($all_donuts as $donut_product) {
        if ($donut_product->is_type('variable')) {
            $variations = $donut_product->get_children();
            foreach ($variations as $variation_id) {
                $variation_product = wc_get_product($variation_id);
                if ($variation_product && !in_array($variation_id, $disabled_variations)) {
                    $all_products[] = $variation_product;
                }
            }
        }
    }
} elseif ($group_selection === 'all_large_donuts' || $group_selection === 'all_midi_donuts') {
    // Fetch donuts of specific size based on selection
    $selected_size = ($group_selection === 'all_large_donuts') ? 'large' : 'midi';
    $args = array(
        'status' => 'publish',
        'limit' => -1,
        'type' => 'variable',
        'tax_query' => array(
            array(
                'taxonomy' => 'rd_product_type',
                'field' => 'slug',
                'terms' => 'donut',
            ),
        ),
    );

    $all_donuts = wc_get_products($args);
    foreach ($all_donuts as $donut_product) {
        if ($donut_product->is_type('variable')) {
            $variations = $donut_product->get_children();
            foreach ($variations as $variation_id) {
                $variation_product = wc_get_product($variation_id);
                if ($variation_product && !in_array($variation_id, $disabled_variations)) {
                    $variation_attributes = $variation_product->get_attributes();
                    if (isset($variation_attributes['pa_size']) && strtolower($variation_attributes['pa_size']) === strtolower($selected_size)) {
                        $all_products[] = $variation_product;
                    }
                }
            }
        }
    }
} elseif ($group_selection === 'category') {
    // Fetch donuts by selected category
    $selected_category = get_post_meta($product->get_id(), '_donut_category_selection', true);
    if ($selected_category) {
        $args = array(
            'status' => 'publish',
            'limit' => -1,
            'type' => 'variable',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => $selected_category,
                ),
            ),
        );

        $category_donuts = wc_get_products($args);

        foreach ($category_donuts as $donut_product) {
            if ($donut_product->is_type('variable')) {
                $variations = $donut_product->get_children();
                foreach ($variations as $variation_id) {
                    $variation_product = wc_get_product($variation_id);
                    if ($variation_product && !in_array($variation_id, $disabled_variations)) {
                        // Apply the size filter if a size is selected
                        if ($selected_size && $selected_size !== 'all') {
                            $variation_attributes = $variation_product->get_attributes();
                            if (isset($variation_attributes['pa_size']) && strtolower($variation_attributes['pa_size']) === strtolower($selected_size)) {
                                $all_products[] = $variation_product;
                            }
                        } else {
                            // If no size filter, include all variations
                            $all_products[] = $variation_product;
                        }
                    }
                }
            }
        }
    }
} elseif ($group_selection === 'selected_flavours_only') {
    // Only use manually selected variations
    $all_products = array_filter($selected_products, function ($product) use ($disabled_variations) {
        return !in_array($product->get_id(), $disabled_variations);
    });
} else {
    // Default to manually selected variations if no specific selection is made
    $all_products = array_filter($selected_products, function ($product) use ($disabled_variations) {
        return !in_array($product->get_id(), $disabled_variations);
    });
}

// Remove duplicate products (if any)
$all_products = array_unique($all_products, SORT_REGULAR);

// Sort products by name
usort($all_products, function ($a, $b) {
    return strcasecmp($a->get_name(), $b->get_name());
});

// Fetch the disable add/remove value to pass to JavaScript
$disable_add_remove = get_post_meta($product->get_id(), '_donut_box_builder_disable_add_remove', true);
?>


<div id="default-product-layout">
    <div class="max-w-max-1370 mx-auto flex flex-col md:flex-row lg:justify-between lg:mb-20">
        <?php echo view('woocommerce.single-product.product-image')->render(); ?>

        <div class="relative w-full px-4  lg:pt-0 tablet-sm:w-48 desktop:left-20">
            <?php do_action('woocommerce_single_product_summary'); ?>
            <div class="bg-black-full border-w-[3px] leading-normal mx-0 my-6 rounded-[20px] border-black custom-styles-1">
         <?php if ( ! empty( $prefilled_products ) ) : ?>
    <?php $product_counts = array_count_values( $prefilled_products ); ?>
    <ul class="woosb-wrap woosb-bundled p-5">
        <?php foreach ( $product_counts as $product_id => $count ) : ?>
            <?php
            $loop_product = wc_get_product( $product_id );  // <-- new name
            if ( ! $loop_product ) {
                continue;
            }
            $thumbnail = wp_get_attachment_image(
                $loop_product->get_image_id(),
                'thumbnail',
                false,
                [
                    'style' =>
                        'width:40px;height:40px;object-fit:cover;
                         border-radius:50%;margin-right:10px;vertical-align:middle;'
                ]
            );
            ?>
            <li class="order-b-neutral-200 flex leading-normal m-0 px-0 py-2.5
                       border-b border-dotted text-white items-center">
                <?php echo $thumbnail; ?>
                <span><?php echo esc_html( $loop_product->get_name() ); ?>
                       × <?php echo $count; ?>
                </span>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
            </div>
         <div class="w-full">
                <?php do_action( 'woocommerce_default_after_summary' ); ?>
        </div>
          <div class=" flex flex-col my-12 border-t border-black-full">
            <div class="flex items-start justify-between py-4">
                <div class="flex flex-col justify-center w-full">
                    <span class="text-black-full font-reg420 text-sm-md-font" for="custom-price">Number of Boxes</span>
                    <div class="flex items-center quantity margin-auto">
                        <button type="button" id="box-quantity-decrement" class="border border-solid border-black rounded bg-white h-[29px] w-[29px] flex items-center justify-center decrement-btn hover:bg-yellow-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="4" viewBox="0 0 19 4" fill="none">
                                <path d="M18.0553 2.26316C18.0553 3.2175 17.2816 3.99116 16.3273 3.99116H2.0073C1.05295 3.99116 0.279297 3.2175 0.279297 2.26316C0.279297 1.30881 1.05295 0.535156 2.0073 0.535156H16.3273C17.2816 0.535156 18.0553 1.30881 18.0553 2.26316Z" fill="#291F19"></path>
                            </svg>
                        </button>
                        <input type="number" id="box-quantity" class="border-none input-text qty text hasQtyButtons" step="1" min="1" value="1" title="Qty" size="4" inputmode="numeric" autocomplete="off">
                        <button type="button" id="box-quantity-increment" class="border border-solid border-black rounded bg-white h-[29px] w-[29px] flex items-center justify-center increment-btn hover:bg-yellow-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
                                <path d="M2.08737 8.00708C1.13303 8.00708 0.359375 7.23343 0.359375 6.27908C0.359375 5.32473 1.13303 4.55108 2.08738 4.55108H4.42338V2.18308C4.42338 1.22873 5.19703 0.455078 6.15137 0.455078C7.10572 0.455078 7.87937 1.22873 7.87937 2.18308V4.55108H10.2474C11.2017 4.55108 11.9754 5.32473 11.9754 6.27908C11.9754 7.23343 11.2017 8.00708 10.2474 8.00708H7.87937V10.3431C7.87937 11.2974 7.10572 12.0711 6.15137 12.0711C5.19703 12.0711 4.42338 11.2974 4.42338 10.3431V8.00708H2.08737Z" fill="#291F19"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <button id="add-box-to-cart" onclick="addBoxToCart()" class="mt-8 flex items-center text-center justify-center bg-black-full border-3 border-black-full rounded-[132px] text-white hover:text-black-full whitespace-nowrap mob-md-font mobile:text-sm-md-font font-reg420 gap-4 h-[54px] max-w-[416px] w-full py-4 px-[80px]  hover:bg-yellow-primary hover:border-none" <?php global $product;
                                                                                                                                                                                                                                                                                                                                                                                        $product_id = $product->get_id(); ?>>
                <?php _e('Add Box to Cart', 'donut-box-builder'); ?>
            </button>

         </div>
        <?php
        $disable_build = get_post_meta(get_the_ID(), '_donut_box_builder_disable_build_button', true);
        if ($disable_build !== 'yes') :
        ?>
            <div class="py-6 text-center border-t">
                <button id="open-builder-button"
                    type="button"
                    class="flex items-center justify-center bg-yellow-primary text-black-full border-3 border-black-full rounded-[132px] whitespace-nowrap mob-md-font mobile:text-sm-md-font font-reg420 gap-4 h-[54px] max-w-[416px] w-full py-4 px-[80px] hover:bg-black-full hover:text-white transition-all">
                    <?php _e('Build Your Own Box', 'donut-box-builder'); ?>
                </button>
            </div>
        <?php endif; ?>
        </div>
    </div>
       <?php do_action('woocommerce_after_single_product_summary'); ?>
</div>
<div id="donut-builder-ui" style="display:none;">
    <div class=" border-black-full border-y w-full flex justify-between items-center relative px-5 pb-4 border-l-0 border-r-0 border-t-0 border-b-3 max-md:pt-8 lg:px-8">
        <span class="mb-2 font-light text-sm-md-font">Step 1. Mix and match flavours</span>
        <button id="back-to-product-button" class="my-4 px-6 py-2  bg-red-critical rounded text-white hover:text-black-full font-bold">
            X Close Box builder
        </button>
    </div>
    <div id="product-<?php the_ID(); ?>" <?php wc_product_class('', $product); ?>>
        <div class="flex flex-col w-full h-fit <?php if ($product_id != 3947) : // Check if it's a custom-order product
                                            ?>lg:flex-row<?php endif; ?>">

            <div id="available-products-container" class="max-lg:hidden w-full px-0 <?php if ($product_id != 3947) : ?>lg:w-3/5 pt-8 lg:px-8<?php endif; ?> max-lg:order-2">
                <div id="available-products" class="relative grid items-center w-full grid-cols-4 gap-3 pd_box_list h-fit">
                    <?php
                    if (!empty($all_products)) {
                        $non_vegan_products = array();
                        $vegan_products = array();

                        foreach ($all_products as $product_item) {
                            // Check if the product is vegan
                            $parent_product_id = $product_item->get_parent_id();
                            $parent_product = wc_get_product($parent_product_id);

                            if ($parent_product) {
                                $vegan_category_id = 168;

                                if (has_term($vegan_category_id, 'product_cat', $parent_product->get_id())) {
                                    $vegan_products[] = $product_item;
                                } else {
                                    $non_vegan_products[] = $product_item;
                                }
                            }
                        }

                        function display_product_with_quantity($product_item, $current_product_id, $product)
                        {
                            $product_name = $product_item->get_name();
                            $product_categories = wc_get_product_category_list($product_item->get_id(), ' ', '', '');

                            if ($current_product_id != 3947 && $product->get_slug() != 'custom-order') {
                                $product_name = str_replace(array('- Large', '- Midi', '- Standard'), '', $product_item->get_name());
                                $product_name = trim($product_name);
                            } else {
                                $product_name = $product_item->get_name();
                            }


                            $product_data = array(
                                'id'        => $product_item->get_id(),
                                'name'      => $product_item->get_name(),
                                'thumbnail' => wp_get_attachment_image_url($product_item->get_image_id(), 'woocommerce_thumbnail'),
                                'price'     => $product_item->get_price()
                            );

                            $category_class = implode(' ', wp_get_post_terms($product_item->get_id(), 'product_cat', array('fields' => 'slugs')));
                    ?>
                            <?php
                            // Use the global $product object to retrieve the correct product ID
                            $product_id = $product->get_id();
                            ?>
                            <div id="product-<?php echo $product_item->get_id(); ?>" class="relative flex flex-col justify-center items-center w-full product-item <?php echo esc_attr($category_class); ?>" data-item='<?php echo esc_attr(json_encode($product_data)); ?>'>
                                <div id="toast-<?php echo $product_item->get_id(); ?>"
                                    class="absolute hidden p-4 text-white transform -translate-x-1/2 -translate-y-full bg-red-500 rounded-lg shadow-lg z-90 toast-message left-1/2 w-72 b-0"
                                    role="alert"
                                    aria-live="polite">
                                    <div class="z-0 flex-1 my-auto shrink basis-0">
                                        In order to add additional flavours, you need to remove items from the current box as it exceeds the box limit.
                                    </div>
                                    <svg class="object-contain absolute z-0 shrink-0 self-start w-9 aspect-[1.56] bottom-[-15px] h-[23px] right-[118px] mt-2 text-center" xmlns="http://www.w3.org/2000/svg" width="32" height="18" viewBox="0 0 32 18" fill="none">
                                        <path d="M16 18L31.5885 0.75H0.411543L16 18Z" fill="#E3645F" />
                                    </svg>
                                </div>
                                <?php if ($product_id == 3947) : ?>
                                    <div class="flex flex-col w-full">
                                        <div class="flex flex-row items-center justify-start w-full">
                                            <?php echo $product_item->get_image('woocommerce_thumbnail', array('class' => 'rounded-full h-[80px] w-[80px] object-contain')); ?>
                                            <p class="py-4 leading-none text-left pd_title text-black-full font-reg420 text-base-font"><?php echo esc_html($product_name); ?></p>
                                            <div class="flex items-center mt-4 quantity margin-auto">
                                                <button type="button" class="decrement-btn" onclick="decrementProductQuantity(<?php echo $product_item->get_id(); ?>)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="4" viewBox="0 0 19 4" fill="none">
                                                        <path d="M18.0553 2.26316C18.0553 3.2175 17.2816 3.99116 16.3273 3.99116H2.0073C1.05295 3.99116 0.279297 3.2175 0.279297 2.26316C0.279297 1.30881 1.05295 0.535156 2.0073 0.535156H16.3273C17.2816 0.535156 18.0553 1.30881 18.0553 2.26316Z" fill="#291F19"></path>
                                                    </svg>
                                                </button>
                                                <input type="number"
                                                    id="product-quantity-<?php echo $product_item->get_id(); ?>"
                                                    class="border-none product-quantity-input input-text qty text hasQtyButtons"
                                                    data-product-id="<?php echo $product_item->get_id(); ?>"
                                                    step="1"
                                                    min="0"
                                                    value="0"
                                                    title="Qty"
                                                    size="4"
                                                    inputmode="numeric"
                                                    autocomplete="off">
                                                <button type="button" class="increment-btn" onclick="incrementProductQuantity(<?php echo $product_item->get_id(); ?>)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
                                                        <path d="M2.08737 8.00708C1.13303 8.00708 0.359375 7.23343 0.359375 6.27908C0.359375 5.32473 1.13303 4.55108 2.08738 4.55108H4.42338V2.18308C4.42338 1.22873 5.19703 0.455078 6.15137 0.455078C7.10572 0.455078 7.87937 1.22873 7.87937 2.18308V4.55108H10.2474C11.2017 4.55108 11.9754 5.32473 11.9754 6.27908C11.9754 7.23343 11.2017 8.00708 10.2474 8.00708H7.87937V10.3431C7.87937 11.2974 7.10572 12.0711 6.15137 12.0711C5.19703 12.0711 4.42338 11.2974 4.42338 10.3431V8.00708H2.08737Z" fill="#291F19"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <?php
                                    // Find how many of this product are prefilled
                                    $current_pid    = $product_item->get_id();
                                    $count_in_box   = isset($prefilled_counts[$current_pid]) ? (int) $prefilled_counts[$current_pid] : 0;
                                    $quantity_value = $count_in_box > 0 ? $count_in_box : 1;
                                    $quantity_style = $count_in_box > 0 ? '' : ' style="display:none;"';
                                    ?>

                                    <?php echo $product_item->get_image('woocommerce_thumbnail', array('class' => 'rounded-full h-[150px] w-[150px] object-contain')); ?>
                                    <p class="pt-4 leading-none text-center pd_title text-black-full font-reg420 text-mob-md-font">
                                        <?php echo esc_html($product_name); ?>
                                    </p>

                                <div class="items-center mx-2 gap-x-4 quantity margin-auto flex justify-space-between">
                             <button class="font-bold minus-btn hidden border-2 border-yellow-primary hover:border-black-full hover:bg-white bg-yellow-primary rounded-full h-[40px] w-[40px]"
                                data-pid="<?php echo $current_pid; ?>"
                                        aria-label="<?php esc_attr_e('Remove one', 'donut-box-builder'); ?>">
                                &minus;
                                </button>
                            <p class="in-box-count text-sm text-gray-600" data-pid="<?php echo $product_item->get_id(); ?>"></p>
                                <button class="font-bold plus-btn border-2 border-yellow-primary hover:border-black-full hover:bg-white bg-yellow-primary rounded-full h-[40px] w-[40px]"
                                        data-item='<?php echo esc_attr(wp_json_encode($product_data)); ?>'
                                        aria-label="<?php esc_attr_e('Add to box', 'donut-box-builder'); ?>">
                                +
                                </button>
                                </div>
                                <?php endif; ?>

                            </div>
                    <?php
                        }

                        $current_product_id = $product->get_id();

                        foreach ($non_vegan_products as $non_vegan_product) {
                            display_product_with_quantity($non_vegan_product, $current_product_id, $product);
                        }

                        foreach ($vegan_products as $vegan_product) {
                            display_product_with_quantity($vegan_product, $current_product_id, $product);
                        }
                    } else {
                        echo '<p>' . __('No matching products found.', 'donut-box-builder') . '</p>';
                    }
                    ?>
                </div>
            </div>

        <div class="mobile">
            <!-- MOBILE BOX SUMMARY -->
                <div id="mobile-box-summary" class="block lg:hidden m-5 px-4 py-3 bg-black-full rounded-[1rem] text-white">
                <div class="flex items-center justify-between mb-2">
                    <div class="text-sm">
                    <strong><?php _e('Box Quantity', 'donut-box-builder'); ?>:</strong>
                    <span id="mobile-current-box-quantity">0</span>/<?php echo esc_html( $box_quantity ); ?>
                    </div>
                    <?php if ( $disable_add_remove !== 'yes' ): ?>
                    <button
                        id="mobile-clear-box"
                        class="bg-red-btn text-black-full px-4 py-1 rounded-[5px] hover:bg-white"
                    >
                        <?php _e('Clear Box', 'donut-box-builder'); ?>
                    </button>
                    <?php endif; ?>
                </div>
                <ul id="mobile-box-summary-list" class="woosb-wrap woosb-bundled divide-y divide-white"></ul>
                <p id="mobile-box-summary-empty" class="text-sm text-white">Your box is empty.</p>
               </div>
                <!-- MOBILE BUILDER MODAL -->
        <div id="mobile-builder-modal"
            class="fixed inset-0 bg-black bg-opacity-75 hidden lg:hidden flex justify-center items-center h-full"
            style="z-index:100000000000;"
        >
        <div id="mobile-modal-content" class="bg-white rounded-lg w-full max-w-full overflow-auto p-4 fixed h-[75%] bottom-0 rounded-t-[40px] border-4 border-black overflow-y-scroll">
            <p class="py-4 relative leading-none text-center pd_title font-reg420 text-mob-md-font">
               Add Flavours to your box!      </p>
            <button id="mobile-modal-close"
                    class="absolute top-2 right-2 text-black font-bold"><svg width="24" height="24" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg"><g fill="#f55959" stroke="#000" stroke-linecap="round" stroke-linejoin="round" transform="translate(2 2)"><circle cx="8.5" cy="8.5" r="8"></circle><g transform="matrix(0 1 -1 0 17 0)"><path d="m5.5 11.5 6-6"></path><path d="m5.5 5.5 6 6"></path></g></g></svg></button>

            <!-- SEARCH BOX -->
            <div class="mb-4 px-2 w-full max-w-[90%]">
            <input
                type="text"
                id="modal-search-input"
                placeholder="Search flavours…"
                class="w-full p-2 border border-gray-300 rounded"
            />
            </div>

            <!-- AVAILABLE PRODUCTS GRID -->
            <div id="available-products-mobile" class="grid gap-2">
            <?php foreach ( $all_products as $product_item ) :
                $raw_name = $product_item->get_name();
                if ( $current_product_id != 3947 && $product->get_slug() != 'custom-order' ) {
                    $display_name = trim( str_replace(['- Large','- Midi','- Standard'], '', $raw_name) );
                } else {
                    $display_name = $raw_name;
                }

                $data = [
                    'id'        => $product_item->get_id(),
                    'name'      => $display_name,
                    'thumbnail' => wp_get_attachment_image_url( $product_item->get_image_id(), 'thumbnail' ),
                    'price'     => $product_item->get_price(),
                ];
            ?>
            <div class="flex flex-col items-center p-2 bg-gray-100 rounded fit" id="mobile-product-<?php echo $data['id']; ?>">

            <!-- thumbnail -->
            <img src="<?php echo esc_url( $data['thumbnail'] ); ?>"
                class="h-16 w-16 rounded-full"
                alt="<?php echo esc_attr( $data['name'] ); ?>" />

            <!-- name -->
            <p class="py-4 leading-none text-center pd_title font-reg420 text-mob-md-font">
                <?php echo esc_html( $data['name'] ); ?>
            </p>


                                <div class="items-center mx-2 gap-x-4 quantity margin-auto flex justify-space-between">
                             <button class="font-bold minus-btn hidden border-2 border-yellow-primary hover:border-black-full hover:bg-white bg-yellow-primary rounded-full h-[40px] w-[40px]"
                                data-pid="<?php echo $current_pid; ?>"
                                        aria-label="<?php esc_attr_e('Remove one', 'donut-box-builder'); ?>">
                                &minus;
                                </button>
                            <p class="in-box-count text-sm text-gray-600" data-pid="<?php echo $product_item->get_id(); ?>"></p>
                                <button class="font-bold plus-btn border-2 border-yellow-primary hover:border-black-full hover:bg-white bg-yellow-primary rounded-full h-[40px] w-[40px]"
                                        data-item='<?php echo esc_attr(wp_json_encode($product_data)); ?>'
                                        aria-label="<?php esc_attr_e('Add to box', 'donut-box-builder'); ?>">
                                +
                                </button>
                                </div>
            </div>
            <?php endforeach; ?>

            </div>
        </div>
        </div>

        <script>
        // live‐filter the modal grid
        document.getElementById('modal-search-input').addEventListener('input', function(){
            const term = this.value.trim().toLowerCase();
            document
            .querySelectorAll('#available-products-mobile > div')
            .forEach(card => {
                const name = card.querySelector('span').textContent.toLowerCase();
                card.style.display = name.includes(term) ? '' : 'none';
            });
        });
        </script>


            </div>

            <div class="max-lg:hidden flex flex-col w-full px-4 lg:w-2/5 summary entry-summary py-8 relative<?php if ($product_id == 3947) : ?>mt-8  justify-center  mx-auto<?php endif; ?>">

                <!-- Custom Fields Display -->
                <?php

                // Define number of columns based on box quantity
                $columns = 3; // Default columns
                if ($box_quantity) {
                    if ($box_quantity <= 6) {
                        $columns = 4;
                    } elseif ($box_quantity <= 12) {
                        $columns = 4;
                    } else {
                        $columns = 5;
                    }
                }
                ?>
                <?php if ($product_id != 3947): ?>
                    <div class="relative w-full m-auto mb-4  max-w-480px max-lg:order-1">
                        <div
                        x-data="stickyBox()"
                        x-init="init()"
                        @scroll.window="handleScroll"
                        :style="boxStyle"
                        class="relative"
                        >
                        <div
                            id="box-section"
                            class="w-full bg-black-full border border-black-full rounded-normal max-w-480px"
                        >
                            <div class="flex flex-row items-center justify-between">
                                <div id="box-quantity-display" class="text-left flex items-center text-sm-font laptop:text-mob-md-font pl-4 text-white h-[50px]"><strong class="max-small:hidden"><?php _e('Box Quantity: ', 'donut-box-builder'); ?></strong> <span class="pl-2" id="current-box-quantity">0</span>/<?php echo esc_html($box_quantity); ?></div>
                                <div class="flex items-center justify-center">
                                    <?php
                                    $disable_add_remove = get_post_meta($product->get_id(), '_donut_box_builder_disable_add_remove', true);

                                    if ($disable_add_remove !== 'yes') {
                                        // Render the Clear Box button
                                    ?>
                                        <button id="clear-box" onclick="clearBoxItems()" class="flex items-center bg-red-btn hover:text-black-full justify-center rounded-sm text-white border-top-right-radius h-[50px] px-[10px] gap-[21.435px] font-medium text-sm-font laptop:text-mob-md-font">
                                            <?php _e('Clear Box', 'donut-box-builder'); ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="33" height="33" viewBox="0 0 33 33" fill="none">
                                                <g clip-path="url(#clip0_3017_6817)">
                                                    <path d="M1.47607 5.77344V13.8114H9.51405" stroke="black" stroke-width="2.67932" stroke-linecap="round" stroke-linejoin="round"></path>
                                                    <path d="M4.83863 20.5088C5.70726 22.9742 7.35362 25.0907 9.52966 26.5391C11.7057 27.9875 14.2935 28.6895 16.9032 28.5393C19.513 28.3891 22.0032 27.3949 23.9987 25.7063C25.9941 24.0178 27.3868 21.7265 27.9669 19.1776C28.5469 16.6288 28.2828 13.9604 27.2145 11.5747C26.1462 9.18894 24.3314 7.21502 22.0437 5.95034C19.756 4.68566 17.1192 4.19873 14.5307 4.56292C11.9421 4.92711 9.54206 6.12269 7.69211 7.96952L1.47607 13.8105" stroke="black" stroke-width="2.67932" stroke-linecap="round" stroke-linejoin="round"></path>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_3017_6817)">
                                                        <rect width="32.1519" height="32.1519" fill="white" transform="translate(0.13623 0.414062)"></rect>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </button>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div id="box-container"
                                class="grid grid-cols-4 gap-4 xl:gap-8 p-4 container-box laptop:p-6"
                                data-max-quantity="<?php echo esc_attr($box_quantity); ?>"
                                data-placeholder-url="<?php echo esc_url($placeholder_url); ?>"
                                data-product-id="<?php echo esc_attr($product->get_id()); ?>">
                                <div id="placeholder" class="relative flex flex-col items-center justify-center box-item p2">
                                    <img src="<?php echo esc_url($placeholder_url); ?>" alt="Donut Placeholder" class="box-img">
                                </div>
                                <!-- Box Items will be inserted here dynamically -->
                            </div>
                                </div>
                                    <div class="mt-4 text-center">
   <a
        href="#step2"
        class="button w-full text-center text-black-full font-reg420 text-sm-md-font h-[56px] flex justify-center items-center rounded-large border-black-full border-solid border-2 bg-white hover:bg-yellow-primary"

      >  <span>Proceed to Next Step</span>
                <!-- chevron-down icon -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg></a>
                    </div>
                    </div>
                <?php else: ?>
                    <div id="box_items" class="w-full m-auto mb-4 border bg-black-full border-black-full max-w-480px">
                        <div class="flex flex-row items-center justify-between">
                            <div id="box-quantity-display" class="text-left flex items-center text-sm-font laptop:text-mob-md-font pl-4 text-white h-[50px]"><strong class="max-small:hidden"><?php _e('Items in Box', 'donut-box-builder'); ?></strong> <span class="pl-2" class="hidden" id="current-box-quantity">0</span>/<?php echo esc_html($box_quantity); ?></div>
                        </div>
                        <div id="item-list-container" class="w-full p-4 m-auto text-black bg-white border border-black-full max-w-480px">
                            <span class="font-bold box-item-count">Total Items: <span id="box-item-count-display">0</span></span>
                            <ul id="item-list">
                                <!-- Items will be inserted here dynamically -->
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
                </div>
        </div>

    </div>

    <div id="step2" class="mb-8 md:mb-20 lg:mb-[15rem]"></div>
    <div class="py-12 px-5 bg-grey-background">

            <div class="flex flex-col order-1 max-w-[800px] w-full px-4 mx-auto">
                <?php do_action('woocommerce_donut_box_builder_after_summary'); ?>

                <div class="py-8 text-center border-b border-gray-300 border-solid extenonheadingparent">
                    <?php
                    global $product;
                    $product = wc_get_product(get_the_ID());
                    if (is_a($product, 'WC_Product')) {
                        $price = $product->get_price();
                        $currency = get_woocommerce_currency_symbol();
                    ?>
                        <div class="text-black-full font-reg420 text-sm-md-font
                            <?php
                            $product_id = $product->get_id();
                            echo (in_array('rd-product-type-donut', get_body_class()) || $product_id == 3947) ? 'hidden' : '';
                            ?>">
                            Box total: <bdi id="box-total" class="relative z-50"><?php echo $currency . $price; ?></bdi>
                        </div>
                    <?php
                    } else {
                        echo 'Price not available';
                    }
                    ?>
                    <?php
                    global $product;

                    $product_id = $product->get_id();

                    if ($product_id == 3947) {
                    ?>
                        <div id="custom-price-container" class="flex flex-col justify-center my-4">
                            <label class="text-black-full font-reg420 text-sm-md-font" for="custom-price">Enter your price (€):</label>
                            <input class="w-full m-auto my-4 text-center" type="number" placeholder="0" id="custom-price" name="custom_price" min="0" step="0.01" required>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <!-- Quantity and Total -->
                <div class="flex items-center justify-between py-4">
                    <div class="flex flex-col justify-center w-full">
                        <span class="text-center text-black-full font-reg420 text-sm-md-font" for="custom-price">Number of Boxes</span>
                        <div class="flex items-center quantity margin-auto bg-white">
                            <button type="button" id="box-quantity-decrement" class="border border-solid border-black rounded bg-white h-[29px] w-[29px] flex items-center justify-center decrement-btn hover:bg-yellow-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="4" viewBox="0 0 19 4" fill="none">
                                    <path d="M18.0553 2.26316C18.0553 3.2175 17.2816 3.99116 16.3273 3.99116H2.0073C1.05295 3.99116 0.279297 3.2175 0.279297 2.26316C0.279297 1.30881 1.05295 0.535156 2.0073 0.535156H16.3273C17.2816 0.535156 18.0553 1.30881 18.0553 2.26316Z" fill="#291F19"></path>
                                </svg>
                            </button>
                            <input type="number" id="box-quantity" class="border-none input-text qty text hasQtyButtons" step="1" min="1" value="1" title="Qty" size="4" inputmode="numeric" autocomplete="off">
                            <button type="button" id="box-quantity-increment" class="border border-solid border-black rounded bg-white h-[29px] w-[29px] flex items-center justify-center increment-btn hover:bg-yellow-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="13" viewBox="0 0 12 13" fill="none">
                                    <path d="M2.08737 8.00708C1.13303 8.00708 0.359375 7.23343 0.359375 6.27908C0.359375 5.32473 1.13303 4.55108 2.08738 4.55108H4.42338V2.18308C4.42338 1.22873 5.19703 0.455078 6.15137 0.455078C7.10572 0.455078 7.87937 1.22873 7.87937 2.18308V4.55108H10.2474C11.2017 4.55108 11.9754 5.32473 11.9754 6.27908C11.9754 7.23343 11.2017 8.00708 10.2474 8.00708H7.87937V10.3431C7.87937 11.2974 7.10572 12.0711 6.15137 12.0711C5.19703 12.0711 4.42338 11.2974 4.42338 10.3431V8.00708H2.08737Z" fill="#291F19"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

<button id="add-box-to-cart" onclick="addBoxToCart()" class="ml-auto mr-auto mt-8 flex items-center text-center justify-center bg-yellow-primary border-3 border-black-full rounded-[132px] text-black-full hover:text-black-full whitespace-nowrap mob-md-font mobile:text-sm-md-font font-reg420 gap-4 h-[54px] max-w-[416px] w-full py-4 px-[80px] disabled:bg-yellow-disabled disabled:cursor-not-allowed disabled:border-grey-disabled hover:bg-white hover:border-black-full" <?php global $product;
$product_id = $product->get_id();
if ($product_id != 3947) echo 'disabled'; ?>>
                    <?php _e('Add Box to Cart', 'donut-box-builder'); ?>
                </button>
                <?php do_action('woocommerce_after_add_to_cart_button'); ?>
            </div>

    </div>

</div>
<?php do_action('woocommerce_after_single_product'); ?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>
  var boxItems = [];

  window.addBoxToCart = function() {
    try {
      const btn = document.getElementById('add-box-to-cart');
      btn.disabled = true;
      btn.textContent = 'Processing…';

      const products = boxItems
        .filter(i => i != null)
        .map(i => ({ id: i.id, quantity: i.quantity }));

      const form = new FormData();
      form.append('action', 'donut_box_add_to_cart');
      form.append('donut_box_product_id', "<?php echo $product_id; ?>");
      form.append('products_data', JSON.stringify(products));
      form.append('quantity', document.getElementById('box-quantity').value);
      form.append('nonce', my_script_object.nonce);

      // ← NEW: remember builder was open
      sessionStorage.setItem('builderOpen', '1');

      fetch(my_script_object.ajax_url, {
        method: 'POST',
        credentials: 'same-origin',
        body: form
      })
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          location.reload();
        } else {
          alert(data.message || 'Error adding box to cart');
          btn.disabled = false;
          btn.textContent = 'Add Box to Cart';
        }
      })
      .catch(err => {
        console.error(err);
        alert('Error adding box to cart');
        btn.disabled = false;
        btn.textContent = 'Add Box to Cart';
      });
    } catch (e) {
      console.error('addBoxToCart threw:', e);
      const btn = document.getElementById('add-box-to-cart');
      btn.disabled = false;
      btn.textContent = 'Add Box to Cart';
    }
  };

  function toggleMinusBtn(pid) {
    const btn = document.querySelector(`.minus-btn[data-pid="${pid}"]`);
    if (!btn) return;
    const qty = (boxItems.find(i => i.id === pid) || {}).quantity || 0;
    btn.classList.toggle('hidden', qty === 0);
    }

  document.addEventListener("DOMContentLoaded", () => {
    // ← NEW: if we just added while builder open, restore it
    if (sessionStorage.getItem('builderOpen') === '1') {
      sessionStorage.removeItem('builderOpen');
      document.getElementById('default-product-layout').style.display = 'none';
      const ui = document.getElementById('donut-builder-ui');
      ui.style.display = '';
      ui.classList.add('active');
      document.getElementById('page-header').style.display = 'none';
    }

    const productId = parseInt("<?php echo $product_id;?>");
    const disableAddRemove = "<?php echo $disable_add_remove;?>";
    const addBoxButtons = document.querySelectorAll("#add-box-to-cart,#add-box-to-cart-builder,#floating-add-to-cart-btn");
    const setAddToCartButtonsEnabled = (e) => addBoxButtons.forEach((b) => b && (b.disabled = !e));
    const boxQuantityInput = document.getElementById("box-quantity");
    const currentBoxQuantityElement = document.getElementById("current-box-quantity");
    let currentAllergens = new Set();
    const sumQty = (a) => a.reduce((t, i) => t + (i ? i.quantity : 0), 0);

    function refreshMiniQuantityInputs() {
      const counts = {};
      boxItems.forEach((i) => {
        counts[i.id] = (counts[i.id] || 0) + i.quantity;
      });
      document.querySelectorAll(".product-quantity-input").forEach((inp) => {
        const pid = parseInt(inp.dataset.productId, 10);
        const wrap = inp.closest(".quantity");
        const qty = counts[pid] || 0;
        inp.value = qty;
        wrap.style.display = qty ? "flex" : "none";
      });
    }
    window.refreshMiniQuantityInputs = refreshMiniQuantityInputs;

    function updateCurrentBoxQuantity() {
      const q = sumQty(boxItems);
      currentBoxQuantityElement && (currentBoxQuantityElement.textContent = q);
      const d = document.getElementById("box-item-count-display");
      d && (d.textContent = q);
    }

    function updateAddToCartButtonState() {
      if (productId === 3947) {
        setAddToCartButtonsEnabled(boxItems.length > 0);
        return;
      }
      const t = sumQty(boxItems);
      const m = parseInt(document.getElementById("box-container").dataset.maxQuantity) || 0;
      setAddToCartButtonsEnabled(m === 0 ? t > 0 : t >= m);
    }

    function updateBoxDisplay() {
      if (productId === 3947) {
        const ul = document.getElementById("item-list");
        if (ul) {
          ul.innerHTML = "";
          boxItems.forEach((i) => {
            const li = document.createElement("li");
            li.textContent = `${i.name} x ${i.quantity}`;
            ul.appendChild(li);
          });
        }
        return;
      }
      const box = document.getElementById("box-container");
      const max = parseInt(box.dataset.maxQuantity) || 0;
      const ph = box.dataset.placeholderUrl;
      box.innerHTML = "";
      boxItems.forEach((i) => {
        for (let k = 0; k < i.quantity; k++) {
          const w = document.createElement("div");
          w.className = "flex flex-col justify-center items-center box-item p2 relative in-box";
          w.innerHTML = `<img src="${i.thumbnail}" class="box-img" alt="${i.name}"><div class="tooltip">${i.name.replace(/- (Large|Midi|Standard)/, "").trim()}</div>`;
          if (disableAddRemove !== "yes") {
            const btn = document.createElement("button");
            btn.className = "absolute top-0 right-0 bg-red-500 text-white px-2 py-1 z-50";
            btn.innerHTML =
              '<svg width="24" height="24" viewBox="0 0 21 21" xmlns="http://www.w3.org/2000/svg"><g fill="#f55959" stroke="#000" stroke-linecap="round" stroke-linejoin="round" transform="translate(2 2)"><circle cx="8.5" cy="8.5" r="8"></circle><g transform="matrix(0 1 -1 0 17 0)"><path d="m5.5 11.5 6-6"></path><path d="m5.5 5.5 6 6"></path></g></g></svg>';
            btn.onclick = () => removeOneItemFromBox(i.id);
            w.appendChild(btn);
          }
          box.appendChild(w);
        }
      });
      if (max) {
        for (let r = max - sumQty(boxItems); r > 0; r--)
          box.insertAdjacentHTML("beforeend", `<div class="flex flex-col justify-center items-center box-item p2 relative placeholder"><img src="${ph}" class="box-img" alt="Donut Placeholder"></div>`);
      }
      updateAddToCartButtonState();
      updateCurrentBoxQuantity();
    }

    function afterMutation() {
      refreshMiniQuantityInputs();
      updateBoxDisplay();
      updateCurrentBoxQuantity();
      updateAddToCartButtonState();
      // keep minus‐buttons in sync on any bulk change:
        document.querySelectorAll('.minus-btn').forEach(btn =>
        toggleMinusBtn(parseInt(btn.dataset.pid, 10))
        );
        boxItems.forEach(i => updateInBoxCount(i.id));
    }


    function addItemToBox(item, qty = 1) {
      const max = parseInt(document.getElementById("box-container").dataset.maxQuantity) || 0;
      if (max && sumQty(boxItems) + qty > max) {
        showToast(item.id);
        return;
      }
      const ex = boxItems.find((i) => i.id === item.id);
      ex ? (ex.quantity += qty) : boxItems.push({ ...item, quantity: qty });
      afterMutation();
    }
    window.addItemToBox = addItemToBox;



    window.addItemAtSlot = (item, slot) => {
      let flat = [];
      boxItems.forEach((i) => {
        for (let k = 0; k < i.quantity; k++) flat.push({ ...i });
      });
      flat.splice(slot, 0, { ...item, quantity: 1 });
      const map = {};
      flat.forEach((u) => {
        if (!map[u.id]) map[u.id] = { ...u, quantity: 0 };
        map[u.id].quantity++;
      });
      boxItems = Object.values(map);
      afterMutation();
    };

    function updateItemInBox(item, qty) {
      if (!item) return;
      const idx = boxItems.findIndex((i) => i.id === item.id);
      if (idx === -1) {
        if (qty > 0) boxItems.push({ ...item, quantity: qty });
      } else {
        if (qty > 0) boxItems[idx].quantity = qty;
        else boxItems.splice(idx, 1);
      }
      afterMutation();
    }

    function removeOneItemFromBox(pid) {
      const item = boxItems.find((i) => i.id === pid);
      if (!item) return;
      item.quantity--;
      if (item.quantity <= 0) boxItems = boxItems.filter((i) => i.id !== pid);
      afterMutation();
    }

    // wire up the big round "+" buttons:
        document.querySelectorAll('.plus-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const item = JSON.parse(btn.dataset.item);
            addItemToBox(item, 1);
            toggleMinusBtn(item.id);
        });
        });

        // wire up your new “–” buttons:
        document.querySelectorAll('.minus-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const pid = parseInt(btn.dataset.pid, 10);
            removeOneItemFromBox(pid);
            toggleMinusBtn(pid);
        });
        });

        const pre = window.my_script_object?.prefilled_products_data || [];
        pre.forEach((p) => {
        const existing = boxItems.find((i) => i.id === p.id);
        if (existing) existing.quantity += p.quantity || 1;
        else boxItems.push({ ...p, quantity: p.quantity || 1 });
        });

        boxItems.forEach(i => updateInBoxCount(i.id));

        refreshMiniQuantityInputs();

        // ← new: fire the toggles once on load
        boxItems.forEach(item => toggleMinusBtn(item.id));



    if (productId !== 3947)
      document.querySelectorAll(".add-to-box-button").forEach((btn) =>
        btn.addEventListener("click", function () {
          const item = JSON.parse(this.dataset.item);
          const input = document.getElementById(`product-quantity-${item.id}`);
          const raw = parseInt(input.value, 10);
          const qty = raw && raw > 0 ? raw : 1;
          addItemToBox(item, qty);
        })
      );

    document.querySelectorAll(".product-quantity-input").forEach((inp) =>
      inp.addEventListener("change", (e) => {
        const input = e.target;
        const pid = parseInt(input.dataset.productId, 10);
        let qty = Math.max(0, parseInt(input.value, 10) || 0);
        const box = document.getElementById("box-container");
        const max = parseInt(box.dataset.maxQuantity, 10) || 0;
        const existing = boxItems.find((i) => i.id === pid);
        const oldQty = existing ? existing.quantity : 0;
        const others = sumQty(boxItems) - oldQty;
        if (max && others + qty > max) {
          showToast(pid);
          qty = Math.max(0, max - others);
          input.value = qty;
        }
        const item = JSON.parse(document.getElementById(`product-${pid}`).dataset.item);
        updateItemInBox(item, qty);
      })
    );

    if (productId === 3947)
      document.querySelectorAll(".product-quantity-input").forEach((inp) =>
        inp.addEventListener("change", (e) => {
          const pid = parseInt(e.target.dataset.productId);
          updateItemInBox(JSON.parse(document.getElementById("product-" + pid).dataset.item), parseInt(e.target.value) || 0);
        })
      );

    window.incrementProductQuantity = (pid) => {
      const inp = document.getElementById("product-quantity-" + pid);
      inp.value = parseInt(inp.value || 0) + 1;
      inp.dispatchEvent(new Event("change"));
    };

    window.decrementProductQuantity = (pid) => {
      const inp = document.getElementById("product-quantity-" + pid);
      inp.value = Math.max(0, parseInt(inp.value || 0) - 1);
      inp.dispatchEvent(new Event("change"));
    };

    window.clearBoxItems = () => {
      boxItems = [];
      currentAllergens.clear();
      afterMutation();
    };

    function showToast(pid) {
    console.log('showToast called for', pid); // Debug log

    const isMobile = window.innerWidth <= 768;
    if (isMobile) {
        const errEl = document.getElementById("mobile-error-" + pid);
        if (errEl) {
        errEl.classList.remove("hidden");
        errEl.style.display = "block";
        setTimeout(() => {
            errEl.classList.add("hidden");
            errEl.style.display = "none";
        }, 5000);
        }
    } else {
        const toastEl = document.getElementById("toast-" + pid);
        if (toastEl) {
        toastEl.classList.remove("hidden");
        toastEl.classList.add("flex");
        setTimeout(() => {
            toastEl.classList.remove("flex");
            toastEl.classList.add("hidden");
        }, 5000);
        }
    }
    }
    window.showToast = showToast;

    function fetchAllergens(pid, cb) {
      const fd = new FormData();
      fd.append("action", "get_product_allergens");
      fd.append("product_id", pid);
      fetch(my_script_object.ajax_url, { method: "POST", body: fd })
        .then((r) => r.json())
        .then((d) => (d.success ? cb(d.data) : console.error(d.data)))
        .catch((e) => console.error(e));
    }

    function updateAllergenDisplay() {}

    function updateInBoxCount(pid) {
        const count = (boxItems.find(i => i.id === pid) || {}).quantity || 0;
        const el    = document.querySelector(`.in-box-count[data-pid="${pid}"]`);
        if (!el) return;
        el.textContent = count > 0 ? `${count} in box` : '';
        }

                // keep a reference to the original
        const _origAfter = afterMutation;

        // override it to also refresh every in-box counter
        afterMutation = function() {
        // 1) run all your existing logic
        _origAfter && _origAfter();

        // 2) then update *every* counter element on the page
        document.querySelectorAll('.in-box-count').forEach(el => {
            const pid = parseInt(el.dataset.pid, 10);
            updateInBoxCount(pid);
        });
        };

        // on initial page‐load do the same for any prefilled items
        document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.in-box-count').forEach(el => {
            const pid = parseInt(el.dataset.pid, 10);
            updateInBoxCount(pid);
        });
        });

        // one‐time draw on load
        document.addEventListener("DOMContentLoaded", () => {
        boxItems.forEach(i => updateInBoxCount(i.id));
        });

    refreshMiniQuantityInputs();
    updateBoxDisplay();
    updateAddToCartButtonState();
  });

</script>

<script>
    jQuery(document).ready(function ($) {
        $("#open-builder-button").on("click", function () {
            $("#default-product-layout").hide();
            $("#donut-builder-ui").show().addClass("active");
             // go right to the top
                $("html, body").animate({ scrollTop: 0 }, 500);
            window.refreshMiniQuantityInputs();
        });
        $("#back-to-product-button").on("click", function () {
            $("#donut-builder-ui").removeClass("active");
            setTimeout(() => {
                $("#donut-builder-ui").hide();
                $("#default-product-layout").show();
                $("html,body").animate({ scrollTop: $("#default-product-layout").offset().top }, 500);
            }, 400);
        });
        $(".product-quantity-input").each(function () {
            $(this).closest(".quantity").hide();
        });
        window.refreshMiniQuantityInputs();
      // =====  DESKTOP  ======================================================
        document.querySelectorAll('.add-to-box-button.plus-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const item  = JSON.parse(btn.dataset.item);
                const qtyEl = document.getElementById(`product-quantity-${item.id}`);
                const wrap  = qtyEl.closest('.quantity');

                // only run if the flavour is still at 0
                if (parseInt(qtyEl.value, 10) === 0) {
                    qtyEl.value = 1;
                    wrap.style.display = 'flex';     // show – / number / +
                    btn.style.display = 'none';      // hide the + icon
                    addItemToBox(item, 1);           // ← existing helper
                }
            });
        });


        // =====  MOBILE  =======================================================
        document.querySelectorAll('.add-to-box-mobile').forEach(btn => {
            btn.addEventListener('click', () => {
                const item = JSON.parse(btn.dataset.item);
                const qtyInput = document.getElementById(
                    `mobile-product-quantity-${item.id}`
                );
                const wrapper = qtyInput.closest('.quantity');

                if (parseInt(qtyInput.value, 10) === 0) {
                    qtyInput.value = 1;
                    wrapper.style.display = 'flex';
                    btn.style.display   = 'none';
                    addItemToBox(item, 1);
                }
            });
        });

        window.incrementProductQuantity = function (pid) {
            const input = document.getElementById(`product-quantity-${pid}`);
            if (!input) return;

            const currentQtyInBox = sumQty(boxItems);
            const max = parseInt(document.getElementById("box-container").dataset.maxQuantity, 10) || 0;

            const itemInBox = boxItems.find(i => i.id === pid);
            const itemQty = itemInBox ? itemInBox.quantity : 0;

            // Total if we increment this item by 1
            const newTotal = currentQtyInBox + 1;

            if (max && newTotal > max) {
                showToast(pid); // 🔥 Trigger toast
                return;
            }

            input.value = itemQty + 1;
            input.dispatchEvent(new Event("change"));
        };
        window.decrementProductQuantity = function (pid) {
            const i = $(`#product-quantity-${pid}`);
            let v = parseInt(i.val(), 10) || 0;
            if (v > 1) {
                i.val(v - 1);
            } else {
                i.val(0);
                i.closest(".quantity").hide();
            }
        };
    });
</script>

<script>
    function stickyBox() {
        return {
            boxStyle: "",
            init() {
                this.handleScroll();
                window.addEventListener("resize", () => this.handleScroll());
            },
            handleScroll() {
                if (window.innerWidth <= 1084) {
                    this.boxStyle = "";
                    return;
                }
                const box = document.getElementById("box-section");
                const boxHeight = box.offsetHeight;
                const container = document.getElementById("available-products-container");
                const top = container.getBoundingClientRect().top + window.scrollY;
                const stop = container.offsetTop + container.offsetHeight - boxHeight;
                const scrollY = window.scrollY;
                const header = document.querySelector("header");
                const headerH = header ? header.offsetHeight : 0;
                const earlyOffset = 20;
                const stickPoint = top - headerH - earlyOffset;
                if (scrollY > stickPoint && scrollY < stop) {
                    this.boxStyle = `position:fixed; top:${headerH}px; width:${box.offsetWidth}px`;
                } else if (scrollY >= stop) {
                    this.boxStyle = `position:absolute; top:${stop - top + headerH}px; width:100%`;
                } else {
                    this.boxStyle = "";
                }
            },
        };
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const listEl = document.getElementById("mobile-box-summary-list");
        const emptyEl = document.getElementById("mobile-box-summary-empty");
        const countEl = document.getElementById("mobile-current-box-quantity");
        const boxContainer = document.getElementById("box-container");
        const clearBtn = document.getElementById("mobile-clear-box");
        const modal = document.getElementById("mobile-builder-modal");
        const modalContent = document.getElementById("mobile-modal-content");
        const closeBtn = document.getElementById("mobile-modal-close");

        function openMobileModal() {
            modal.classList.remove("hidden");
            modalContent.classList.remove("slide-down");
            modalContent.classList.add("slide-up");
            document.body.style.overflow = "hidden";
        }

        function closeMobileModal() {
            modalContent.classList.remove("slide-up");
            modalContent.classList.add("slide-down");
            modalContent.addEventListener("animationend", function handler() {
                modal.classList.add("hidden");
                document.body.style.overflow = "";
                modalContent.removeEventListener("animationend", handler);
            }, { once: true });
            activeSlot = null;
        }
        window.openMobileModal = openMobileModal;
        window.closeMobileModal = closeMobileModal;
        /* ---------- small helpers ---------- */
    const totalInBox = () => boxItems.reduce((t, i) => t + i.quantity, 0);

        const maxSlots = parseInt(boxContainer.dataset.maxQuantity, 10) || 0;
        let activeSlot = null;
        let mobileSlotData = new Array(maxSlots).fill(null);
        function syncFromDesktop() {
            const tiles = Array.from(boxContainer.querySelectorAll(".in-box")).filter((el) => !el.classList.contains("placeholder"));
            tiles.slice(0, maxSlots).forEach((el, i) => {
                const img = el.querySelector("img");
                const name = el.querySelector(".tooltip")?.textContent.trim() || img.alt;
                mobileSlotData[i] = { thumbnail: img.src, name };
            });
        }
        function filledHTML(slot, src, name) {
            return `<li data-slot="${slot}" class="order-b-neutral-200 flex items-center m-0 px-0 py-2.5 border-b border-dotted text-white"><img src="${src}" width="40" height="40" style="object-fit:cover;border-radius:50%;margin-right:10px;" alt="${name}" /><span class="flex-grow">${name}</span><button class="mobile-remove-btn bg-red-btn text-black-full px-4 py-1 rounded-[5px] hover:bg-white">Remove</button></li>`;
        }
        function emptyHTML(slot) {
            return `<li data-slot="${slot}" class="mobile-slot-empty order-b-neutral-200 flex items-center justify-between m-0  py-2.5 border-b border-dotted text-white cursor-pointer"><div class="flex items-center"><img src="/content/uploads/2024/04/Donuts.svg" width="40" height="40" style="object-fit:cover;border-radius:50%;margin-right:10px;" alt="Add flavour" /><span class="flex-grow">Add Flavour to Box</span></div><span class="text-lg font-bold text-[24px]">+</span></li>`;
        }
        function renderList() {
            if (maxSlots === 0) {
                listEl.innerHTML = "";
                emptyEl.style.display = "block";
                return;
            }
            emptyEl.style.display = "none";
            let html = "";
            mobileSlotData.forEach((data, i) => {
                html += data ? filledHTML(i, data.thumbnail, data.name) : emptyHTML(i);
            });
            listEl.innerHTML = html;
            attachHandlers();
            countEl.textContent = mobileSlotData.filter((x) => x).length;
        }
        function attachHandlers() {
            listEl.querySelectorAll(".mobile-remove-btn").forEach((btn) => {
                btn.onclick = () => {
                    const slot = +btn.closest("li").dataset.slot;
                    mobileSlotData[slot] = null;
                    const tiles = Array.from(boxContainer.querySelectorAll(".in-box")).filter((el) => !el.classList.contains("placeholder"));
                    tiles[slot]?.querySelector("button")?.click();
                    renderList();
                };
            });
            listEl.querySelectorAll(".mobile-slot-empty").forEach((el) => {
                el.onclick = () => {
                    activeSlot = +el.dataset.slot;
                    openMobileModal();
                };
            });
            if (clearBtn) {
                clearBtn.onclick = () => {
                    mobileSlotData.fill(null);
                    clearBoxItems();
                    renderList();
                };
            }
        document.querySelectorAll(".add-to-box-mobile").forEach((btn) => {
            btn.addEventListener("click", () => {
                const item = JSON.parse(btn.dataset.item);
                const quantityWrapper = btn.previousElementSibling;
                const input = quantityWrapper?.querySelector("input");

                let quantity = parseInt(input?.value, 10) || 1;
                if (quantity < 1) quantity = 1;

                const emptySlots = mobileSlotData.filter(x => x === null).length;

                if (emptySlots <= 0 || quantity > emptySlots) {
                    showToast(item.id); // ✅ Trigger toast message
                    return;
                }

                for (let i = 0; i < quantity; i++) {
                    const nextSlot = mobileSlotData.findIndex(x => x === null);
                    if (nextSlot === -1) break;

                    mobileSlotData[nextSlot] = {
                        thumbnail: item.thumbnail,
                        name: item.name
                    };
                    window.addItemAtSlot(item, nextSlot);
                }

                quantityWrapper.style.display = "flex";
                renderList();

                // auto-close modal if full
                if (!mobileSlotData.includes(null)) {
                    closeMobileModal();
                }
            });
            window.incrementProductQuantity = function(pid) {
            const input = document.getElementById(`mobile-product-quantity-${pid}`);
            if (!input) return;
            let val = parseInt(input.value, 10) || 0;
            input.value = val + 1;
            input.dispatchEvent(new Event('change'));
        };

        window.decrementProductQuantity = function(pid) {
            const input = document.getElementById(`mobile-product-quantity-${pid}`);
            if (!input) return;
            let val = parseInt(input.value, 10) || 0;
            if (val > 1) {
                input.value = val - 1;
                input.dispatchEvent(new Event('change'));
            }
        };
        });


        }
        closeBtn.addEventListener("click", closeMobileModal);
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                closeMobileModal();
            }
        });
        syncFromDesktop();
        renderList();
        if (typeof window.updateBoxDisplay === "function") {
            const orig = window.updateBoxDisplay;
            window.updateBoxDisplay = () => {
                orig();
                countEl.textContent = mobileSlotData.filter((x) => x).length;
            };
        }
    });
</script>
<script>
    // hide the header when “Build Your Own Box” is clicked, show it again when closed
document.getElementById('open-builder-button').addEventListener('click', () => {
  document.getElementById('page-header').style.display = 'none';
});

document.getElementById('back-to-product-button').addEventListener('click', () => {
  // wait for the fade-out to finish (400ms) before showing it again
  setTimeout(() => {
    document.getElementById('page-header').style.display = '';
  }, 400);
});
</script>
