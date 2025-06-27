jQuery(document).ready(function ($) {
  $('#add-box-to-cart').click(function () {
    var productId = $(this).data('product-id');
    var selectedProducts = []; // Collect selected product IDs

    $('.box-item').each(function () {
      var itemId = $(this).data('item-id');
      if (itemId) {
        selectedProducts.push(itemId);
      }
    });

    $.ajax({
      url: my_script_object.ajax_url,
      type: 'POST',
      data: {
        action: 'donut_box_add_to_cart',
        nonce: my_script_object.nonce,
        donut_box_product_id: productId,
        products: selectedProducts.join(','),
        quantity: $('#box-quantity').val(),
      },
      success: function (response) {
        if (response.success) {
          // Refresh the cart page to show updates
          location.reload();
        } else {
          // Only alert if the productId and selectedProducts are actually invalid
          if (!productId || selectedProducts.length === 0) {
            alert(response.data.message);
          }
        }
      },
      error: function (error) {
        console.log('Error:', error);
      }
    });
  });
});
