<?php
/**
 * Add to Cart
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$icon = isset( $args['icon'] ) ? $args['icon'] : '';
$icon_position = isset( $args['icon_position'] ) ? $args['icon_position'] : '';
$hide_text = isset( $args['hide_text'] ) ? $args['hide_text'] : '';
$show_text = ! $hide_text;

if ( ! class_exists( 'Deep\Components\WooCommerce\Helper\Cart' ) ) {
	require_once Deep\Components\WooCommerce::$dir . 'src/helper/class-cart-helper.php';
}

?>
<div class="deep-woo-product-add-to-cart">
	<?php Deep\Components\WooCommerce\Helper\Cart::get_instance()->AddToCart( $product, $icon, $icon_position, $show_text ); ?>
</div>
