<?php
namespace Deep\WooCommerce\Elementor\Widgets;

use Deep\WooCommerce\Elementor\Deep_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce product Attributes.
 *
 * @since 2.0.0
 */
class Attributes extends Deep_Product_Widget_Base {

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}} .deep-woo-attributes';

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
		return 'deep-woo-Attributes';
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
		return __( 'Product Attributes', 'deep' );
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
		return 'deep-widget deep-eicon-product-attributes';
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
		return array( 'Deep_Single_Product' );
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
				'label'     => __( 'This widget displays the product attributes.', 'deep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		$this->register_table_styles();
		$this->register_table_rows_styles();
		$this->register_table_cells_styles();

		$this->register_attributes_styles();
		$this->register_label_styles();
		$this->register_value_styles();


	}

	/**
	 * Register Attributes Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_attributes_styles() {

		$group_id      = 'attributes_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Box', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = $base_selector . ':hover';

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
	 * Register Attributes Label Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_label_styles() {

		$group_id      = 'label_';
		$base_selector = $this->deep_base_selector . ' .woocommerce-product-attributes-item__label';
		$section_label = __( 'Label', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = $base_selector . ':hover';

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
	 * Register Attributes Value Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_value_styles() {

		$group_id      = 'value_';
		$base_selector = $this->deep_base_selector . ' .woocommerce-product-attributes-item__value';
		$section_label = __( 'Value', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = $base_selector . ':hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'selector' => "$selector, $selector p",
			),
			$group_id . 'hover_typography' => array(
				'selector' => "$selector, $selector:hover p",
			),

			$group_id . 'color'            => array(
				'selector' => "$selector, $selector p",
			),
			$group_id . 'hover_color'      => array(
				'selector' => "$selector, $selector:hover p",
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
	 * Register Table Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_table_styles(){

		$group_id		= 'table_';
		$base_selector	= $this->deep_base_selector;
		$section_label	= __( 'Table', 'deep' );
		$description	= '';
		$selector		= $base_selector . ' table';
		$hover_selector = $selector . ':hover';

		$rewrite_settings_fields = [
			$group_id . 'display_table' => [
				'type' => 'display_table',
			],
			$group_id . 'typography' => false,
			$group_id . 'hover_typography' => false,
			$group_id . 'color' => false,
			$group_id . 'hover_color' => false,
		];

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
	 * Register Table Rows Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_table_rows_styles() {

		$group_id      = 'deep_table_rows_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Table Rows', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' table tbody tr';
		$hover_selector = "$base_selector:hover";

		$rewrite_settings_fields = array(
			$group_id . 'margin'           => false,
			$group_id . 'hover_margin'     => false,

			$group_id . 'padding'           => false,
			$group_id . 'hover_padding'     => false,

			$group_id . 'padding'           => false,
			$group_id . 'hover_padding'     => false,

			$group_id . 'box_shadow'       => false,
			$group_id . 'hover_box_shadow' => false,
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
	 * Register Table Cells Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_table_cells_styles() {

		$group_id      = 'deep_table_cells_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Table Cells', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' table tbody tr th,'.
			$base_selector . ' table tbody tr td';
		$hover_selector = $base_selector . ' table tbody tr th:hover,'.
			$base_selector . ' table tbody tr td:hover';

		$rewrite_settings_fields = array(
			$group_id . 'margin'           => false,
			$group_id . 'hover_margin'     => false,

			$group_id . 'box_shadow'       => false,
			$group_id . 'hover_box_shadow' => false,
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

		$this->prepare_render();

		if ( $this->can_display_product() ) {

			Templates::widget( 'attributes', array() );
		}

		$this->reset_render();
	}
}
