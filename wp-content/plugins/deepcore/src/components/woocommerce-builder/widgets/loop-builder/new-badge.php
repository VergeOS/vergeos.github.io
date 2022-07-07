<?php
namespace Deep\WooCommerce\Elementor\Widgets\LoopBuilder;

use Deep\WooCommerce\Elementor\Deep_Loop_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce product.
 *
 * @since 2.0.0
 */
class NewBadge extends Deep_Loop_Product_Widget_Base {

	public $deep_base_selector = '{{WRAPPER}} .deep-woo-new-badge';

	/**
	 * Retrieve the widget name.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'deep-woo-new-badge';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Item New Badge', 'deep' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'deep-widget deep-eicon-new-badge';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'Deep_Product_Loop' );
	}

	/**
	 * Register the widget controls.
	 *
	 * @since 2.0.0
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
			'description',
			array(
				'label'     => __( 'This widget displays the product new badge.', 'deep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'show_up_to',
			array(
				'label' => __( 'Show up to 5 hours after create', 'deep' ),
				'type' => Controls_Manager::SELECT,
				'options' => array(
					'12' => __( '12 hours', 'deep' ),
					'24' => __( '1 day', 'deep' ),
					'48' => __( '2 days', 'deep' ),
					'72' => __( '3 days', 'deep' ),
					'96' => __( '4 days', 'deep' ),
					'120' => __( '5 days', 'deep' ),
					'144' => __( '6 days', 'deep' ),
					'168' => __( '7 days', 'deep' ),
				),
				'default' => '24',
			)
		);

		$this->add_control(
			'label',
			array(
				'label'     => __( 'Label.', 'deep' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'New', 'deep' ),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'icon',
			array(
				'label'            => __( 'Icon', 'deep' ),
				'type'             => Controls_Manager::ICONS,
			)
		);

		$this->add_control(
			'icon_size',
			[
				'label'		=> __( 'Icon Size', 'deep' ),
				'type'		=> Controls_Manager::SLIDER,
				'selectors' => [
					$this->deep_base_selector . ' i ,'.
					$this->deep_base_selector . ' svg' => "font-size: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};"
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
						'step' => 1,
					],
				],
			]
		);

		$this->add_control(
			'icon_pos',
			array(
				'label'   => __( 'Icon Position', 'deep' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'after',
				'options' => array(
					'' => __( 'None', 'deep' ),
					'before' => __( 'Before', 'deep' ),
					'after'  => __( 'After', 'deep' ),
				),
			)
		);
		$this->end_controls_section();

		$this->register_new_badge_box_styles();
		$this->register_new_badge_styles();
		$this->register_new_badge_icon_styles();
	}

	/**
	 * Register New Badge Box Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_new_badge_box_styles() {

		$group_id       = 'new_badge_box_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Box', 'deep' );
		$description    = '';
		$selector       = $base_selector;
		$hover_selector = $selector . ':hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => false,
			$group_id . 'hover_typography' => false,

			$group_id . 'color'            => false,
			$group_id . 'hover_color'      => false,
		);

		$this->deep_register_styles_controls(
			$group_id,
			$section_label,
			$description,
			$selector,
			$hover_selector,
			$rewrite_settings_fields
		);
	}

	/**
	 * Register New Badge Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_new_badge_styles() {

		$group_id      = 'new_badge_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'New Badge', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' span.label';
		$hover_selector = $selector . ':hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'text_align' => false,
			),
			$group_id . 'hover_typography' => array(
				'text_align' => false,
			),
			$group_id . 'display'          => array(
				'type'    => 'display',
				'default' => 'inline-block',
			),
			$group_id . 'position'         => array(
				'type'    => 'position',
				'default' => 'static',
			),
		);

		$this->deep_register_styles_controls(
			$group_id,
			$section_label,
			$description,
			$selector,
			$hover_selector,
			$rewrite_settings_fields
		);
	}

	/**
	 * Register New Badge Icon Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_new_badge_icon_styles() {

		$group_id      = 'new_badge_icon_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'New Badge Icon', 'deep' );
		$description   = '';

		$selector       = $base_selector . '  i ,'.
			$base_selector . ' svg';
		$hover_selector = $base_selector . ':hover,'.
			$base_selector . ':hover svg';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => false,
			$group_id . 'hover_typography' => false,
		);

		$this->deep_register_styles_controls(
			$group_id,
			$section_label,
			$description,
			$selector,
			$hover_selector,
			$rewrite_settings_fields
		);
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * @since 2.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->prepare_render();

		if ( $this->can_display_item_product() ) {

			Templates::widget( 'product-new-badge', $settings );
		}

		$this->reset_render();
	}
}
