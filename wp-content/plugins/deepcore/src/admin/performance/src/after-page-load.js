(function ($) {
    const head = $("head");
    const domain = window.location.href;
    var loaded = true;

    $(document).on('mousemove', function () {
        if ( loaded ) {
            deep_enq_scripts.forEach(function (script) {
                if ( ! script.includes("http") ) {
                    script = domain + script;
                }
                var src = '<script src="' + script + '"></script>';
                head.append(src);
            });
            loaded = false;
        }
    });
})(jQuery);