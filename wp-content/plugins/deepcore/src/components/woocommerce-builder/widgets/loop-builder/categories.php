<?php
namespace Deep\WooCommerce\Elementor\Widgets\LoopBuilder;

use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;
use Deep\WooCommerce\Elementor\Deep_Loop_Product_Widget_Base;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Product Categories.
 *
 * @since 2.0.0
 */
class Categories extends Deep_Loop_Product_Widget_Base {

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}} .deep-woo-product-cats';

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
		return 'deep-woo-item-categories';
	}

	/**
	 * Retrieve the widget categories.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget categories.
	 */
	public function get_title() {
		return __( 'Loop Product Categories', 'deep' );
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
		return 'deep-widget deep-eicon-product-categories';
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
				'label'     => __( 'This widget displays the product categories.', 'deep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->add_control(
			'separator',
			array(
				'label'   => __( 'separator', 'deep' ),
				'type'    => Controls_Manager::TEXT,
				'default' => '|',
			)
		);
		$this->end_controls_section();

		$this->register_box_styles();
		$this->register_categories_styles();
		$this->register_separator_styles();
	}

	/**
	 * Register box Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_box_styles() {

		$group_id      = 'loop_box_categories_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Box', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = $base_selector;

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'selector' => "$selector, $selector a",
			),
			$group_id . 'hover_typography' => array(
				'selector' => "$hover_selector, $selector a:hover",
			),

			$group_id . 'color'            => array(
				'selector' => "$selector, $selector a",
			),
			$group_id . 'hover_color'      => array(
				'selector' => "$hover_selector, $selector a:hover",
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
	 * Register Categories Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_categories_styles() {

		$group_id      = 'loop_categories_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Categories', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' a';
		$hover_selector = $base_selector . ' a:hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'text_align' => false,
			),
			$group_id . 'hover_typography' => array(
				'text_align' => false,
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
	 * Register Separator Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_separator_styles() {

		$group_id      = 'loop_categories_separator_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Separator', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .separator';
		$hover_selector = "$selector .separator:hover";

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

			Templates::widget( 'product-categories', $settings );
		}

		$this->reset_render();
	}
}
