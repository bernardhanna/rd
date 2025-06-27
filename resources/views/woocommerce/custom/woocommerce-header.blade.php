<?php
/**
 * @Author: Bernard Hanna
 * @Date:   2023-08-09 13:17:27
 * @Last Modified by:   Bernard Hanna
 * @Last Modified time: 2023-10-24 10:23:42
 */
?>
@php
    // Getting body classes
    $bodyClasses = get_body_class();
@endphp
<section id="page-header" class="relative z-50 w-full mb-0 {{ in_array('rd-product-type-box', $bodyClasses) ? '' : 'lg:mb-12' }}"
   x-data="{
        formState: 'login',
        activeTab: 'sign-in',
        showLostPassword: false,
        isAccountPage: <?php echo is_account_page() ? 'true' : 'false'; ?>,
        isLoggedIn: <?php echo is_user_logged_in() ? 'true' : 'false'; ?>,
        isTemplateBoxProducts: <?php echo is_page_template('templates/template-box-products.blade.php') ? 'true' : 'false'; ?>,
        isProductArchive: <?php echo is_post_type_archive('product') ? 'true' : 'false'; ?>,
        pageTitle: '<?php echo esc_js( get_the_title() ); ?>',
        init() {
            window.addEventListener('update-active-tab', (event) => {
                this.activeTab = event.detail.tab;
            });
            window.addEventListener('update-show-lost-password', (event) => {
                this.showLostPassword = event.detail.show;
            });
        }
    }"
>
    @php
        // Define Categories
        $args = array(
            'taxonomy'   => "product_cat",
            'hide_empty' => false,
        );
        $categories = get_terms($args);

        // DESKTOP
        $image_id = get_field('woo_header_bg', 'option', false);
        $image_url = wp_get_attachment_url($image_id);
        $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
        $image_srcset = wp_get_attachment_image_srcset($image_id);

        // MOBILE
        $image_id_mobile = get_field('woo_mobile_bg', 'option', false);
        $image_url_mobile = wp_get_attachment_url($image_id_mobile);
        $image_alt_mobile = get_post_meta($image_id_mobile, '_wp_attachment_image_alt', true);
        $image_srcset_mobile = wp_get_attachment_image_srcset($image_id_mobile);
    @endphp

    @if($image_url || $image_url_mobile)
    <div>
        <!-- Desktop Background -->
        <img class="object-cover w-full min-h-[243px] hidden sm:block" src="{{ $image_url }}" alt="{{ $image_alt }}" srcset="{{ $image_srcset }}" sizes="(min-width: 640px) 100vw">

        <!-- Mobile Background -->
        <img class="block w-full max-mobile:hidden sm:hidden" src="{{ $image_url_mobile }}" alt="{{ $image_alt_mobile }}" srcset="{{ $image_srcset_mobile }}" sizes="(max-width: 639px) 100vw">
    </div>
    @endif

    <div class="bg-black-full sm:bg-transparent min-h-[150px] max-md:min-h-[200px] mobile:absolute top-0 left-0 right-0 w-full h-auto mobile:h-full mx-auto max-w-max-1485  <?php if (is_product()) : ?> tablet:flex-col max-tablet:flex max-tablet:justify-center max-tablet:items-center <?php endif; ?>">
        <div class="hidden w-full pl-4 md:flex lg:max-w-max-1485 desktop:pl-0">
            @php
                woocommerce_breadcrumb();
            @endphp
        </div>
        <div class="max-md:h-[200px] relative flex items-center <?php echo is_singular('product') ? 'justify-center' : ''; ?> px-2 text-center mobile:pt-8 mobile:px-4 desktop:p-0 {{ in_array('rd-product-type-box', $bodyClasses) ? 'desktop:pt-0 flex-col' : 'desktop:pt-6 flex-row' }}">
        <div x-data="{ content: 'Dynamic content based on conditions' }" class="relative inline-block px-4 <?php echo is_singular('product') ? '' : 'm-auto'; ?> text-container width-fit-content desktop:p-0 {{ is_singular('product') ? '' : '' }}">
                <h1 class="relative left-0 z-10 m-auto text-center text-white font-reg420 text-font-28 mobile:text-mob-xl-font lg:text-lg-font xl:text-lg-font xxl:text-xxl-font" x-text="
                    showLostPassword ? 'Reset Password' :
                    activeTab === 'register' ? 'Register' :
                    isAccountPage && !isLoggedIn ? 'Sign In' :
                    isTemplateBoxProducts ? 'Our Boxes' :
                    isProductArchive ? 'Our Donuts' :
                    pageTitle
                "></h1>
            </div>
            @if(is_page_template('templates/template-box-products.blade.php') || is_page_template('templates/template-merch-products.blade.php'))
            @include('components.filter')
            @elseif(is_singular('product'))
            <div class="text-container">
                @php
                global $product;
                $product = wc_get_product(get_the_ID());
                if (is_a($product, 'WC_Product')) {
                    $price = $product->get_price();
                    $currency = get_woocommerce_currency_symbol();
                    $product_id = $product->get_id(); // Get product ID
                @endphp

                    <!-- Only show price if the product is not the custom-order product (ID 3947) -->
                    @if ($product_id != 3947)
                        <div class="font-medium text-white product-price text-sm-md-font xs:text-md-font mobile:text-lg-font {{ in_array('rd-product-type-donut', get_body_class()) ? 'hidden' : '' }}">
                            <bdi class="relative z-50">{!! $currency !!}{{ $price }}</bdi>
                        </div>
                    @endif

                @php
                } else {
                    echo 'Price not available';
                }
                @endphp
            </div>
            @else
            @endif
        </div>

    @if(is_page('donut-box') && has_excerpt())
        <div class="justify-center hidden w-2/3 px-2 m-auto text-center text-white md:flex text-base-font font-lighter laptop:font-light font-laca">
            {{ get_the_excerpt() }}
        </div>
    @elseif(is_shop())
        <div class="flex justify-center w-[90%] px-2 m-auto text-center text-white text-base-font font-lighter laptop:font-light font-laca">
            Our latest flavours are listed below. Donuts can be purchased as part of a box.
        </div>
    @endif


    </div>
</section>
