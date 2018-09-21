jQuery(document).ready(function ($) {

    var activeUrl = window.location;
    var documentLocationToString = document.location.toString();

    $('.dropdown-menu.account-nav li a[href="' + activeUrl + '"]').parent().addClass('active');

    $('.modal-ajax [data-dismiss="modal"]').on('click', function() {
        $('.modal-ajax').removeClass('in');
        $('.add-cart .btn-cart').prop('disabled', false);
    });

    /* subscribed account-create checkbox fixed */
    $('.account-create label[for="is_subscribed"], .opc-wrapper-opc label[for="is_subscribed"], [for*="remember_me"], .link-tip').each(function(){
        $(this).appendTo($(this).parent().find('.input-box'));
    });

    /* scroll to top */
    $('.btn-scroll-top').on('click', function(e) {
        $('html, body').animate({scrollTop : 0}, 500);
        e.preventDefault();
    });
    /* / */

    $(document).on('click', '.link-compare, .link-wishlist', function (e) {
        var activeText = $(this).attr('data-active-text');
        $(this).find('span').html(activeText);
        $(this).addClass('active');
    });

    $('.link-compare, .link-wishlist').each(function() {
        if ($(this).is('.active')) {
            var activeText = $(this).attr('data-active-text');
            $(this).find('span').html(activeText);
        }
    });

    /* bootstrap tabs cookie */

    var tabId = $('.tabpanel-cookie').attr('id');
    $('.tabpanel-cookie [data-toggle="tab"]').on('shown.bs.tab', function(e){
        $.cookie(tabId, $(e.target).attr('href'));
    });
    var lastTab = $.cookie(tabId);
    if (lastTab) {
        if ($('.tabpanel-cookie .nav-tabs > li').length > 1 && $('.tabpanel-cookie .tab-pane').is(lastTab)) {
            $('.tabpanel-cookie .nav-tabs').children().removeClass('active');
            $('.tabpanel-cookie [href='+ lastTab +']').parents('li:first').addClass('active');
            $('.tabpanel-cookie .tab-content').children().removeClass('active');
            $('.tabpanel-cookie ' + lastTab).addClass('active');
        }
    }
    $('.tabpanel-cookie [data-toggle="tab"]').on('shown.bs.tab', function () {
        if ($('.tabpanel-cookie .nav-tabs > li').length > 1 && $('.tabpanel-cookie .tab-pane').is(lastTab)) {
            var target = this.href.split('#');
            $('.tabpanel-cookie .nav-tabs a').filter('[href="#'+target[1] +'"]').tab('show');
        }
    });
    $('.tabpanel').on('shown.bs.collapse', function (e) {
        $('.tabpanel .panel-heading a').removeClass('active');
        $(e.target).prev('.panel-heading').find('a').addClass('active');
    });

    /* / */

    /* tab hash for page-reload */

    $(window).load(function() {
        if (documentLocationToString.match('#')) {
            $('[data-toggle="tab"][href="#' + documentLocationToString.split('#')[1] + '"]').tab('show');
            setTimeout(function(){
                $('html, body').animate({scrollTop: $('#' + documentLocationToString.split('#')[1]).offset().top - 200}, 500);
            }, 500);
        }
    });
    /**/

    /* fix product options on click */
    $(document).on('click', '.product-options .options-list > li', function () {
        $(this).find('input').trigger('click');
    });
    /**/

    $(document).on('click', '[data-slide-to]', function (e) {
        $('html, body').animate({scrollTop: $($(this).attr('data-slide-to')).offset().top}, $(this).attr('data-slide-speed'));
    });

    /* nice alerts + confirm (bootstrap modal) */
    $(document).on('click', '[data-confirm]', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var message = $(this).attr('data-confirm');
        bootbox.confirm(message, function(result) {
            if (result) {
                document.location.href = href;
            }
        });
    });
    window.alert = function(message){
        bootbox.alert(message);
    };
    /* / */

    /* AW layered nav after click helper */

    $(document).on('click', '#aw-ln-filters-container dt', function (e) {
        $(this).parent().parent().addClass('accordion-open');
        $(this).parent().children().removeClass('current');
        $(this).next('dd').addClass('current');
        $(this).addClass('current');
    });

    /* remove alerts */
    $(document).on('keyup change', 'input, textarea, select', function() {
        $(this).parent().find('.validation-advice').fadeOut('200');
    });
    $(document).on('click', function() {
        $('.messages, .opc-messages').fadeOut('3000');
    });

    /* / */

    /* aids */

    $('textarea').textareaAutoSize();
    $('[data-toggle="popover"]').popover();
    $('input.qty').spinner();
    $('.accordion').on('shown.bs.collapse', function (e) {
        $(e.target).prev('.panel-heading').find('a').addClass('active');
    });
    $('.accordion').on('hidden.bs.collapse', function (e) {
        $(e.target).prev('.panel-heading').find('a').removeClass('active');
    });
    $(document).on('click', '.catalog-product-view .section-products.related-product .section-title', function (e) {
        $(this).parent().toggleClass('click');
    });
    $('#my-orders-table').wrap('<div class="table-responsive"/>');

    /* / */

    /* modal center reposition */

    function modalReposition() {
        var modal = $(this),
            dialog = modal.find('.modal-dialog');
        modal.css('display', 'block');
        dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
    }

    $('.modal.modal-center').on('show.bs.modal', modalReposition);

    $(window).on('resize', function() {
        $('.modal.modal-center:visible').each(modalReposition);
    });

    /**/

    /* form submit */

    $(document).on('submit', '.submit-disabled', function() {
        $(this).find('button[type=submit]').attr('disabled', 'disabled');
    });

    /**/

    $('.owl-carousel').on('initialized.owl.carousel changed.owl.carousel refreshed.owl.carousel', function (event) {
        if (!event.namespace) return;
        var carousel = event.relatedTarget,
            element = event.target,
            current = carousel.current();
        $('.owl-next', element).toggleClass('disabled', current === carousel.maximum());
        $('.owl-prev', element).toggleClass('disabled', current === carousel.minimum());
    });

    /**/

    /* mobile */

    $('.backdrop').on('click', function() {
        $('.navbar, .col-left.sidebar').removeClass('in');
        $('body').removeClass('body-active');
        $('body').removeClass('navbar-active');
        $('body').removeClass('filter-active');
        $('body').removeClass('cart-nav-active');
        $('body').removeClass('account-nav-active');
    });

    $('.navbar').on('show.bs.collapse', function() {
        $('body').addClass('navbar-active');
        $('body').addClass('body-active');
    }).on('hide.bs.collapse', function() {
        $('body').removeClass('navbar-active');
        $('body').removeClass('body-active');
    });

    $('.col-left.sidebar').on('show.bs.collapse', function() {
        $('body').addClass('filter-active');
        $('body').addClass('body-active');
    }).on('hide.bs.collapse', function() {
        $('body').removeClass('filter-active');
        $('body').removeClass('body-active');
    });

    $(document).on('show.bs.dropdown', '.header-cart-dropdown', function () {
        $('body').addClass('cart-nav-active');
        $('body').addClass('body-active');
    }).on('hide.bs.dropdown', function () {
        $('body').removeClass('cart-nav-active');
        $('body').removeClass('body-active');
    });

    $(document).on('show.bs.dropdown', '.account-nav-dropdown', function () {
        $('body').addClass('account-nav-active');
        $('body').addClass('body-active');
    }).on('hide.bs.dropdown', function () {
        $('body').removeClass('account-nav-active');
        $('body').removeClass('body-active');
    });

    $('.btn-back').on('click', function(e) {
        e.preventDefault();
        history.back();
    });

    /**/

    /* responsive */

    var navBarLink = $('.navbar .navbar-nav .dropdown > a');
    responsive();
    $(window).resize(responsive);

    function responsive() {
        if(window.matchMedia('(max-width: 767px)').matches) {
            $('body').on('touchstart click', '.navbar .navbar-nav .dropdown > a', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).parent().siblings().removeClass('open');
                $(this).parent().toggleClass('open');
            });
            $('.navbar-nav-container').on('affix.bs.affix affix-top.bs.affix', function () {
                $('body').css('padding-top', 0);
            });
        } else if(window.matchMedia('(min-width: 767px)').matches) {
            $('[data-hover="dropdown"]').dropdownHover();
            $('.sidebar #aw-ln-filters, .sidebar .block-account').stick_in_parent({offset_top: 65});
            $('.navbar-nav-container').on('affix.bs.affix affix-top.bs.affix', function (e) {
                var padding = e.type === 'affix' ? $(this).height() : '';
                $('body').css('padding-top', padding);
            });
        }
    }

    $(window).load(function() {
        $('body').addClass('body-loaded');

        /* carousel */

        $('.section-products .owl-carousel').owlCarousel({
            margin: 0,
            loop: false,
            nav: true,
            navText: ['',''],
            dots: false,
            thumbs: false,
            responsive: {
                0:{
                    items: 2
                },
                767:{
                    items: 2
                },
                991:{
                    items: 3
                },
                1200:{
                    items: 4
                }
            }
        });

    });
});