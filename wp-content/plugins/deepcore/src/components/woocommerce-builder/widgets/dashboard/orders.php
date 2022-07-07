<?php
namespace Deep\WooCommerce\Elementor\Widgets;

use Deep\WooCommerce\Elementor\Deep_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Dashboard Orders.
 *
 * @since 2.0.0
 */
class DashboardOrders extends Deep_Product_Widget_Base {

	public $deep_base_selector = '{{WRAPPER}} .deep-woo-orders';

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
		return 'deep-woo-dashboard-orders';
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
		return __( 'Dashboard Orders', 'deep' );
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
		return 'deep-widget deep-eicon-orders';
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
		return array( 'Deep_Dashboard' );
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
				'label'     => __( 'This widget displays the dashboard orders.', 'deep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		$this->register_orders_box_styles();
		$this->register_orders_table_styles();
		$this->register_orders_table_head_styles();
		$this->register_orders_table_head_cels_styles();
		$this->register_orders_table_body_styles();
		$this->register_orders_table_rows_cels_styles();
		$this->register_orders_view_button_styles();

	}

	/**
	 * Register Orders Widget Box Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_orders_box_styles() {

		$group_id       = 'order_box_';
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
	 * Register Orders Widget Tabel Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_orders_table_styles() {

		$group_id       = 'orders_table_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Table', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' table';
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
	 * Register Orders Widget Table Head Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_orders_table_head_styles() {

		$group_id       = 'orders_table_head_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Table Head', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' table thead';
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
	 * Register Orders Widget Table Head Cels Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_orders_table_head_cels_styles() {

		$group_id       = 'orders_table_head_cels_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Head Cels', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' table thead tr th';
		$hover_selector = $selector . ':hover';

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
	 * Register Orders Widget Table Body Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_orders_table_body_styles() {

		$group_id       = 'orders_table_body_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Table Body', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' table tbody';
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
	 * Register Orders Widget Table Rows Cels Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_orders_table_rows_cels_styles() {

		$group_id       = 'orders_table_rows_cels_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Row Cels', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' table tbody tr td';
		$hover_selector = $selector . ':hover';

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
	 * Register Orders Widget View Button Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_orders_view_button_styles() {

		$group_id       = 'orders_view_button_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'View Button', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' table tbody tr td.woocommerce-orders-table__cell-order-actions a';
		$hover_selector = $selector . ':hover';

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

		Templates::widget( 'dashboard-order', array() );
	}
}
