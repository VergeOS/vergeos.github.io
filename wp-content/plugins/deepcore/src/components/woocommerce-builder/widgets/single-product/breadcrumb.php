<?php
namespace Deep\WooCommerce\Elementor\Widgets;

use Deep\WooCommerce\Elementor\Deep_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce product Breadcrumb.
 *
 * @since 2.0.0
 */
class Breadcrumb extends Deep_Product_Widget_Base {

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}} .deep-woo-breadcrumbs';

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
		return 'deep-woo-breadcrumb';
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
		return __( 'Product Breadcrumb', 'deep' );
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
		return 'deep-widget deep-eicon-product-breadcrumbs';
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
				'label'     => __( 'This widget displays the product breadcrumb.', 'deep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		$this->register_breadcrumb_styles();
		$this->register_breadcrumb_links_styles();
		$this->register_breadcrumb_icons_styles();
	}

	/**
	 * Register Breadcrumb Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_breadcrumb_styles() {

		$group_id      = 'breadcrumb_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Breadcrumb', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' nav';
		$hover_selector = $base_selector . ' nav:hover';

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
	 * Register Breadcrumb Links Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_breadcrumb_links_styles() {

		$group_id      = 'breadcrumb_links';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Breadcrumb Links', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' nav a';
		$hover_selector = $base_selector . ' nav a:hover';

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
	 * Register Breadcrumb Links Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_breadcrumb_icons_styles() {

		$group_id      = 'breadcrumb_icons';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Breadcrumb Icons', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' nav i::before';
		$hover_selector = $base_selector . ' nav i::before:hover';

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

		$this->prepare_render();

		if ( $this->can_display_product() ) {

			Templates::widget( 'breadcrumb', array() );
		}

		$this->reset_render();
	}
}
