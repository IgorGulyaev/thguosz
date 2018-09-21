var pages = '';

var ias = jQuery.ias({
    container: '.category-row',
    item: '.category-item',
    pagination: '#pagination-scroll',
    next: '.next-scroll',
    negativeMargin: 2000
});

ias.extension(new IASSpinnerExtension({
        html: '<span class="scroll-loading"></span>'
    })
);

ias.on('load', function (event) {
    event.url = jQuery('.next-scroll').attr('href');

    if ( !getParameterByName("scroll", event.url) ) {
        event.url = event.url + '&scroll=1';
    }

    if ( pages == '' ) {
        pages = getParameterByName("p", event.url) - 1;
    }

    pages += ',' + getParameterByName("p", event.url);

    event.url = event.url + '&pages=' + pages;
});

function getParameterByName(name, url) {
    url = url.toLowerCase();

    name = name.replace(/[\[\]]/g, "\\$&").toLowerCase();

    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),

        results = regex.exec(url);

    if (!results) return null;

    if (!results[2]) return '';

    return decodeURIComponent(results[2].replace(/\+/g, " "));
}


function getHtmlItems(data) {
    var result = JSON.parse(data);
    var toolbar = result.toolbar;

    jQuery('.toolbar').replaceWith(toolbar);

    return result.product_list;
}

