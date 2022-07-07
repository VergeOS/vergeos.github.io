<?php
namespace Deep\WooCommerce\Elementor\Widgets;

defined( 'ABSPATH' ) || exit;

use Deep\WooCommerce\Elementor\Deep_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

/**
 * Elementor widget for WooCommerce product Add To Cart.
 *
 * @since 5.0.0
 */
class AddToCart extends Deep_Product_Widget_Base {

	/**
	 * @since 5.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}} .deep-woo-add-to-cart';

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
		return 'deep-woo-add-to-cart';
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
		return __( 'Product Add To Cart', 'deep' );
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
		return 'deep-widget deep-eicon-add-to-cart';
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
		return array( 'deep-woo-add-to-cart', 'thwvsf-public-style' );
	}


	/**
	 * Load depend scripts.
	 *
	 * @since 5.0.0
	 *
	 * @access protected
	 */
	public function get_script_depends() {
		return array( 'deep-woo-add-to-cart', 'thwvsf-public-script' );
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

		$this->deep_display(
			array(
				'name'     => 'display_stock',
				'label'    => __( 'Display stock', 'deep' ),
				'selector' => $this->deep_base_selector . ' .stock',
				'options'  => array(
					''             => __( 'Default', 'deep' ),
					'inherit'      => __( 'Inherit', 'deep' ),
					'inline'       => __( 'inline', 'deep' ),
					'inline-block' => __( 'inline block', 'deep' ),
					'block'        => __( 'block', 'deep' ),
					'none'         => __( 'none', 'deep' ),
				),
			)
		);

		$this->deep_display(
			array(
				'name'     => 'display_button',
				'label'    => __( 'Display Quantity', 'deep' ),
				'selector' => $this->deep_base_selector . ' form .quantity',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button',
			array(
				'label' => __( 'Button', 'deep' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'text_align',
			array(
				'label'     => __( 'Alignment', 'deep' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'left',
				'toggle'    => true,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'deep' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'deep' ),
						'icon'  => 'fa fa-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'deep' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .deep-woo-add-to-cart' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'hide_text',
			array(
				'type'      => Controls_Manager::SWITCHER,
				'label'     => __( 'Hide Text', 'deep' ),
				'label_on'  => __( 'Hide', 'deep' ),
				'label_off' => __( 'Show', 'deep' ),
			)
		);

		$this->add_control(
			'add_to_cart_text',
			array(
				'label'   => __( 'Add to cart text', 'deep' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Add to cart', 'deep' ),
			)
		);

		$this->add_control(
			'cart_icon',
			array(
				'label'            => __( 'Icon', 'deep' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'default'          => array(
					'value'   => 'fas fa-shopping-cart',
					'library' => 'fa-solid',
				),
			)
		);

		$this->add_control(
			'icon_size',
			array(
				'label'      => __( 'Icon Size', 'deep' ),
				'type'       => Controls_Manager::SLIDER,
				'selectors'  => array(
					$this->deep_base_selector . ' .button i ,' .
					$this->deep_base_selector . ' .button svg' => 'font-size: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};',
				),
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 200,
						'step' => 1,
					),
				),
			)
		);

		$this->add_control(
			'cart_icon_pos',
			array(
				'label'   => __( 'Icon Position', 'deep' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'after',
				'options' => array(
					'before' => __( 'Before', 'deep' ),
					'after'  => __( 'After', 'deep' ),
				),
			)
		);

		$this->end_controls_section();

		$this->register_add_to_cart_styles();
		$this->register_qty_wrapper_styles();
		$this->register_add_to_cart_input_styles();
		$this->register_variation_lables_styles();
		$this->register_add_to_cart_button_styles();
	}

	/**
	 * Register Add to Cart Controls for Styles
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function register_qty_wrapper_styles() {

		$group_id      = 'qty_wrapper';
		$base_selector = $this->deep_base_selector . ' span.deep-woo-add-to-cart';
		$section_label = __( 'Qty Wrapper', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = $base_selector . ':hover';

		$default_margin = array(
			'top'    => 0,
			'bottom' => 0,
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
	 * Register Add to Cart Controls for Styles
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function register_add_to_cart_styles() {

		$group_id      = 'add_to_cart';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Add to cart', 'deep' );
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
	 * Register Add to Cart Input Controls for Styles
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function register_add_to_cart_input_styles() {

		$group_id      = 'add_to_cart_input';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Add to cart input', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' input';
		$hover_selector = $base_selector . ' input:hover';

		$default_margin          = array(
			'top'    => 5,
			'bottom' => 5,
			'left'   => 0,
			'right'  => 0,
		);
		$rewrite_settings_fields = array(
			$group_id . 'margin'       => array(
				'default' => $default_margin,
			),
			$group_id . 'hover_margin' => array(
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
	 * Register Add to Cart Variations label Controls for Styles
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function register_variation_lables_styles() {

		$group_id      = 'add_to_cart_variation_labels';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Product Variations Label', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .variations td label';
		$hover_selector = $base_selector . ' .variations td label:hover';

		$default_margin          = array(
			'top'    => 0,
			'bottom' => 0,
			'left'   => 0,
			'right'  => 0,
		);
		$rewrite_settings_fields = array(
			$group_id . 'margin'       => array(
				'default' => $default_margin,
			),
			$group_id . 'hover_margin' => array(
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
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function register_add_to_cart_button_styles() {

		$group_id      = 'add_to_cart_button';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Add to cart button', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' a,';
		$selector       .= $base_selector . ' button';
		$hover_selector = $base_selector . ' a:hover,';
		$hover_selector .= $base_selector . ' button:hover';

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
	 * @since 5.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		add_action( 'woocommerce_product_single_add_to_cart_text', array( $this, 'get_add_to_cart_text' ), 999 );
		$this->prepare_render();
		if ( $this->can_display_product() ) {

			Templates::widget( 'add-to-cart', $settings );
		}
		$this->reset_render();
		remove_action( 'woocommerce_product_single_add_to_cart_text', array( $this, 'get_add_to_cart_text' ) );
	}

	/**
	 * Return add to cart text
	 *
	 * @since 5.0.0
	 *
	 * @access public
	 */
	public function get_add_to_cart_text( $btn_text ) {

		$settings  = $this->get_settings_for_display();
		$hide_text = 'yes' === $settings['hide_text'];

		return ! $hide_text ? $btn_text : '';
	}
}
