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
use Elementor\Group_Control_Box_shadow;
use Deep\Components\LifterLMS;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for LifterLMS Course Content.
 *
 * @since 5.0.0
 */
class CourseContent extends Widget_Base {
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
		return 'llms-course-content';
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
		return __( 'LifterLMS Course Content', 'deep' );
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
		return 'deep-widget deep-eicon-llms-course-content';
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
				'label' 	=> __( 'This widget displays the course content for a specific course.', 'deep' ),
				'type'	 	=> Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'course_content_paragraph_style',
			[
				'label' => __( 'Paragraph', 'deep' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'course_content_paragraph_typography',
				'label' 	=> __( 'Typography', 'deep' ),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
				'selector' 	=> '#wrap {{WRAPPER}} .deep-llms-course-content p',
			]
		);

		$this->add_control(
			'course_content_paragraph_align',
			[
				'label'     => __( 'Text align', 'deep' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'deep' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'deep' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'deep' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-course-content p' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'course_content_paragraph_color',
			[
				'label' 		=> __( 'Color', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'#wrap {{WRAPPER}} .deep-llms-course-content p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'course_content_paragraph_background',
				'label' => __( 'Background', 'deep' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-course-content p',
			]
		);

		$this->add_responsive_control(
			'course_content_paragraph_margin',
			[
				'label' 		=> __( 'Margin', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-course-content p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'course_content_paragraph_padding',
			[
				'label' 		=> __( 'Padding', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-course-content p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'course_content_paragraph_border',
				'label' => __( 'Border', 'deep' ),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-course-content p',
			]
		);

		$this->add_responsive_control(
			'course_content_paragraph_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-course-content p' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'course_content_paragraph_box_shadow',
					'label' => __( 'Box Shadow', 'deep' ),
					'selector' => '#wrap {{WRAPPER}} .deep-llms-course-content p',
				]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'course_content_link_style',
			[
				'label' => __( 'Link', 'deep' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs(
			'link_style_tabs'
		);

		$this->start_controls_tab(
			'style_link_normal_tab',
			[
				'label' => __( 'Normal', 'deep' ),
			]
		);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' 		=> 'course_content_link_typography',
					'label' 	=> __( 'Typography', 'deep' ),
					'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
					'selector' 	=> '#wrap {{WRAPPER}} .deep-llms-course-content a',
				]
			);

			$this->add_control(
				'course_content_link_align',
				[
					'label'     => __( 'Text align', 'deep' ),
					'type'      => \Elementor\Controls_Manager::CHOOSE,
					'options'   => [
						'left'   => [
							'title' => __( 'Left', 'deep' ),
							'icon'  => 'fa fa-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'deep' ),
							'icon'  => 'fa fa-align-center',
						],
						'right'  => [
							'title' => __( 'Right', 'deep' ),
							'icon'  => 'fa fa-align-right',
						],
					],
					'toggle'    => true,
					'selectors' => [
						'#wrap {{WRAPPER}} .deep-llms-course-content a' => 'text-align: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'course_content_link_color',
				[
					'label' 		=> __( 'Color', 'deep' ),
					'type' 			=> \Elementor\Controls_Manager::COLOR,
					'selectors' 	=> [
						'#wrap {{WRAPPER}} .deep-llms-course-content a' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Background::get_type(),
				[
					'name' => 'course_content_link_background',
					'label' => __( 'Background', 'deep' ),
					'types' => [ 'classic', 'gradient', 'video' ],
					'selector' => '#wrap {{WRAPPER}} .deep-llms-course-content a',
				]
			);

			$this->add_responsive_control(
				'course_content_link_margin',
				[
					'label' 		=> __( 'Margin', 'deep' ),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'selectors' => [
						'#wrap {{WRAPPER}} .deep-llms-course-content a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'course_content_link_padding',
				[
					'label' 		=> __( 'Padding', 'deep' ),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'selectors' => [
						'#wrap {{WRAPPER}} .deep-llms-course-content a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'course_content_link_border',
					'label' => __( 'Border', 'deep' ),
					'selector' => '#wrap {{WRAPPER}} .deep-llms-course-content a',
				]
			);

			$this->add_responsive_control(
				'course_content_link_border_radius',
				[
					'label' 		=> __( 'Border Radius', 'deep' ),
					'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'devices' => [ 'desktop', 'tablet', 'mobile' ],
					'selectors' => [
						'#wrap {{WRAPPER}} .deep-llms-course-content a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
					[
						'name' => 'course_content_link_box_shadow',
						'label' => __( 'Box Shadow', 'deep' ),
						'selector' => '#wrap {{WRAPPER}} .deep-llms-course-content a',
					]
			);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_link_hover_tab',
			[
				'label' => __( 'Hover', 'deep' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'course_content_link_typography_hover',
				'label' 	=> __( 'Typography', 'deep' ),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
				'selector' 	=> '#wrap {{WRAPPER}} .deep-llms-course-content a:hover',
			]
		);

		$this->add_control(
			'course_content_link_align_hover',
			[
				'label'     => __( 'Text align', 'deep' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'deep' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'deep' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'deep' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'toggle'    => true,
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-course-content a:hover' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'course_content_link_color_hover',
			[
				'label' 		=> __( 'Color', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'#wrap {{WRAPPER}} .deep-llms-course-content a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'course_content_link_background_hover',
				'label' => __( 'Background', 'deep' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-course-content a:hover',
			]
		);

		$this->add_responsive_control(
			'course_content_link_margin_hover',
			[
				'label' 		=> __( 'Margin', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-course-content a:hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'course_content_link_padding_hover',
			[
				'label' 		=> __( 'Padding', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-course-content a:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'course_content_link_border_hover',
				'label' => __( 'Border', 'deep' ),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-course-content a:hover',
			]
		);

		$this->add_responsive_control(
			'course_content_link_border_radius_hover',
			[
				'label' 		=> __( 'Border Radius', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-course-content a:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'course_content_link_box_shadow_hover',
					'label' => __( 'Box Shadow', 'deep' ),
					'selector' => '#wrap {{WRAPPER}} .deep-llms-course-content a:hover',
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
		$id = '';

		// This only for the preview in the editor mode
		if ( Plugin::$instance->editor->is_edit_mode()  ) {
			$id = LifterLMS::get_course();
		}
		?>
		<div class="deep-llms-course-content llms-full-description">
			<?php
				$post = get_post( $id );
				echo do_shortcode( $post->post_content );
            ?>
		</div>
		<div class="clear"></div>
		<?php
	}
}
