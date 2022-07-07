(function ($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetProductsHandler = function ($scope, $) {
        console.log('$scope');

        $(document).on('click', '.deep-woo-loadmore', function(e) {
            
            e.preventDefault();

            var $this = $(this),
                $wrap = $scope,
                $next_page_url = $wrap.find('a.next.page-numbers').attr('href');

            if ( ! $next_page_url ) {
                $this.parents('.deep-woo-loadmore-wrapper').fadeOut();
                return;
            }
            
            $wrap.css('opacity','0.5');
            $.ajax({
                type: 'GET',
                url: $next_page_url,
                dataType: 'html',
                cache: true,
                headers: {'cache-control': 'no-cache'},
                data: {
                    url : $next_page_url,
                },
                success: function( data ) {
                    var $products = $(data).find('ul.products').html();
                    var $pagination = $(data).find('.woocommerce-pagination').html();
                    console.log($(data).find('ul.products'));
                    $wrap.find('ul.products').append($products);
                    $wrap.find('.woocommerce-pagination').html($pagination);
                    $wrap.css('opacity',1);
                    // inject.src = baseUrl + 'resources/....javascriptfile.js';
                },
                error: function( XMLHttpRequest, textStatus, errorThrown, data ) {
                    alert(textStatus+': '+errorThrown);
                    $wrap.css('opacity',1);
                }
            });
        });

        $(document).on('click', '.deep-woo-sidebar a', function(e) {
            
            e.preventDefault();

            var $this = $(this),
                $wrap = $this.closest('.deep-woo-products-loop-wrapper'),
                $sidebar = $this.closest('.deep-woo-sidebar'),
                $ajaxurl = $this.attr('href');

            if ( ! $ajaxurl ) {
                return;
            }
            
            $sidebar.removeClass('isopen');
            $wrap.css('opacity','0.5');
            $.ajax({
                type: 'GET',
                url: $ajaxurl,
                dataType: 'html',
                cache: true,
                headers: {'cache-control': 'no-cache'},
                data: {
                    url : $ajaxurl,
                },
                success: function( data ) {
                    var $page = $(data).find('.deep-woo-products-loop-wrapper').html();
                    $wrap.html($page);
                    $wrap.css('opacity',1);
                    /**
                     * Fix Price slider
                     */
                    var inject = document.createElement('script');
                    inject.src = $('#wc-price-slider-js').attr('src');
                    document.getElementsByTagName('body')[0].appendChild(inject);
                },
                error: function( XMLHttpRequest, textStatus, errorThrown, data ) {
                    alert(textStatus+': '+errorThrown);
                    $wrap.css('opacity',1);
                }
            });
        });

        $(document).on('click', '.deep-woo-sidebar-toggle', function(e) {
            var $sidebar = $(this).next('.deep-woo-sidebar'),
                $wrap = $(this).closest('.deep-woo-sidebar')

            if ( $sidebar.hasClass('isopen') || $wrap.hasClass('isopen') ) {
                $sidebar.removeClass('isopen');
                $wrap.removeClass('isopen');
            } else {
                $sidebar.addClass('isopen');
                $wrap.addClass('isopen');
            }

        });
       
    };

    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/deep-woo-products-loop.default', WidgetProductsHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/deep-woo-recent-products.default', WidgetProductsHandler);
    });
})(jQuery);