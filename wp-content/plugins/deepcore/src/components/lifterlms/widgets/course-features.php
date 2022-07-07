<?php
namespace LifterLMS\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Deep\Components\LLMS_Widgets;
use Deep\Components\LifterLMS;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for LifterLMS Course Features.
 *
 * @since 5.0.0
 */
class CourseFeatures extends Widget_Base {
	/**
	 * Retrieve the widget name.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'llms-course-features';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'LifterLMS Course Features', 'deep' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'deep-widget deep-eicon-llms-course-features';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'Deep_LifterLMS' );
	}

	/**
	 * Load depend styles.
	 *
	 * @since 5.0.0
	 *
	 * @access protected
	 */
	public function get_style_depends() {
		return array( 'deep-llms-course-features' );
	}

	/**
	 * Register the widget controls.
	 *
	 * @since 5.0.0
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => __( 'General', 'deep' ),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'   => __( 'Title', 'deep' ),
				'type'    => Controls_Manager::TEXT,
                'default' => __( 'Course Features', 'deep' ),
			)
		);

        $this->add_control(
			'show_date',
			[
				'label'        => __( 'Show Date', 'deep' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'deep' ),
				'label_off'    => __( 'Hide', 'deep' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

        $this->add_control(
			'show_instructor',
			[
				'label'        => __( 'Show Instructor', 'deep' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'deep' ),
				'label_off'    => __( 'Hide', 'deep' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

        $this->add_control(
			'show_category',
			[
				'label'        => __( 'Show Category', 'deep' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'deep' ),
				'label_off'    => __( 'Hide', 'deep' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

        $this->add_control(
			'show_viewers',
			[
				'label'        => __( 'Show Viewers', 'deep' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'deep' ),
				'label_off'    => __( 'Hide', 'deep' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

        $this->add_control(
			'show_students',
			[
				'label'        => __( 'Show Students', 'deep' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'deep' ),
				'label_off'    => __( 'Hide', 'deep' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

        $this->add_control(
			'show_capacity',
			[
				'label'        => __( 'Show Capacity', 'deep' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'deep' ),
				'label_off'    => __( 'Hide', 'deep' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * @since 5.0.0
	 *
	 * @access protected
	 */
	protected function render() {

		$settings          = $this->get_settings_for_display();
        $title             = $settings['title'];
        $date              = $settings['show_date'] ? true : false;
        $instructor        = $settings['show_instructor'] ? true : false;
        $category          = $settings['show_category'] ? true : false;
        $viewers           = $settings['show_viewers'] ? true : false;
        $students          = $settings['show_students'] ? true : false;
        $capacity          = $settings['show_capacity'] ? true : false;
        $post_id           = get_the_id();
        $start_date        = LifterLMS::get_course_start_date( $post_id );
        $categories        = LifterLMS::get_categories( $post_id );
        $enrolled_students = LifterLMS::get_enrolled_students( $post_id );
        $course_capacity   = LifterLMS::get_course_capacity( $post_id );
        $views             = deep_getViews( $post_id );

        ?>
            <div class="deep-llms-course-features">
                <?php if ( $title ): ?>
                    <h3><?php echo esc_html( $title ); ?></h3>
                <?php endif; ?>

                <?php if ( $date && $start_date ): ?>
                    <div class="llms-features course-feature-date">
                        <span class="course-feature-icon"><img src="<?php echo esc_url( LLMS_Widgets::$assets . 'svg/course-date.svg'); ?>" alt="Course Date"></span>
                        <span class="course-feature-title"><?php esc_html_e( 'Start Course:', 'deep' ); ?></span>
                        <span class="course-feature-value"><?php echo esc_html( $start_date ); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ( $instructor ): ?>
                    <div class="llms-features course-feature-instructor">
                        <span class="course-feature-icon"><img src="<?php echo esc_url( LLMS_Widgets::$assets . 'svg/course-instructor.svg'); ?>" alt="Course Date"></span>
                        <span class="course-feature-title"><?php esc_html_e( 'Instructor:', 'deep' ); ?></span>
                        <span class="course-feature-value"><?php esc_html( the_author() ); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ( $category && $categories ): ?>
                    <div class="llms-features course-feature-category">
                        <span class="course-feature-icon"><img src="<?php echo esc_url( LLMS_Widgets::$assets . 'svg/course-category.svg'); ?>" alt="Course Date"></span>
                        <span class="course-feature-title"><?php esc_html_e( 'Category:', 'deep' ); ?></span>
                        <span class="course-feature-value"><?php echo $categories; ?></span>
                    </div>
                <?php endif; ?>

                <?php if ( $viewers ): ?>
                    <?php deep_setViews( $post_id ); ?>
                    <div class="llms-features course-feature-viewers">
                        <span class="course-feature-icon"><img src="<?php echo esc_url( LLMS_Widgets::$assets . 'svg/course-viewers.svg'); ?>" alt="Course Date"></span>
                        <span class="course-feature-title"><?php esc_html_e( 'Viewers:', 'deep' ); ?></span>
                        <span class="course-feature-value"><?php echo esc_html( $views ); ?></span>
                    </div>
                <?php endif; ?>

                <?php if ( $students ): ?>
                    <div class="llms-features course-feature-students">
                        <span class="course-feature-icon"><img src="<?php echo esc_url( LLMS_Widgets::$assets . 'svg/course-students.svg'); ?>" alt="Course Date"></span>
                        <span class="course-feature-title"><?php esc_html_e( 'Students:', 'deep' ); ?></span>
                        <span class="course-feature-value"><?php echo $enrolled_students; ?></span>
                    </div>
                <?php endif; ?>

                <?php if ( $capacity ): ?>
                    <div class="llms-features course-feature-capacity">
                        <span class="course-feature-icon"><img src="<?php echo esc_url( LLMS_Widgets::$assets . 'svg/course-capacity.svg'); ?>" alt="Course Date"></span>
                        <span class="course-feature-title"><?php esc_html_e( 'Course Capacity:', 'deep' ); ?></span>
                        <span class="course-feature-value"><?php echo esc_html( $course_capacity ); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        <?php
	}
}
