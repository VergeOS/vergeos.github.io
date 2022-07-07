<?php
namespace Deep\WooCommerce\Elementor\Widgets\LoopBuilder;

use Deep\WooCommerce\Elementor\Deep_Loop_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Product Stock.
 *
 * @since 2.0.0
 */
class Stock extends Deep_Loop_Product_Widget_Base {

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}} .deep-woo-product-stock';

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
		return 'deep-woo-item-stock';
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
		return __( 'Loop Product Stock', 'deep' );
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
		return 'deep-widget deep-eicon-product-stock';
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
			'label',
			array(
				'type'        => Controls_Manager::TEXT,
				'label'       => __( 'Label', 'deep' ),
				'placeholder' => __( 'ex: Available:', 'deep' ),
			)
		);

		$this->deep_display(
			array(
				'selector' => $this->deep_base_selector . ' label ,' . $this->deep_base_selector . ' p',
			)
		);

		$this->add_control(
			'stock_value',
			array(
				'type'    => Controls_Manager::SELECT,
				'label'   => __( 'Stock Value', 'deep' ),
				'options' => array(
					'status'       => __( 'Status', 'deep' ),
					'stock'        => __( 'Stock', 'deep' ),
					'stock_status' => __( 'Stock and Status', 'deep' ),
				),
				'default' => 'status',
			)
		);

		$this->end_controls_section();

		$this->register_label_styles();
		$this->register_in_stock_styles();
		$this->register_out_of_stock_styles();
	}

	/**
	 * Register In Stock Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_label_styles() {

		$group_id      = 'label_stock_';
		$base_selector = $this->deep_base_selector . ' label';
		$section_label = __( 'Label', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = "$base_selector:hover";

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
	 * Register In Stock Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_in_stock_styles() {

		$group_id      = 'in_stock_';
		$base_selector = $this->deep_base_selector . ' p.in-stock';
		$section_label = __( 'In Stock', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = "$base_selector:hover";

		$default_margin = array(
			'top'    => 0,
			'bottom' => 0,
			'left'   => 0,
			'right'  => 0,
		);

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'text_align' => false,
			),
			$group_id . 'hover_typography' => array(
				'text_align' => false,
			),
			$group_id . 'margin'           => array(
				'default' => $default_margin,
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
	 * Register In Stock Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_out_of_stock_styles() {

		$group_id      = 'out_of_stock_';
		$base_selector = $this->deep_base_selector . ' p.out-of-stock';
		$section_label = __( 'Out of Stock', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = "$base_selector:hover";

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'text_align' => false,
			),
			$group_id . 'hover_typography' => array(
				'text_align' => false,
			),
			$group_id . 'color'            => array(
				'default' => '#FA0000',
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

		$this->prepare_render();

		if ( $this->can_display_item_product() ) {

			$settings = $this->get_settings_for_display();
			Templates::widget( 'product-stock', $settings );
		}

		$this->reset_render();
	}
}
