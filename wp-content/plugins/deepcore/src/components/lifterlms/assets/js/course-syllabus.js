(function ($) {
    /**
     * @param $scope The Widget wrapper element as a jQuery element
     * @param $ The jQuery alias
     */
    var WidgetCourseSyllabusHandler = function ($scope, $) {

        const sections = $scope.find('.deep-llms-sections');
        const title    = $scope.find('.llms-section-title');
        const preview  = $scope.find('.llms-lesson-preview');

        sections.each(function() {

            const item = $(this);

            item.find(preview).last().addClass('n-border');
        })

        title.first().addClass('open');

        title.on( 'click', function() {

            const item = $(this);

            item.next().slideToggle();
            item.toggleClass('open')
        })

        sections.first().show();
    };

    // Make sure you run this code under Elementor.
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/llms-course-syllabus.default', WidgetCourseSyllabusHandler);
    });
})(jQuery);
