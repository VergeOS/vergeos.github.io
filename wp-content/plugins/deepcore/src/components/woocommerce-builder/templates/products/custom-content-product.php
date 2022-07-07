<?php
/**
 * Product Title
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;
global $deep_custom_template_id;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
	<?php
		echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $deep_custom_template_id, false );
	?>
</li>


