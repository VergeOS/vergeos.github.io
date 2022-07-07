<?php
/**
 * Single Product Price
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$classes    = apply_filters( 'woocommerce_product_price_class', 'price' );
$price_html = $product->get_price_html();
?>
<div class="deep-woo-price">
	<p class="<?php echo esc_attr( $classes ); ?>"><?php echo $price_html; ?></p>
</div>
