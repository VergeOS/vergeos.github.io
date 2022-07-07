<?php
/**
 * WooCommerce Cart.
 *
 * @since 5.0.0
 * @package Deep
 */

namespace Deep\Components\WooCommerce\Helper;

defined( 'ABSPATH' ) || exit;
/**
 * Cart class
 *
 * @version 1.0.0
 */
class Cart {

	/**
	 * Instance of this class.
	 *
	 * @access  public
	 * @var     Cart
	 */
	public static $instance;

	/**
	 * Provides access to a single instance of a module using the singleton pattern.
	 *
	 * @return  object
	 */
	public static function get_instance() {
		if ( self::$instance === null ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Add to cart button
	 *
	 * @param object $product
	 * @return HTML
	 */
	public function AddToCart( $product, $icon = '', $icon_position = 'after', $show_text = true, $custom_text = '' ) {
		if ( $product ) {
			$args = array(
				'quantity'   => isset( $_POST['quantity'] ) ? $_POST['quantity'] : 1,
				'class'      => implode(
					' ',
					array_filter(
						array(
							'button',
							'product_type_' . $product->get_type(),
							$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
							$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
						)
					)
				),
				'attributes' => array(
					'data-product_id'  => $product->get_id(),
					'data-product_sku' => $product->get_sku(),
					'aria-label'       => $product->add_to_cart_description(),
					'rel'              => 'nofollow',
				),
			);

			if ( isset( $args['attributes']['aria-label'] ) ) {
				$args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
			}

			if ( is_array( $icon ) && strpos( $icon['url'], '.svg' ) ) {
				$path = parse_url( $icon['url'], PHP_URL_PATH );
				$icon = '<i class="deep-svg-icon">' . file_get_contents( $_SERVER['DOCUMENT_ROOT'] . $path ) . '</i>';
			} else {
				$icon = $icon ? '<i class="' . esc_attr( $icon ) . '"></i>' : '';
			}

			$before = 'before' == $icon_position ? $icon : '';
			$after  = 'after' == $icon_position ? $icon : '';
			$text   = $show_text ? $product->add_to_cart_text() : '';
			$text   = ( '' !== $custom_text && $show_text ) ? $custom_text : $text;
			if ( 'variable' == $product->get_type() ) {
				echo apply_filters(
					'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
					sprintf(
						'<button type="submit" class="%s" %s>%s %s %s</button>',
						esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
						isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
						$before,
						esc_html( $text ),
						$after,
					),
					$product,
					$args
				);
			} else {
				echo apply_filters(
					'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
					sprintf(
						'<a href="%s" data-quantity="%s" class="%s" %s>%s %s %s</a>',
						esc_url( $product->add_to_cart_url() ),
						esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
						esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
						isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
						$before,
						esc_html( $text ),
						$after,
					),
					$product,
					$args
				);
			}
		}
	}
}

Cart::get_instance();
