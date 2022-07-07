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
 * Elementor widget for LifterLMS Achievements.
 *
 * @since 5.0.0
 */
class Achievements extends Widget_Base {
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
		return 'achievements';
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
		return __( 'LifterLMS Achievements', 'deep' );
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
		return 'deep-widget deep-eicon-llms-achievements';
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
			'count',
			[
				'label' => __( 'Number of achievements', 'deep' ),
				'type'  => Controls_Manager::NUMBER,
				'min'   => 1,
				'max'   => 100,
				'step'  => 1,
				'default' => 1,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'achievements_box_style',
			[
				'label' => __( 'Box', 'deep' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'achievements_box_background',
				'label' => __( 'Background', 'deep' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-achievements',
			]
		);

		$this->add_responsive_control(
			'achievements_box_margin',
			[
				'label' 		=> __( 'Margin', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-achievements' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'achievements_box_padding',
			[
				'label' 		=> __( 'Padding', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-achievements' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'achievements_box_border',
				'label' => __( 'Border', 'deep' ),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-achievements',
			]
		);

		$this->add_responsive_control(
			'achievements_box_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-achievements' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'achievements_box_Box_shadow',
					'label' => __( 'Box Shadow', 'deep' ),
					'selector' => '#wrap {{WRAPPER}} .deep-llms-achievements',
				]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'achievements_item_style',
			[
				'label' => __( 'Items', 'deep' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'achievements_item_background',
				'label' => __( 'Background', 'deep' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item, #wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item a',
			]
		);

		$this->add_responsive_control(
			'achievements_item_margin',
			[
				'label' 		=> __( 'Margin', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'achievements_item_padding',
			[
				'label' 		=> __( 'Padding', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'achievements_item_border',
				'label' => __( 'Border', 'deep' ),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item',
			]
		);

		$this->add_responsive_control(
			'achievements_item_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'achievements_item_Box_shadow',
					'label' => __( 'Box Shadow', 'deep' ),
					'selector' => '#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item',
				]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'achievements_image_style',
			[
				'label' => __( 'Image', 'deep' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'achievements_image_background',
				'label' => __( 'Background', 'deep' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item a div img.llms-achievement-img',
			]
		);

		$this->add_responsive_control(
			'achievements_image_margin',
			[
				'label' 		=> __( 'Margin', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item a div img.llms-achievement-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'achievements_image_padding',
			[
				'label' 		=> __( 'Padding', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item a div img.llms-achievement-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'achievements_image_border',
				'label' => __( 'Border', 'deep' ),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item a div img.llms-achievement-img',
			]
		);

		$this->add_responsive_control(
			'achievements_image_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item a div img.llms-achievement-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'achievements_image_Box_shadow',
					'label' => __( 'Box Shadow', 'deep' ),
					'selector' => '#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item a div img.llms-achievement-img',
				]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'achievements_title_style',
			[
				'label' => __( 'Title', 'deep' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'achievements_title_typography',
				'label' 	=> __( 'Typography', 'deep' ),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_2,
				'selector' 	=> '#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item a h4.llms-achievement-title',
			]
		);

		$this->add_control(
			'achievements_title_align',
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
					'#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item a h4.llms-achievement-title' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'achievements_title_color',
			[
				'label' 		=> __( 'Color', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::COLOR,
				'selectors' 	=> [
					'#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item a h4.llms-achievement-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'achievements_title_background',
				'label' => __( 'Background', 'deep' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item a h4.llms-achievement-title',
			]
		);

		$this->add_responsive_control(
			'achievements_title_margin',
			[
				'label' 		=> __( 'Margin', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item a h4.llms-achievement-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'achievements_title_padding',
			[
				'label' 		=> __( 'Padding', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item a h4.llms-achievement-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'achievements_title_border',
				'label' => __( 'Border', 'deep' ),
				'selector' => '#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item a h4.llms-achievement-title',
			]
		);

		$this->add_responsive_control(
			'achievements_title_border_radius',
			[
				'label' 		=> __( 'Border Radius', 'deep' ),
				'type' 			=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item a h4.llms-achievement-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'achievements_title_Box_shadow',
					'label' => __( 'Box Shadow', 'deep' ),
					'selector' => '#wrap {{WRAPPER}} .deep-llms-achievements ul li.achievement-item a h4.llms-achievement-title',
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
        $count = $this->get_settings_for_display( 'count' );
		$achievements = do_shortcode( shortcode_unautop( '[lifterlms_my_achievements count="' . $count . '"]' ) );
		?>
		<div class="deep-llms-achievements">
			<?php echo $achievements; ?>
		</div>
		<?php
	}
}
