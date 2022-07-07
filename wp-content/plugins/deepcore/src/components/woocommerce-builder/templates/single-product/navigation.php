<?php
/**
 * Single Product Navigation
 *
 * @package Deep\Components\WooCommerce\Templates
 *
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

$next_product          = get_adjacent_post( true, '', false, 'product_cat' );
$next_product_link     = get_permalink( $next_product );
$previous_product      = get_adjacent_post( true, '', true, 'product_cat' );
$previous_product_link = get_permalink( $previous_product );

?>
<div class="deep-woo-navigation">
	<a href="<?php echo $previous_product_link; ?>"><i class="ti-angle-left"></i></a>
	<a href="<?php echo $next_product_link; ?>"><i class="ti-angle-right"></i></a>
</div>
