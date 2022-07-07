<?php
namespace Deep\WooCommerce\Elementor\Widgets\LoopBuilder;

use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;
use Deep\WooCommerce\Elementor\Deep_Loop_Product_Widget_Base;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Product Sku.
 *
 * @since 2.0.0
 */
class Sku extends Deep_Loop_Product_Widget_Base {

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
		return 'deep-woo-item-item-sku';
	}

	/**
	 * Retrieve the widget sku.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Loop Product Sku', 'deep' );
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
		return 'deep-widget deep-eicon-product-sku';
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
				'label'     => __( 'This widget displays the product Sku.', 'deep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		$this->register_sku_styles();
	}

	/**
	 * Register Sku Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_sku_styles() {

		$group_id      = 'sku_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Sku', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = "$base_selector:hover";

		$rewrite_settings_fields = array();

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

			Templates::widget( 'product-sku', $settings );
		}

		$this->reset_render();
	}
}
