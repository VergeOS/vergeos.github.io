<?php
namespace LifterLMS\Elementor\Widgets;

use Elementor\Plugin;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Deep\Components\LifterLMS;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for LifterLMS Lesson Video.
 *
 * @since 5.0.0
 */
class LessonVideo extends Widget_Base {
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
		return 'llms-lesson-video';
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
		return __( 'LifterLMS Lesson Video', 'deep' );
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
		return 'deep-widget deep-eicon-llms-lesson-video';
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
				'label' 	=> __( 'This widget displays the lesson video for a specific lesson.', 'deep' ),
				'type'	 	=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

			//Styling
			$this->start_controls_section(
				'box_style',
				[
					'label' => __('Box', 'deep'),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'  => 'box_background',
					'label' => __('Background', 'deep'),
					'types' => ['classic'],
					'selector' => '{{WRAPPER}} .deep-llms-lesson-video',
				]
			);

			$this->add_responsive_control(
				'box_padding',
				[
					'label' => __('Padding', 'deep'),
					'type' 	=> Controls_Manager::DIMENSIONS,
					'size_units' => ['px', 'em', '%'],
					'devices' 	=> ['desktop', 'tablet', 'mobile'],
					'selectors' => [
						'{{WRAPPER}} .deep-llms-lesson-video' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'box_margin',
				[
					'label' => __('Margin', 'deep'),
					'type' 	=> Controls_Manager::DIMENSIONS,
					'size_units' => ['px', 'em', '%'],
					'devices' 	=> ['desktop', 'tablet', 'mobile'],
					'selectors' => [
						'{{WRAPPER}} .deep-llms-lesson-video' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'  => 'box_border',
					'label' => __('Border', 'deep'),
					'selector' => '{{WRAPPER}} .deep-llms-lesson-video',
				]
			);

			$this->add_responsive_control(
				'box_border_radius',
				[
					'label' => __('Border Radius', 'deep'),
					'type' 	=> Controls_Manager::DIMENSIONS,
					'size_units' => ['px', 'em', '%'],
					'devices'    => ['desktop', 'tablet', 'mobile'],
					'selectors'  => [
						'{{WRAPPER}} .deep-llms-lesson-video' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'box_box_shadow',
					'label' =>  esc_html__('Box Shadow', 'deep'),
					'selector' => '{{WRAPPER}} .deep-llms-lesson-video',
				]
			);

			$this->end_controls_section();

			$this->start_controls_section(
				'video_style',
				[
					'label' => __('Video', 'deep'),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			$this->add_responsive_control(
				'video_width',
				[
					'label' => __('Width', 'deep'),
					'type' 	=> Controls_Manager::SLIDER,
					'size_units' => ['px', '%'],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1920,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 640,
					],
					'selectors' => [
						'{{WRAPPER}} .deep-llms-lesson-video .llms-video-wrapper .center-video iframe' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'video_height',
				[
					'label' => __('Height', 'deep'),
					'type' 	=> Controls_Manager::SLIDER,
					'size_units' => ['px', '%'],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1080,
							'step' => 1,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => 'px',
						'size' => 480,
					],
					'selectors' => [
						'{{WRAPPER}} .deep-llms-lesson-video .llms-video-wrapper .center-video iframe' => 'height: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name'  => 'video_background',
					'label' => __('Background', 'deep'),
					'types' => ['classic'],
					'selector' => '{{WRAPPER}} .deep-llms-lesson-video .llms-video-wrapper .center-video iframe',
				]
			);

			$this->add_responsive_control(
				'video_padding',
				[
					'label' => __('Padding', 'deep'),
					'type' 	=> Controls_Manager::DIMENSIONS,
					'size_units' => ['px', 'em', '%'],
					'devices' 	=> ['desktop', 'tablet', 'mobile'],
					'selectors' => [
						'{{WRAPPER}} .deep-llms-lesson-video .llms-video-wrapper .center-video iframe' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'video_margin',
				[
					'label' => __('Margin', 'deep'),
					'type' 	=> Controls_Manager::DIMENSIONS,
					'size_units' => ['px', 'em', '%'],
					'devices' 	=> ['desktop', 'tablet', 'mobile'],
					'selectors' => [
						'{{WRAPPER}} .deep-llms-lesson-video .llms-video-wrapper .center-video iframe' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'  => 'video_border',
					'label' => __('Border', 'deep'),
					'selector' => '{{WRAPPER}} .deep-llms-lesson-video .llms-video-wrapper .center-video iframe',
				]
			);

			$this->add_responsive_control(
				'video_border_radius',
				[
					'label' => __('Border Radius', 'deep'),
					'type' 	=> Controls_Manager::DIMENSIONS,
					'size_units' => ['px', 'em', '%'],
					'devices'    => ['desktop', 'tablet', 'mobile'],
					'selectors'  => [
						'{{WRAPPER}} .deep-llms-lesson-video .llms-video-wrapper .center-video iframe' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'video_box_shadow',
					'label' =>  esc_html__('Box Shadow', 'deep'),
					'selector' => '{{WRAPPER}} .deep-llms-lesson-video .llms-video-wrapper .center-video iframe',
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

		// This only for the preview in the editor mode
		if ( Plugin::$instance->editor->is_edit_mode()  ) {
			$id = LifterLMS::get_course();
			$course = new \LLMS_Course( $id );

			if ( $course->get_video() ) {
				?>
				<div class="deep-llms-lesson-video llms-video-wrapper">
					<div class="center-video">
						<?php echo $course->get_video(); ?>
					</div>
				</div>
				<?php
			} else {
				esc_html_e( 'This course does not have a video.', 'deep' );
			}
		}

		?>
		<div class="deep-llms-lesson-video">
			<?php
                if ( function_exists( 'lifterlms_template_single_lesson_video' ) ) {
                    lifterlms_template_single_lesson_video();
                }
            ?>
		</div>
		<?php
	}
}
