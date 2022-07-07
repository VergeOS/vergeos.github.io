<?php
namespace Deep\WooCommerce\Elementor\Widgets\LoopBuilder;

use Deep\WooCommerce\Elementor\Deep_Loop_Product_Widget_Base;
use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Product Review.
 *
 * @since 2.0.0
 */
class Review extends Deep_Loop_Product_Widget_Base {

	/**
	 * @since 2.0.0
	 *
	 * @var string
	 */
	public $deep_base_selector = '{{WRAPPER}} .deep-woo-product-review';

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
		return 'deep-woo-item-review';
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
		return __( 'Loop Product Review', 'deep' );
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
		return 'deep-widget deep-eicon-product-review';
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
			'icon',
			array(
				'label' => __( 'Icon', 'deep' ),
				'type'  => Controls_Manager::ICONS,
			)
		);

		$this->add_control(
			'icon_size',
			[
				'label'		=> __( 'Icon Size', 'deep' ),
				'type'		=> Controls_Manager::SLIDER,
				'selectors' => [
					$this->deep_base_selector . ' i::before ,'.
					$this->deep_base_selector . ' svg' => "font-size: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};"
				],
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 200,
						'step' => 1,
					],
				],
			]
		);

		$this->end_controls_section();

		$this->register_box_style_controls();
		$this->review_icon_style_controls();
		$this->register_review_count_style_controls();
	}


	/**
	 * Register Box Style Controls
	 *
	 * @since 2.0.0
	 *
	 * @access Public
	 *
	 * @return void
	 */
	public function register_box_style_controls() {

		$group_id      = 'review_box_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Box', 'deep' );
		$description   = '';

		$selector       = $base_selector;
		$hover_selector = "$selector:hover";

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
	 * Register Review Count Style Controls
	 *
	 * @since 2.0.0
	 *
	 * @access Public
	 *
	 * @return void
	 */
	public function register_review_count_style_controls() {

		$group_id      = 'review_count_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Count', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' .review-count';
		$hover_selector = "$selector:hover";

		$padding_default = array(
			'top'      => '',
			'bottom'   => '',
			'left'     => 10,
			'right'    => 10,
			'isLinked' => true,
		);

		$rewrite_settings_fields = array(
			$group_id . 'padding'       => array(
				'default' => $padding_default,
			),
			$group_id . 'hover_padding' => array(
				'default' => $padding_default,
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
	 * Register Icon Style Controls
	 *
	 * @since 2.0.0
	 *
	 * @access Public
	 *
	 * @return void
	 */
	public function review_icon_style_controls() {

		$group_id      = 'review_icon_';
		$base_selector = $this->deep_base_selector;
		$section_label = __( 'Icon', 'deep' );
		$description   = '';

		$selector       = $base_selector . ' i::before ,'.
			$base_selector . ' svg';
		$hover_selector = $base_selector . ':hover i::before,'.
			$base_selector . ':hover svg';

		$rewrite_settings_fields = array(
			$group_id . 'typography'       => false,
			$group_id . 'hover_typography' => false,
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

		if ( $this->can_display_item_product() ) {

			$settings = $this->get_settings_for_display();
			Templates::widget( 'product-review', $settings );
		}

		$this->reset_render();
	}
}
