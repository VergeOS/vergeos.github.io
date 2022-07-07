<?php
namespace LifterLMS\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Deep\Components\LifterLMS;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for LifterLMS Course Student Counter.
 *
 * @since 5.0.0
 */
class CourseStudentCounter extends Widget_Base {
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
		return 'llms-course-student-counter';
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
		return __( 'LifterLMS Course Student Counter', 'deep' );
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
		return 'deep-widget deep-eicon-llms-course-student-counter';
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
		return [ 'Deep_LifterLMS' ];
	}

	/**
	 * Load depend styles.
	 *
	 * @since 5.0.0
	 *
	 * @access protected
	 */
	public function get_style_depends() {
		return ['deep-llms-student-counter'];
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
			[
				'label' => __( 'General', 'deep' ),
			]
		);

		$this->add_control(
			'description',
			[
				'label' 	=> __( 'This widget displays the number of students for a specific course.', 'deep' ),
				'type'	 	=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'course_student_counter_icon',
			[
				'label' => __( 'Select Icon', 'deep' ),
				'type' => \Elementor\Controls_Manager::ICON,
				'default' => 'wn-far wn-fa-user',
			]
		);

		$this->add_control(
			'course_student_counter_label',
			[
				'label' 		=> __( 'Label', 'deep' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Students', 'deep' ),
				'placeholder' 	=> __( 'Type your Label here', 'deep' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'student_counter_numbber_style',
			[
				'label' => __( 'Student Counter Number', 'deep' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 	=> 'student_counter_number_typography',
				'label' => __( 'Typography', 'deep' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .deep-llms-course-student-counter .llms-student-counter',
			]
		);

		$this->add_control(
			'student_counter_number_color',
			[
				'label'  => __( 'Color', 'deep' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-course-student-counter .llms-student-counter' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'student_counter_number_background',
				'label' => __( 'Background', 'deep' ),
				'types' => [ 'classic' ],
				'selector' => '{{WRAPPER}} .deep-llms-course-student-counter .llms-student-counter',
			]
		);

		$this->add_responsive_control(
			'student_counter_number_padding',
			[
				'label' => __( 'Padding', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' 	=> [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-course-student-counter .llms-student-counter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'student_counter_number_margin',
			[
				'label' => __( 'Margin', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' 	=> [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-course-student-counter .llms-student-counter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'student_counter_number_border',
				'label' => __( 'Border', 'deep' ),
				'selector' => '{{WRAPPER}} .deep-llms-course-student-counter .llms-student-counter',
			]
		);

		$this->add_responsive_control(
			'student_counter_number_border_radius',
			[
				'label' => __( 'Border Radius', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices'    => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'  => [
					'{{WRAPPER}} .deep-llms-course-student-counter .llms-student-counter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'student_counter_label_style',
			[
				'label' => __( 'Student Counter Label', 'deep' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 	=> 'student_counter_label_typography',
				'label' => __( 'Typography', 'deep' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .deep-llms-course-student-counter .llms-student-counter-label',
			]
		);

		$this->add_control(
			'student_counter_label_color',
			[
				'label'  => __( 'Color', 'deep' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-course-student-counter .llms-student-counter-label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'student_counter_label_background',
				'label' => __( 'Background', 'deep' ),
				'types' => [ 'classic' ],
				'selector' => '{{WRAPPER}} .deep-llms-course-student-counter .llms-student-counter-label',
			]
		);

		$this->add_responsive_control(
			'student_counter_label_padding',
			[
				'label' => __( 'Padding', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' 	=> [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-course-student-counter .llms-student-counter-label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'student_counter_label_margin',
			[
				'label' => __( 'Margin', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' 	=> [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-course-student-counter .llms-student-counter-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'student_counter_label_border',
				'label' => __( 'Border', 'deep' ),
				'selector' => '{{WRAPPER}} .deep-llms-course-student-counter .llms-student-counter-label',
			]
		);

		$this->add_responsive_control(
			'student_counter_label_border_radius',
			[
				'label' => __( 'Border Radius', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices'    => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'  => [
					'{{WRAPPER}} .deep-llms-course-student-counter .llms-student-counter-label' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'student_counter_icon_style',
			[
				'label' => __( 'Student Counter Icon', 'deep' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'student_counter_icon_margin',
			[
				'label' => __( 'Margin', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' 	=> [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-course-student-counter i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'student_counter_icon_border',
				'label' => __( 'Border', 'deep' ),
				'selector' => '{{WRAPPER}} .deep-llms-course-student-counter i',
			]
		);

		$this->add_responsive_control(
			'student_counter_icon_border_radius',
			[
				'label' => __( 'Border Radius', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices'    => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'  => [
					'{{WRAPPER}} .deep-llms-course-student-counter i' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
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

		$settings		= $this->get_settings_for_display();
		$student_count 	= LifterLMS::get_enrolled_students( get_the_id() );
		$student_label	= $settings['course_student_counter_label'];

		?>
			<div class="deep-llms-course-student-counter llms-meta">
				<?php
					if ( $settings['course_student_counter_icon'] != '' ) {
						echo '<i class="wn-icon '. esc_attr( $settings['course_student_counter_icon'] ) . '"></i>';
					}
					echo '<span class="llms-student-counter">' . $student_count . '</span>';
					echo '<span class="llms-student-counter-label">' . esc_html( $student_label ) . '</span>';
				?>
			</div>
		<?php
	}
}
