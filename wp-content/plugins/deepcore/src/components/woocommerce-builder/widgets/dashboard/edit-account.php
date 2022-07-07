<?php
namespace Deep\WooCommerce\Elementor\Widgets;

use Deep\WooCommerce\Elementor\Deep_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Dashboard Edit Account.
 *
 * @since 2.0.0
 */
class DashboardEditAccount extends Deep_Product_Widget_Base {

	public $deep_base_selector = '{{WRAPPER}} .deep-woo-edit-account-details';

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
		return 'deep-woo-dashboard-edit-account';
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
		return __( 'Dashboard Edit Account', 'deep' );
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
		return 'deep-widget deep-eicon-edit-account';
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
				'label'     => __( 'This widget displays the edit account form.', 'deep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		$this->register_edit_account_box_styles();
		$this->register_edit_account_labels_styles();
		$this->register_edit_account_inputs_styles();
		$this->register_edit_account_notes_styles();
		$this->register_edit_account_button_styles();
	}

	/**
	 * Register Edit Account Widget Box Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_edit_account_box_styles() {

		$group_id       = 'edit_account_box_';
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
	 * Register Edit Account Widget Labels Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_edit_account_labels_styles() {

		$group_id       = 'edit_account_labels_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Labels', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' p label';
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
	 * Register Edit Account Widget Inputs Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_edit_account_inputs_styles() {

		$group_id       = 'edit_account_inputs_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Inputs', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' p input';
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
	 * Register Edit Account Widget Notes Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_edit_account_notes_styles() {

		$group_id       = 'edit_account_notes_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Notes', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' p span em';
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
	 * Register Edit Account Widget Button Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_edit_account_button_styles() {

		$group_id       = 'edit_account_button_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Button', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' button';
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

		Templates::widget( 'dashboard-edit-account', array() );
	}
}
