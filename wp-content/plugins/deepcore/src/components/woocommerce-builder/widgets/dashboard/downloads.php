<?php
namespace Deep\WooCommerce\Elementor\Widgets;

use Deep\WooCommerce\Elementor\Deep_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Dashboard Downloads.
 *
 * @since 2.0.0
 */
class DashboardDownloads extends Deep_Product_Widget_Base {

	public $deep_base_selector = '{{WRAPPER}} .deep-woo-downloads';

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
		return 'deep-woo-dashboard-downloads';
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
		return __( 'Dashboard Downloads', 'deep' );
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
		return 'deep-widget deep-eicon-downloads';
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
				'label'     => __( 'This widget displays the dashboard downloads.', 'deep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		$this->register_downloads_box_styles();
		$this->register_downloads_table_styles();
		$this->register_downloads_table_head_styles();
		$this->register_downloads_table_head_cels_styles();
		$this->register_downloads_table_body_styles();
		$this->register_downloads_table_rows_cels_styles();
		$this->register_downloads_product_name_styles();
		$this->register_downloads_available_downloads_styles();
		$this->register_downloads_expires_styles();
		$this->register_downloads_download_button_styles();

	}

	/**
	 * Register Downloads Widget Box Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_downloads_box_styles() {

		$group_id       = 'downloads_box_';
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
	 * Register Downloads Widget Tabel Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_downloads_table_styles() {

		$group_id       = 'downloads_table_';
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
	 * Register Downloads Widget Table Head Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_downloads_table_head_styles() {

		$group_id       = 'downloads_table_head_';
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
	 * Register Downloads Widget Table Head Cels Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_downloads_table_head_cels_styles() {

		$group_id       = 'downloads_table_head_cels_';
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
	 * Register Downloads Widget Table Body Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_downloads_table_body_styles() {

		$group_id       = 'downloads_table_body_';
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
	 * Register Downloads Widget Table Rows Cels Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_downloads_table_rows_cels_styles() {

		$group_id       = 'downloads_table_rows_cels_';
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
	 * Register Downloads Widget Product Name Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_downloads_product_name_styles() {

		$group_id       = 'downloads_product_name_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Product Name', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' table tbody tr td.download-product a';
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
	 * Register Downloads Widget Availabel Downloads Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_downloads_available_downloads_styles() {

		$group_id       = 'downloads_available_downloads_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Available Downloads', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' table tbody tr td.download-remaining';
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
	 * Register Downloads Widget Expire date Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_downloads_expires_styles() {

		$group_id       = 'downloads_expires_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Expire Date', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' table tbody tr td.download-expires';
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
	 * Register Downloads Widget Download Button Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_downloads_download_button_styles() {

		$group_id       = 'downloads_download_button_';
		$base_selector  = $this->deep_base_selector;
		$section_label  = __( 'Download Button', 'deep' );
		$description    = '';
		$selector       = $base_selector . ' table tbody tr td.download-file a';
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

		Templates::widget( 'dashboard-downloads', array() );
	}
}
