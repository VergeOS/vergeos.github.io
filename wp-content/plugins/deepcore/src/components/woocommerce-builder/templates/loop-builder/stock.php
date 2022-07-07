<?php
/**
 * Product Stock
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$label = isset( $args['label'] ) && ! empty( $args['label'] ) ? '<label>' . $args['label'] . '</label>' : '';

$status              = $product->get_stock_status();
$stock_value_pattern = isset( $args['stock_value'] ) && ! empty( $args['stock_value'] ) ? $args['stock_value'] : 'stock_status';

switch ( $stock_value_pattern ) {
	case 'status':
		if ( 'outofstock' == $status ) {
			$stock_html = '<p class="stock out-of-stock">' . __( 'out of stock', 'deep' ) . '</p>';
		} elseif ( 'instock' == $status ) {
			$stock_html = '<p class="stock in-stock">' . __( 'in stock', 'deep' ) . '</p>';
		}

		break;
	case 'stock':
		$qty        = $product->get_stock_quantity();
		$class      = $qty ? 'in-stock' : 'out-of-stock';
		$stock_html = '<p class="stock ' . $class . '">' . $qty . '</p>';

		break;
	case 'stock_status':
	default:
		$stock_html = wc_get_stock_html( $product );

		break;
}

?>
<div class="deep-woo-product-stock">
	<?php echo $label . $stock_html; ?>
</div>
