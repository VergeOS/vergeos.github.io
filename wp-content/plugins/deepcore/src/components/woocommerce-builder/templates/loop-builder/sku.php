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

?>
<div class="deep-woo-product-stock">
	<?php echo $product->get_sku(); ?>
</div>
