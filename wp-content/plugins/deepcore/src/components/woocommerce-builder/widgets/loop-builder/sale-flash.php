<?php
namespace Deep\WooCommerce\Elementor\Widgets\LoopBuilder;

use Deep\WooCommerce\Elementor\Deep_Loop_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce product Add To Cart.
 *
 * @since 2.0.0
 */
class OnSale extends Deep_Loop_Product_Widget_Base {

	public $deep_base_selector = '{{WRAPPER}} .deep-woo-onsale';

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
		return 'deep-woo-onsale';
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
		return __( 'Item Sale Badge', 'deep' );
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
		return 'deep-widget deep-eicon-sale-badge';
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
				'label'     => __( 'This widget displays the product sale badge.', 'deep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_control(
			'label',
			array(
				'label'     => __( 'Label.', 'deep' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Sale!', 'deep' ),
				'separator' => 'before',
			)
		);
		$this->add_control(
			'cart_icon',
			array(
				'label'            => __( 'Icon', 'deep' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default'          => array(
					'value'   => 'fas fa-shopping-cart',
					'library' => 'fa-solid',
				),
			)
		);

		$this->add_control(
			'icon_size',
			[
				'label'		=> __( 'Icon Size', 'deep' ),
				'type'		=> Controls_Manager::SLIDER,
				'selectors' => [
					$this->deep_base_selector . ' .onsale i ,'.
					$this->deep_base_selector . ' .onsale svg' => "font-size: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};"
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
			'cart_icon_pos',
			array(
				'label'   => __( 'Icon Position', 'deep' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'after',
				'options' => array(
					'before' => __( 'Before', 'deep' ),
					'after'  => __( 'After', 'deep' ),
				),
			)
		);
		$this->end_controls_section();

		$this->register_sale_badge_box_styles();
		$this->register_sale_badge_styles();
		$this->register_sale_badge_icon_styles();
	}

	/**
	 * Register Sale Badge Box Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_sale_badge_box_styles() {

		$group_id       = 'sales_badge_box_';
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
	 * Register Sale Badge Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_sale_badge_styles() {

		$group_id      = 'sales_badge_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Sale Badge', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .onsale';
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
	 * Register Sale Badge Icon Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_sale_badge_icon_styles() {

		$group_id      = 'sales_badge_icon_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Sale Badge Icon', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .onsale i ,'.
			$base_selector . ' .onsale svg';
		$hover_selector = $base_selector . ' .onsale i:hover,'.
			$base_selector . ' .onsale:hover svg';

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

			Templates::widget( 'sale-flash', $settings );
		}

		$this->reset_render();
	}
}
