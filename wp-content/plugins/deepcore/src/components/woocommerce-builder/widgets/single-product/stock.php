<?php
namespace Deep\WooCommerce\Elementor\Widgets;

use Deep\WooCommerce\Elementor\Deep_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce product Stock.
 *
 * @since 5.0.0
 */
class Stock extends Deep_Product_Widget_Base {

	/**
	 * @since 5.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}} .deep-woo-stock';

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
		return 'deep-woo-stock';
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
		return __( 'Product Stock', 'deep' );
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
		return 'deep-widget deep-eicon-product-stock';
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
		return array( 'Deep_Single_Product' );
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
			'icon',
			array(
				'label'   => __( 'Icon', 'deep' ),
				'type'    => Controls_Manager::ICONS,
				'default' => array(
					'value'   => 'fas fa-box-open',
					'library' => 'fa-solid',
				),
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

		$this->register_icon_styles();
		$this->register_label_styles();
		$this->register_in_stock_styles();
		$this->register_out_of_stock_styles();
	}

/**
	 * Register Icon Style Controls
	 *
	 * @since 5.0.0
	 *
	 * @access Public
	 *
	 * @return void
	 */
	public function register_icon_styles() {

		$group_id      = 'icon_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Icon', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .wn-stock-icon ,'
			. $base_selector . ' svg';
		$hover_selector = $base_selector . ' .wn-stock-icon:hover,'
			. $base_selector . ' svg:hover';

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
	 * Register In Stock Controls for Styles
	 *
	 * @since 5.0.0
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
	 * @since 5.0.0
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
	 * @since 5.0.0
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
	 * @since 5.0.0
	 *
	 * @access protected
	 */
	protected function render() {

		$this->prepare_render();

		if ( $this->can_display_product() ) {

			$settings = $this->get_settings_for_display();
			Templates::widget( 'stock', $settings );
		}

		$this->reset_render();
	}
}
