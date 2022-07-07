<?php
namespace Deep\WooCommerce\Elementor\Widgets;

use Deep\WooCommerce\Elementor\Deep_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Addresses.
 *
 * @since 2.0.0
 */
class DashboardAddresses extends Deep_Product_Widget_Base {

	public $deep_base_selector = '{{WRAPPER}} .deep-woo-addresses';

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
		return 'deep-woo-dashboard-addresses';
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
		return __( 'WooCommerce Addresses', 'deep' );
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
		return 'deep-widget deep-eicon-addresses';
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
				'label'     => __( 'This widget displays the WooCommerce addresses.', 'deep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		$this->register_addresses_box_styles();
		$this->register_addresses_description_styles();
		$this->register_addresses_titles_styles();
		$this->register_addresses_add_address_styles();
		$this->register_addresses_addresses_styles();
	}

	/**
	 * Register Addresses Widget Box Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_addresses_box_styles() {

		$group_id       = 'addresses_box_';
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
	 * Register Addresses Widget Description Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_addresses_description_styles() {

		$group_id       = 'addresses_description_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Description', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' .addresses-widget-description';
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
	 * Register Addresses Widget Billing and Shipping Titles Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_addresses_titles_styles() {

		$group_id       = 'addresses_titles_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Titles', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' header h3';
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
	 * Register Addresses Widget Add Address buttons Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_addresses_add_address_styles() {

		$group_id       = 'addresses_add_address_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Add Address Button', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' header a';
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
	 * Register Addresses Widget Addresses Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_addresses_addresses_styles() {

		$group_id       = 'addresses_addresses_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Addresses', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' address';
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

		Templates::widget( 'dashboard-addresses', array() );
	}
}
