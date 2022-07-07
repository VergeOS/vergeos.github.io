<?php
namespace Deep\WooCommerce\Elementor\Widgets;

use Deep\WooCommerce\Elementor\Deep_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Product Meta.
 *
 * @since 2.0.0
 */
class Meta extends Deep_Product_Widget_Base {
	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}} .deep-woo-meta';

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
		return 'deep-woo-meta';
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
		return __( 'Product Meta', 'deep' );
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
		return 'deep-widget deep-eicon-product-meta';
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
	 * Retrieve the list of styles the widget depended on.
	 *
	 * Used to set styles dependencies required to run the widget.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 *
	 * @return array Widget styles dependencies.
	 */
	public function get_style_depends() {

		return array( 'deep-woo-meta' );
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
			'show_sku',
			array(
				'label'        => __( 'Show SKU', 'deep' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'deep' ),
				'label_off'    => __( 'Hide', 'deep' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'sku_label',
			array(
				'label'     => __( 'SKU label', 'deep' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'SKU:', 'deep' ),
				'condition' => array(
					'show_sku' => 'yes',
				),
			)
		);

		$this->add_control(
			'sku_hr',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'show_category',
			array(
				'label'        => __( 'Show Category', 'deep' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'deep' ),
				'label_off'    => __( 'Hide', 'deep' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'category_label',
			array(
				'label'     => __( 'Category label', 'deep' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Category:', 'deep' ),
				'condition' => array(
					'show_category' => 'yes',
				),
			)
		);

		$this->add_control(
			'category_hr',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_control(
			'show_tag',
			array(
				'label'        => __( 'Show Tag', 'deep' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Show', 'deep' ),
				'label_off'    => __( 'Hide', 'deep' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'tag_label',
			array(
				'label'     => __( 'Tag label', 'deep' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Tag:', 'deep' ),
				'condition' => array(
					'show_tag' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->register_meta_styles();
		$this->register_meta_items_styles();
		$this->register_labels_styles();
		$this->register_values_styles();
		$this->register_links_styles();
	}

	/**
	 * Register Meta Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_meta_styles() {

		$group_id      = 'meta_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Box', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = $base_selector . ':hover';

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
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_meta_items_styles() {

		$group_id      = 'items_';
		$base_selector = $this->deep_base_selector . ' > div';
		$section_label = __( 'Items', 'deep' );
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
	 * Register Meta Labels Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_labels_styles() {

		$group_id      = 'labels_';
		$base_selector = $this->deep_base_selector . ' .deep-label';
		$section_label = __( 'Labels', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = $base_selector . ':hover';

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
	 * Register Meta Values Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_values_styles() {

		$group_id      = 'values_';
		$base_selector = $this->deep_base_selector . ' .deep-value';
		$section_label = __( 'Values', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = $base_selector . ':hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'selector' => "$selector, $selector a",
			),
			$group_id . 'hover_typography' => array(
				'selector' => "$selector:hover, $selector:hover a",
			),

			$group_id . 'color'            => array(
				'selector' => "$selector, $selector a",
			),
			$group_id . 'hover_color'      => array(
				'selector' => "$selector:hover, $selector:hover a",
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
	 * Register Meta Value Controls for Styles
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function register_links_styles() {

		$group_id      = 'links_';
		$base_selector = $this->deep_base_selector . ' .deep-value';
		$section_label = __( 'Links', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = $base_selector . ':hover';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => array(
				'selector' => "$selector a",
			),
			$group_id . 'hover_typography' => array(
				'selector' => "$selector a:hover",
			),

			$group_id . 'color'            => array(
				'selector' => "$selector a",
			),
			$group_id . 'hover_color'      => array(
				'selector' => "$selector a:hover",
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

		if ( $this->can_display_product() ) {

			Templates::widget( 'meta', $settings );
		}

		$this->reset_render();
	}
}
