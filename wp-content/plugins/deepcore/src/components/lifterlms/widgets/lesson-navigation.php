<?php
namespace LifterLMS\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for LifterLMS Lesson Navigation.
 *
 * @since 5.0.0
 */
class LessonNavigation extends Widget_Base {
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
		return 'llms-lesson-navigation';
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
		return __( 'LifterLMS Lesson Navigation', 'deep' );
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
		return 'deep-widget deep-eicon-llms-lesson-navigation';
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
				'label' 	=> __( 'This widget displays the lesson navigation.', 'deep' ),
				'type'	 	=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'wrap_style',
			[
				'label' => __( 'Wrap', 'deep' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'wrap_background',
				'label' => __( 'Background', 'deep' ),
				'types' => [ 'classic' ],
				'selector' => '{{WRAPPER}} .deep-llms-lesson-navigation .llms-lesson-link',
			]
		);

		$this->add_responsive_control(
			'wrap_padding',
			[
				'label' => __( 'Padding', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' 	=> [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-lesson-navigation .llms-lesson-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'wrap_margin',
			[
				'label' => __( 'Margin', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' 	=> [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-lesson-navigation .llms-lesson-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'wrap_border',
				'label' => __( 'Border', 'deep' ),
				'selector' => '{{WRAPPER}} .deep-llms-lesson-navigation .llms-lesson-link',
			]
		);

		$this->add_responsive_control(
			'wrap_border_radius',
			[
				'label' => __( 'Border Radius', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices'    => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'  => [
					'{{WRAPPER}} .deep-llms-lesson-navigation .llms-lesson-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'link_style',
			[
				'label' => __( 'Link', 'deep' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 	=> 'link_typography',
				'label' => __( 'Typography', 'deep' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .deep-llms-lesson-navigation .llms-pre-text',
			]
		);

		$this->add_control(
			'link_color',
			[
				'label'  => __( 'Color', 'deep' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-lesson-navigation .llms-pre-text' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'link_background',
				'label' => __( 'Background', 'deep' ),
				'types' => [ 'classic' ],
				'selector' => '{{WRAPPER}} .deep-llms-lesson-navigation .llms-pre-text',
			]
		);

		$this->add_responsive_control(
			'link_padding',
			[
				'label' => __( 'Padding', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' 	=> [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-lesson-navigation .llms-pre-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'link_margin',
			[
				'label' => __( 'Margin', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' 	=> [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-lesson-navigation .llms-pre-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'link_border',
				'label' => __( 'Border', 'deep' ),
				'selector' => '{{WRAPPER}} .deep-llms-lesson-navigation .llms-pre-text',
			]
		);

		$this->add_responsive_control(
			'link_border_radius',
			[
				'label' => __( 'Border Radius', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices'    => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'  => [
					'{{WRAPPER}} .deep-llms-lesson-navigation .llms-pre-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'title_style',
			[
				'label' => __( 'Title', 'deep' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 	=> 'title_typography',
				'label' => __( 'Typography', 'deep' ),
				'scheme'   => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .deep-llms-lesson-navigation .llms-lesson-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'  => __( 'Color', 'deep' ),
				'type'   => Controls_Manager::COLOR,
				'scheme' => [
					'type'  => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-lesson-navigation .llms-lesson-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'  => 'title_background',
				'label' => __( 'Background', 'deep' ),
				'types' => [ 'classic' ],
				'selector' => '{{WRAPPER}} .deep-llms-lesson-navigation .llms-lesson-title',
			]
		);

		$this->add_responsive_control(
			'title_padding',
			[
				'label' => __( 'Padding', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' 	=> [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-lesson-navigation .llms-lesson-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'title_margin',
			[
				'label' => __( 'Margin', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' 	=> [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .deep-llms-lesson-navigation .llms-lesson-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'  => 'title_border',
				'label' => __( 'Border', 'deep' ),
				'selector' => '{{WRAPPER}} .deep-llms-lesson-navigation .llms-lesson-title',
			]
		);

		$this->add_responsive_control(
			'title_border_radius',
			[
				'label' => __( 'Border Radius', 'deep' ),
				'type' 	=> Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices'    => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'  => [
					'{{WRAPPER}} .deep-llms-lesson-navigation .llms-lesson-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		?>
		<div class="deep-llms-lesson-navigation">
			<?php
                if ( function_exists( 'lifterlms_template_lesson_navigation' ) ) {
                    lifterlms_template_lesson_navigation();
                }
            ?>
		</div>
		<?php
	}
}
