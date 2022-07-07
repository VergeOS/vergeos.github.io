<?php
namespace Deep\WooCommerce\Elementor\Widgets;

use Deep\WooCommerce\Elementor\Deep_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Product Images.
 *
 * @since 5.0.0
 */
class Image extends Deep_Product_Widget_Base {

	/**
	 * @since 5.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}} .deep-woo-images';

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
		return 'deep-woo-image';
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
		return __( 'Product Images', 'deep' );
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
		return 'deep-widget deep-eicon-product-thumbnail';
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
	 * Retrieve the list of styles the widget depended on.
	 *
	 * Used to set styles dependencies required to run the widget.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return array Widget styles dependencies.
	 */
	public function get_style_depends() {
		return array( 'deep-woo-image' );
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return array( 'deep-woo-image' );
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
			'zoom_effect',
			array(
				'label' => __( 'Zoom Effect', 'deep' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Enable', 'deep' ),
				'label_off' => __( 'Disable', 'deep' ),
				'return_value' => 'yes',
				'default' => '',
			)
		);

		$this->add_control(
			'direction',
			array(
				'label'   => __( 'Direction', 'deep' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => array(
					'vertical'   => __( 'Vertical', 'deep' ),
					'horizontal' => __( 'Horizontal', 'deep' ),
				),
			)
		);

		$this->add_control(
			'position',
			array(
				'label'     => __( 'Position', 'deep' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'left',
				'options'   => array(
					'left'  => __( 'Left', 'deep' ),
					'right' => __( 'Right', 'deep' ),
				),
				'condition' => array(
					'direction' => 'vertical',
				),
			)
		);

		$this->end_controls_section();

		$this->register_product_image_box_styles();
		$this->register_product_image_styles();
		$this->register_product_image_thumbnails_wrapper_styles();
		$this->register_product_image_thumbnails_styles();
	}

	/**
	 * Register Meta Controls for Styles
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function register_product_image_box_styles() {

		$group_id      = 'product_image_box_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Box', 'deep' );
		$description   = '';

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
	 * Register Meta Controls for Styles
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function register_product_image_styles() {

		$group_id      = 'product_image_';
		$base_selector = $this->deep_base_selector . ' .woocommerce-product-gallery__image img';
		$section_label = __( 'Product Image', 'deep' );
		$description   = '';

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
	 * Register Meta Controls for Styles
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function register_product_image_thumbnails_wrapper_styles() {
		$group_id      = 'product_image_thumbnails_wrapper_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Thumbnails Wrapper', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .woocommerce-product-gallery ol.flex-control-nav';
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
	 * Register Meta Controls for Styles
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function register_product_image_thumbnails_styles() {
		$group_id      = 'product_image_thumbnails_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Thumbnails', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .woocommerce-product-gallery ol.flex-control-nav li';
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
	 * Render the widget output on the frontend.
	 *
	 * @since 5.0.0
	 *
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$this->prepare_render();

		if ( $this->can_display_product() ) {
			Templates::widget( 'image', $settings );
		}

		$this->reset_render();
	}
}
