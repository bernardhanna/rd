jQuery(document).ready(function ($) {
  // Delay execution to ensure elements are loaded
  setTimeout(function () {
    function togglePrefilledProductsSelect() {
      const prefilledValue = $('input[name="_donut_box_builder_pre_filled"]:checked').val();
      if (prefilledValue === 'yes') {
        $('#prefilled_products_container').show(); // Show prefilled products container
      } else {
        $('#prefilled_products_container').hide(); // Hide prefilled products container
      }
    }

    // Initial call to set visibility based on current selection
    togglePrefilledProductsSelect();

    // Bind the change event to handle the radio button toggling
    $('input[name="_donut_box_builder_pre_filled"]').on('change', function () {
      togglePrefilledProductsSelect();
    });

    // Handle adding prefilled products
    function addPrefilledProduct() {
      var prefilledProductHtml = `
                <div class="prefilled-product">
                    <select name="_prefilled_box_products[]" class="prefilled-product-select" style="width: 80%;">
                        ${$('#custom_box_products option').map(function () { return `<option value="${$(this).val()}">${$(this).text()}</option>`; }).get().join('')}
                    </select>
                    <button type="button" class="remove_prefilled_product button">Remove</button>
                </div>`;
      $('#prefilled_products_container').append(prefilledProductHtml);
      $('#prefilled_products_container .prefilled-product-select').last().select2(); // Apply select2 for the new select
    }

    // Bind the add prefilled product button
    $('#add_prefilled_product_top, #add_prefilled_product_bottom').click(function () {
      addPrefilledProduct();
    });

    // Handle removing prefilled products
    $('#prefilled_products_container').on('click', '.remove_prefilled_product', function () {
      $(this).closest('.prefilled-product').remove();
    });

    // Initialize select2 for all existing prefilled product selects
    $('#prefilled_products_container .prefilled-product-select').select2();
  }, 500); // Delay of 500 milliseconds
});

