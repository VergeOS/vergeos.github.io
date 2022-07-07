<?php
/**
 * External Product Add To Cart
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

$args = ADD_TO_CART_ARGS;
$icon	= isset( $args['cart_icon'] ) ? $args['cart_icon'] : '';
$before	= 'before' == $args['cart_icon_pos'] ? '<i class="' . esc_attr( $icon ) . '"></i>' : '';
$after	= 'after' == $args['cart_icon_pos'] ? '<i class="' . esc_attr( $icon ) . '"></i>' : '';
$allowed_html = array( 'i' => array( 'class' => true ) );

do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="cart" action="<?php echo esc_url( $product_url ); ?>" method="get">
	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	<button type="submit" class="single_add_to_cart_button button alt">
		<?php
		$args         = ADD_TO_CART_ARGS;
		$allowed_html = array( 'i' => array( 'class' => true ) );
		echo wp_kses( $before, $allowed_html );
		echo esc_html( $button_text );
		echo wp_kses( $after, $allowed_html );
		?>
	</button>

	<?php wc_query_string_form_fields( $product_url ); ?>

	<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
