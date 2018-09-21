jQuery(document).ready(function ($) {
    var modalQuickViewToAppend = jQuery('#ecomitizeQuickView');
    $(document).on('click', '.link-quick-view', function (e) {
        if ( typeof(spConfig) != 'undefined' ) {
            oldSpConfig = spConfig;
        }
        e.preventDefault();
        var quickURL = $(this).attr('data-url');
        $('.loading').removeClass('hidden').addClass('active');
        $.post(quickURL , function(data) {
            modalQuickViewToAppend.empty();
            modalQuickViewToAppend.append(data);
        }).done(function() {
            $('.loading').removeClass('active');
        });
    });
    $(document).on('click', '#ecomitizeModalQuickViewClose', function() {
        modalQuickViewToAppend.empty();
        if ( typeof(oldSpConfig) != 'undefined' ) {
            swatchesConfig = new Product.ConfigurableSwatches(oldSpConfig);
            spConfig = oldSpConfig;
        }
        if ( typeof(swatchesConfig) != 'undefined' ) {
            swatchesConfig._E.cartBtn.btn = $$('.add-to-cart.configurable-button #product-addtocart-button');
            swatchesConfig._E.cartBtn.onclick = "productAddToCartForm.submit(this)";
            swatchesConfig._E.activeConfigurableOptions = [] ;
        }
        AW_AjaxCartPro.startObservers('clickOnAddToCartInProductPage');
    });
});