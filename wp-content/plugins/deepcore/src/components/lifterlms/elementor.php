<?php
/**
 * LifterLMS.
 *
 * Register the course single widgets.
 *
 * @package Deep
 */

namespace Deep\Components;

use Elementor\Plugin;
use LifterLMS\Elementor\Widgets;

defined( 'ABSPATH' ) || exit;

/**
 * Class LLMS_Widgets.
 */
class LLMS_Widgets {
	/**
	 * Instance of this class.
	 *
	 * @since   5.0.0
	 * @access  public
	 * @var     LLMS_Widgets
	 */
	public static $instance;

	/**
	 * LifterLMS widgets directory.
	 *
	 * @var string
	 */
	public static $dir;

	/**
	 * LifterLMS widgets assets directory.
	 *
	 * @var string
	 */
	public static $assets;

	/**
	 * Provides access to a single instance of a module using the singleton pattern.
	 *
	 * @since   5.0.0
	 * @return  object
	 */
	public static function get_instance() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 *
	 * @since 5.0.0
	 * @access private
	 */
	private function __construct() {
		$this->definition();
		$this->hooks();
	}

	/**
	 * Definition.
	 *
	 * @since 5.0.0
	 * @access private
	 */
	private function definition() {
		self::$dir 		= DEEP_COMPONENTS_DIR . 'lifterlms/widgets/';
		self::$assets 	= DEEP_COMPONENTS_URL . 'lifterlms/assets/';
	}

	/**
	 * Include widgets files.
	 *
	 * @since 5.0.0
	 * @access private
	 */
    private function widgets_files() {

		$widgets = glob( self::$dir . '*.php' );

		foreach ( $widgets as $widget ) {
			if ( __FILE__ != basename( $widget ) ) {
				require_once $widget;
			}
		}
	}

	/**
	 * Hooks.
	 *
	 * @since 5.0.0
	 * @access private
	 */
    private function hooks() {
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'register_scripts' ) );
		add_action( 'elementor/frontend/after_register_styles', [$this, 'register_styles'] );
		add_action( 'elementor/widgets/widgets_registered', [$this, 'register_widgets'] );
		add_action( 'elementor/elements/categories_registered', [$this, 'widget_categories'] );
    }

	/**
	 * LifterLMS widgets category.
	 *
	 * @since 5.0.0
	 * @access public
	 */
	public function widget_categories( $elements_manager ) {
        $elements_manager->add_category(
            'Deep_LifterLMS',
            [
                'title' => __( 'Deep LifterLMS', 'deep' )
            ]
        );
    }

	/**
	 * Register Elementor Widgets
	 *
	 * @since 5.0.0
	 * @access public
	 */
	public function register_widgets() {
		$this->widgets_files();

		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Registration() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Achievements() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Account() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Login() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Memberships() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Courses() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Title() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Prerequisites() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\MetaInfo() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CourseAuthor() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\PricingTable() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CourseSyllabus() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CourseProgress() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Checkout() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\LessonMarkComplete() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CourseContinueButton() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CourseContinue() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\LessonVideo() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\LessonNavigation() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\LessonAudio() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\FeaturedImage() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\SingleVideo() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\SingleAudio() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\SingleDifficulty() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CourseContent() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Reviews() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CourseOutline() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\ParentCourse() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CourseLength() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CourseTags() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CourseLessonCounter() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CourseStudentCounter() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CourseEnrollButton() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\CourseFeatures() );
		Plugin::instance()->widgets_manager->register_widget_type( new Widgets\MaterialIncludes() );
	}

	/**
	 * Register widgets scripts.
	 *
	 * @since 5.0.0
	 * @access public
	 */
	public function register_scripts() {
		wp_register_script( 'deep-llms-course-syllabus', self::$assets . 'js/course-syllabus.js', array( 'jquery' ), true );
	}

	/**
	 * Register widgets styles.
	 *
	 * @since 5.0.0
	 * @access public
	 */
	public function register_styles() {
		wp_register_style( 'deep-llms-author', self::$assets . 'css/course-author.css' );
		wp_register_style( 'deep-llms-length', self::$assets . 'css/course-length.css' );
		wp_register_style( 'deep-llms-course-tags', self::$assets . 'css/course-tags.css' );
		wp_register_style( 'deep-llms-lesson-counter', self::$assets . 'css/course-lesson-counter.css' );
		wp_register_style( 'deep-llms-student-counter', self::$assets . 'css/course-student-counter.css' );
		wp_register_style( 'deep-llms-enroll-button', self::$assets . 'css/course-enroll-button.css' );
		wp_register_style( 'deep-llms-progress', self::$assets . 'css/course-progress.css' );
		wp_register_style( 'deep-llms-courses', self::$assets . 'css/courses.css' );
		wp_register_style( 'deep-llms-course-features', self::$assets . 'css/course-features.css' );
		wp_register_style( 'deep-llms-course-reviews', self::$assets . 'css/course-reviews.css' );
		wp_register_style( 'deep-llms-course-syllabus', self::$assets . 'css/course-syllabus.css' );
		wp_register_style( 'deep-llms-course-material', self::$assets . 'css/course-material.css' );
		wp_register_style( 'deep-llms-course-featured-image', self::$assets . 'css/course-featured-image.css' );
		wp_register_style( 'deep-llms-pricing-table', self::$assets . 'css/pricing-table.css' );
		wp_register_style( 'deep-llms-course-outline', self::$assets . 'css/course-outline.css' );
	}
}

LLMS_Widgets::get_instance();
