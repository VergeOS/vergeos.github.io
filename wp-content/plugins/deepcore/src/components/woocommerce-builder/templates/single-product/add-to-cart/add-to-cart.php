<?php
/**
 * Single Product Add To Cart
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) ) {
	return;
}

$post_type = $product->get_type();
define( 'ADD_TO_CART_ARGS', $args );
?>
<div class="deep-woo-add-to-cart product-<?php echo esc_attr( $post_type ); ?>">
	<?php
	switch ( $product->get_type() ) {
		case 'simple':
			woocommerce_simple_add_to_cart();
			break;

		case 'grouped':
			woocommerce_grouped_add_to_cart();
			break;

		case 'variable':
			woocommerce_variable_add_to_cart();
			break;

		case 'external':
			woocommerce_external_add_to_cart();
			break;
	}
	?>
</div>
