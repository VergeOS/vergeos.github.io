<?php

namespace LifterLMS\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_shadow;
use Deep\Components\LifterLMS;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for LifterLMS Courses.
 *
 * @since 5.0.0
 */
class Courses extends Widget_Base {
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
		return 'llms-courses';
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
		return __( 'LifterLMS Courses', 'deep' );
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
		return 'deep-widget deep-eicon-llms-courses';
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
	 * Load depend scripts.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function get_script_depends() {
		return array( 'deep-magnific-popup', 'deep-video-ply-btn' );
	}

	/**
	 * Load depend styles.
	 *
	 * @since 5.0.0
	 *
	 * @access protected
	 */
	public function get_style_depends() {
		return array( 'deep-llms-courses', 'deep-magnific-popup' );
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
			'count',
			array(
				'label' => __( 'Number of courses', 'deep' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 1,
				'max'   => 100,
				'step'  => 1,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'courses_box_style',
			[
				'label' => __('Box', 'deep'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_box_background',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses',
			]
		);

		$this->add_responsive_control(
			'courses_box_margin',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_box_padding',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_box_border',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses',
			]
		);

		$this->add_responsive_control(
			'courses_box_border_radius',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_box_box_shadow',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'courses_item_style',
			[
				'label' => __('Items', 'deep'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_item_background',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner',
			]
		);

		$this->add_responsive_control(
			'courses_item_margin',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_item_padding',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_item_border',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner',
			]
		);

		$this->add_responsive_control(
			'courses_item_border_radius',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_item_box_shadow',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'courses_image_style',
			[
				'label' => __('Featured Image', 'deep'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_image_background',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-image img',
			]
		);

		$this->add_responsive_control(
			'courses_image_margin',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-image img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_image_padding',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_image_border',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-image img',
			]
		);

		$this->add_responsive_control(
			'courses_image_border_radius',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_image_box_shadow',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-image img',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'courses_meta_wrapper_style',
			[
				'label' => __('Meta Wrapper', 'deep'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_meta_wrappers_background',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta',
			]
		);

		$this->add_responsive_control(
			'courses_meta_wrappers_margin',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_meta_wrappers_padding',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_meta_wrappers_border',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta',
			]
		);

		$this->add_responsive_control(
			'courses_meta_wrappers_border_radius',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_meta_wrappers_box_shadow',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'courses_category_style',
			[
				'label' => __('Category', 'deep'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'courses_category_tabs'
		);

		$this->start_controls_tab(
			'courses_category_normal_tab',
			[
				'label' => __('Normal', 'deep'),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'courses_category_typography',
				'label' 	=> __('Typography', 'deep'),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
				'selector' 	=> '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a',
			]
		);

		$this->add_control(
			'courses_category_align',
			[
				'label'     => __('Text align', 'deep'),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __('Left', 'deep'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'deep'),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __('Right', 'deep'),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'courses_category_color',
			[
				'label' 		=> __('Color', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_category_background',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a',
			]
		);

		$this->add_responsive_control(
			'courses_category_margin',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_category_padding',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_category_border',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a',
			]
		);

		$this->add_responsive_control(
			'courses_category_border_radius',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_category_box_shadow',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'courses_category_hover_tab',
			[
				'label' => __('Hover', 'deep'),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'courses_category_typography_hover',
				'label' 	=> __('Typography', 'deep'),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
				'selector' 	=> '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a:hover',
			]
		);

		$this->add_control(
			'courses_category_align_hover',
			[
				'label'     => __('Text align', 'deep'),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __('Left', 'deep'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'deep'),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __('Right', 'deep'),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a:hover' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'courses_category_color_hover',
			[
				'label' 		=> __('Color', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_category_background_hover',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a:hover',
			]
		);

		$this->add_responsive_control(
			'courses_category_margin_hover',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_category_padding_hover',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_category_border_hover',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a:hover',
			]
		);

		$this->add_responsive_control(
			'courses_category_border_radius_hover',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_category_box_shadow_hover',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-cat a:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'courses_price_style',
			[
				'label' => __('Price', 'deep'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'courses_price_tabs'
		);

		$this->start_controls_tab(
			'courses_price_normal_tab',
			[
				'label' => __('Normal', 'deep'),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'courses_price_typography',
				'label' 	=> __('Typography', 'deep'),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
				'selector' 	=> '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price',
			]
		);

		$this->add_control(
			'courses_price_align',
			[
				'label'     => __('Text align', 'deep'),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __('Left', 'deep'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'deep'),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __('Right', 'deep'),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'courses_price_color',
			[
				'label' 		=> __('Color', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_price_background',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price',
			]
		);

		$this->add_responsive_control(
			'courses_price_margin',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_price_padding',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_price_border',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price',
			]
		);

		$this->add_responsive_control(
			'courses_price_border_radius',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_price_box_shadow',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'courses_price_hover_tab',
			[
				'label' => __('Hover', 'deep'),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'courses_price_typography_hover',
				'label' 	=> __('Typography', 'deep'),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
				'selector' 	=> '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price:hover',
			]
		);

		$this->add_control(
			'courses_price_align_hover',
			[
				'label'     => __('Text align', 'deep'),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __('Left', 'deep'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'deep'),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __('Right', 'deep'),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price:hover' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'courses_price_color_hover',
			[
				'label' 		=> __('Color', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_price_background_hover',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price:hover',
			]
		);

		$this->add_responsive_control(
			'courses_price_margin_hover',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_price_padding_hover',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_price_border_hover',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price:hover',
			]
		);

		$this->add_responsive_control(
			'courses_price_border_radius_hover',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_price_box_shadow_hover',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-meta .llms-price span.lifterlms-price:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'courses_title_style',
			[
				'label' => __('Title', 'deep'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'courses_title_tabs'
		);

		$this->start_controls_tab(
			'courses_title_normal_tab',
			[
				'label' => __('Normal', 'deep'),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'courses_title_typography',
				'label' 	=> __('Typography', 'deep'),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
				'selector' 	=> '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title',
			]
		);

		$this->add_control(
			'courses_title_align',
			[
				'label'     => __('Text align', 'deep'),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __('Left', 'deep'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'deep'),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __('Right', 'deep'),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'courses_title_color',
			[
				'label' 		=> __('Color', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_title_background',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title',
			]
		);

		$this->add_responsive_control(
			'courses_title_margin',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_title_padding',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_title_border',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title',
			]
		);

		$this->add_responsive_control(
			'courses_title_border_radius',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_title_box_shadow',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'courses_title_hover_tab',
			[
				'label' => __('Hover', 'deep'),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'courses_title_typography_hover',
				'label' 	=> __('Typography', 'deep'),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
				'selector' 	=> '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title:hover',
			]
		);

		$this->add_control(
			'courses_title_align_hover',
			[
				'label'     => __('Text align', 'deep'),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __('Left', 'deep'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'deep'),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __('Right', 'deep'),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title:hover' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'courses_title_color_hover',
			[
				'label' 		=> __('Color', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_title_background_hover',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title:hover',
			]
		);

		$this->add_responsive_control(
			'courses_title_margin_hover',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_title_padding_hover',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_title_border_hover',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title:hover',
			]
		);

		$this->add_responsive_control(
			'courses_title_border_radius_hover',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_title_box_shadow_hover',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-course-title:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'learners_wrappers_style',
			[
				'label' => __('learners Wrapper', 'deep'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'learners_wrappers_background',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap',
			]
		);

		$this->add_responsive_control(
			'learners_wrappers_margin',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'learners_wrappers_padding',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'learners_wrappers_border',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap',
			]
		);

		$this->add_responsive_control(
			'learners_wrappers_border_radius',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'learners_wrappers_Box_shadow',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'courses_instructor_image_style',
			[
				'label' => __('Instructor Image', 'deep'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_instructor_image_background',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-image img',
			]
		);

		$this->add_responsive_control(
			'courses_instructor_image_margin',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-image img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_instructor_image_padding',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_instructor_image_border',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-image img',
			]
		);

		$this->add_responsive_control(
			'courses_instructor_image_border_radius',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_instructor_image_box_shadow',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-image img',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'courses_by_style',
			[
				'label' => __('Course By', 'deep'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'courses_by_tabs'
		);

		$this->start_controls_tab(
			'courses_by_normal_tab',
			[
				'label' => __('Normal', 'deep'),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'courses_by_typography',
				'label' 	=> __('Typography', 'deep'),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
				'selector' 	=> '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by',
			]
		);

		$this->add_control(
			'courses_by_align',
			[
				'label'     => __('Text align', 'deep'),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __('Left', 'deep'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'deep'),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __('Right', 'deep'),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'courses_by_color',
			[
				'label' 		=> __('Color', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_by_background',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by',
			]
		);

		$this->add_responsive_control(
			'courses_by_margin',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_by_padding',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_by_border',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by',
			]
		);

		$this->add_responsive_control(
			'courses_by_border_radius',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_by_box_shadow',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'courses_by_hover_tab',
			[
				'label' => __('Hover', 'deep'),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'courses_by_typography_hover',
				'label' 	=> __('Typography', 'deep'),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
				'selector' 	=> '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by:hover',
			]
		);

		$this->add_control(
			'courses_by_align_hover',
			[
				'label'     => __('Text align', 'deep'),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __('Left', 'deep'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'deep'),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __('Right', 'deep'),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by:hover' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'courses_by_color_hover',
			[
				'label' 		=> __('Color', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_by_background_hover',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by:hover',
			]
		);

		$this->add_responsive_control(
			'courses_by_margin_hover',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_by_padding_hover',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_by_border_hover',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by:hover',
			]
		);

		$this->add_responsive_control(
			'courses_by_border_radius_hover',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_by_box_shadow_hover',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-course-by:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'courses_instructor_name_style',
			[
				'label' => __('Instructor Name', 'deep'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'courses_instructor_name_tabs'
		);

		$this->start_controls_tab(
			'courses_instructor_name_normal_tab',
			[
				'label' => __('Normal', 'deep'),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'courses_instructor_name_typography',
				'label' 	=> __('Typography', 'deep'),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
				'selector' 	=> '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name',
			]
		);

		$this->add_control(
			'courses_instructor_name_align',
			[
				'label'     => __('Text align', 'deep'),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __('Left', 'deep'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'deep'),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __('Right', 'deep'),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'courses_instructor_name_color',
			[
				'label' 		=> __('Color', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_instructor_name_background',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name',
			]
		);

		$this->add_responsive_control(
			'courses_instructor_name_margin',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_instructor_name_padding',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_instructor_name_border',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name',
			]
		);

		$this->add_responsive_control(
			'courses_instructor_name_border_radius',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_instructor_name_box_shadow',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'courses_instructor_name_hover_tab',
			[
				'label' => __('Hover', 'deep'),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'courses_instructor_name_typography_hover',
				'label' 	=> __('Typography', 'deep'),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
				'selector' 	=> '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name:hover',
			]
		);

		$this->add_control(
			'courses_instructor_name_align_hover',
			[
				'label'     => __('Text align', 'deep'),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __('Left', 'deep'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'deep'),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __('Right', 'deep'),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name:hover' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'courses_instructor_name_color_hover',
			[
				'label' 		=> __('Color', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_instructor_name_background_hover',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name:hover',
			]
		);

		$this->add_responsive_control(
			'courses_instructor_name_margin_hover',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_instructor_name_padding_hover',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_instructor_name_border_hover',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name:hover',
			]
		);

		$this->add_responsive_control(
			'courses_instructor_name_border_radius_hover',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_instructor_name_box_shadow_hover',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-instructor .llms-instructor-name:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'courses_learners_icon_style',
			[
				'label' => __('learners Icon', 'deep'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_learners_icon_background',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners svg',
			]
		);

		$this->add_responsive_control(
			'courses_learners_icon_margin',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_learners_icon_padding',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_learners_icon_border',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners svg',
			]
		);

		$this->add_responsive_control(
			'courses_learners_icon_border_radius',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners svg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_learners_icon_box_shadow',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners svg',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'courses_learners_count_style',
			[
				'label' => __('Learners Count', 'deep'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'courses_learners_count_tabs'
		);

		$this->start_controls_tab(
			'courses_learners_count_normal_tab',
			[
				'label' => __('Normal', 'deep'),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'courses_learners_count_typography',
				'label' 	=> __('Typography', 'deep'),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
				'selector' 	=> '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count',
			]
		);

		$this->add_control(
			'courses_learners_count_align',
			[
				'label'     => __('Text align', 'deep'),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __('Left', 'deep'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'deep'),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __('Right', 'deep'),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'courses_learners_count_color',
			[
				'label' 		=> __('Color', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_learners_count_background',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count',
			]
		);

		$this->add_responsive_control(
			'courses_learners_count_margin',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_learners_count_padding',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_learners_count_border',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count',
			]
		);

		$this->add_responsive_control(
			'courses_learners_count_border_radius',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_learners_count_box_shadow',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'courses_learners_count_hover_tab',
			[
				'label' => __('Hover', 'deep'),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'courses_learners_count_typography_hover',
				'label' 	=> __('Typography', 'deep'),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
				'selector' 	=> '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count:hover',
			]
		);

		$this->add_control(
			'courses_learners_count_align_hover',
			[
				'label'     => __('Text align', 'deep'),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __('Left', 'deep'),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'deep'),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __('Right', 'deep'),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count:hover' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'courses_learners_count_color_hover',
			[
				'label' 		=> __('Color', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'courses_learners_count_background_hover',
				'label' => __('Background', 'deep'),
				'types' => ['classic', 'gradient', 'video'],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count:hover',
			]
		);

		$this->add_responsive_control(
			'courses_learners_count_margin_hover',
			[
				'label' 		=> __('Margin', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'courses_learners_count_padding_hover',
			[
				'label' 		=> __('Padding', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'courses_learners_count_border_hover',
				'label' => __('Border', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count:hover',
			]
		);

		$this->add_responsive_control(
			'courses_learners_count_border_radius_hover',
			[
				'label' 		=> __('Border Radius', 'deep'),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'devices' => ['desktop', 'tablet', 'mobile'],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'courses_learners_count_box_shadow_hover',
				'label' => __('Box Shadow', 'deep'),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-courses .deep-llms-course-inner .llms-learners-wrap .llms-learners .llms-learners-count:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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

		$count   = $this->get_settings_for_display( 'count' );
		$courses = new \WP_Query(
			array(
				'post_type'      => 'course',
				'posts_per_page' => $count,
			)
		);
		?>
		<div class="deep-llms-courses">
			<?php
			while ( $courses->have_posts() ) :
				$courses->the_post();

				$video_url = LifterLMS::get_featured_video_url( get_the_id() );
				$products  = LifterLMS::get_llms_products( get_the_id() );
				$price     = LifterLMS::get_product_price( $products );
			?>
				<div class="deep-llms-course">
					<div class="deep-llms-course-inner">
						<div class="llms-image">
							<?php echo get_the_post_thumbnail(); ?>
							<?php if ( $video_url ) : ?>
								<a href="<?php echo esc_url( $video_url ); ?>" class="llms-video-link wn-popup-video video-play-btn video-play-btn">
									<div class="llms-video">
										<svg xmlns="http://www.w3.org/2000/svg" width="10.615" height="12.133" viewBox="0 0 10.615 12.133">
											<path data-name="Icon awesome-play" d="M10.056,5.089,1.716.158A1.131,1.131,0,0,0,0,1.137V11a1.136,1.136,0,0,0,1.716.979l8.341-4.929a1.136,1.136,0,0,0,0-1.957Z" transform="translate(0 -0.002)" fill="#33ba76"/>
										</svg>
									</div>
								</a>
							<?php endif; ?>
						</div>
						<div class="llms-meta">
							<span class="llms-cat"><?php echo LifterLMS::get_categories( get_the_id() ); ?></span>
							<span class="llms-price"><?php echo wp_kses_post( $price ); ?></span>
						</div>
						<div class="llms-course-title"><a href="<?php the_permalink(); ?>"><?php esc_html( the_title() ); ?></a></div>
							<div class="llms-learners-wrap">
								<div class="llms-instructor">
									<span class="llms-instructor-image"><?php echo wp_kses_post( get_avatar( get_the_author_meta( 'email', get_post_field( 'post_author', $courses->ID ) ), 35 ) ); ?></span>
									<span class="llms-course-by"><?php esc_html_e( 'By', 'deep' ); ?></span>
									<span class="llms-instructor-name"><?php esc_html( the_author() ); ?></span>
								</div>
								<div class="llms-learners">
									<svg xmlns="http://www.w3.org/2000/svg" width="17.252" height="17.252" viewBox="0 0 17.252 17.252">
										<path data-name="Icon material-person" d="M14.626,14.626a4.313,4.313,0,1,0-4.313-4.313A4.312,4.312,0,0,0,14.626,14.626Zm0,2.157C11.747,16.783,6,18.227,6,21.1v2.157H23.252V21.1C23.252,18.227,17.505,16.783,14.626,16.783Z" transform="translate(-6 -6)" fill="#373737"/>
									</svg>
									<span class="llms-learners-count">
										<?php echo LifterLMS::get_enrolled_students( get_the_id() ); ?>
										<?php esc_html_e( 'Learners', 'deep' ); ?>
									</span>
								</div>
							</div>
						</div>
					</div>
				<?php
			endwhile;
			wp_reset_query();
				?>
				</div>
		<?php
	}
}
