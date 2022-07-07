<?php
/**
 * Product loop sale flash
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $post, $product;
$label = isset( $args['label'] ) ? $args['label'] : esc_html__( 'Sale!', 'woocommerce' );
ob_start();
	\Elementor\Icons_Manager::render_icon( $args['cart_icon'], array( 'aria-hidden' => 'true' ) );
$icon  = ob_get_clean();
$bicon = isset( $args['cart_icon_pos'], $icon ) && 'before' == $args['cart_icon_pos'] ? $icon : '';
$aicon = isset( $args['cart_icon_pos'], $icon ) && 'after' == $args['cart_icon_pos'] ? $icon : '';
?>

<div class="deep-woo-onsale">
	<?php if ( $product->is_on_sale() ) : ?>
		<?php
			echo apply_filters(
				'woocommerce_sale_flash',
				'<span class="onsale">' . $bicon . $label . $aicon . '</span>',
				$post,
				$product
			);
		?>
	<?php endif; ?>
</div>
