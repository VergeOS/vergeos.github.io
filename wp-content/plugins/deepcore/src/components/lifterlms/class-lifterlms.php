<?php
/**
 * LifterLMS.
 *
 * Compatibilities with LifterLMS.
 *
 * @package Deep
 */

namespace Deep\Components;

use Elementor\Plugin;
use Deep\Components\LLMS_Widgets;

defined( 'ABSPATH' ) || exit;

/**
 * Class LifterLMS.
 */
class LifterLMS {
	/**
	 * Instance of this class.
	 *
	 * @since   5.0.0
	 * @access  public
	 * @var     LifterLMS
	 */
	public static $instance;

	/**
	 * LifterLMS directory.
	 *
	 * @var string
	 */
	private static $dir;

	/**
	 * Settings
	 *
	 * @var array
	 */
	private static $settings = array();

	/**
	 * Course page ID.
	 *
	 * @var string
	 */
	private static $course_page_id;

	/**
	 * Lesson page ID.
	 *
	 * @var string
	 */
	private static $lesson_page_id;

	/**
	 * Membership page ID.
	 *
	 * @var string
	 */
	private static $membership_page_id;

	/**
	 * Provides access to a single instance of a module using the singleton pattern.
	 *
	 * @since   5.0.0
	 *
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
	 *
	 * @access private
	 */
	private function __construct() {
		add_filter( 'llms_prevent_automatic_wizard_redirect', '__return_true' );
		if ( ! did_action( 'elementor/loaded' ) || ! class_exists( 'LifterLMS' ) ) {
			return;
		}
		$this->definition();
		$this->hooks();
		$this->load_dependencies();
	}

	/**
	 * Definition.
	 *
	 * @since 5.0.0
	 *
	 * @access private
	 */
	private function definition() {
		self::$dir                = DEEP_COMPONENTS_DIR . 'lifterlms/';
		self::$settings           = self::get_settings();
		self::$course_page_id     = isset( self::$settings['deep_custom_lifterlms_course_page'] ) ? self::$settings['deep_custom_lifterlms_course_page'] : '';
		self::$lesson_page_id     = isset( self::$settings['deep_custom_lifterlms_lesson_page'] ) ? self::$settings['deep_custom_lifterlms_lesson_page'] : '';
		self::$membership_page_id = isset( self::$settings['deep_custom_lifterlms_membership_page'] ) ? self::$settings['deep_custom_lifterlms_membership_page'] : '';
	}

