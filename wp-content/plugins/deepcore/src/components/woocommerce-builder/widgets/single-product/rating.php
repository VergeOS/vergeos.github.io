<?php
namespace Deep\WooCommerce\Elementor\Widgets;

use Deep\WooCommerce\Elementor\Deep_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce product Rating.
 *
 * @since 2.0.0
 */
class Rating extends Deep_Product_Widget_Base {

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}} .deep-woo-product-rating';

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
		return 'deep-woo-rating';
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
		return __( 'Product Rating', 'deep' );
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
		return 'deep-widget deep-eicon-product-rating';
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
				'label'     => __( 'This widget displays the product rating.', 'deep' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->end_controls_section();

		$this->register_product_rating_box_styles();
		$this->register_product_rating_stars_wrapper_styles();
		$this->register_product_rating_empty_stars_styles();
		$this->register_product_rating_filled_stars_styles();
	}

	/**
	 * Register Rating Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_product_rating_box_styles() {
		$group_id      = 'product_rating_box_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Box', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = "$selector:hover";

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
	 * Register Rating Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_product_rating_stars_wrapper_styles() {
		$group_id      = 'product_rating_stars_wrapper_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Stars Wrapper', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .star-rating';
		$hover_selector = "$selector:hover";

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
	 * Register Rating Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_product_rating_empty_stars_styles() {
		$group_id      = 'product_rating_empty_stars_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Empty Stars', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .star-rating:before';
		$hover_selector = "$selector:hover";

		$rewrite_settings_fields = array(
			$group_id . 'typography'          => false,
			$group_id . 'hover_typography'    => false,
			$group_id . 'margin'              => false,
			$group_id . 'hover_margin'        => false,
			$group_id . 'padding'             => false,
			$group_id . 'hover_padding'       => false,
			$group_id . 'background'          => false,
			$group_id . 'hover_background'    => false,
			$group_id . 'border'              => false,
			$group_id . 'hover_border'        => false,
			$group_id . 'border-radius'       => false,
			$group_id . 'hover_border-radius' => false,
			$group_id . 'box_shadow'          => false,
			$group_id . 'hover_box_shadow'    => false,
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
	 * Register Rating Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_product_rating_filled_stars_styles() {
		$group_id      = 'product_rating_filled_stars_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Filled Stars', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .star-rating span:before';
		$hover_selector = "$selector:hover";

		$rewrite_settings_fields = array(
			$group_id . 'typography'          => false,
			$group_id . 'hover_typography'    => false,
			$group_id . 'margin'              => false,
			$group_id . 'hover_margin'        => false,
			$group_id . 'padding'             => false,
			$group_id . 'hover_padding'       => false,
			$group_id . 'background'          => false,
			$group_id . 'hover_background'    => false,
			$group_id . 'border'              => false,
			$group_id . 'hover_border'        => false,
			$group_id . 'border-radius'       => false,
			$group_id . 'hover_border-radius' => false,
			$group_id . 'box_shadow'          => false,
			$group_id . 'hover_box_shadow'    => false,
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

		$this->prepare_render();

		if ( $this->can_display_product() ) {

			Templates::widget( 'rating', array() );
		}

		$this->reset_render();
	}
}
