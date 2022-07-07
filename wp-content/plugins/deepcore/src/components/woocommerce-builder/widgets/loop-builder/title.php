<?php
namespace Deep\WooCommerce\Elementor\Widgets\LoopBuilder;

use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;
use Deep\WooCommerce\Elementor\Deep_Loop_Product_Widget_Base;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Product Title.
 *
 * @since 2.0.0
 */
class Title extends Deep_Loop_Product_Widget_Base {

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}}';

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
		return 'deep-woo-item-title';
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
		return __( 'Loop Product Title', 'deep' );
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
		return 'deep-widget deep-eicon-product-title';
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
			'tag',
			array(
				'label'   => __( 'Title HTML Tag', 'deep' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h1',
				'options' => array(
					'h1' => __( 'h1', 'deep' ),
					'h2' => __( 'h2', 'deep' ),
					'h3' => __( 'h3', 'deep' ),
					'h4' => __( 'h4', 'deep' ),
					'h5' => __( 'h5', 'deep' ),
					'h6' => __( 'h6', 'deep' ),
					'p'  => __( 'p', 'deep' ),
				),
			)
		);

		$this->add_control(
			'link_to_product',
			array(
				'label'        => __( 'Link to Product', 'deep' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'link_target',
			array(
				'label'     => __( 'Title HTML Tag', 'deep' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '_self',
				'options'   => array(
					'_blank' => __( 'New Window', 'deep' ),
					'_self'  => __( 'Current Window', 'deep' ),
				),
				'condition' => array(
					'link_to_product' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->register_title_styles();
	}

	/**
	 * Register Title Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_title_styles() {

		$group_id      = 'product_title_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Title', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .product_title';
		$hover_selector = $base_selector . ' .product_title:hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'selector' => "$selector, $base_selector a",
			),
			$group_id . 'hover_typography' => array(
				'selector' => "$hover_selector, $base_selector a:hover",
			),

			$group_id . 'color'            => array(
				'selector' => "$selector, $base_selector a",
			),
			$group_id . 'hover_color'      => array(
				'selector' => "$hover_selector, $base_selector a:hover",
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

			Templates::widget( 'product-title', $settings );
		}

		$this->reset_render();
	}
}