	/**
	 * Hooks.
	 *
	 * @since 5.0.0
	 *
	 * @access private
	 */
	private function hooks() {
		add_filter( 'template_include', array( $this, 'custom_templates' ), 99 );
		add_action( 'deep_custom_lifterlms_course_single', array( $this, 'single_course_content' ) );
		add_action( 'deep_custom_lifterlms_membership_single', array( $this, 'single_membership_content' ) );
		add_action( 'deep_custom_lifterlms_lesson_single', array( $this, 'single_lesson_content' ) );
		add_filter( 'lifterlms_theme_override_directories', array( $this, 'llms_template_override' ), 10, 1 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_style' ) );
		add_action( 'lifterlms_before_student_dashboard', array( $this, 'dashboard_heading' ) );
		add_action( 'lifterlms_before_main_content', array( $this, 'before_loop_content' ) );
		add_action( 'lifterlms_after_main_content', array( $this, 'after_loop_content' ) );
	}

	/**
	 * Load the dependencies.
	 *
	 * @since 5.0.0
	 *
	 * @access private
	 */
	private function load_dependencies() {
		require_once self::$dir . 'elementor.php';
	}

	/**
	 * Load custom course templates.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function custom_templates( $template ) {

		if ( self::is_course_builder() && is_course() ) {
			return self::$dir . 'templates/builder/single-course.php';
		}

		if ( self::is_lesson_builder() && is_lesson() ) {
			return self::$dir . 'templates/builder/single-lesson.php';
		}

		if ( self::is_membership_builder() && is_membership() ) {
			return self::$dir . 'templates/builder/single-membership.php';
		}

		return $template;
	}

	/**
	 * Returns Deep options.
	 *
	 * @since 5.0.0
	 *
	 * @access private
	 *
	 * @return array
	 */
	private static function get_settings() {
		$settings = get_option( 'deep_options' );

		return $settings;
	}

	/**
	 * Check if course builder is enabled.
	 *
	 * @since 5.0.0
	 *
	 * @access private
	 *
	 * @return bool
	 */
	private static function is_course_builder() {
		if ( ! empty( self::$settings['deep_custom_lifterlms_course'] ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Check if lesson builder is enabled.
	 *
	 * @since 5.0.0
	 *
	 * @access private
	 *
	 * @return bool
	 */
	private static function is_lesson_builder() {
		if ( ! empty( self::$settings['deep_custom_lifterlms_lesson'] ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Check if membership builder is enabled.
	 *
	 * @since 5.0.0
	 *
	 * @access private
	 *
	 * @return bool
	 */
	private static function is_membership_builder() {
		if ( ! empty( self::$settings['deep_custom_lifterlms_membership'] ) ) {
			return true;
		}
		return false;
	}

	/**
	 * Returns the content of the page that has been selected as the course single page.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function single_course_content() {
		if ( self::is_course_builder() ) {
			echo Plugin::instance()->frontend->get_builder_content_for_display( self::$course_page_id, false );
		}
	}

	/**
	 * Returns the content of the page that has been selected as the membership single page.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function single_membership_content() {
		if ( self::is_membership_builder() ) {
			echo Plugin::instance()->frontend->get_builder_content_for_display( self::$membership_page_id, false );
		}
	}

	/**
	 * Returns the content of the page that has been selected as the lesson single page.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function single_lesson_content() {
		if ( self::is_lesson_builder() ) {
			echo Plugin::instance()->frontend->get_builder_content_for_display( self::$lesson_page_id, false );
		}
	}

	/**
	 * Override templates path.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function llms_template_override( $dirs ) {

		array_unshift( $dirs, self::$dir . 'templates' );

		return $dirs;
	}

	/**
	 * Returns the ID of the latest published course.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public static function get_course() {

		$id = '';

		$latest_course = wp_get_recent_posts(
			array(
				'numberposts' => 1,
				'post_status' => 'publish',
				'post_type'   => 'course',
			)
		);

		if ( $latest_course ) {
			foreach ( $latest_course as $course ) {
				$id = $course['ID'];
			}
		}

		return $id;
	}

	/**
	 * Returns the list of the categories with their links.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public static function get_categories( string $id ) {

		if ( taxonomy_exists( 'course_cat' ) ) {
			$cats       = get_the_terms( $id, 'course_cat' );
			$course_cat = array();
			if ( is_array( $cats ) ) {
				foreach ( $cats as $cat ) {
					$course_cat[] = $cat->slug;
				}
			}
			$categories = '';
			$cat_slug   = array();
			if ( $cats && ! is_wp_error( $cats ) ) {
				foreach ( $cats as $cat ) {
					$cat_slug[] = '<a href="' . esc_url( get_term_link( $cat, 'course_cat' ) ) . '">' . esc_html( $cat->name ) . '</a>';
				}
				$categories = implode( ', ', $cat_slug );
			}
			if ( $categories ) {
				return wp_kses_post( $categories );
			}
		}

		return '';
	}

	/**
	 * Returns enrolled students.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public static function get_enrolled_students( string $post_id ) {

		$query = new \LLMS_Student_Query(
			array(
				array(
					'post_id'  => $post_id,
					'statuses' => 'enrolled',
				),
			)
		);

		if ( $query->found_results ) {
			return $query->found_results;
		}

		return '0';
	}

	/**
	 * Returns the course featured video URL.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public static function get_featured_video_url( string $post_id ) {

		$video_url = get_post_meta( $post_id, '_llms_video_embed', true );

		if ( $video_url ) {
			return $video_url;
		}

		return '';
	}

	/**
	 * Returns the course start date.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public static function get_course_start_date( string $post_id ) {

		$start_date = get_post_meta( $post_id, '_llms_start_date', true );

		if ( $start_date ) {
			return $start_date;
		}

		return '';
	}

	/**
	 * Returns the course capacity.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public static function get_course_capacity( string $post_id ) {

		$capacity = get_post_meta( $post_id, '_llms_capacity', true );

		if ( $capacity ) {
			return $capacity;
		}

		return '';
	}

	/**
	 * Dashboard heading.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function dashboard_heading() {
		?>
			<div class="llms-dashboard-deep-heading">
				<img src="<?php echo esc_url( LLMS_Widgets::$assets . 'img/llms-dashboard-deep-heading.jpg' ); ?>" alt="dashboard heading">
				<p class="dashboard-deep-heading"><?php esc_html_e( 'My Profile', 'deep' ); ?></p>
			</div>
		<?php
	}

	/**
	 * Returns product IDs.
	 *
	 * @since 5.1.3
	 *
	 * @access public
	 */
	public static function get_llms_products( string $id ) {
		$product  = new \LLMS_Product( $id );
		$products = array();

		if ( $product ) {
			foreach ( $product->get_access_plans() as $key => $value ) {
				$products[] = $value->post->ID;
			}

			return $products;
		}

		return array();
	}

	/**
	 * Returns product price.
	 *
	 * @since 5.1.3
	 *
	 * @access public
	 */
	public static function get_product_price( array $products ) {

		foreach ( $products as $product ) {
			if ( isset( $product ) ) {
				$plan  = new \LLMS_Access_Plan( $product );
				$price = $plan->get_price( 'price' );
			}
		}

		if ( isset( $price ) ) {
			return $price;
		}

		return '';
	}

	/**
	 * Before loop content.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function before_loop_content() {
		echo '<div class="container">';
	}

	/**
	 * After loop content.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function after_loop_content() {
		echo '</div>';
	}

	/**
	 * enqueue style.
	 *
	 * @access public
	 *
	 * @since 5.0.0
	 */
	public function enqueue_style() {
		wp_enqueue_style( 'deep-llms-single-lesson', LLMS_Widgets::$assets . 'css/single-lesson.css', false, DEEP_VERSION );

		if ( is_llms_account_page() || is_llms_checkout()) {
			wp_enqueue_style( 'deep-llms-dashboard', LLMS_Widgets::$assets . 'css/llms-dashboard.css', false, DEEP_VERSION );
			wp_enqueue_style( 'deep-llms-form', LLMS_Widgets::$assets . 'css/form.css', false, DEEP_VERSION );
		}
	}
}

LifterLMS::get_instance();
