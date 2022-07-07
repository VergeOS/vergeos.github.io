<?php
namespace Deep\WooCommerce\Elementor\Widgets;

use Deep\WooCommerce\Elementor\Deep_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Dashboard.
 *
 * @since 2.0.0
 */
class Dashboard extends Deep_Product_Widget_Base {

	public $deep_base_selector = '{{WRAPPER}} .deep-woo-dashboard';

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
		return 'deep-woo-dashboard';
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
		return __( 'WooCommerce Dashboard', 'deep' );
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
		return 'deep-widget deep-eicon-dashboard';
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
				'label'     => __( 'This widget displays the WooCommerce dashboard.', 'deep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->end_controls_section();
		$this->register_dashboard_box_styles();
		$this->register_dashboard_paragraphs_styles();
		$this->register_dashboard_names_styles();
		$this->register_dashboard_links_styles();
	}

	/**
	 * Register Dashboard Widget Box Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_dashboard_box_styles() {

		$group_id       = 'dashboard_box_';
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
	 * Register Dashboard Widget Paragraphs Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_dashboard_paragraphs_styles() {

		$group_id       = 'dashboard_paragraphs_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Paragraphs', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' p';
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
	 * Register Dashboard Widget Names Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_dashboard_names_styles() {

		$group_id       = 'dashboard_names_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Names', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' p strong';
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
	 * Register Dashboard Widget Links Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_dashboard_links_styles() {

		$group_id       = 'dashboard_links_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'links', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' p a';
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
	 * @access protected
	 */
	protected function render() {

		Templates::widget( 'dashboard', array() );
	}
}
