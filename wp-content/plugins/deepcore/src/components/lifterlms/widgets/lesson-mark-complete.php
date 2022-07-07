<?php
namespace LifterLMS\Elementor\Widgets;

use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for LifterLMS Lesson Mark Complete Button.
 *
 * @since 5.0.0
 */
class LessonMarkComplete extends Widget_Base {
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
		return 'llms-lesson-mark-complete';
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
		return __( 'LifterLMS Lesson Mark Complete', 'deep' );
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
		return 'deep-widget deep-eicon-llms-lesson-mark-complete';
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
	 * @access public
	 */
	public function get_style_depends() {
		return ['deep-llms-enroll-button'];
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
				'label' 	=> __( 'This widget displays the lesson mark complete / mark incomplete button and form.', 'deep' ),
				'type'	 	=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'btn_style',
			[
				'label' => __( 'Button', 'deep' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 	=> 'btn_typography',
				'label' => __( 'Typography', 'deep' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .deep-llms-lesson-mark-complete .llms-button-primary',
			]
		);

		$this->add_control(
			'btn_color',
			[
				'label'  => __( 'Color', 'deep' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-lesson-mark-complete .llms-button-primary' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'btn_background',
				'label' => __( 'Background', 'deep' ),
				'types' => [ 'classic' ],
				'selector' => '{{WRAPPER}} .deep-llms-lesson-mark-complete .llms-button-primary',
			]
		);

		$this->add_responsive_control(
			'btn_padding',
			[
				'label' => __( 'Padding', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' 	=> [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-lesson-mark-complete .llms-button-primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'btn_margin',
			[
				'label' => __( 'Margin', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' 	=> [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-lesson-mark-complete .llms-button-primary' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'btn_border',
				'label' => __( 'Border', 'deep' ),
				'selector' => '{{WRAPPER}} .deep-llms-lesson-mark-complete .llms-button-primary',
			]
		);

		$this->add_responsive_control(
			'btn_border_radius',
			[
				'label' => __( 'Border Radius', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices'    => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'  => [
					'{{WRAPPER}} .deep-llms-lesson-mark-complete .llms-button-primary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

		if ( Plugin::$instance->editor->is_edit_mode()  ) {
			?>
			<!-- This only for the preview in the editor mode -->
			<div class="deep-llms-lesson-mark-complete">
				<div class="llms-button-primary" style="display: table; margin: 0 auto;"> Mark Complete </div>
			</div>
			<?php
		}

		$lesson_mark_complete = do_shortcode( shortcode_unautop( '[lifterlms_lesson_mark_complete]' ) );
		?>
		<div class="deep-llms-lesson-mark-complete">
			<?php echo $lesson_mark_complete; ?>
		</div>
		<?php
	}
}
