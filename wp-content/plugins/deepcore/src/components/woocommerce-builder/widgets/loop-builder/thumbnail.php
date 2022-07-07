<?php
namespace Deep\WooCommerce\Elementor\Widgets\LoopBuilder;

use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;
use Deep\WooCommerce\Elementor\Deep_Loop_Product_Widget_Base;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Product Thumbnail.
 *
 * @since 2.0.0
 */
class Thumbnail extends Deep_Loop_Product_Widget_Base {

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}}';

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
		return 'deep-woo-item-thumbnail';
	}

	/**
	 * Retrieve the widget thumbnail.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return string Widget thumbnail.
	 */
	public function get_title() {
		return __( 'Loop Product Thumbnail', 'deep' );
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
		return 'deep-widget deep-eicon-product-thumbnail';
	}

	/**
	 * Retrieve the list of thumbnail the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return array Widget thumbnail.
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
			'description',
			array(
				'label'     => __( 'This widget displays the product thumbnail.', 'deep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);
		$this->end_controls_section();

		$this->register_image_styles();
	}

	/**
	 * Register Image Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_image_styles() {

		$group_id      = 'product_thumbnail_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Thumbnail', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' img';
		$hover_selector = $base_selector . ' img:hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'        => false,
			$group_id . 'hover_typography'  => false,

			$group_id . 'color'             => false,
			$group_id . 'hover_color'       => false,

			$group_id . 'image_width'       => array(
				'selector' => $selector,
				'type'     => 'image_width',
			),
			$group_id . 'hover_image_width' => array(
				'selector' => $hover_selector,
				'type'     => 'image_width',
			),

			$group_id . 'max_width'         => array(
				'selector' => $selector,
				'type'     => 'max_width',
			),
			$group_id . 'hover_max_width'   => array(
				'selector' => $hover_selector,
				'type'     => 'max_width',
			),

			$group_id . 'max_height'        => array(
				'selector' => $selector,
				'type'     => 'max_height',
			),
			$group_id . 'hover_max_height'  => array(
				'selector' => $hover_selector,
				'type'     => 'max_height',
			),

			$group_id . 'opacity'           => array(
				'selector' => $selector,
				'type'     => 'opacity',
			),
			$group_id . 'hover_opacity'     => array(
				'selector' => $hover_selector,
				'type'     => 'opacity',
			),

			$group_id . 'css_filter'        => array(
				'selector' => $selector,
				'type'     => 'css_filter',
			),
			$group_id . 'hover_css_filter'  => array(
				'selector' => $hover_selector,
				'type'     => 'css_filter',
			),

			$group_id . 'hover_transition'  => array(
				'selector' => $hover_selector,
				'type'     => 'transition',
			),

			$group_id . 'hover_animation'   => array(
				'selector' => $selector,
				'type'     => 'hover_animation',
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

		$settings = $this->get_settings_for_display();

		$this->prepare_render();

		if ( $this->can_display_item_product() ) {

			Templates::widget( 'product-thumbnail', $settings );
		}

		$this->reset_render();
	}
}
