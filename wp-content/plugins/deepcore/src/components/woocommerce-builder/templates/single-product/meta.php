<?php
/**
 * Single Product Meta
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$sku            = $args['show_sku'];
$tag            = $args['show_tag'];
$category       = $args['show_category'];
$sku_label      = $args['sku_label'];
$tag_label      = $args['tag_label'];
$category_label = $args['category_label'];

?>
<div class="deep-woo-meta product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && $sku && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
		<div class="deep-woo-meta-sku sku_wrapper">
			<?php if ( $sku_label ) : ?>
				<span class="deep-label"><?php esc_html_e( $sku_label, 'deep' ); ?></span>
			<?php endif; ?>
			<span class="sku deep-value"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'deep' ); ?></span>
		</div>
	<?php endif; ?>

	<?php if ( $category ) : ?>
		<div class="deep-woo-meta-categories">
			<?php
			echo wc_get_product_category_list(
				$product->get_id(),
				', ',
				'<span class="posted_in"><span class="deep-label">' . _n( $category_label, $category_label, count( $product->get_category_ids() ), 'deep' ) . '</span> <span class="deep-value">',
				'</span></span>'
			);
			?>
		</div>
	<?php endif; ?>

	<?php if ( $tag ) : ?>
		<div class="deep-woo-meta-tags">
			<?php
			echo wc_get_product_tag_list(
				$product->get_id(),
				', ',
				'<span class="tagged_as"><span class="deep-label">' . _n( $tag_label, $tag_label, count( $product->get_tag_ids() ), 'deep' ) . '</span> <span class="deep-value">',
				'</span></span>'
			);
			?>
		</div>
	<?php endif; ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
