<?php
/**
 * Product Description
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

?>
<div class="deep-woo-product-description">
	<?php echo $product->get_description(); ?>
</div>
