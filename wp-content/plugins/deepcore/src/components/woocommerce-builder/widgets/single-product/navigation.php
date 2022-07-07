<?php
namespace Deep\WooCommerce\Elementor\Widgets;

use Deep\WooCommerce\Elementor\Deep_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Product Navigation.
 *
 * @since 2.0.0
 */
class Navigation extends Deep_Product_Widget_Base {

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}} .deep-woo-navigation';

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
		return 'deep-woo-navigation';
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
		return __( 'Product Navigation', 'deep' );
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
		return 'deep-widget deep-eicon-product-navigation';
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
				'label'     => __( 'This widget displays the product navigation.', 'deep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		$this->register_navigation_styles();
		$this->register_navigation_next_styles();
		$this->register_navigation_prev_styles();
	}

	/**
	 * Register navigation Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_navigation_styles() {

		$group_id      = 'navigation';
		$base_selector = $this->deep_base_selector;
		$section_label = __( '‌Box', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = $base_selector . ':hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'selector' => "$selector a",
			),
			$group_id . 'hover_typography' => array(
				'selector' => "$selector:hover a",
			),

			$group_id . 'color'            => array(
				'selector' => "$selector a",
			),
			$group_id . 'hover_color'      => array(
				'selector' => "$selector:hover a",
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
	 * Register Prev Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_navigation_prev_styles() {

		$group_id      = 'navigation_prev';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Prev', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' a:first-child';
		$hover_selector = $base_selector . ' a:first-child:hover';

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
	 * Register Next Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_navigation_next_styles() {

		$group_id      = 'navigation_next';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Next', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' a:last-child';
		$hover_selector = $base_selector . ' a:last-child:hover';

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

		$settings               = $this->get_settings();
		$settings['product_id'] = $this->get_product_id();

		$this->prepare_render();

		if ( $this->can_display_product() ) {

			Templates::widget( 'navigation', $settings );
		}

		$this->reset_render();
	}
}
