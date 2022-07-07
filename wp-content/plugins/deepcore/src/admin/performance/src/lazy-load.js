(function ($) {
    $(window).on('load', function () {
        var img = $('img');

        img.each(function () {
            var item = $(this);
            item.addClass('lozad');
            var src = item.attr('src');
            item.attr('data-src', src);
        });

        const observer = lozad();
        observer.observe();
    });
})(jQuery);