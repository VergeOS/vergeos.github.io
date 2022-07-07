<?php
/**
 * Single Product Attributes
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

?>
<div class="deep-woo-attributes">
	<?php wc_display_product_attributes( $product ); ?>
</div>
