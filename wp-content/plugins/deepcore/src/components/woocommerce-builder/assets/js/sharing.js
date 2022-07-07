jQuery(document).ready(function($) {
    $('.deep-btn-social-share-links').on( 'click', function() {
        var target = $(this).data('target');

        if ( ! $(target).hasClass('open') ) {
            $(target).addClass('open');
        } else {
            $(target).removeClass('open');
        }

        return false;
    })
});
