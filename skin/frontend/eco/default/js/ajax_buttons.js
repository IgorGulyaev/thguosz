String.prototype.format = function() {
    var formatted = this;
    for (var i = 0; i < arguments.length; i++) {
        var regexp = new RegExp('\\{'+i+'\\}', 'gi');
        formatted = formatted.replace(regexp, arguments[i]);
    }
    return formatted;
};

var ajaxPopupTemplate = "<div class='std'><ul class='messages'><li class='success-msg'><ul><li><span> {0} </span></li></ul></li></ul></div>";

function addToCompareAjax(url){
    jQuery('#loading').addClass('active');

    new Ajax.Request(url, {
        method:'post',
        onSuccess: function(transport) {
            var result = JSON.parse(transport.responseText);

            if ( result.redirect ) {
                window.location.href = result.redirect;
            } else if ( result.header ) {
                jQuery('#compare-link').replaceWith(result.header);
                jQuery('#loading').removeClass('active');
                jQuery('#loading').after(ajaxPopupTemplate.format(result.message));
            }
        },
        onFailure: function(result) { console.log( result ); jQuery('#loading').removeClass('active'); }
    });

    return false;
}

function addToWishlistAjax(url, data){
    jQuery('#loading').addClass('active');

    new Ajax.Request(url, {
        method:'post',
        parameters: data,
        onSuccess: function(transport) {
            var result = JSON.parse(transport.responseText);

            if ( result.status == 'login' ) {
                window.location.href = result.redirectLink;
            } else if ( result.status == 'success' ) {
                jQuery('.wishlist-link').replaceWith(result.wishlistLink);

                jQuery('#loading').removeClass('active');

                jQuery('#loading').after(ajaxPopupTemplate.format(result.message));

            } else if ( result.status == 'wishlist' ) {
                window.location.href = result.redirectLink;
            }
        },
        onFailure: function(result) { console.log( result ); jQuery('#loading').removeClass('active'); }
    });

    return false;
}

function removeFromWishListAjax(url, q, id) {

    bootbox.confirm(q, function(result) {
        if ( result ) {
            jQuery('#loading').addClass('active');

            new Ajax.Request(url, {
                method: 'post',
                onSuccess: function (transport) {
                    var result = JSON.parse(transport.responseText);

                    jQuery('.wishlist-link').replaceWith(result.wishlistLink);

                    jQuery('.products-item-' + id).parent().remove();

                    if (!jQuery('.wishlist-item')[0]) {
                        jQuery('fieldset').html('<p class="wishlist-empty">You have no items in your wishlist.</p>');
                    }

                    jQuery('#loading').removeClass('active');

                    jQuery('#loading').after(ajaxPopupTemplate.format(result.message));
                },
                onFailure: function (result) {
                    console.log(result);
                    jQuery('#loading').removeClass('active');
                }
            });
        }
    });

    return false;
}

function removeAjax(url, q, id){
    bootbox.confirm(q, function(result) {

        if ( result ) {
            jQuery('#loading').addClass('active');

            new Ajax.Request(url, {
                method:'post',
                onSuccess: function(transport) {
                    var result = JSON.parse(transport.responseText);

                    jQuery( ".products-item-" + id ).remove();

                    if(  jQuery("#product_comparison").find('tr').find('td').length == 0  ) {
                        jQuery("#product_comparison").replaceWith('<p class="compare-list-empty">You have no items in your compare list.</p>');
                    }

                    if ( result.header ) {
                        jQuery('#compare-link').replaceWith(result.header);
                    }

                    jQuery('#loading').removeClass('active');

                    jQuery('#loading').after(ajaxPopupTemplate.format(result.message));
                },
                onFailure: function(result) { console.log( result ); jQuery('#loading').removeClass('active'); }
            });
        }
    });

    return false;
}
