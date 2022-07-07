<?php
/**
 * Variation Product Add To Cart
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
$args = ADD_TO_CART_ARGS;
$icon	= isset( $args['cart_icon'] ) ? $args['cart_icon'] : '';
$before	= 'before' == $args['cart_icon_pos'] ? '<i class="' . esc_attr( $icon ) . '"></i>' : '';
$after	= 'after' == $args['cart_icon_pos'] ? '<i class="' . esc_attr( $icon ) . '"></i>' : '';
$allowed_html = array( 'i' => array( 'class' => true ) );
?>
<div class="woocommerce-variation-add-to-cart variations_button">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<?php
	do_action( 'woocommerce_before_add_to_cart_quantity' );

	woocommerce_quantity_input(
		array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
		)
	);

	do_action( 'woocommerce_after_add_to_cart_quantity' );
	?>

	<button type="submit" class="single_add_to_cart_button button alt">
		<?php
		echo wp_kses( $before, $allowed_html );
		echo esc_html( $product->single_add_to_cart_text() );
		echo wp_kses( $after, $allowed_html );
		?>
	</button>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
