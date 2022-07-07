<?php
/**
 * Single Product Breadcrumb
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="deep-woo-breadcrumbs">
	<?php woocommerce_breadcrumb( array( 'delimiter' => ' <i class="wn-fa wn-fa-angle-right colorf"></i> ' ) ); ?>
</div>
