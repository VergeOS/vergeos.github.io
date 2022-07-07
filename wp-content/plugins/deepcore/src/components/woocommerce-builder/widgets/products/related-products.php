<?php

namespace Deep\WooCommerce\Elementor\Widgets\Products_Loop;

use Elementor\Controls_Manager;
use Deep\Components\WooCommerce\Templates;

defined( 'ABSPATH' ) || exit;

/**
 * Elementor widget for WooCommerce Related Products.
 *
 * @since 2.0.0
 */
class Related_Products extends Products_Loop {

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
		return 'deep-woo-related-products';
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
		return __( 'Related Products', 'deep' );
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
		return 'deep-widget deep-eicon-related-products';
	}

	/**
	 * Render CSS file.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function get_style_depends() {
		return array( 'deep-pagination' );
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * @since 2.0.0
	 *
	 * @access public
	 */
	public function render() {

		$this->prepare_render();

		parent::render();

		$this->reset_render();
	}

	/**
	 * Get Default Query Args and Attributes
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array
	 */
	public function get_default_query_attributes() {

		$atts = parent::get_default_query_attributes();

		$atts['limit']   = 4;
		$atts['columns'] = 4;

		return $atts;
	}

	/**
	 * Add Attributes from Settings
	 *
	 * @param array $atts
	 * @param array $settings
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array
	 */
	public function parse_attributes( $atts, $settings ) {

		$atts = parent::parse_attributes( $atts, $settings );

		return $atts;
	}

	/**
	 * Prepare Query Args
	 *
	 * @param array  $query_args
	 * @param array  $attributes
	 * @param string $type
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array
	 */
	public function prepare_query_args( $query_args, $attributes, $type ) {

		if ( false === strpos( $type, 'deep-woo-' ) ) {

			return $query_args;
		}

		$query_args = parent::prepare_query_args( $query_args, $attributes, $type );

		$p_id       = isset( $query_args['p'] ) ? $query_args['p'] : '';
		$q_post__in = isset( $query_args['post__in'] ) ? $query_args['post__in'] : '';
		$q_post__in = empty( $post__in ) && ! empty( $p_id ) ? array( $p_id ) : $q_post__in;

		if ( empty( $q_post__in ) ) {

			$product_id       = get_the_ID();
			$related_products = wc_get_related_products( $product_id, -1 );
			$post__in         = $related_products;
		} else {

			$post__in = $q_post__in;
		}
		$query_args['p']        = '';
		$query_args['post__in'] = $post__in;

		return $query_args;
	}
}

