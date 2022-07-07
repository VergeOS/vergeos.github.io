<?php
namespace Deep\WooCommerce\Elementor\Widgets\LoopBuilder;

use Deep\WooCommerce\Elementor\Deep_Loop_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce product Add To Cart.
 *
 * @since 2.0.0
 */
class AddToCart extends Deep_Loop_Product_Widget_Base {

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}} .deep-woo-product-add-to-cart';

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
		return 'deep-woo-product-add-to-cart';
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
		return __( 'Loop Product Add To Cart', 'deep' );
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
		return 'deep-widget deep-eicon-add-to-cart';
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
			'hide_text',
			[
				'type'     => Controls_Manager::SWITCHER,
				'label'     => __( 'Hide Text', 'deep' ),
				'label_on'     => __( 'Hide', 'deep' ),
				'label_off'     => __( 'Show', 'deep' ),
			]
		);

		$this->add_control(
			'icon',
			array(
				'label'   => __( 'Icon', 'deep' ),
				'type'    => Controls_Manager::ICON,
			)
		);

		$this->add_control(
			'icon_position',
			array(
				'label'   => __( 'Icon Position', 'deep' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '',
				'options' => array(
					''       => __( 'None', 'deep' ),
					'before' => __( 'Before', 'deep' ),
					'after'  => __( 'After', 'deep' ),
				),
			)
		);

		$this->end_controls_section();

		$this->register_box_styles();
		$this->register_add_to_cart_button_styles();
		$this->register_view_cart_styles();
		$this->register_read_more_button_styles();
	}

	/**
	 * Register Box Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_box_styles() {

		$group_id      = 'add_to_cart_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Box', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = $base_selector . ':hover';

		$default_margin = array(
			'top'    => 5,
			'bottom' => 5,
			'left'   => 0,
			'right'  => 0,
		);

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => false,
			$group_id . 'hover_typography' => false,

			$group_id . 'color'            => false,
			$group_id . 'hover_color'      => false,

			$group_id . 'margin'           => array(
				'default' => $default_margin,
			),
			$group_id . 'hover_margin'     => array(
				'default' => $default_margin,
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
	 * Register Add to Cart Button Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_add_to_cart_button_styles() {

		$group_id      = 'add_to_cart_button_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Add to cart button', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .button.add_to_cart_button';
		$hover_selector = $base_selector . ' .button.add_to_cart_button:hover';

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
	 * Register Read More Button Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_view_cart_styles() {

		$group_id      = 'view_cart_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'View Cart', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .added_to_cart';
		$hover_selector = $base_selector . ' .added_to_cart:hover';

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
	 * Register Read More Button Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_read_more_button_styles() {

		$group_id      = 'read_more_button_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Read More button', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .button';
		$hover_selector = $base_selector . ' .button:hover';

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
		if ( $this->can_display_item_product() ) {

			$settings = $this->get_settings_for_display();
			Templates::widget( 'product-add-to-cart', $settings );
		}
		$this->reset_render();
	}
}
