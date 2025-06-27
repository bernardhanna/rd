<?php
// single-product-donut-box-builde.php (simplified to not override everything)
defined('ABSPATH') || exit;

get_header('shop');
do_action('woocommerce_before_main_content');

// Always load the standard content single-product:
while (have_posts()) :
    the_post();
    wc_get_template_part('content', 'single-product');
endwhile;

do_action('woocommerce_after_main_content');
get_footer('shop');

?>
